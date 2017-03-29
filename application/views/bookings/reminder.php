<div>
<?php
echo form_open('bookings/reminder', ['class' => 'edit-reminder base-form']);

$input = form_label('Email', 'email')
    . form_input(['name' => 'email', 'value' => $email, 'id' => 'email']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Erinnerungen anfang', 'start_remind')
    . form_input(['name' => 'start_remind', 'value' => $startRemind, 'id' => 'start_remind']);
echo div($input, ['class' => 'form-input']);

$input = form_label('Erinnerungen ende', 'end_remind')
    . form_input(['name' => 'end_remind', 'value' => $endRemind, 'id' => 'end_remind']);
echo div($input, ['class' => 'form-input']);


$input = form_button(['name' => 'cancel', 'id' => 'cancel', 'content' => 'Abbrechen'])
    . form_submit(['name' => 'submit', 'id' => 'submit', 'value' => 'Speichern']);
echo div($input, ['class' => 'buttons']);

echo form_close();
?>
</div>
