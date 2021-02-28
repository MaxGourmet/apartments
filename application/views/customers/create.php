<div class="save-form">
<?php
$isViewer = user('role') == 'viewer';
echo form_open('customers/create', ['class' => 'create-apartment base-form']);

if (isset($customer['id'])) {
    $input = form_input(['name' => 'id', 'value' => $customer['id'], 'type' => 'hidden']);
    echo $input;
}

$input = form_label('Ist firma', 'is_company')
	. form_checkbox(['name' => 'is_company', 'id' => 'is_company'], 1, $customer['is_company'] == 1);
echo div($input, ['class' => 'form-input']);

$input = form_label('Firmaname', 'company_name')
    . form_input(['name' => 'company_name', 'value' => $customer['company_name'], 'id' => 'company_name']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Kundenname', 'users_name')
    . form_input(['name' => 'users_name', 'value' => $customer['users_name'], 'id' => 'users_name']);
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
echo div($input, ['class' => 'buttons']);

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
