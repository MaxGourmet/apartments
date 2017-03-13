<?php
class Config_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get()
    {
        return $this->db->get('config')->result_array();
    }
}