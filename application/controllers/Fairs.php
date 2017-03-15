<?php
/**
 * @property Apartments_model $apartments
 * @property Fairs_model $fairs
 * @property Bookings_model $bookings
 */
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
        } else {
            $this->load->helper('form');
            $this->load->helper('html');
            $this->showView('fairs/create');
        }
    }
}
