<?php
class Authors_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    // Get all author from layout
    public function get_all_authors()
    {
        $this->db->order_by('name_author', "asc");
        $this->db->from('authors');
        return $this->db->get()->result_array();
    }

    // Insert a author to database
    public function insertAAuthor($authorData)
    {
        $this->db->insert('authors', $authorData);
        return $this->db->insert_id();
    }

    // Remove a author from database
    public function removeAAuthor($id)
    {
        if (isset($id)) {
            $this->db->where('id', $id);
            $this->db->delete('authors');
        }
    }

    // Show information of author with id
    public function showAuthorById($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('authors')->row_array();
    }

    // Update a author
    public function updateAAuthor($id, $authorToUpdate)
    {
        $this->db->where('id', $id);    // Note: Luu y thu tu
        $this->db->update('authors', $authorToUpdate);
    }
}
