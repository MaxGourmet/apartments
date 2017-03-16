<div>
    <?php
    echo form_open('fairs/create', ['class' => 'create-fair']);

    $input = form_label('Name', 'name')
        . form_input(['name' => 'name', 'value' => '', 'id' => 'name']);
    echo div($input, ['class' => 'form-input']);

    $input = form_label('Address', 'address')
        . form_input(['name' => 'address', 'value' => '', 'id' => 'address']);
    echo div($input, ['class' => 'form-input']);

    $input = form_label('City', 'city')
        . form_dropdown(['name' => 'city', 'id' => 'city'], $cities);
    echo div($input, ['class' => 'form-input']);

    $input = form_label('Start Date', 'start_date')
        . form_input(['name' => 'start', 'value' => date('Y-m-d'), 'id' => 'start_date']);
    echo div($input, ['class' => 'form-input']);

    $input = form_label('End Date', 'end_date')
        . form_input(['name' => 'end', 'value' => date('Y-m-d', strtotime("+1 day")), 'id' => 'end_date']);
    echo div($input, ['class' => 'form-input']);

    $input = form_label('Price', 'price')
        . form_input(['name' => 'price', 'id' => 'price', 'value' => 0, 'type' => 'number', 'step' => 0.01]);
    echo div($input, ['class' => 'form-input']);

    $input = form_button(['name' => 'cancel', 'id' => 'cancel', 'content' => 'Cancel'])
        . form_submit(['name' => 'submit', 'id' => 'submit', 'value' => 'Save']);
    echo div($input, ['class' => 'buttons']);

    echo form_close();
    ?>
</div>
