<div class="month">
    <?php
    $previousMonth = date('Y-m', strtotime($currentMonth . " -1month"));
    $nextMonth = date('Y-m', strtotime($currentMonth . " +1month"));
//    $previousMonthText = date('F', strtotime($previousMonth));
//    $currentMonthText = date('F', strtotime($currentMonth));
//    $nextMonthText = date('F', strtotime($nextMonth));strftime('%A')
    $r = setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
    $previousMonthText = utf8_encode(strftime('%B', strtotime($previousMonth)));
    $currentMonthText = utf8_encode(strftime('%B', strtotime($currentMonth)));
    $nextMonthText = utf8_encode(strftime('%B', strtotime($nextMonth)));
    ?>
    <a id="prev_month" href="javascript:void(0)" data-attr-href="/calendar/month/<?= $previousMonth; ?>"><?//= $previousMonthText; ?>&laquo;</a>
    <span><?= $currentMonthText; ?></span>
    <a id="next_month" href="javascript:void(0)" data-attr-href="/calendar/month/<?= $nextMonth; ?>"><?//= $nextMonthText; ?>&raquo;</a>
</div>
<table class="calendar">
    <tr>
        <th></th>
        <?php $i = 0; ?>
        <?php foreach ($monthDays as $date) : ?>
            <?php
            $i++;
            $isWeekend = in_array(date('N', strtotime($date)), [6, 7]);
            $isToday = $date == date('Y-m-d');
            ?>
            <th class="date <?= $isWeekend ? 'weekend' : '' ?> <?= $isToday ? 'today' : '' ?>"><?= $i; ?></th>
        <?php endforeach; ?>
    </tr>
    <?php foreach($apartments as $apartment) : ?>
        <?php $bookingsForApartment = isset($bookings[$apartment['id']]) ? $bookings[$apartment['id']] : []; ?>
        <tr data-attr-apartment_id="<?= $apartment['id']; ?>">
            <td><?= $apartment['address']; ?></td>
            <?php
            foreach($monthDays as $date) {
                $isWeekend = in_array(date('N', strtotime($date)), [6, 7]);
                $defaultClass = $isWeekend ? 'weekend' : 'free';
                $addClass = '';
                $addAttributes = "data-attr-date='$date'";
                if (!empty($bookingsForApartment)) {
                    foreach ($bookingsForApartment as $bookingId => $booking) {
                        $info = '';
                        $colspan = 1;
                        if (in_array($date, $booking)) {
                            $addClass = $booking[0] == $date ? $addClass . ' first-day' : $addClass;
                            $addClass = $booking[count($booking) - 1] == $date ? $addClass . ' last-day' : $addClass;
                            $defaultClass = 'booked';
                            $addAttributes .= " data-attr-booking_id='$bookingId'";
                            if (isset($bookingsInfo[$bookingId])) {
                                $info = "data-info='{$bookingsInfo[$bookingId]}'";
//                                $info = $bookingsInfo[$bookingId];
                            }
                            $colspan++;
                        }
                    }
                }
                echo "<td $info class='$defaultClass $addClass' $addAttributes></td>";
            }
            ?>
        </tr>
    <?php endforeach; ?>
</table>
<script>
    var bookingsInfo = <?= json_encode($bookingsInfo); ?>;
</script>