<?php
class Fairs_model extends CI_Model {

    public $table = 'fairs';

    public function __construct()
    {
        $this->load->database();
    }

    public function get($filters = [])
    {
        $query = $this->db->select('*')->from($this->table);
        if (!empty($filters)) {
            foreach ($filters as $filter) {
                $key = "{$filter['field']} {$filter['operand']}";
                $value = $filter['value'];
                $query->where($key, $value);
            }
        }
        return $query->get()->result_array();
    }

    public function createFair($data)
    {
        if (isset($data['id'])) {
            $id = $data['id'];
            unset($data['id']);
            $this->db->update($this->table, $data, ['id' => $id]);
        } else {
            $this->db->insert($this->table, $data);
        }
    }
}