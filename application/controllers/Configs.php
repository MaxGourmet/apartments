<?php
class Configs extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->checkRole('dev')) {
            show_404();
        }
    }

    public function index()
    {
        $this->title = $this->configs->get(false, 'configs_title');
        $configs = $this->configs->get();
        $this->showView(
            'configs/index',
            [
                'configs' => $configs
            ]
        );
    }

    public function create($id = null)
    {
        if (($data = $this->post()) && !empty($data)) {
            array_extract($data, 'submit');
            $this->configs->update($data);
            redirect('configs');
        } else {
            $this->load->helper('form');
            $this->load->helper('html');
            if ($id) {
                $this->title = $this->configs->get(false, 'configs_edit_title');
                $config = $this->configs->getById($id);
            } else {
                $this->title = $this->configs->get(false, 'configs_create_title');
                $config = [
                    'alias' => '',
                    'name' => '',
                    'value' => '',
                    'editable' => 1
                ];
            }
            $this->showView('configs/create', ['config' => $config]);
        }
    }

    public function edit($id)
    {
        if ($id) {
            $this->create($id);
        } else {
            redirect('configs');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $this->fairs->delete($id);
        }
        redirect('configs');
    }
}
