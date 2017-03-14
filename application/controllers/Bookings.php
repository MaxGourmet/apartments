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

    public function create_booking()
    {
        if ($data = $this->post() && !empty($data)) {
            $this->bookings->update($data);
        } else {
            $apartments = $this->apartments->get();
            $this->showView('bookings/create', ['apartments' => $apartments]);
        }
    }
}
