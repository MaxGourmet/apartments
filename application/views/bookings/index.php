<table class="bookings">
    <tr>
        <th>Appartement</th>
        <th>Buchung ID</th>
        <th>Datum</th>
        <th>Soll</th>
        <th>Ist</th>
        <th>Diff</th>
        <th></th>
    </tr>
    <?php foreach($bookings as $booking) : ?>
        <tr data-attr-booking_id="<?= $booking['id'] ?>">
            <td><?= $booking['address'] ?></td>
            <td class="text-center"><?= $booking['id'] ?></td>
            <td class="text-right"><?= date('d.m.Y', strtotime($booking['start'])) . " - " . date('d.m.Y', strtotime($booking['end'])) ?></td>
            <td class="text-right to_pay"><?= $booking['to_pay'] . " €" ?></td>
            <td class="text-right payed"><?= $booking['payed'] . " €" ?></td>
            <td class="text-right diff"><?= $booking['diff'] . " €" ?></td>
            <td class="text-right payed_confirm">
                <a
                    data-id="<?= $booking['id'] ?>"
                    class="payed_confirm"
                    href="javascript:void(0)"
                    >Bezahlt</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
