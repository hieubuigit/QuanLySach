<?php
class Auhtor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('authors_model');
    }

    // Get all authors from layout
    public function render()
    {
        $data['authors'] = $this->authors_model->get_all_authors();
    }
}
