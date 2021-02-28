<?php
class Customers extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
		if (!$this->checkRole('admin')/* && !$this->checkRole('viewer')*/) {
			show_404();
		}
    }

    public function index()
    {
        $this->title = "Customers";
        $customers = $this->customers->get();
        $this->showView(
            'customers/index',
            [
                'customers' => $customers
            ]
        );
    }

    public function create($id = null)
    {
        if (($data = $this->post()) && !empty($data)) {
            array_extract($data, 'submit');
			$data['last_clean_date'] = date('Y-m-d', strtotime($data['last_clean_date']));
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
                $apartment['clean_link'] = $this->apartments->getCleanLink($id);
                $apartment['history'] = $this->apartments->getCleanHistory($id, 10);
                if (empty($apartment)) {
                    redirect('apartments');
                }
            } else {
				if ($this->checkRole('viewer')) {
					show_404();
				}
                $this->title = $this->configs->get(false, 'apartments_create_title');
                $apartment = [
                    'address' => '',
                    'city' => $citiesResult[0]['value'],
                    'beds' => 0,
                    'price1' => 0,
                    'price2' => 0,
                    'price3' => 0,
                    'last_clean_date' => null,
					'clean_link' => ''
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
}
