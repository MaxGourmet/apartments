<?php
class Apartments extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->checkRole('admin')) {
            show_404();
        }
    }

    public function index()
    {
        $this->title = $this->configs->get(false, 'apartments_title');
        $apartments = $this->apartments->get();
        $this->showView(
            'apartments/index',
            [
                'apartments' => $apartments
            ]
        );
    }

    public function create($id = null)
    {
        if (($data = $this->post()) && !empty($data)) {
            array_extract($data, 'submit');
            $this->apartments->update($data);
            redirect('apartments');
        } else {
            $this->load->helper('form');
            $this->load->helper('html');
            $citiesResult = $this->configs->get('city', false, []);
            $cities = [];
            foreach ($citiesResult as $city) {
                $cities[$city['value']] = $city['value'];
            }
            if ($id) {
                $this->title = $this->configs->get(false, 'apartments_edit_title');
                $apartment = $this->apartments->getById($id);
                if (empty($apartment)) {
                    redirect('apartments');
                }
            } else {
                $this->title = $this->configs->get(false, 'apartments_create_title');
                $apartment = [
                    'address' => '',
                    'city' => $citiesResult[0]['value'],
                    'beds' => 0,
                    'price1' => 0,
                    'price2' => 0,
                    'price3' => 0,
                ];
            }
            $this->showView('apartments/create', ['cities' => $cities, 'apartment' => $apartment]);
        }
    }

    public function edit($id)
    {
        if ($id) {
            $this->create($id);
        } else {
            redirect('apartments');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $this->apartments->delete($id);
        }
        redirect('apartments');
    }

    public function getPrice()
    {
        if (!$this->checkAjax()) {
            echo json_encode(['success' => 'false', 'error' => 'Invalid Data']);
            return;
        }
        $data = $this->post();
        var_dump($data);exit;
        if (empty($data)) {
            echo json_encode(['success' => 'false', 'error' => 'Invalid Data']);
            return;
        }
        $apartment = $this->apartments->getById($data['apartment_id']);
        if (empty($apartment)) {
            echo json_encode(['success' => 'false', 'error' => 'Invalid Apartment']);
            return;
        }
        $dates = date_range($data['start_date'], $data['end_date']);
        if (empty($dates)) {
            echo json_encode(['success' => 'false', 'error' => 'Invalid Dates']);
            return;
        }
        $peopleCount = $data['people_count'];
        $countDays = count($dates) - 1;
        unset($dates[$countDays]);
        $priceIndex = 1;
        $daysForPrice2 = $this->configs->get(false, 'days_for_price2');
        $daysForPrice3 = $this->configs->get(false, 'days_for_price3');
        if ($countDays >= $daysForPrice3) {
            $priceIndex = 3;
        } elseif ($countDays >= $daysForPrice2) {
            $priceIndex = 2;
        }
        $price = $apartment["price{$priceIndex}"];
        $fairsFilters = [
            'filters' => [
                "(start <= '{$data['end_date']}' AND end >= '{$data['start_date']}')",
                ['field' => 'city', 'operand' => '=', 'value' => $apartment['city']]
            ]
        ];
        $fairs = $this->fairs->get($fairsFilters);
        $this->fairs->prepare($fairs);
        $totalPrice = 0;
        $priceText = $countDays;
        $prices = [];
        $bedsCount = intval($apartment['beds']);
        foreach ($dates as $date) {
            if (isset($fairs[$date])) {
                $prices[$date] = $fairs[$date];
            } else {
                $prices[$date] = floatval($price);
            }
        }
        foreach ($prices as $date => &$pr) {
            $previousDate = date('Y-m-d', strtotime($date . " -1day"));
            if (isset($fairs[$date]) && in_array($previousDate, $dates)) {
                $prices[$previousDate] = max($prices[$previousDate], $fairs[$date]);
            }
        }
        unset($pr);
        $priceIndex = 0;
        reset($prices);
        $currentPrice = current($prices);
        reset($prices);
        foreach ($prices as $date => $pr) {
            if ($pr == $currentPrice) {
                $priceIndex++;
            } else {
                if ($priceIndex > 0) {
//                    if ($currentPrice != $price) {
//                        $priceText .= "$bedsCount x $peopleCount x ";
//                    }
//                    $priceText .= "$priceIndex x $currentPrice € + ";
//                    $priceText .= "$priceIndex";
                }
                $priceIndex = 1;
                $currentPrice = $pr;
            }
            if ($currentPrice != $price) {
                $pr *= $bedsCount;
                $pr *= $peopleCount;
            }
            $totalPrice += $pr;
        }
        if ($priceIndex > 0) {
//            if ($currentPrice != $price) {
//                $priceText .= "$bedsCount x $peopleCount x ";
//            }
//            $priceText .= "$priceIndex x $currentPrice €";
//            $priceText .= "$priceIndex";
        }
        echo json_encode(['success' => 'true', 'price' => $totalPrice, 'priceText' => $priceText]);
    }

    public function getBookedDates()
    {
        if (!$this->checkAjax()) {
            echo json_encode(['success' => 'false', 'error' => 'Invalid Data']);
            return;
        }
        $apartmentId = $this->get('apartmentId');
        if (!$apartmentId) {
            echo json_encode(['success' => 'false', 'error' => 'Invalid apartmentId']);
            return;
        }
        $bookingId = intval($this->get('bookingId'));
        $date = date('Y-m-d');
        $bookingsFilters = [
            'filters' => [
                "(start <= '{$date}' OR end >= '{$date}')",
                ['field' => 'apartment_id', 'operand' => '=', 'value' => $apartmentId]
            ]
        ];
        if ($bookingId) {
            $bookingsFilters['filters'][] = ['field' => 'id', 'operand' => '!=', 'value' => $bookingId];
        }
        $bookings = $this->bookings->get($bookingsFilters);
        if (empty($bookings)) {
            echo json_encode(['success' => 'true', 'dateArray' => []]);
            return;
        }
        $dateArray = $this->bookings->getBookedDates($bookings);
        echo json_encode(['success' => 'true', 'dateArray' => $dateArray]);
    }
}
