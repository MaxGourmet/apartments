<?php
class Apartments extends MY_Controller
{
    public function index()
    {
        $apartments = $this->apartments->get();
        $fairParams = [
            'filters' => [
                [
                    'field' => 'start',
                    'operand' => '>=',
                    'value' => date("Y-m-01")
                ]
            ],
        ];
        $fairs = $this->fairs->get($fairParams);
        $bookings = $this->bookings->get();
        $monthDays = intval(date("t"));
        $this->showView(
            'apartments/index',
            [
                'apartments' => $apartments,
                'bookings' =>  $bookings,
                'monthDays' => $monthDays
            ]
        );
    }

    public function create()
    {
        if (($data = $this->post()) && !empty($data)) {
            array_extract($data, 'submit');
            $this->apartments->update($data);
        } else {
            $this->load->helper('form');
            $this->load->helper('html');
            $cities = json_decode($this->config->get('city'), true);
            $this->showView('apartments/create', ['cities' => $cities]);
        }
    }
}
