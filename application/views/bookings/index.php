<table class="bookings">
    <tr>
        <th>Appartement</th>
        <th>Buchung ID</th>
        <th>Datum</th>
        <th>Soll</th>
        <th>Ist</th>
        <th>Diff</th>
    </tr>
    <?php foreach($bookings as $booking) : ?>
        <tr data-attr-booking_id="<?= $booking['id'] ?>">
            <td><?= $booking['address'] ?></td>
            <td class="text-center"><?= $booking['id'] ?></td>
            <td class="text-right"><?= "{$booking['start']} - {$booking['end']}" ?></td>
            <td class="text-right"><?= $booking['to_pay'] . " €" ?></td>
            <td class="text-right"><?= $booking['payed'] . " €" ?></td>
            <td class="text-right"><?= $booking['diff'] . " €" ?></td>
        </tr>
    <?php endforeach; ?>
</table>