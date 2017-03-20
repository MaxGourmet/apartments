<?php
class Fairs_model extends MY_Model
{
    public $table = 'fairs';

    public function get($params = [])
    {
        if (!isset($params['order'])) {
            $params['order'] = ['orderBy' => 'start'];
        }
        return parent::get($params);
    }


    public function prepare(&$fairs)
    {
        $result = [];
        foreach ($fairs as $fair) {
            $start = $fair['start'];
            $end = $fair['end'];
            $dateRange = date_range($start, $end);
            foreach ($dateRange as $date) {
                if (!isset($result[$date])) {
                    $result[$date] = 0;
                }
                $result[$date] = max($result[$date], floatval($fair['price']));
            }
        }
        $fairs = $result;
    }
}