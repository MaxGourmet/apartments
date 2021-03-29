<?php
class Services extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->title = "Zusatzleistungen";
        if (!$this->checkRole('admin') && !$this->checkRole('viewer')) {
            show_404();
        }
    }

    public function index()
    {
        $services = $this->services->get();
        $this->showView(
            'services/index',
            [
                'services' => $services
            ]
        );
    }

    public function create($id = null)
    {
        if (($data = $this->post()) && !empty($data)) {
			if ($this->checkRole('viewer')) {
				show_404();
			}
            array_extract($data, 'submit');
			$this->services->update($data);
            redirect('services');
        } else {
            $this->load->helper('form');
            $this->load->helper('html');
            $vatRates = $this->configs->get('vat_rate', false, []);
            var_dump($vatRates);exit;
            if ($id) {
                $service = $this->services->getById($id);
                if (empty($service)) {
                    redirect('services');
                }
            } else {
				if ($this->checkRole('viewer')) {
					show_404();
				}
                $service = [
                    'name' => '',
                    'description' => '',
                    'vat_rate' => 0,
//                    'city' => $vatRates[0]['value'],
                    'price' => 0
                ];
            }
            $this->showView('services/create', [/*'cities' => $cities, */'service' => $service]);
        }
    }

    public function edit($id)
    {
        if ($id) {
            $this->create($id);
        } else {
            redirect('services');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $this->services->delete($id);
        }
        redirect('services');
    }
}
