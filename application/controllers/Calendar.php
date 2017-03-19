<?php
class Calendar extends MY_Controller
{
    public function index($ym = null)
    {
        $apartments = $this->apartments->get();
        $filtersDate = $ym && ($d = date('Y-m', strtotime($ym))) ? $d : date('Y-m');
        $monthDays = intval(date("t", strtotime($filtersDate)));
        $monthDays = date_range("$filtersDate-01", "$filtersDate-$monthDays");
        $bookingFilters = [
            'filters' => ["(start >= '$filtersDate-01' OR end <= '$filtersDate-31')"]
        ];
        $bookings = $this->bookings->get($bookingFilters);
        $this->bookings->prepare($bookings);
        $this->showView(
            'calendar/index',
            [
                'apartments' => $apartments,
                'bookings' =>  $bookings,
                'monthDays' => $monthDays,
                'currentMonth' => $filtersDate
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
