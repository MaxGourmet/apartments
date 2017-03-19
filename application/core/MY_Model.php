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
        $select = isset($params['select']) ? $params['select'] : "{$this->table}.*";
        $filters = isset($params['filters']) ? $params['filters'] : [];
        $order = isset($params['order']) ? $params['order'] : false;
        $limit = isset($params['limit']) ? $params['limit'] : 0;
        $offset = isset($params['offset']) ? $params['offset'] : 0;
        $joins = isset($params['joins']) ? $params['joins'] : [];
        $query = $this->db->select($select)->from($this->table);
        foreach ($filters as $filter) {
            if (is_array($filter)) {
                $key = "{$filter['field']} {$filter['operand']}";
                $value = $filter['value'];
                $query->where($key, $value);
            } else {
                $query->where($filter);
            }
        }
        foreach ($joins as $join) {
            $table = $join['table'];
            $type = isset($join['type']) ? $join['type'] : '';
            $condition = $join['condition'];
            if (isset($join['select'])) {
                $query->select($join['select']);
            }
            $query->join($table, $condition, $type);
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

    public function getById($id)
    {
        if (!$id) {
            return [];
        }
        $params = [
            'filters' => [
                [
                    'field' => 'id',
                    'operand' => '=',
                    'value' => $id
                ]
            ]
        ];
        $result = self::get($params);
        return isset($result[0]) ? $result[0] : [];
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

    public function delete($id)
    {
        return $this->db->delete($this->table, "id = $id");
    }

    public function deleteAll()
    {
        return $this->db->truncate($this->table);
    }

    public function dump($table = false)
    {
        if (!$table) {
            $tablesFromDb = $this->db->query("SHOW TABLES")->result_array();
            $tables = [];
            foreach ($tablesFromDb as $table) {
                $tables[] = current($table);
            }
        } else {
            $tables = [$table];
        }
        $dumpDir = __DIR__;
        $dumpDir = str_replace(['application\core', 'application/core'], '', $dumpDir);
        $dumpDir .= 'assets/uploads/';
        $dumpDir = str_replace('\\', '/', $dumpDir);
        foreach ($tables as $table) {
            $fileName = $dumpDir . $table . "_" . date('Y-m-d') . ".sql";
            $this->db->query("SELECT * FROM $table INTO OUTFILE '$fileName'");
        }
    }
}