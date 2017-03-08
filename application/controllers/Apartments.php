<?php
/**
 * @property Apartments_model $apartments_model
 */
class apartments extends CI_Controller {
	public function index()
	{
        $this->load->model('apartments_model');
        $apartments = $this->apartments_model->get();
        var_dump($apartments);exit;
		$this->load->view('welcome_message');
	}
}
