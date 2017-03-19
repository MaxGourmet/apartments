<html>
<head>
	<title>Login</title>
</head>
<body>
	<?php 
    if ($error) echo '<p class="error">'. $error .'</p>';
    echo form_open(); 
    echo form_label('Username', 'username') .'<br />';
    echo form_input(array('name' => 'username', 'value' => set_value('username'))) .'<br />';
    echo form_error('email');
    echo form_label('Password', 'password') .'<br />';
    echo form_password(array('name' => 'password', 'value' => set_value('password'))) .'<br />';
    echo form_error('password');
    echo form_submit(array('type' => 'submit', 'value' => 'Login'));
    echo form_close();
    ?>
</body>
</html>
