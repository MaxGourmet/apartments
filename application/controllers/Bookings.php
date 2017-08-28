<?php
class Bookings extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->checkRole('admin')) {
            show_404();
        }
    }

    public function index()
    {
        $this->title = $this->configs->get(false, 'bookings_title');
        $params = [
            'filters' => [
                [
                    'field' => '(`to_pay` - `payed`)',
                    'operand' => '>',
                    'value' => 0
                ]
            ]
        ];
        $this->indexView($params);
    }

    protected function indexView($additionalParams = [])
    {
        $params = [
            'filters' => [],
            'joins' => [
                [
                    'select' => 'address',
                    'table' => 'apartments',
                    'condition' => 'apartments.id = apartment_id'
                ]
            ]
        ];
        if ($additionalParams) {
            $params['filters'] = array_merge($params['filters'], $additionalParams['filters']);
        }
        $bookings = $this->bookings->get($params);
        foreach ($bookings as &$booking) {
            $booking['diff'] = floatval($booking['to_pay']) - floatval($booking['payed']);
        }
        $this->showView(
            'bookings/index',
            [
                'bookings' => $bookings
            ]
        );
    }

    public function create($apartmentId = null, $startDate = null, $endDate = null, $id = null)
    {
        $this->load->helper('form');
        $this->load->helper('html');
        $payments = $this->bookings->payments;
        reset($payments);
        if (($data = $this->post()) && !empty($data)) {
            array_extract($data, 'submit');
            if ($this->bookings->checkFreeBooking($data)) {
                $data['start_time'] = date('H:i:s', strtotime($data['start_time']));
                $data['end_time'] = date('H:i:s', strtotime($data['end_time']));
                $data['payment_method'] = isset($payments[$data['payment_method']]) ? $data['payment_method'] : null;
                $this->bookings->update($data);
                $m = date('Y-m', strtotime($data['start']));
                redirect("/calendar/month/$m");
            } else {
                $this->showView(
                    'bookings/create',
                    [
                        'apartments' => $this->apartments->prepare($this->apartments->get()),
                        'booking' => $data,
                        'error' => 'Sorry, but this dates are booked now. Please check another.'
                    ]
                );
            }
        } else {
            $apartments = $this->apartments->prepare($this->apartments->get());
            reset($apartments);
            $selectedApartment = key($apartments);
            if ($id) {
                $this->title = $this->configs->get(false, 'bookings_edit_title');
                $booking = $this->bookings->getById($id);
                if (!$booking['start_time']) {
                    $bookingStart = $this->configs->get(false, 'booking_start');
                    $booking['start_time'] = date('H:i:s', strtotime($bookingStart));
                }
                if (!$booking['end_time']) {
                    $bookingEnd = $this->configs->get(false, 'booking_end');
                    $booking['end_time'] = date('H:i:s', strtotime($bookingEnd));
                }
                if (!$booking['payment_method']) {
                    $booking['payment_method'] = key($payments);
                }
                if (empty($booking)) {
                    redirect('bookings');
                }
            } else {
                $this->title = $this->configs->get(false, 'bookings_create_title');
                if ($apartmentId && isset($apartments[$apartmentId])) {
                    $selectedApartment = $apartmentId;
                }
                if ($startDate) {
                    $startDate = date('Y-m-d', strtotime($startDate));
                    if ($startDate == '1970-01-01') {
                        $startDate = date('Y-m-d');
                    }
                } else {
                    $startDate = date('Y-m-d');
                }
                if ($endDate) {
                    $endDate = date('Y-m-d', strtotime($endDate));
                    if ($endDate == '1970-01-01') {
                        $endDate = date('Y-m-d', strtotime("$startDate +1day"));
                    }
                } else {
                    $endDate = date('Y-m-d', strtotime("$startDate +1day"));
                }
                if (strtotime($startDate) > strtotime($endDate)) {
                    $endDate = $startDate;
                }
                $bookingStart = $this->configs->get(false, 'booking_start');
                $bookingEnd = $this->configs->get(false, 'booking_end');
                $startTime = date('H:i:s', strtotime($bookingStart));
                $endTime = date('H:i:s', strtotime($bookingEnd));
                $booking = [
                    'apartment_id' => $selectedApartment,
                    'start' => $startDate,
                    'end' => $endDate,
                    'to_pay' => 0,
                    'payed' => 0,
                    'info' => '',
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'payment_method' => key($payments),
                ];
            }
            $this->showView(
                'bookings/create',
                [
                    'apartments' => $apartments,
                    'booking' => $booking,
                    'payments' => $payments
                ]
            );
        }
    }

    public function edit($id)
    {
        if ($id) {
            $this->create(null, null, null, $id);
        } else {
            redirect('bookings');
        }
    }

    public function search()
    {
        $this->title = $this->configs->get(false, 'bookings_search_title');
        $searchQuery = $this->get('search');
        if ($searchQuery) {
            $params = [
                'filters' => [
                    [
                        'field' => 'info',
                        'operand' => 'like',
                        'value' => "%$searchQuery%"
                    ]
                ]
            ];
            $this->indexView($params);
        }
    }

    public function reminder()
    {
        $this->title = $this->configs->get(false, 'reminder');
        $this->load->helper('form');
        $this->load->helper('html');
        if (($data = $this->post()) && !empty($data)) {
            array_extract($data, 'submit');
            $this->configs->updateConfig('reminder', 'email', $data['email']);
            $this->configs->updateConfig('reminder', 'start_remind', $data['start_remind']);
            $this->configs->updateConfig('reminder', 'end_remind', $data['end_remind']);
            redirect('bookings/reminder');
        } else {
            $reminderConfigs = $this->configs->get('reminder');
            $email = '';
            $startRemind = '';
            $endRemind = '';
            foreach ($reminderConfigs as $config) {
                if ($config['name'] == 'email') {
                    $email = $config['value'];
                }
                if ($config['name'] == 'start_remind') {
                    $startRemind = $config['value'];
                }
                if ($config['name'] == 'end_remind') {
                    $endRemind = $config['value'];
                }
            }
            $this->showView(
                'bookings/reminder',
                [
                    'email' => $email,
                    'startRemind' => $startRemind,
                    'endRemind' => $endRemind,
                ]
            );
        }
    }

    public function remind()
    {
        $reminderConfigs = $this->configs->get('reminder');
        $bookingStart = $this->configs->get(false, 'booking_start');
        $bookingEnd = $this->configs->get(false, 'booking_end');
        $email = '';
        $startRemind = '';
        $endRemind = '';
        foreach ($reminderConfigs as $config) {
            if ($config['name'] == 'email') {
                $email = $config['value'];
            }
            if ($config['name'] == 'start_remind') {
                $startRemind = $config['value'];
            }
            if ($config['name'] == 'end_remind') {
                $endRemind = $config['value'];
            }
        }
//        $startDate = date('Y-m-d H:i:s', strtotime(""));
        $date = date('Y-m-d');
        $bookingsParams = [
            'filters' => [
                "(`start` = '$date' OR `end` = '$date')"
            ],
            'joins' => [
                [
                    'select' => 'address',
                    'table' => 'apartments',
                    'condition' => 'apartments.id = apartment_id'
                ]
            ]
        ];
        $bookings = $this->bookings->get($bookingsParams);
        foreach ($bookings as $booking) {
            if ($booking['start'] == $date) {
                $type = 'start';
                $bookingReminder = strtotime($booking['start'] . " $bookingStart -$startRemind minutes");
            } else {
                $type = 'end';
                $bookingReminder = strtotime($booking['end'] . " $bookingEnd -$endRemind minutes");
            }
            if (time() >= $bookingReminder && $this->reminder->checkNeedRemind($booking['id'], $type)) {
                $subject = ucfirst($type) . ". Booking ID: {$booking['id']}. Address: {$booking['address']}.";
                array_extract($booking, 'apartment_id');
                $message = '';
                foreach ($booking as $key => $value) {
                    $message .= ucfirst($key) . ": $value \r\n";
                }
                $emailPostFix = str_replace(['http://', 'https://', '/', '//'], '', base_url());
                $emailPostFix = $emailPostFix ? $emailPostFix : 'apartments.de';
                $header = "From: Apartments info <info@{$emailPostFix}>";
                $res = mail($email, $subject, $message, $header);
                if ($res) {
                    $this->reminder->saveRemind($booking['id'], $type);
                }
            }
        }
    }

    public function delete($id)
    {
        if ($id) {
            $this->bookings->delete($id);
        }
        redirect('calendar');
    }

    public function confirmPayment()
    {
        if (!$this->checkAjax()) {
            return;
        }
        $data = $this->post('data');
        $booking = $this->bookings->getById($data['id']);
        $booking['payed'] = $booking['to_pay'];
        $this->bookings->update($booking);
    }
}
