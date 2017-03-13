<?php
class User_Roles_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get()
    {
        return $this->db->get('user_roles')->result_array();
    }
}