<?php
class Bookings extends MY_Controller
{
    public function index()
    {
    }

    public function create()
    {
        if (($data = $this->post()) && !empty($data)) {
            array_extract($data, 'submit');
            $this->bookings->update($data);
            redirect();
        } else {
            $this->load->helper('form');
            $this->load->helper('html');
            $apartmentsResult = $this->apartments->get();
            $apartments = [];
            foreach ($apartmentsResult as $apartment) {
                $apartments[$apartment['id']] = $apartment['address'];
            }
            $this->showView('bookings/create', ['apartments' => $apartments]);
        }
    }
}
