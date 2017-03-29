<div>
<?php
echo form_open('fairs/create', ['class' => 'create-fair base-form']);

if (isset($fair['id'])) {
    $input = form_input(['name' => 'id', 'value' => $fair['id'], 'type' => 'hidden']);
    echo div($input, ['class' => 'form-input']);
}

$input = form_label('Name', 'name')
    . form_input(['name' => 'name', 'value' => $fair['name'], 'id' => 'name']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Ort', 'city')
    . form_dropdown(['name' => 'city', 'id' => 'city'], $cities, $fair['city']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Datum von', 'start_date')
    . form_input(['name' => 'start', 'value' => $fair['start'], 'id' => 'start_date']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Datum bis', 'end_date')
    . form_input(['name' => 'end', 'value' => $fair['end'], 'id' => 'end_date']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Preis', 'price')
    . form_input(['name' => 'price', 'id' => 'price', 'value' => $fair['price'], 'type' => 'number', 'step' => 0.01]);
echo div($input, ['class' => 'form-input']);

$input = form_button(['name' => 'cancel', 'id' => 'cancel', 'content' => 'Abbrechen'])
    . form_submit(['name' => 'submit', 'id' => 'submit', 'value' => 'Speichern']);
echo div($input, ['class' => 'buttons']);

echo form_close();
?>
</div>
