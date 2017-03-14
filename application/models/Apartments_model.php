<?php
class Apartments_model extends MY_Model
{
    public $table = 'apartments';

    public function get($params = [])
    {
        if (!isset($params['order'])) {
            $params['order'] = ['orderBy' => 'address'];
        }
        return parent::get($params);
    }

}