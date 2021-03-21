<?php $isPopup = !isset($isPopup) ? false : $isPopup; ?>
<div class="save-form">
<?php

$isViewer = user('role') == 'viewer';
echo form_open('customers/create', ['class' => 'create-apartment base-form']);

if (isset($customer['id'])) {
    $input = form_input(['name' => 'id', 'value' => $customer['id'], 'type' => 'hidden']);
    echo $input;
}

$input = form_label('Geschäftskunde', 'is_company')
	. form_checkbox(['name' => 'is_company', 'id' => 'is_company'], 1, $customer['is_company'] == 1);
echo div($input, ['class' => 'form-input']);

$input = form_label('Firmenname', 'company_name')
    . form_input(['name' => 'company_name', 'value' => $customer['company_name'], 'id' => 'company_name']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Anrede');
foreach ([1 => 'Herr', 2 => 'Frau'] as $salutationKey => $salutationValue) {
	$input .= span(form_label($salutationValue, "salutation$salutationKey", ['class' => 'radio3'])
		. form_radio(['name' => 'salutation', 'id' => "salutation$salutationKey"], $salutationKey, $salutationKey == $customer['salutation']));
}
echo div($input, ['class' => 'form-input']);

$input = form_label('Vorname', 'first_name')
    . form_input(['name' => 'first_name', 'value' => $customer['first_name'], 'id' => 'first_name']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Name', 'last_name')
    . form_input(['name' => 'last_name', 'value' => $customer['last_name'], 'id' => 'last_name']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Land', 'country')
    . form_input(['name' => 'country', 'value' => $customer['country'], 'id' => 'country']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Ort', 'city')
    . form_input(['name' => 'city', 'value' => $customer['city'], 'id' => 'city']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Strasse', 'street')
    . form_input(['name' => 'street', 'value' => $customer['street'], 'id' => 'street']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Plz', 'postcode')
    . form_input(['name' => 'postcode', 'value' => $customer['postcode'], 'id' => 'postcode']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Telefon', 'phone')
	. form_input(['name' => 'phone', 'value' => $customer['phone'], 'id' => 'phone']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Email', 'email')
	. form_input(['name' => 'email', 'value' => $customer['email'], 'id' => 'email']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Rabatt', 'personal_discount')
    . form_input(['name' => 'personal_discount', 'id' => 'personal_discount', 'value' => $customer['personal_discount'], 'type' => 'number', 'step' => 1]);
echo div($input, ['class' => 'form-input']);

$input = form_button(['name' => 'cancel', 'id' => 'cancel', 'content' => 'Abbrechen'])
    . form_submit(['name' => 'submit', 'id' => 'submit', 'value' => 'Speichern']);
echo div($input, ['class' => 'buttons', 'style' => $isPopup ? 'display:none' : '']);

if ($isPopup) {
	$input = form_button(['name' => 'pcancel', 'id' => 'pcancel', 'content' => 'Abbrechen'])
		. form_button(['name' => 'psubmit', 'id' => 'psubmit', 'value' => 'Speichern']);
	echo div($input, ['class' => 'buttons']);
}

if (isset($booking['id'])) {
	$input .= form_button(['name' => 'delete', 'id' => 'delete', 'content' => 'Löschen']);
}
echo form_close();
?>
</div>
<script>
	window.viewer = <?= $isViewer ? 1 : 0; ?>;
	$(document).ready(function () {
		if (window.viewer) {
			$('.save-form input, .save-form select').attr('disabled', 'disabled');
		}
	});
</script>
