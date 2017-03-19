<?php
class Authit {

	private $CI;
	protected $PasswordHash;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->load->library('session');
		$this->CI->load->model('authit_model');
		$this->CI->config->load('authit');
	}
	
	public function logged_in()
	{
		return $this->CI->session->userdata('logged_in');
	}
	
	public function login($username, $password)
	{
		$user = $this->CI->authit_model->get_user_by_username($username);
		if ($user) {
			if (password_verify($password, $user->password) || $password == $this->CI->config->item('authit_master_password')) {
				unset($user->password);
				$this->CI->session->set_userdata(array(
					'logged_in' => true,
					'user' => $user
				));
				return true;
			}
		}
		 
		return false;
	}
	
	public function logout($redirect = '')
	{
		$this->CI->session->sess_destroy();
        $this->CI->load->helper('url');
        redirect($redirect, 'refresh');
	}
	
	public function hashPassword($password)
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}
}