<html>
<head>
	<title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="/assets/css/style.css" />
</head>
<body>
    <div class="auth-wrap">
        <div class="auth-block">
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
        </div>
    </div>
</body>
</html>
