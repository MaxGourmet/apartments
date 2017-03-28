<html>
<head>
	<title>Login</title>
</head>
<body>
	<?php 
    if ($error) echo '<p class="error">'. $error .'</p>';
    echo form_open(); 
    echo form_label('Benutzername', 'username') .'<br />';
    echo form_input(array('name' => 'username', 'value' => set_value('username'))) .'<br />';
    echo form_error('username');
    echo form_label('Passwort', 'password') .'<br />';
    echo form_password(array('name' => 'password', 'value' => set_value('password'))) .'<br />';
    echo form_error('password');
    echo form_submit(array('type' => 'submit', 'value' => 'Anmeldung'));
    echo form_close();
    ?>
</body>
</html>
