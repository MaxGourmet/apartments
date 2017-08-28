<div>
<?php
if (isset($error)) {
    echo div($error, ['class' => 'error']);
}
echo form_open('bookings/create', ['class' => 'create-booking base-form']);

if (isset($booking['id'])) {
    $input = span("Buchung Id: {$booking['id']}",['class' => 'label']);
    $input .= form_input(['name' => 'id', 'value' => $booking['id'], 'type' => 'hidden']);
    echo div($input, ['class' => 'form-input']);
}

$input = form_label('Appartement', 'apartment')
    . form_dropdown(['name' => 'apartment_id', 'id' => 'apartment'], $apartments, $booking['apartment_id']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Datum von', 'start_date')
    . form_input(['name' => 'start', 'value' => $booking['start'], 'id' => 'start_date']);
echo div($input, ['class' => 'form-input half half-1']);

$input = form_label('bis', 'end_date')
    . form_input(['name' => 'end', 'value' => $booking['end'], 'id' => 'end_date']);
echo div($input, ['class' => 'form-input half half-2']);

$input = form_label('Zusatzinformation', 'info')
    . form_textarea(['name' => 'info', 'value' => $booking['info'], 'id' => 'info']);
echo div($input, ['class' => 'form-input']);

echo div(
    span('Preis',['class' => 'label']) . " " . span($booking['to_pay'], ['id' => 'calculated_price']) . " &euro; (" . span('', ['id' => 'calc_text']) . ")",
  ['class' => 'form-input']
);

$input = form_label('Soll', 'to_pay_show')
    . form_input(['name' => 'to_pay_show', 'id' => 'to_pay_show', 'value' => $booking['to_pay'], 'disabled' => 'disabled'])
    . form_input(['name' => 'to_pay', 'id' => 'to_pay', 'value' => $booking['to_pay'], 'type' => 'hidden']);
echo div($input, ['class' => 'form-input half half-1']);

$input = form_label('Ist', 'payed')
    . form_input(['name' => 'payed', 'id' => 'payed', 'value' => $booking['payed'], 'type' => 'number', 'step' => 0.01]);
echo div($input, ['class' => 'form-input half half-2']);

$input = form_label('Time start', 'start_time')
    . form_input(['name' => 'start_time', 'id' => 'start_time', 'value' => $booking['start_time']]);
echo div($input, ['class' => 'form-input half half-1']);

$input = form_label('Time end', 'end_time')
    . form_input(['name' => 'end_time', 'id' => 'end_time', 'value' => $booking['end_time']]);
echo div($input, ['class' => 'form-input half half-1']);

$input = form_button(['name' => 'cancel', 'id' => 'cancel', 'content' => 'Abbrechen'])
    . form_submit(['name' => 'submit', 'id' => 'submit', 'value' => 'Speichern']);

if (isset($booking['id'])) {
    $input .= form_button(['name' => 'delete', 'id' => 'delete', 'content' => 'Löschen']);
    $input .= form_button(['name' => 'payed_confirm', 'id' => 'payed_confirm', 'content' => 'Bezahlt']);
}
echo div($input, ['class' => 'buttons']);

echo form_close();
?>
</div>
