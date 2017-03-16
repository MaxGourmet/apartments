<?php
class Fairs extends MY_Controller
{
    public function index()
    {
    }

    public function create()
    {
        if (($data = $this->post()) && !empty($data)) {
            array_extract($data, 'submit');
            $this->fairs->update($data);
            redirect();
        } else {
            $this->load->helper('form');
            $this->load->helper('html');
            $citiesResult = json_decode($this->configs->get('city'), true);
            $cities = [];
            foreach ($citiesResult as $city) {
                $cities[$city] = $city;
            }
            $this->showView('fairs/create', ['cities' => $cities]);
        }
    }
}
