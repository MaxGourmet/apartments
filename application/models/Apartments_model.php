<?php
class Apartments_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get()
    {
        return $this->db->get('apartments')->result_array();
    }
}