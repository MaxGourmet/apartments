<?php
/**
 * @property Apartments_model $apartments
 * @property Fairs_model $fairs
 * @property Bookings_model $bookings
 */
class Apartments extends MY_Controller {

    public function index()
	{
        $apartments = $this->apartments->get();
//        $fairFilters = [
//            [
//                'field' => 'start',
//                'operand' => '>=',
//                'value' => date("Y-m-01")
//            ],
//        ];
//        $fairs = $this->fairs->get($fairFilters);
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

    public function fill()
    {
//        $apartment = [
//            'address' => substr(md5(date('i:s')), 0, rand(5, 25)) . " " . rand(1, 100),
//            'beds' => rand(1, 10),
//            'price1' => rand(1, 100),
//            'price2' => rand(1, 100),
//            'price3' => rand(1, 100),
//        ];
        $md5 = md5(date('i:s'));
        $name = substr($md5, 0, rand(5, 25)) . " " . str_shuffle(substr($md5, 0, rand(5, 25)));
        $start = rand(1, 31);
        $end = rand($start, 31);
        $start = date('Y-m') . "-$start";
        $end = date('Y-m') . "-$end";
        $fair = [
            'name' => $name,
            'address' => substr(md5(date('i:s')), 0, rand(5, 25)) . " " . rand(1, 100),
            'start' => $start,
            'end' => $end,
            'price' => rand(1, 100),
        ];
//        $this->apartments_model->createApartment($apartment);
        $this->fairs_model->createFair($fair);
    }
}
