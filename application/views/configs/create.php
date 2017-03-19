<div>
<?php
echo form_open('configs/create', ['class' => 'create-config']);
$aliasParams = [];
$nameParams = [];
$valueParams = $config['editable'] == '1' ? [] : ['disabled' => 'disabled'];

if (isset($config['id'])) {
    $aliasParams = ['disabled' => 'disabled'];
    $nameParams = ['disabled' => 'disabled'];
    $input = form_input(['name' => 'id', 'value' => $config['id'], 'type' => 'hidden']);
    echo div($input, ['class' => 'form-input']);
}

$input = form_label('Alias', 'alias')
    . form_input(array_merge(['name' => 'alias', 'id' => 'alias', 'value' => $config['alias']], $aliasParams));
echo div($input, ['class' => 'form-input']);

$input = form_label('Name', 'name')
    . form_input(array_merge(['name' => 'name', 'id' => 'name', 'value' => $config['name']], $nameParams));
echo div($input, ['class' => 'form-input']);

$input = form_label('Value', 'value')
    . form_input(array_merge(['name' => 'value', 'id' => 'value', 'value' => $config['value']], $valueParams));
echo div($input, ['class' => 'form-input']);

$input = form_input(['name' => 'editable', 'value' => $config['editable'], 'type' => 'hidden']);
echo div($input, ['class' => 'form-input']);

$input = form_button(['name' => 'cancel', 'id' => 'cancel', 'content' => 'Cancel'])
    . form_submit(['name' => 'submit', 'id' => 'submit', 'value' => 'Save']);
echo div($input, ['class' => 'buttons']);

echo form_close();
?>
</div>
