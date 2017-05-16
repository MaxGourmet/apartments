<?php
class Calendar extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->checkRole('admin')) {
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
        foreach ($bookings as $booking) {
            $preparedInfo = trim($booking['info']);
            $preparedInfo = str_replace(["\r\n", "\r", "\n"], ' ', $preparedInfo);
            $bookingsInfo[$booking['id']] = $preparedInfo;
        }
        $this->bookings->prepare($bookings);
        $this->showView(
            'calendar/index',
            [
                'apartments' => $apartments,
                'bookings' =>  $bookings,
                'monthDays' => $monthDays,
                'currentMonth' => $filtersDate,
                'bookingsInfo' => $bookingsInfo,
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
