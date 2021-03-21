<?php
class Customers extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
		if (!$this->checkRole('admin')/* && !$this->checkRole('viewer')*/) {
			show_404();
		}
		$this->title = "Kunden";
    }

    public function index()
    {
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

			if (!isset($data['is_company'])) {
				$data['is_company'] = 0;
			}
            $this->customers->update($data);
            redirect('customers');
        } else {
            $this->load->helper('form');
            $this->load->helper('html');
            if ($id) {
                $customer = $this->customers->getById($id);
                if (empty($customer)) {
                    redirect('customers');
                }
            } else {
				if ($this->checkRole('viewer')) {
					show_404();
				}
				$customer = [
                    'salutation' => 1,
					'first_name' => '',
					'last_name' => '',
					'country' => '',
					'city' => '',
					'street' => '',
					'postcode' => '',
					'is_company' => '',
					'company_name' => '',
					'full_name' => '',
					'phone' => '',
					'email' => '',
					'personal_discount' => '',
                ];
            }
            $this->showView('customers/create', ['customer' => $customer]);
        }
    }

    public function edit($id)
    {
        if ($id) {
            $this->create($id);
        } else {
            redirect('customers');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $this->customers->delete($id);
        }
        redirect('customers');
    }

	public function updateCustomersList()
	{
		if (!$this->checkAjax()) {
			return;
		}
		$customers = $this->customers->getForDropdown();
		echo json_encode(['success' => 'true', 'customers' => $customers]);
	}

	public function saveCustomerAjax()
	{
		if (!$this->checkAjax()) {
			return;
		}
		$data = $this->post();
		array_extract($data, 'submit');

		if (!isset($data['is_company'])) {
			$data['is_company'] = 0;
		}
		$this->customers->update($data);
		$id = $this->customers->getLastId();
		$name = "{$data['first_name']} {$data['last_name']} ({$data['company_name']})";

		echo json_encode(['success' => 'true', 'id' => $id, 'name' => $name]);
	}
}
