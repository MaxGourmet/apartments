<?php
class Reminder_model extends MY_Model
{
    public $table = 'reminder';

    public function checkNeedRemind($bookingId, $type)
    {
        $filters = [
            'filters' => [
                [
                    'field' => 'booking_id',
                    'operand' => '=',
                    'value' => $bookingId
                ],
                [
                    'field' => 'type',
                    'operand' => '=',
                    'value' => $type
                ],
            ]
        ];
        $result = $this->get($filters);
        return empty($result);
    }

    public function saveRemind($bookingId, $type)
    {
        $data = [
            'booking_id' => $bookingId,
            'date' => date('Y-m-d H:i:s'),
            'type' => $type
        ];
        return $this->db->insert($this->table, $data);
    }
}