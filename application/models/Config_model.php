<?php
class Config_model extends MY_Model
{
    public $table = 'config';

    public function get($alias = false, $param = false, $default = false)
    {
        if ($alias) {
            $query = $this->db->select('*')
                ->from($this->table)
                ->where('alias', $alias);
            $result = $query->get()->result_array();
            return !empty($result) ? $result : $default;
        } elseif ($param) {
            $query = $this->db->select('value')
                ->from($this->table)
                ->where('name', $param);
            $result = $query->get()->row();
            return $result ? $result->value : $default;
        } elseif (!$alias && !$param) {
            $params = [
                'filters' => [
                    [
                        'field' => 'editable',
                        'operand' => '=',
                        'value' => '1'
                    ]
                ],
                'order' => [
                    'orderBy' => 'alias'
                ]
            ];
            return parent::get($params);
        } else {
            return $default;
        }
    }

    public function getMenuLang()
    {
        $langsResult = $this->get('menu_lang');
        $result = [];
        foreach ($langsResult as $l) {
            $result[$l['name']] = $l['value'];
        }
        return $result;
    }

    public function updateConfig($alias, $name, $value)
    {
        return $this->db->update($this->table, ['value' => $value], ['alias' => $alias, 'name' => $name]);
    }
}