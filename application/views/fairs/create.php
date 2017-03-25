<div>
<?php
echo form_open('fairs/create', ['class' => 'create-fair']);

if (isset($fair['id'])) {
    $input = form_input(['name' => 'id', 'value' => $fair['id'], 'type' => 'hidden']);
    echo div($input, ['class' => 'form-input']);
}

$input = form_label('Name', 'name')
    . form_input(['name' => 'name', 'value' => $fair['name'], 'id' => 'name']);
echo div($input, ['class' => 'form-input']);

$input = form_label('City', 'city')
    . form_dropdown(['name' => 'city', 'id' => 'city'], $cities, $fair['city']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Start Date', 'start_date')
    . form_input(['name' => 'start', 'value' => $fair['start'], 'id' => 'start_date']);
echo div($input, ['class' => 'form-input']);

$input = form_label('End Date', 'end_date')
    . form_input(['name' => 'end', 'value' => $fair['end'], 'id' => 'end_date']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Price', 'price')
    . form_input(['name' => 'price', 'id' => 'price', 'value' => $fair['price'], 'type' => 'number', 'step' => 0.01]);
echo div($input, ['class' => 'form-input']);

$input = form_button(['name' => 'cancel', 'id' => 'cancel', 'content' => 'Cancel'])
    . form_submit(['name' => 'submit', 'id' => 'submit', 'value' => 'Save']);
echo div($input, ['class' => 'buttons']);

echo form_close();
?>
</div>
