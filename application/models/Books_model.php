<?php
class Books_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    // Get all book from database
    public function getAllBooks()
    {
        $sql = "SELECT books.* , authors.name_author FROM books 
                LEFT JOIN authors ON books.author_id = authors.id";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    // Insert information of a book to database
    public function insertABook($title, $author, $price)
    {
        $get_data = array(
            'title' => $title,
            'author_id' => $author,
            'price' => $price
        );

        $this->db->insert('books', $get_data);
        return $this->db->insert_id();
    }

    // Remove a book from database
    public function removeABook($id)
    {
        if (isset($id)) {
            $this->db->where('id', $id);
            $this->db->delete('books');
        }
    }

    // Get a book from id book
    public function getBookFromId($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('books')->row_array();
    }

    // Update a book from database
    public function updateABook($id, $bookToUpdate)
    {
        $this->db->where('id', $id);
        $this->db->update('books', $bookToUpdate);
    }

    // Update only author of book to database
    public function updateAuthorOfBook($bookID, $authorID)
    {
        $sql = "UPDATE books
        SET author_id = $authorID
        WHERE id = $bookID";

        $this->db->query($sql);
    }

    /** Precess book data */
    public function processBooksData($keyword, $authorIdSelected, $start, $limit)
    {
        $sql = "SELECT * FROM books ";

        if ($start != -1 && $limit != -1) {
            if (!empty($keyword) && empty($authorIdSelected)) {
                $sql .= "WHERE title LIKE '%$keyword%'";
            } elseif (!empty($authorIdSelected) && empty($keyword)) {
                $sql .= "WHERE author_id = $authorIdSelected";
            } elseif (!empty($keyword) && !empty($authorIdSelected)) {
                $sql .= "WHERE title LIKE '%$keyword%' AND author_id = $authorIdSelected";
            }
        }
        $sql .= " ORDER BY title ASC LIMIT $start, $limit";
        return $this->db->query($sql)->result_array();
    }

    // Count result after process books data
    public function countBooksResult($keyword, $authorIdSelected)
    {
        $this->db->select('*');
        if (!empty($keyword) && empty($authorIdSelected)) {
            $this->db->like('title', $keyword);
        } elseif ($authorIdSelected >= 0 && empty($keyword)) {
            $this->db->where('author_id', $authorIdSelected);
        } elseif (!empty($keyword) && !empty($authorIdSelected)) {
            $this->db->where('author_id', $authorIdSelected);
            $this->db->like('title', $keyword);
        }
        return $this->db->count_all_results('books');
    }

    // Get books per page
    public function getBooksPerPage($start, $limit)
    {
        $sql = "SELECT * FROM `books` 
        ORDER BY title ASC 
        LIMIT $start, $limit";
        return $this->db->query($sql)->result_array();
    }

    // Pagination the numbers of books
    public function countTotalBooks()
    {
        return $this->db->count_all_results('books');
    }
}
