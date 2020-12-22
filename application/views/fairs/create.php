<div class="save-form">
<?php
$isViewer = user('role') == 'viewer';
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
    . form_input(['name' => 'start', 'value' => date('d.m.Y', strtotime($fair['start'])), 'id' => 'start_date']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Datum bis', 'end_date')
    . form_input(['name' => 'end', 'value' => date('d.m.Y', strtotime($fair['end'])), 'id' => 'end_date']);
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
<script>
	window.viewer = <?= $isViewer ? 1 : 0; ?>;
	$(document).ready(function () {
		if (window.viewer) {
			$('.save-form input, .save-form select').attr('disabled', 'disabled');
			$('.buttons').remove();
		}
	});
</script>
