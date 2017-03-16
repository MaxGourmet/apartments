<div>
<?php
echo form_open('bookings/create', ['class' => 'create-booking']);

$input = form_label('Apartment', 'apartment')
    . form_dropdown(['name' => 'apartment', 'id' => 'apartment'], $apartments);
echo div($input, ['class' => 'form-input']);

$input = form_label('Start Date', 'start_date')
    . form_input(['name' => 'start', 'value' => date('Y-m-d'), 'id' => 'start_date']);
echo div($input, ['class' => 'form-input']);

$input = form_label('End Date', 'end_date')
    . form_input(['name' => 'end', 'value' => date('Y-m-d', strtotime("+1 day")), 'id' => 'end_date']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Info', 'info')
    . form_textarea(['name' => 'info', 'value' => '', 'id' => 'info']);
echo div(
    span('Price') . " " . span('0', ['id' => 'calculated_price']) . "&euro; (" . span('', ['id' => 'calc_text']) . ")",
    []
);

$input = form_label('To Pay', 'to_pay')
    . form_input(['name' => 'to_pay', 'id' => 'to_pay', 'value' => 0, 'disabled' => 'disabled']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Payed', 'payed')
    . form_input(['name' => 'payed', 'id' => 'payed', 'value' => 0, 'type' => 'number', 'step' => 0.01]);
echo div($input, ['class' => 'form-input']);

$input = form_button(['name' => 'cancel', 'id' => 'cancel', 'content' => 'Cancel'])
    . form_submit(['name' => 'submit', 'id' => 'submit', 'value' => 'Save']);
echo div($input, ['class' => 'buttons']);

echo form_close();
?>
</div>
