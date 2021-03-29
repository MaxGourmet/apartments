<div class="save-form">
<?php
$isViewer = user('role') == 'viewer';
if (isset($error)) {
    echo div($error, ['class' => 'error']);
}
echo form_open('bookings/create', ['class' => 'create-booking base-form']);

if (isset($booking['id'])) {
    $input = span("Buchung Id: {$booking['id']}",['class' => 'label']);
    $input .= form_input(['name' => 'id', 'value' => $booking['id'], 'type' => 'hidden']);
    echo div($input, ['class' => 'form-input']);
}

$input = form_label('Appartement', 'apartment')
    . form_dropdown(['name' => 'apartment_id', 'id' => 'apartment'], $apartments, $booking['apartment_id']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Datum von', 'start_date')
    . form_input(['name' => 'start', 'value' => date('d.m.Y', strtotime($booking['start'])), 'id' => 'start_date']);
echo div($input, ['class' => 'form-input half half-1']);

$input = form_label('bis', 'end_date')
    . form_input(['name' => 'end', 'value' => date('d.m.Y', strtotime($booking['end'])), 'id' => 'end_date']);
echo div($input, ['class' => 'form-input half half-2']);

$input = form_label('Kunden', 'customer_id')
	. form_dropdown(['name' => 'customer_id', 'id' => 'customer_id'], $customers, $booking['customer_id']);
$input .= "<div class='customers-buttons'>
<a class='create-customer' href='javascript:void(0)'>Neuer Kunde</a>
<a class='update-customer-list' href='javascript:void(0)'>Aktualisieren Sie die Liste</a>
</div>";
echo div($input, ['class' => 'form-input']);

$input = form_label($is_final_decision, 'is_final_decision')
    . form_checkbox(['name' => 'is_final_decision', 'id' => 'is_final_decision'], 1, $booking['is_final_decision'] == 1);
echo div($input, ['class' => 'form-input']);

$input = form_label('Zusatzinformation', 'info')
    . form_textarea(['name' => 'info', 'value' => $booking['info'], 'id' => 'info']);
echo div($input, ['class' => 'form-input']);

if (!$isViewer) {
	$input = form_label('Zahlungsinformation', 'payment_info')
		. form_textarea(['name' => 'payment_info', 'value' => $booking['payment_info'], 'id' => 'payment_info']);
	echo div($input, ['class' => 'form-input']);
}

echo div(
    span('Übernachtungen',['class' => 'label']) . " " . span($booking['nights'], ['id' => 'calc_text']),
  ['class' => 'form-input']
);

$input = form_label('Soll', 'to_pay_show')
    . form_input(['name' => 'to_pay_show', 'id' => 'to_pay_show', 'value' => $booking['to_pay'], 'disabled' => 'disabled'])
    . form_input(['name' => 'to_pay', 'id' => 'to_pay', 'value' => $booking['to_pay'], 'type' => 'hidden']);
echo div($input, ['class' => 'form-input half half-1']);

$input = form_label('Ist', 'payed')
    . form_input(['name' => 'payed', 'id' => 'payed', 'value' => $booking['payed'], 'type' => 'number', 'step' => 0.01]);
echo div($input, ['class' => 'form-input half half-2']);

$input = form_label('Check-in', 'start_time')
    . form_input(['name' => 'start_time', 'id' => 'start_time', 'value' => $booking['start_time']]);
echo div($input, ['class' => 'form-input half half-1']);

$input = form_label('Check-out', 'end_time')
    . form_input(['name' => 'end_time', 'id' => 'end_time', 'value' => $booking['end_time']]);
echo div($input, ['class' => 'form-input half half-2 half-2-1']);

//$input = form_label('Zahlung', 'payment_method')
//    . form_dropdown(['name' => 'payment_method', 'id' => 'payment_method'], $payments, $booking['payment_method']);
//echo div($input, ['class' => 'form-input']);

$input = form_label('Zahlung');
foreach ($payments as $paymentKey => $payment) {
    $input .= span(form_label($payment, "payment_status$paymentKey", ['class' => 'radio3'])
        . form_radio(['name' => 'payment_status', 'id' => "payment_status$paymentKey"], $paymentKey, $paymentKey == $booking['payment_status']));
}
echo div($input, ['class' => 'form-input']);

$input = form_label('Personen');
for ($i = 1; $i <= $maxPeopleCount; $i++) {
    $input .= span(form_label($i, "people_count$i", ['class' => 'radio'])
        . form_radio(['name' => 'people_count', 'id' => "people_count$i"], $i, $i == $booking['people_count']), ['class' => "people_count$i"]);
}
echo div($input, ['class' => 'form-input']);

$input = form_button(['name' => 'cancel', 'id' => 'cancel', 'content' => 'Abbrechen'])
    . form_submit(['name' => 'submit', 'id' => 'submit', 'value' => 'Speichern']);

if (isset($booking['id'])) {
    $input .= form_button(['name' => 'delete', 'id' => 'delete', 'content' => 'Löschen']);
    $input .= form_button(['name' => 'payed_confirm', 'id' => 'payed_confirm', 'content' => 'Bezahlt']);
    $input .= form_button(['style' => 'width: 160px;', 'name' => 'print_bill', 'id' => 'print_bill', 'content' => 'Rechnung drucken']);
}
echo div($input, ['class' => 'buttons']);

echo form_close();
?>
	<div>
		<h2>Zusatzleistungen</h2>
		<?php
		foreach ($services as $service) {
			$input = form_label($service['name'] . "({$service['price']} €)", 'service' . $service['id'])
				. form_checkbox(['name' => 'services[]', 'id' => 'service' . $service['id']], $service['id'], 0);
			echo div($input, ['class' => 'form-input']);
		}
		?>
	</div>
</div>

<div class="customer-popup" style="display: none">
	<div class="customer-popup-content">
	<?php
		$customer = [
			'salutation' => 1,
			'first_name' => '',
			'last_name' => '',
			'country' => '',
			'city' => '',
			'street' => '',
			'postcode' => '',
			'is_company' => '',
			'company_name' => '',
			'full_name' => '',
			'phone' => '',
			'email' => '',
			'personal_discount' => '',
		];
		$this->load->view('customers/create', ['customer' => $customer, 'isPopup' => true]);
	?>
	</div>
</div>

<script>
    window.totalPeopleCount = <?= json_encode($totalPeopleCount); ?>;
	window.viewer = <?= $isViewer ? 1 : 0; ?>;
	$(document).ready(function () {
		if (window.viewer) {
			$('.save-form input, .save-form select, .save-form textarea').attr('disabled', 'disabled');
			$('#info, #submit, #cancel').attr('disabled', false);
			$('#delete').remove();
			$('#payed_confirm').remove();
			// $('.buttons').remove();
			$(document).on('submit', '.create-booking', function (ev) {
				$('.save-form input, .save-form select, .save-form textarea').attr('disabled', false);
				$('#to_pay_show').attr('disabled', 'disabled');
			})
		}
	});
</script>
