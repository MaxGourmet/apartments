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
		$vatRates = $this->configs->getPrepared('vat_rate', false, []);
        $this->showView(
            'services/index',
            [
                'services' => $services,
                'vatRates' => $vatRates,
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
            $vatRates = $this->configs->getPrepared('vat_rate', false, []);
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
                    'vat_rate' => $vatRates['vat_rate_1'],
                    'price' => 0
                ];
            }
            $this->showView('services/create', ['vatRates' => $vatRates, 'service' => $service]);
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
