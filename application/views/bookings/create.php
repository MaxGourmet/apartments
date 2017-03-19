<div>
<?php
echo form_open('bookings/create', ['class' => 'create-booking']);

if (isset($booking['id'])) {
    $input = span("Booking Id: {$booking['id']}");
    $input .= form_input(['name' => 'id', 'value' => $booking['id'], 'type' => 'hidden']);
    echo div($input, ['class' => 'form-input']);
}

$input = form_label('Apartment', 'apartment')
    . form_dropdown(['name' => 'apartment_id', 'id' => 'apartment'], $apartments, $booking['apartment_id']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Start Date', 'start_date')
    . form_input(['name' => 'start', 'value' => $booking['start'], 'id' => 'start_date']);
echo div($input, ['class' => 'form-input']);

$input = form_label('End Date', 'end_date')
    . form_input(['name' => 'end', 'value' => $booking['end'], 'id' => 'end_date']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Info', 'info')
    . form_textarea(['name' => 'info', 'value' => $booking['info'], 'id' => 'info']);
echo div($input, ['class' => 'form-input']);

echo div(
    span('Price') . " " . span($booking['to_pay'], ['id' => 'calculated_price']) . " &euro; (" . span('', ['id' => 'calc_text']) . ")",
    []
);

$input = form_label('To Pay', 'to_pay_show')
    . form_input(['name' => 'to_pay_show', 'id' => 'to_pay_show', 'value' => $booking['to_pay'], 'disabled' => 'disabled'])
    . form_input(['name' => 'to_pay', 'id' => 'to_pay', 'value' => $booking['to_pay'], 'type' => 'hidden']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Payed', 'payed')
    . form_input(['name' => 'payed', 'id' => 'payed', 'value' => $booking['payed'], 'type' => 'number', 'step' => 0.01]);
echo div($input, ['class' => 'form-input']);

$input = form_button(['name' => 'cancel', 'id' => 'cancel', 'content' => 'Cancel'])
    . form_submit(['name' => 'submit', 'id' => 'submit', 'value' => 'Save']);
echo div($input, ['class' => 'buttons']);

echo form_close();
?>
</div>
