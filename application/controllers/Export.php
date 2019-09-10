<?php
class Export extends MY_Controller
{
    public function __construct()
    {
        $this->needCheckAuth = false;
        parent::__construct();
    }

    public function calendar($apartmentId)
    {
        $this->needCheckAuth = false;
        $bookings = $this->bookings->get([
            'select' => ['id', 'start', 'end', 'info'],
            'filters' => [['field' => 'apartment_id', 'operand' => '=', 'value' => $apartmentId]]
        ]);
        $calendar = "BEGIN:VCALENDAR\r\n";
        $calendar .= "PRODID;X-RICAL-TZSOURCE=TZINFO:-//Airbnb Inc//Hosting Calendar 0.8.8//EN\r\n";
        $calendar .= "CALSCALE:GREGORIAN\r\n";
        $calendar .= "VERSION:2.0\r\n";
        foreach ($bookings as $d) {
            $dateStart = date('Ymd', strtotime($d['start']));
            $dateEnd = date('Ymd', strtotime($d['end']));
            $calendar .= "BEGIN:VEVENT\r\n";
            $calendar .= "DTSTART;VALUE=DATE:{$dateStart}\r\n";
            $calendar .= "DTEND;VALUE=DATE:{$dateEnd}\r\n";
            $calendar .= "SUMMARY:{$dateStart}-{$dateEnd}\r\n";
            $calendar .= "UID:{$apartmentId}\r\n";
            $calendar .= "END:VEVENT\r\n";
        }
        $calendar .= "END:VCALENDAR";
        if (ob_get_level()) {
            ob_end_clean();
        }
        $txt = tmpfile();
        fwrite($txt, $calendar);
        fseek($txt, 0);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=calendar_$apartmentId.ics");
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($calendar));
        echo fread($txt, strlen($calendar));
        exit;
    }
}