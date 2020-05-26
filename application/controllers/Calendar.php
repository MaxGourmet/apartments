<?php
class Calendar extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->checkRole('admin') && !$this->checkRole('viewer')) {
            show_404();
        }
    }

    public function index($ym = null)
    {
        $filtersDate = $ym && ($d = date('Y-m', strtotime($ym))) ? $d : date('Y-m');
        $this->title = utf8_encode(strftime('%B', strtotime($filtersDate)));
        $this->needTitle = false;
        $apartments = $this->apartments->get();
        $monthDays = intval(date("t", strtotime($filtersDate)));
        $monthDays = date_range("$filtersDate-01", "$filtersDate-$monthDays");
        $ym = date('Ym', strtotime($filtersDate));
        $bookingFilters = [
            'select' => "*, DATE_FORMAT(`start`, '%Y%m') AS start_month, DATE_FORMAT(`end`, '%Y%m') AS end_month",
            'having' => ["(start_month <= '$ym' OR end_month >= '$ym')"]
        ];
        $bookings = $this->bookings->get($bookingFilters);
        $bookingsInfo = [];
		$bookingsData =[];
        foreach ($bookings as $booking) {
            $preparedInfo = trim($booking['info']);
            $preparedInfo = str_replace(["\r\n", "\r", "\n"], ' ', $preparedInfo);
            $bookingsInfo[$booking['id']] = $preparedInfo;
            $bookingsData[$booking['id']] = $booking;
        }
        $this->bookings->prepare($bookings);
        $start = date('Y-m-01', strtotime($filtersDate));
        $end = date('Y-m-31', strtotime($filtersDate));
        $fairs = $this->fairs->get([
            'filters' => [
                "(start >= '$start' OR end <= '$end')"
            ]
        ]);
        $fairRes = [];
        $fairForJS = [];
        foreach ($fairs as $fair) {
            $start = $fair['start'];
            $end = $fair['end'];
            $dateRange = date_range($start, $end);
            if (!isset($fairRes[$fair['city']])) {
                $fairRes[$fair['city']] = [];
            }
            foreach ($dateRange as $date) {
                $fairRes[$fair['city']][$date] = "{$fair['id']}|||{$fair['name']}";
            }
            $fairForJS[$fair['id']] = $fair['name'];
        }
        $colors = $this->configs->get('colors');
        $this->showView(
            'calendar/index',
            [
                'apartments' => $apartments,
                'bookings' =>  $bookings,
                'monthDays' => $monthDays,
                'currentMonth' => $filtersDate,
                'bookingsInfo' => $bookingsInfo,
                'bookingsData' => $bookingsData,
                'fairs' => $fairRes,
                'fairForJS' => $fairForJS,
                'colors' => $colors
            ]
        );
    }

    public function month($ym)
    {
        if ($ym && (date('Y-m', strtotime($ym)) != '1970-01')) {
            $this->index($ym);
        } else {
            redirect();
        }
    }
}
