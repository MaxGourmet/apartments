<?php
echo form_open('fairs/create', ['class' => 'create-fair']);
echo form_label('Start Date', 'start_date');
echo form_input(['name' => 'start', 'value' => date('Y-m-d'), 'id' => 'start_date']);
echo form_label('End Date', 'end_date');
echo form_input(['name' => 'end', 'value' => date('Y-m-d', strtotime("+1 day")), 'id' => 'end_date']);
echo form_label('Info', 'info');
echo form_textarea(['name' => 'info', 'value' => '', 'id' => 'info']);
echo div(
    span('Price') . " " . span('0', ['id' => 'calculated_price']) . "&euro; (" . span('', ['id' => 'calc_text']) . ")",
    []
);
//Calculated price span
echo form_label('To Pay', 'to_pay');
echo form_input(['name' => 'to_pay', 'id' => 'to_pay', 'value' => 0, 'disabled' => 'disabled']);
echo form_label('Payed', 'payed');
echo form_input(['name' => 'payed', 'id' => 'payed', 'value' => 0]);
echo form_button(['name' => 'cancel', 'id' => 'cancel', 'content' => 'Cancel']);
echo form_submit(['name' => 'submit', 'id' => 'submit', 'value' => 'Save']);
echo form_close();
?>