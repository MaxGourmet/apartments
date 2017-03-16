<div>
<?php
echo form_open('apartments/create', ['class' => 'create-apartment']);

$input = form_label('Address', 'address')
    . form_input(['name' => 'address', 'value' => '', 'id' => 'address']);
echo div($input, ['class' => 'form-input']);

$input = form_label('City', 'city')
    . form_dropdown(['name' => 'city', 'id' => 'city'], $cities);
echo div($input, ['class' => 'form-input']);

$input = form_label('Beds', 'beds')
    . form_input(['name' => 'beds', 'id' => 'beds', 'value' => 0, 'type' => 'number', 'step' => 1]);
echo div($input, ['class' => 'form-input']);

$input = form_label('Price 1', 'price1')
    . form_input(['name' => 'price1', 'id' => 'price1', 'value' => 0, 'type' => 'number', 'step' => 0.01]);
echo div($input, ['class' => 'form-input']);

$input = form_label('Price 2', 'price2')
    . form_input(['name' => 'price2', 'id' => 'price2', 'value' => 0, 'type' => 'number', 'step' => 0.01]);
echo div($input, ['class' => 'form-input']);

$input = form_label('Price 3', 'price3')
    . form_input(['name' => 'price3', 'id' => 'price3', 'value' => 0, 'type' => 'number', 'step' => 0.01]);
echo div($input, ['class' => 'form-input']);

$input = form_button(['name' => 'cancel', 'id' => 'cancel', 'content' => 'Cancel'])
    . form_submit(['name' => 'submit', 'id' => 'submit', 'value' => 'Save']);
echo div($input, ['class' => 'buttons']);

echo form_close();
?>
</div>
