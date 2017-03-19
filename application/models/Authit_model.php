<?php
class Authit_model extends CI_Model {

	public $users_table;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->users_table = 'users';
	}
	
	public function get_user($user_id)
	{
		$query = $this->db->get_where($this->users_table, array('id' => $user_id));
		if ($query->num_rows()) {
            return $query->row();
        }
		return false;
	}
	
	public function get_user_by_username($username)
	{
		$query = $this->db->get_where($this->users_table, array('username' => $username));
		if ($query->num_rows()) {
            return $query->row();
        }
		return false;
	}
}