<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct()
	{
        parent::__construct();
        $this->load->library('authit');
        $this->load->helper('authit');
		$this->config->load('authit');
		$this->load->helper('url');
	}
	
	public function index()
	{
		if (!logged_in()) {
            redirect('auth/login');
        }

        if (user('role') == 'dev') {
            redirect('configs');
        }
        if (user('role') == 'cleaner') {
			redirect(isset($_SESSION['redirect_route']) ? $_SESSION['redirect_route'] : 'https://google.com');
		}
		redirect('');
	}
	
	/**
	 * Login page
	 */
	public function login()
	{
		var_dump($this->authit->hashPassword('faS41kfAwq'));exit;
		if (logged_in()) {
            if (user('role') == 'dev') {
                redirect('configs');
            }
			if (user('role') == 'cleaner') {
				redirect(isset($_SESSION['redirect_route']) ? $_SESSION['redirect_route'] : 'https://google.com');
			}
            redirect('');
        }
		 
		$this->load->library('form_validation');
		$this->load->helper('form');
		$data['error'] = false;
		 
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run()) {
			if ($this->authit->login(set_value('username'), set_value('password'))) {
                if (user('role') == 'dev') {
                    redirect('configs');
                }
				if (user('role') == 'cleaner') {
					redirect(isset($_SESSION['redirect_route']) ? $_SESSION['redirect_route'] : 'https://google.com');
				}
				redirect('');
			} else {
				$data['error'] = 'Your username and/or password is incorrect.';
			}
		}
		
		$this->load->view('auth/login', $data);
	}
	
	/**
	 * Logout page
	 */
	public function logout()
	{
		if (!logged_in()) {
            redirect('auth/login');
        }

		$this->authit->logout('auth/login');
	}
}
