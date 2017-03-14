<?php
/**
 * @property CI_DB_query_builder $db
 */
class MY_Model extends CI_Model
{
    public $table;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get($params = [])
    {
        $select = isset($params['select']) ? $params['select'] : '*';
        $filters = isset($params['filters']) ? $params['filters'] : [];
        $order = isset($params['order']) ? $params['order'] : false;
        $limit = isset($params['limit']) ? $params['limit'] : 0;
        $offset = isset($params['offset']) ? $params['offset'] : 0;
        $query = $this->db->select($select)->from($this->table);
        foreach ($filters as $filter) {
            $key = "{$filter['field']} {$filter['operand']}";
            $value = $filter['value'];
            $query->where($key, $value);
        }
        if ($order) {
            $orderBy = isset($order['orderBy']) ? $order['orderBy'] : 'id';
            $direction = isset($order['direction']) ? $order['direction'] : 'ASC';
            $query->order_by($orderBy, $direction);
        }
        if ($limit) {
            $query->limit($limit);
        }
        if ($offset) {
            $query->offset($offset);
        }
        return $query->get()->result_array();
    }

    public function update($data)
    {
        if (isset($data['id'])) {
            $id = array_extract($data, 'id');
            $this->db->update($this->table, $data, ['id' => $id]);
        } else {
            $this->db->insert($this->table, $data);
        }
    }
}