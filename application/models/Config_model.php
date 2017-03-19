<?php
class Config_model extends MY_Model
{
    public $table = 'config';

    public function get($param = false, $default = false)
    {
        if (!$param) {
            return '';
        }
        $query = $this->db->select('value')
            ->from($this->table)
            ->where('name', $param);
        $result = $query->get()->row();
        return $result ? $result->value : $default;
    }
}