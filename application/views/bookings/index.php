<table class="bookings">
    <tr>
        <td>Appartement</td>
        <td>Buchung ID</td>
        <td>Datum</td>
        <td>Soll</td>
        <td>Ist</td>
        <td>Diff</td>
    </tr>
    <?php foreach($bookings as $booking) : ?>
        <tr data-attr-booking_id="<?= $booking['id'] ?>">
            <td><?= $booking['address'] ?></td>
            <td><?= $booking['id'] ?></td>
            <td><?= "{$booking['start']} - {$booking['end']}" ?></td>
            <td><?= $booking['to_pay'] . " €" ?></td>
            <td><?= $booking['payed'] . " €" ?></td>
            <td><?= $booking['diff'] . " €" ?></td>
        </tr>
    <?php endforeach; ?>
</table>