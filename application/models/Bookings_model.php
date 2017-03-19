<?php
class Bookings_model extends MY_Model
{
    public $table = 'bookings';

    public function prepare(&$bookings) {
        $result = [];
        foreach ($bookings as $booking) {
            $start = $booking['start'];
            $end = $booking['end'];
            $dateRange = date_range($start, $end);
            if (!isset($result[$booking['apartment_id']])) {
                $result[$booking['apartment_id']] = [];
            }
            $result[$booking['apartment_id']][$booking['id']] = $dateRange;
        }
        $bookings = $result;
    }
}