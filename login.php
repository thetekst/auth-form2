<?php
require_once('core/init.php');

if (Input::exists()) {
	$validate = new Validate();
	$validation = $validate->check($_POST, array(
		'email' => array('required' => true),
		'pass' => array('required' => true)
	));

	if ($validation->passed()) {
		$user = new User();

		$remember = (Input::get('remember') === 'on') ? true : false;
		
		$login = $user->login(Input::get('email'), Input::get('pass'), $remember);

		if ($login) {
			Redirect::to('index.php');
		} else {
			echo 'Sorry, loggin in failed.';
		}
	} else {
		foreach ($validation->errors() as $error) {
			echo $error, '<br>';
		}
	}
}
?>

<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>	</title>
</head>
<body>
	<form action="" method="post" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
		<input type="text" name="email" id="" placeholder="Логин" value="<?php echo escape(Input::get('email'));?>" required="required">
		<input type="password" name="pass" id="" placeholder="Пароль" required="required">
		<label for="remember"><input type="checkbox" name="remember" id="remember">Запомнить</label><br>
		<input type="hidden" name="token" value="<?php echo Token::generate();?>">
		<input type="submit" value="Войти">
	</form>
</body>
</html>