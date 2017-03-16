<?php
/**
 * @property Apartments_model $apartments
 * @property Fairs_model $fairs
 * @property Bookings_model $bookings
 * @property Config_model $config
 */
class MY_Controller extends CI_Controller {

    public $title = 'Apartments';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('apartments_model', 'apartments');
        $this->load->model('fairs_model', 'fairs');
        $this->load->model('bookings_model', 'bookings');
        $this->load->model('config_model', 'config');
        $this->load->helper('security');
        $this->load->helper('array');
    }

    public function showView($viewName, $data = [])
    {
        $title = $this->title;
        if (isset($data['title'])) {
            $title = array_extract($data, 'title');
        }
        $content = $this->load->view($viewName, $data, true);
        $this->load->view('layout', ['title' => $title, 'content' => $content]);
    }

    protected function get($parameter = '')
    {
        $get = $_GET;
        if (empty($get)) {
            return $parameter == '' ? [] : false;
        }
        $this->cleanParams($get);
        if ($parameter != '' && isset($get[$parameter])) {
            return $get[$parameter];
        }
        return $get;
    }

    protected function post($parameter = '')
    {
        $post = $_POST;
        if (empty($post)) {
            return $parameter == '' ? [] : false;
        }
        $this->cleanParams($post);
        if ($parameter != '' && isset($post[$parameter])) {
            return $post[$parameter];
        }
        return $post;
    }

    private function cleanParams(&$params)
    {
        foreach ($params as &$item) {
            $item = trim($item);
            $item = htmlspecialchars($item);
            $item = xss_clean($item);
            $item = encode_php_tags($item);
        }
    }
}
