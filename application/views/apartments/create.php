<div>
<?php
echo form_open('apartments/create', ['class' => 'create-apartment']);

if (isset($apartment['id'])) {
    $input = form_input(['name' => 'id', 'value' => $apartment['id'], 'type' => 'hidden']);
    echo $input;
}

$input = form_label('Adresse', 'address')
    . form_input(['name' => 'address', 'value' => $apartment['address'], 'id' => 'address']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Ort', 'city')
    . form_dropdown(['name' => 'city', 'id' => 'city'], $cities, $apartment['city']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Schlafplätze', 'beds')
    . form_input(['name' => 'beds', 'id' => 'beds', 'value' => $apartment['beds'], 'type' => 'number', 'step' => 1]);
echo div($input, ['class' => 'form-input']);

$input = form_label('Preis 1', 'price1')
    . form_input(['name' => 'price1', 'id' => 'price1', 'value' => $apartment['price1'], 'type' => 'number', 'step' => 0.01]);
echo div($input, ['class' => 'form-input']);

$input = form_label('Preis 2', 'price2')
    . form_input(['name' => 'price2', 'id' => 'price2', 'value' => $apartment['price2'], 'type' => 'number', 'step' => 0.01]);
echo div($input, ['class' => 'form-input']);

$input = form_label('Preis 3', 'price3')
    . form_input(['name' => 'price3', 'id' => 'price3', 'value' => $apartment['price3'], 'type' => 'number', 'step' => 0.01]);
echo div($input, ['class' => 'form-input']);

$input = form_button(['name' => 'cancel', 'id' => 'cancel', 'content' => 'Abbrechen'])
    . form_submit(['name' => 'submit', 'id' => 'submit', 'value' => 'Speichern']);
echo div($input, ['class' => 'buttons']);

echo form_close();
?>
</div>
