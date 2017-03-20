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

    public function create($apartmentId = null, $startDate = null, $id = null)
    {
        if (($data = $this->post()) && !empty($data)) {
            array_extract($data, 'submit');
            $this->bookings->update($data);
            redirect();
        } else {
            $this->load->helper('form');
            $this->load->helper('html');
            $apartmentsResult = $this->apartments->get();
            $apartments = [];
            foreach ($apartmentsResult as $apartment) {
                $apartments[$apartment['id']] = $apartment['address'];
            }
            $selectedApartment = $apartmentsResult[0]['id'];
            if ($id) {
                $this->title = $this->configs->get(false, 'bookings_edit_title');
                $booking = $this->bookings->getById($id);
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
                $booking = [
                    'apartment_id' => $selectedApartment,
                    'start' => $startDate,
                    'end' => date('Y-m-d', strtotime("$startDate +1day")),
                    'to_pay' => 0,
                    'payed' => 0,
                    'info' => ''
                ];
            }
            $this->showView(
                'bookings/create',
                [
                    'apartments' => $apartments,
                    'booking' => $booking
                ]
            );
        }
    }

    public function edit($id) {
        if ($id) {
            $this->create(null, null, $id);
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
}
