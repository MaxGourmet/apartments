<?php
class Customers_model extends MY_Model
{
    public $table = 'customers';

    public function getForDropdown()
    {
    	$customers = $this->get();
        $result = [null => 'Wählen Sie den Kunden'];
        foreach ($customers as $customer) {
            $result[$customer['id']] = $customer['full_name'];
        }
        return $result;
    }
	
}
