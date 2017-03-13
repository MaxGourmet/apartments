<?php
class Bookings_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get()
    {
        return $this->db->get('bookings')->result_array();
    }
}