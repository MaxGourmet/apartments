<?php
class Fairs extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->checkRole('admin') && !$this->checkRole('viewer')) {
            show_404();
        }
    }

    public function index()
    {
        $this->title = $this->configs->get(false, 'fairs_title');
        $fairs = $this->fairs->get();
        $this->showView(
            'fairs/index',
            [
                'fairs' => $fairs
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
            $this->fairs->update($data);
            redirect('fairs');
        } else {
            $this->load->helper('form');
            $this->load->helper('html');
            $citiesResult = $this->configs->get('city', false, []);
            $cities = [];
            foreach ($citiesResult as $city) {
                $cities[$city['value']] = $city['value'];
            }
            if ($id) {
                $this->title = $this->configs->get(false, 'fairs_edit_title');
                $fair = $this->fairs->getById($id);
                if (empty($fair)) {
                    redirect('fairs');
                }
            } else {
				if ($this->checkRole('viewer')) {
					show_404();
				}
                $this->title = $this->configs->get(false, 'fairs_create_title');
                $fair = [
                    'name' => '',
                    'city' => $citiesResult[0]['value'],
                    'start' => date('Y-m-d'),
                    'end' => date('Y-m-d'),
                    'price' => 0
                ];
            }
            $this->showView('fairs/create', ['cities' => $cities, 'fair' => $fair]);
        }
    }

    public function edit($id)
    {
        if ($id) {
            $this->create($id);
        } else {
            redirect('fairs');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $this->fairs->delete($id);
        }
        redirect('fairs');
    }
}
