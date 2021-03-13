<?php
class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('books_model');
        $this->load->model('authors_model');
    }

    // Render pages
    public function render($page = 'home', $title = 'Chương trình quản lý sách')
    {
        if (!file_exists(APPPATH . 'views/quan-ly-sach/' . $page . '.php')) {
            show_404(); //Show error when can not find page 
        } else {
            $data['title'] = ucfirst($title);
            $data['keyword'] = "";
            $data['authorIdSelected'] = "";
            $data['aBook']['title'] = "";
            $data['aBook']['author'] = "";
            $data['aBook']['price'] = "";

            $data['authors'] = $this->authors_model->get_all_authors();
            // $data['books'] = $this->books_model->get_all_books();
            $data['books'] = $this->books_model->getBooksPerPage(0, 3);
            // $data['books'] = $this->books_model->processBooksData(1, 3);
            $data['linkNextPage'] = base_url('home/processBooksData/');
            $data['currentPage'] = 1;

            // Pagination
            $total_row = $this->books_model->countTotalBooks();
            $data['pages'] = ceil($total_row / 3);

            $this->load->view('quan-ly-sach/' . $page, $data);
        }
    }

    // Insert information of a book to database
    public function insertABook()
    {
        // Check submit button is tapped?
        if ($this->input->post('insert-a-book')) {
            // Get value from form
            $title = $this->input->post('book-name');
            $author = $this->input->post('authors');
            $authorId = $author[0];
            $price = $this->input->post('price');

            $result = $this->books_model->insertABook($title, $authorId, $price);
            if ($result == true) {
                $this->session->set_flashdata('success', "Thêm sách thành công!");
                redirect(base_url(), 'refresh');
            } else {
                $this->session->set_flashdata('failed', "Thêm sách thất bại!");
            }
        }
    }

    // Remove a book from database
    public function removeABook()
    {
        $this->books_model->removeABook($_POST['book_id']);
    }

    // Get id of book and show information of book before edit
    public function showABook($id)
    {
        if (isset($id)) {
            $data['title'] = "Sửa thông tin sách";
            $data['aBook'] = $this->books_model->getBookFromId($id);

            $data['authors'] = $this->authors_model->get_all_authors();
            $this->load->view('quan-ly-sach/edit-book', $data);
        }
    }

    // Edit a book from database
    public function updateABook($idBook)
    {
        $data_to_update['title'] = $this->input->post('book-name');
        $data_to_update['author_id'] = $this->input->post('authors');
        $data_to_update['price'] = $this->input->post('price');

        $this->books_model->updateABook($idBook, $data_to_update);
        redirect(base_url(), 'refresh');
    }

    // Update author of book to database
    public function updateAuthorOfBook()
    {
        $bookID = $_POST['book_id'];
        $authorID = $_POST['author_id'];

        $this->books_model->updateAuthorOfBook($bookID, $authorID);
        redirect(base_url(), 'refresh');
    }

    // Process book data
    public function processBooksData($currentPage = 1, $limit = 3)
    {
        $data['title'] = TITLE;
        $data['authors'] = $this->authors_model->get_all_authors();
        $data['currentPage'] = $currentPage;

        // Get data from URL
        $keyword = trim($this->input->get('keyword'));
        $authorIdSelected = $this->input->get('authors');

        // Set data to UI
        $data['keyword'] = $keyword;
        $data['authorIdSelected'] = $authorIdSelected;

        // Calculate pages number
        $start = ($currentPage - 1) * $limit;

        $data['linkNextPage'] = base_url('home/processBooksData');
        if (!empty($keyword) && empty($authorIdSelected)) {
            $data['books'] = $this->books_model->processBooksData($keyword, $authorIdSelected, $start, $limit);

            // Calculate the books number per page
            $totalRow = $this->books_model->countBooksResult($keyword, $authorIdSelected);
            $data['pages'] = ceil($totalRow / $limit);

            $this->load->view('quan-ly-sach/home', $data);
        } elseif (!empty($authorIdSelected) && empty($keyword)) {
            $data['books'] = $this->books_model->processBooksData($keyword, $authorIdSelected, $start, $limit);

            // Calculate the books number per page
            $totalRow = $this->books_model->countBooksResult($keyword, $authorIdSelected);
            $data['pages'] = ceil($totalRow / $limit);

            $this->load->view('quan-ly-sach/home', $data);
        } elseif (!empty($keyword) && !empty($authorIdSelected)) {
            $data['books'] = $this->books_model->processBooksData($keyword, $authorIdSelected, $start, $limit);

            // Calculate the books number per page
            $totalRow = $this->books_model->countBooksResult($keyword, $authorIdSelected);
            $data['pages'] = ceil($totalRow / $limit);

            $this->load->view('quan-ly-sach/home', $data);
        } else {
            $data['books'] = $this->books_model->processBooksData($keyword, $authorIdSelected, $start, $limit);

            // Calculate the books number per page
            $totalRow = $this->books_model->countTotalBooks();
            $data['pages'] = ceil($totalRow / $limit);

            $this->load->view('quan-ly-sach/home', $data);
        }
    }

    // Paging the number of books
    public function pagingTheNumberOfBooks($currentPage, $limit = 3)
    {
        $data['authors'] = $this->authors_model->get_all_authors();
        $data['currentPage'] = $currentPage;
        $keyword = trim($this->input->get('keyword'));
        $authorSelected = $this->input->get('authors');

        $start = ($currentPage - 1) * $limit;

        if (isset($currentPage)) {
            //Test
            var_dump("{CONTROLLER}-Current Page = " . $data['currentPage']);

            $data['title'] = "Chương trình quản lý sách";
            $data['books'] = $this->books_model->getBooksPerPage($start, $limit);

            // Keyword and filter
            $data['keyword'] = $keyword;
            $data['authorIdSelected'] = $authorSelected;

            // Books in page
            $total_row = $this->books_model->countTotalBooks();
            $data['pages'] = ceil($total_row / 3);

            $this->load->view('quan-ly-sach/home', $data);
        }
    }


    /* ==================== Author manager ======================== */
    public function insertAAuthor()
    {
        // Check submit button
        if ($this->input->post('insert-a-author')) {
            // Get value from form
            $nameAuthor = $this->input->post('name-author');

            $get_data = array('name_author' => $nameAuthor);

            $result = $this->authors_model->insertAAuthor($get_data);
            if ($result == true) {
                $this->session->set_flashdata('success', "Thêm tác giả thành công!");
                redirect(base_url('author-manager'), 'refresh');
            } else {
                $this->session->set_flashdata('failed', "Thêm tác giả thất bại!");
            }
        }
    }

    // Remove a author
    public function removeAAuthor()
    {
        $this->authors_model->removeAAuthor($_POST['author_id']);
    }

    // Show information of author
    public function showAAuthor($idOfAuthor)
    {
        if (isset($idOfAuthor)) {
            $data['title'] = "Sửa thông tin tác giả";
            $data['aAuthor'] = $this->authors_model->showAuthorById($idOfAuthor);
            $this->load->view('quan-ly-sach/edit-author', $data);
        }
    }

    // Update a author
    public function updateAAuthor($idAuthor)
    {
        $dataToUpdate['name_author'] = $this->input->post('name-author');

        $result = $this->authors_model->updateAAuthor($idAuthor, $dataToUpdate);
        redirect(base_url('author-manager'), 'refresh');
    }
}
