<div>
<?php
echo form_open('', ['class' => 'create-apartment base-form']);

$input = form_input(['name' => 'id', 'value' => $apartment['id'], 'type' => 'hidden']);
echo $input;
$input = form_button(['name' => 'cancel', 'id' => 'cancel', 'content' => 'Abbrechen'])
	. form_submit(['name' => 'submit', 'id' => 'submit', 'value' => 'Ja']);
echo div($input, ['class' => 'buttons']);

echo form_close();
?>
</div>
