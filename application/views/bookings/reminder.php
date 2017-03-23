<div>
    <?php
    echo form_open('bookings/reminder_view', ['class' => 'edit-reminder']);

    $input = form_label('Email', 'email')
        . form_input(['name' => 'email', 'value' => $email, 'id' => 'email']);
    echo div($input, ['class' => 'form-input']);

    $input = form_label('Remind start', 'start_remind')
        . form_input(['name' => 'start_remind', 'value' => $startRemind, 'id' => 'start_remind']);
    echo div($input, ['class' => 'form-input']);

    $input = form_label('Remind End', 'end_remind')
        . form_input(['name' => 'end_remind', 'value' => $endRemind, 'id' => 'end_remind']);
    echo div($input, ['class' => 'form-input']);


    $input = form_button(['name' => 'cancel', 'id' => 'cancel', 'content' => 'Cancel'])
        . form_submit(['name' => 'submit', 'id' => 'submit', 'value' => 'Save']);
    echo div($input, ['class' => 'buttons']);

    echo form_close();
    ?>
</div>
