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
	<a id="prev_month" href="javascript:void(0)"
	   data-attr-href="/calendar/month/<?= $previousMonth; ?>"><? //= $previousMonthText; ?>&laquo;</a>
	<span><?= "$currentMonthText $year"; ?></span>
	<a id="next_month" href="javascript:void(0)"
	   data-attr-href="/calendar/month/<?= $nextMonth; ?>"><? //= $nextMonthText; ?>&raquo;</a>
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
					<th colspan="2"
						class="date <?= $isWeekend ? 'weekend' : '' ?> <?= $isToday ? 'today' : '' ?>"><?= $i; ?></th>
				<?php endforeach; ?>
				<th></th>
			</tr>
			<?php foreach ($fairs as $city => $fairDates) : ?>
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
							<td class="<?= $isWeekend ? 'weekend' : '' ?>" data-fair-id="<?= $id; ?>"
								data-name="<?= $name; ?>"></td>
							<td class="<?= $isWeekend ? 'weekend' : '' ?>" data-fair-id="<?= $id; ?>"
								data-name="<?= $name; ?>"></td>
						<?php else : ?>
							<td class="<?= $isWeekend ? 'weekend' : '' ?>"></td>
							<td class="<?= $isWeekend ? 'weekend' : '' ?>"></td>
						<?php endif; ?>
					<?php endforeach; ?>
					<td></td>
				</tr>
			<?php endforeach; ?>
			</thead>
			<tbody>
			<?php foreach ($apartments as $apartment) : ?>
				<?php $bookingsForApartment = isset($bookings[$apartment['id']]) ? $bookings[$apartment['id']] : []; ?>
				<tr data-attr-apartment_id="<?= $apartment['id']; ?>">
					<td><?= $apartment['address']; ?></td>
					<?php
					foreach ($monthDays as $date) {
						$isWeekend = in_array(date('N', strtotime($date)), [6, 7]);
						$defaultClass = $isWeekend ? 'weekend free' : 'free';
						$defaultClass1 = $defaultClass2 = $defaultClass;
						$addClass = '';
						$addClass1 = $addClass2 = $addClass;
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
									$isFirstDay = $booking[0] == $date;
									$isLastDay = $booking[count($booking) - 1] == $date;
									$oneDay = count($booking) == 2;

									if ($isFirstDay) {
										$bookingsForThisDay['fd'] = $bookingId;
										$defaultClass2 = $isWeekend ? 'weekend booked' : 'booked';
										$defaultClass2 .= " {$bookingsData[$bookingId]['payment_status']}";
										$addClass2 .= ' first-day';
										if ($oneDay) {
											$addClass2 .= ' one-day';
										}
										$info = "data-info='{$bookingsInfo[$bookingId]}'";
									}

									if ($isLastDay) {
										$bookingsForThisDay['ld'] = $bookingId;
										$defaultClass1 = $isWeekend ? 'weekend booked' : 'booked';
										$defaultClass1 .= " {$bookingsData[$bookingId]['payment_status']}";
										$addClass1 .= ' last-day';
										if ($bookingsData[$bookingId]['is_final_decision']) {
											$addClass1 .= ' final_decision';
										}
										if ($oneDay) {
											$addClass1 .= ' one-day';
										}
										$info = "data-info='{$bookingsInfo[$bookingId]}'";
									}

									if (!$isFirstDay && !$isLastDay) {
										$defaultClass = $isWeekend ? 'weekend booked' : 'booked';
										$defaultClass .= " {$bookingsData[$bookingId]['payment_status']}";
										$defaultClass1 = $defaultClass2 = $defaultClass;
										$bookingsForThisDay['od'] = $bookingId;
										$info = "data-info='{$bookingsInfo[$bookingId]}'";
									}

									$colspan++;
								}
							}
						}

						$isFD = false;
						$isLD = false;
						$isOD = true;

						if ($bookingsForThisDay['fd'] != 0) {
							$bookingIdForDate = $bookingsForThisDay['fd'];
							$isFD = true;
							$isOD = false;
						}
						if ($bookingsForThisDay['ld'] != 0) {
							$bookingIdForDate = $bookingsForThisDay['ld'];
							$isLD = true;
							$isOD = false;
						}
						if ($bookingsForThisDay['od'] != 0) {
							$bookingIdForDate = $bookingsForThisDay['od'];
						}

						$addAttributes1 = $addAttributes2 = $addAttributes;
						if ($bookingIdForDate != 0) {
							if ($isFD) {
								$addAttributes2 .= " data-attr-booking_id='{$bookingsForThisDay['fd']}'";
							}
							if ($isLD) {
								$addAttributes1 .= " data-attr-booking_id='{$bookingsForThisDay['ld']}'";
							}
							if ($isOD) {
								$addAttributes1 .= " data-attr-booking_id='$bookingIdForDate'";
								$addAttributes2 .= " data-attr-booking_id='$bookingIdForDate'";
							}
						}
						echo "<td $info class='$defaultClass1 $addClass1' $addAttributes1></td>";
						echo "<td $info class='$defaultClass2 $addClass2' $addAttributes2></td>";
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
