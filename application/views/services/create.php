<div class="save-form">
<?php
$isViewer = user('role') == 'viewer';
echo form_open('services/create', ['class' => 'create-fair base-form']);

if (isset($service['id'])) {
    $input = form_input(['name' => 'id', 'value' => $service['id'], 'type' => 'hidden']);
    echo div($input, ['class' => 'form-input']);
}

$input = form_label('Name', 'name')
    . form_input(['name' => 'name', 'value' => $service['name'], 'id' => 'name']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Beschreibung', 'description')
    . form_input(['name' => 'description', 'value' => $service['description'], 'id' => 'description']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Preis', 'price')
    . form_input(['name' => 'price', 'id' => 'price', 'value' => $service['price'], 'type' => 'number', 'step' => 0.01]);
echo div($input, ['class' => 'form-input']);

$input = form_label('TVA', 'vat_rate')
	. form_input(['name' => 'vat_rate', 'value' => $service['vat_rate'], 'id' => 'vat_rate']);
echo div($input, ['class' => 'form-input']);

$input = form_button(['name' => 'cancel', 'id' => 'cancel', 'content' => 'Abbrechen'])
    . form_submit(['name' => 'submit', 'id' => 'submit', 'value' => 'Speichern']);
echo div($input, ['class' => 'buttons']);

echo form_close();
?>
</div>
<script>
	window.viewer = <?= $isViewer ? 1 : 0; ?>;
	$(document).ready(function () {
		if (window.viewer) {
			$('.save-form input, .save-form select').attr('disabled', 'disabled');
			$('.buttons').remove();
		}
	});
</script>
