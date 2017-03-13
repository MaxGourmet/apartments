<?php
/**
 * @property Apartments_model $apartments
 * @property Fairs_model $fairs
 * @property Bookings_model $bookings
 */
class MY_Controller extends CI_Controller {

    public $title = 'Apartments';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('apartments_model', 'apartments');
        $this->load->model('fairs_model', 'fairs');
        $this->load->model('bookings_model', 'bookings');
    }

    public function showView($viewName, $data = [])
    {
        $title = $this->title;
        if (isset($data['title'])) {
            $title = $data['title'];
            unset($data['title']);
        }
        $content = $this->load->view($viewName, $data, true);
        $this->load->view('layout', ['title' => $title, 'content' => $content]);
    }
}
