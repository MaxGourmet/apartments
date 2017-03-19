<?php
class Apartments extends MY_Controller
{
    public function index()
    {
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
            $citiesResult = json_decode($this->configs->get('city'), true);
            $cities = [];
            foreach ($citiesResult as $city) {
                $cities[$city] = $city;
            }
            if ($id) {
                $apartment = $this->apartments->getById($id);
                if (empty($apartment)) {
                    redirect('apartments');
                }
            } else {
                $apartment = [
                    'address' => '',
                    'city' => $citiesResult[0],
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
        $countDays = count($dates);
        $priceIndex = 1;
        $daysForPrice2 = $this->configs->get('days_for_price2');
        $daysForPrice3 = $this->configs->get('days_for_price3');
        if ($countDays >= $daysForPrice2) {
            $priceIndex = 2;
        } elseif ($countDays >= $daysForPrice3) {
            $priceIndex = 3;
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
        $priceText = '';
        foreach ($dates as $date) {
            if (isset($fairs[$date])) {
                $totalPrice += $fairs[$date];
                $priceText .= '1 x ' . $fairs[$date] . "€ + ";
            } else {
                $totalPrice += $price;
                $priceText .= '1 x ' . $price . "€ + ";
            }
        }
        $priceText = substr($priceText, 0, -3);
        echo json_encode(['success' => 'true', 'price' => $totalPrice, 'priceText' => $priceText]);
    }
}
