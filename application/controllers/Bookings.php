<?php
class Bookings extends MY_Controller
{
    public function __construct()
    {
    	$path = $_SERVER['PATH_INFO'];
    	$isReminder = strpos($path, 'remind') !== false && strpos($path, 'reminder') === false;
    	if ($isReminder) {
			$this->needCheckAuth = false;
		}
        parent::__construct();
        if (!$this->checkRole('admin') && !$this->checkRole('viewer')) {
            show_404();
        }
    }

    public function index()
    {
		if ($this->checkRole('viewer')) {
			show_404();
		}
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
		if ($this->checkRole('viewer')) {
			show_404();
		}
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
        $payments = $this->bookings->paymentStatus;
        $is_final_decision = $this->configs->get(false, 'is_final_decision', 'ohne Verlängerungsoption');
        reset($payments);
        $services = $this->services->get();
		$vatRates = $this->configs->getPrepared('vat_rate', false, []);
        if (($data = $this->post()) && !empty($data)) {
//			if ($this->checkRole('viewer')) {
//				show_404();
//			}
            array_extract($data, 'submit');
            if ($this->bookings->checkBooking($data)) {
                $data['start_time'] = date('H:i:s', strtotime($data['start_time']));
                $data['end_time'] = date('H:i:s', strtotime($data['end_time']));
                $data['start'] = date('Y-m-d', strtotime($data['start']));
                $data['end'] = date('Y-m-d', strtotime($data['end']));
                $data['payment_status'] = isset($payments[$data['payment_status']]) ? $data['payment_status'] : null;
                if (!isset($data['is_final_decision'])) {
                    $data['is_final_decision'] = 0;
                }
                $servicesToSave = array_extract($data, 'services');

                $this->bookings->update($data);

                if (!empty($servicesToSave)) {
                	$bookingId = isset($data['id']) ? $data['id'] : $this->bookings->getLastId();
                	$this->services_to_booking->save($bookingId, $services);
				}
                $m = date('Y-m', strtotime($data['start']));
                redirect("/calendar/month/$m");
            } else {
                $this->showView(
                    'bookings/create',
                    [
                        'apartments' => $this->apartments->prepare($this->apartments->get()),
                        'booking' => $data,
                        'error' => 'Sorry, but this dates are booked now. Please check another.',
						'services' => $services,
						'vatRates' => $vatRates
                    ]
                );
            }
        } else {
            $apartmentsRes = $this->apartments->get(['index' => 'id']);
            $apartments = $this->apartments->prepare($apartmentsRes);
            reset($apartments);
            $selectedApartment = key($apartments);
            $customers = $this->customers->getForDropdown();
            if ($id) {
                $this->title = $this->configs->get(false, 'bookings_edit_title');
                $booking = $this->bookings->getById($id);
                $booking['services'] = $this->services_to_booking->getById($id);
                var_dump($booking['services']);exit;
				if ($this->checkRole('viewer') && strtotime($booking['start']) < strtotime("2020-06-01")) {
					show_404();
				}
                if (!$booking['start_time']) {
                    $bookingStart = $this->configs->get(false, 'booking_start');
                    $booking['start_time'] = date('H:i:s', strtotime($bookingStart));
                }
                if (!$booking['end_time']) {
                    $bookingEnd = $this->configs->get(false, 'booking_end');
                    $booking['end_time'] = date('H:i:s', strtotime($bookingEnd));
                }
                if (!$booking['payment_status']) {
                    $booking['payment_status'] = key($payments);
                }
                if (!isset($booking['is_final_decision'])) {
                    $booking['is_final_decision'] = 0;
                }
                if (!$booking['people_count']) {
                    $booking['people_count'] = $apartmentsRes[$booking['apartment_id']]['beds'];
                }
                if (!$booking['payment_info']) {
                    $booking['payment_info'] = '';
                }
                $booking['nights'] = count(date_range(strtotime($booking['start']), strtotime($booking['end']))) - 1;
                if (empty($booking)) {
                    redirect('bookings');
                }
            } else {
				if ($this->checkRole('viewer')) {
					show_404();
				}
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
                $nights = count(date_range(strtotime($startDate), strtotime($endDate))) - 1;
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
                    'payment_status' => key($payments),
                    'people_count' => $apartmentsRes[$selectedApartment]['beds'],
                    'nights' => $nights,
					'is_final_decision' => 0,
					'payment_info' => '',
					'customer_id' => null,
					'services' => []
                ];
            }
            $totalPeopleCount = [];
            foreach ($apartmentsRes as $id => $ap) {
                $totalPeopleCount[$id] = $ap['beds'];
            }
            $this->showView(
                'bookings/create',
                [
                    'apartments' => $apartments,
                    'booking' => $booking,
                    'payments' => $payments,
                    'maxPeopleCount' => $apartmentsRes[$booking['apartment_id']]['beds'],
                    'totalPeopleCount' => $totalPeopleCount,
                    'is_final_decision' => $is_final_decision,
					'customers' => $customers,
					'services'=> $services,
					'vatRates' => $vatRates
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
                    ],
					[
						'or' => 'or',
						'field' => 'payment_info',
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
		if ($this->checkRole('viewer')) {
			show_404();
		}
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
            $tempStartRemind = $booking['start_time'] ? $booking['start_time'] : $startRemind;
            $tempEndRemind = $booking['end_time'] ? $booking['end_time'] : $endRemind;
            if ($booking['start'] == $date) {
                $type = 'start';
                $bookingReminder = strtotime($booking['start'] . " $bookingStart -$tempStartRemind minutes");
            } else {
                $type = 'end';
                $bookingReminder = strtotime($booking['end'] . " $bookingEnd -$tempEndRemind minutes");
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
		if ($this->checkRole('viewer')) {
			show_404();
		}
        if ($id) {
            $this->bookings->delete($id);
        }
        redirect('calendar');
    }

    public function confirmPayment()
    {
		if ($this->checkRole('viewer')) {
			show_404();
		}
        if (!$this->checkAjax()) {
            return;
        }
        $data = $this->post('data');
        $booking = $this->bookings->getById($data['id']);
        $booking['payed'] = $booking['to_pay'];
        $this->bookings->update($booking);
    }

    public function print_bill($id)
	{
		$booking = $this->bookings->getById($id);
		$apartment = $this->apartments->getById($booking['apartment_id']);
		$customer = $this->customers->getById($booking['customer_id']);
		$vatRates = $this->configs->getPrepared('vat_rate', false, []);
		var_dump($booking, $apartment, $customer, $vatRates);exit;
		$this->showView(
			'bookings/print_bill',
			[
//				'email' => $email,
//				'startRemind' => $startRemind,
//				'endRemind' => $endRemind,
			]
		);
	}
}
