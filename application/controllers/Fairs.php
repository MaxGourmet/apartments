<?php
class Fairs extends MY_Controller
{
    public function index()
    {
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
            array_extract($data, 'submit');
            $this->fairs->update($data);
            redirect('fairs');
        } else {
            $this->load->helper('form');
            $this->load->helper('html');
            $citiesResult = json_decode($this->configs->get('city'), true);
            $cities = [];
            foreach ($citiesResult as $city) {
                $cities[$city] = $city;
            }
            if ($id) {
                $fair = $this->fairs->getById($id);
                if (empty($fair)) {
                    redirect('fairs');
                }
            } else {
                $fair = [
                    'name' => '',
                    'address' => '',
                    'city' => $citiesResult[0],
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
