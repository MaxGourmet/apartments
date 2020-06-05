<style>
    <?php foreach ($colors as $color) : ?>
    .calendar td.booked.<?= $color['name']; ?> {
        background-color: <?= $color['value']; ?>;
    }
	.calendar td.booked.<?= $color['name']; ?>.one-day:before {
		background-color: <?= $color['value']; ?>;
	}
	.calendar td.booked.<?= $color['name']; ?>.one-day:after {
		background-color: <?= $color['value']; ?>;
	}
    <?php endforeach; ?>
	.calendar td.booked.one-day {
		background: #ff0000 !important;
	}
	.calendar td.booked.weekend.one-day {
		background: #ff0000 !important;
	}
</style>
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
    $prevMonthsArray = [];
    $nextMonthsArray = [];
    for ($i = 1; $i <= 6; $i++) {
        if ($i <= 2) {
            $p = 3 - $i;
            $pm = date('Y-m', strtotime($currentMonth . " -{$p} month"));
            $prevMonthsArray[$pm] = utf8_encode(strftime('%b', strtotime($pm)));
        }
        $nm = date('Y-m', strtotime($currentMonth . " +{$i} month"));
        $nextMonthsArray[$nm] = utf8_encode(strftime('%b', strtotime($nm)));
    }
    $year = date('y', strtotime($currentMonth));
    ?>
    <?php foreach ($prevMonthsArray as $m => $pM) : ?>
        <a class="little-month" href="/calendar/month/<?= $m; ?>"><?= $pM; ?></a>
    <?php endforeach; ?>
    <a id="prev_month" href="javascript:void(0)" data-attr-href="/calendar/month/<?= $previousMonth; ?>"><?//= $previousMonthText; ?>&laquo;</a>
    <span><?= "$currentMonthText $year"; ?></span>
    <a id="next_month" href="javascript:void(0)" data-attr-href="/calendar/month/<?= $nextMonth; ?>"><?//= $nextMonthText; ?>&raquo;</a>
    <?php foreach ($nextMonthsArray as $m => $nM) : ?>
        <a class="little-month" href="/calendar/month/<?= $m; ?>"><?= $nM; ?></a>
    <?php endforeach; ?>
</div>
<div class="calendar-wrap">
    <div class="inner">
            <table class="calendar">
                <thead>
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
                    <th></th>
                </tr>
                <?php foreach($fairs as $city => $fairDates) : ?>
                    <tr data-city="<?= $city; ?>">
                        <td><?= $city; ?></td>
                        <?php foreach ($monthDays as $date) : ?>
                            <?php
                            $i++;
                            $isWeekend = in_array(date('N', strtotime($date)), [6, 7]);
                            $isToday = $date == date('Y-m-d');
                            ?>
                            <?php if (isset($fairDates[$date])) : ?>
                                <?php list($id, $name) = explode('|||', $fairDates[$date]); ?>
                                <td class="<?= $isWeekend ? 'weekend' : '' ?>" data-fair-id="<?= $id; ?>" data-name="<?= $name; ?>"></td>
                            <?php else : ?>
                                <td class="<?= $isWeekend ? 'weekend' : '' ?>"></td>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
                </thead>
                <tbody>
                <?php foreach($apartments as $apartment) : ?>
                  <?php $bookingsForApartment = isset($bookings[$apartment['id']]) ? $bookings[$apartment['id']] : []; ?>
                    <tr data-attr-apartment_id="<?= $apartment['id']; ?>">
                        <td><?= $apartment['address']; ?></td>
                          <?php
                          foreach($monthDays as $date) {
                            $isWeekend = in_array(date('N', strtotime($date)), [6, 7]);
                            $defaultClass = $isWeekend ? 'weekend free' : 'free';
                            $addClass = '';
                            $addAttributes = "data-attr-date='$date'";
                            $bookingIdForDate = 0;
                            $bookingsForThisDay = [
								'fd' => 0,
								'ld' => 0,
								'od' => 0
							];
                            if (!empty($bookingsForApartment)) {
                              foreach ($bookingsForApartment as $bookingId => $booking) {
                                $info = '';
                                $colspan = 1;
                                if (in_array($date, $booking)) {
                                  $addClass = $booking[0] == $date ? $addClass . ' first-day' : $addClass;
                                  $addClass = $booking[count($booking) - 1] == $date ? $addClass . ' last-day' : $addClass;
                                  $addClass = ($booking[count($booking) - 1] == $date) && $bookingsData[$bookingId]['is_final_decision'] ? $addClass . ' final_decision' : $addClass;
                                  if (count($booking) == 2) {
                                  	$addClass .= ' one-day';
								  }
                                  $defaultClass = $defaultClass == 'weekend free' ? 'weekend booked' : 'booked';
                                  $defaultClass .= " {$bookingsData[$bookingId]['payment_status']}";
                                  if ($booking[0] == $date) {
									  $bookingsForThisDay['fd'] = $bookingId;
								  }
                                  if ($booking[count($booking) - 1] == $date) {
									  $bookingsForThisDay['ld'] = $bookingId;
								  }
                                  $bookingsForThisDay['od'] = $bookingId;

                                  if (isset($bookingsInfo[$bookingId])) {
                                    $info = "data-info='{$bookingsInfo[$bookingId]}'";
                                    //                                $info = $bookingsInfo[$bookingId];
                                  }
                                  $colspan++;
                                }
                              }
                            }
                            if ($bookingsForThisDay['fd'] != 0) {
								$bookingIdForDate = $bookingsForThisDay['fd'];
							} elseif ($bookingsForThisDay['ld'] != 0) {
								$bookingIdForDate = $bookingsForThisDay['ld'];
							} elseif ($bookingsForThisDay['od'] != 0) {
								$bookingIdForDate = $bookingsForThisDay['od'];
							}
                            if ($bookingIdForDate != 0) {
								$addAttributes .= " data-attr-booking_id='$bookingIdForDate'";
							}
                            echo "<td $info class='$defaultClass $addClass' $addAttributes></td>";
                          }
                          ?>
                        <td><?= $apartment['address']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
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
                    <td></td>
                </tr>
                </tfoot>

            </table>
    </div>
</div>

<script>
    var bookingsInfo = <?= json_encode($bookingsInfo); ?>;
    var fairs = <?= json_encode($fairForJS); ?>;
</script>
