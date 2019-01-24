<?php
class Bookings_model extends MY_Model
{
    public $table = 'bookings';

    public $payments = [
        "bank" => "Bank",
        "bar" => "Bar"
    ];

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

    public function checkFreeBooking($params)
    {
        $bookingParams = [
            'filters' => [
                "`apartment_id` = {$params['apartment_id']}"
            ]
        ];
        if (isset($params['id'])) {
            $bookingParams['filters'][] = "`id` != {$params['id']}";
        }
        $existedBookings = $this->get($bookingParams);
        $existedDates = $this->getBookedDates($existedBookings);
        $newDates = date_range($params['start'], $params['end']);
        $diff = array_intersect($existedDates, $newDates);
        if (!empty($diff)) {
            $checkStart = in_array($params['start'], $diff);
            $checkEnd = in_array($params['end'], $diff);
            foreach ($existedBookings as $booking) {
                if ($booking['start'] == $params['start'] && $booking['end'] == $params['end']) {
                    continue;
                }
                if ($booking['start'] == $params['end'] && $checkEnd) {
                    if (in_array($params['end'], $diff)) {
                        $diff = array_diff($diff, [$params['end']]);
                    }
                }
                if ($booking['end'] == $params['start'] && $checkStart) {
                    if (in_array($params['start'], $diff)) {
                        $diff = array_diff($diff, [$params['start']]);
                    }
                }
            }
        }
        return empty($diff);
    }

    public function getBookedDates($bookings)
    {
        $existedDates = [];
        foreach ($bookings as $booking) {
            $dr = date_range(date('Y-m-d', strtotime($booking['start'] . " +1day")), date('Y-m-d', strtotime($booking['end'] . " -1day")));
            if (!$dr) {
                $dr = [$booking['start']];
            }
            $existedDates = array_merge($existedDates, $dr);
        }
        return $existedDates;
    }
}