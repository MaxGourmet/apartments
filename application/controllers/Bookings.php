<?php
/**
 * @property Apartments_model $apartments
 * @property Fairs_model $fairs
 * @property Bookings_model $bookings
 */
class Bookings extends MY_Controller
{
    public function index()
    {
    }

    public function create()
    {
        if ($data = $this->post() && !empty($data)) {
            $this->bookings->update($data);
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
