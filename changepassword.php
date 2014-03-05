<?php
require_once('core/init.php');

$user = new User();

if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

if (Input::exists()) {
	if(Token::check(Input::get('token'))) {

		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'pass_current' => array(
				'required' => true,
				'min' => 6
			),
			'pass_new' => array(
				'required' => true,
				'min' => 6
			),
			'pass_confirm' => array(
				'required' => true,
				'min' => 6,
				'matches' => 'pass_new'
			)
		));

		if ($validation->passed()) {

			if (Hash::make(Input::get('pass_current'), $user->data()->salt) !== $user->data()->pass) {
				echo 'Действующий пароль не совпадает';
			} else {
				$salt = Hash::make(32);
				$user->update(array(
					'pass' => Hash::make(Input::get('pass_new'), $salt),
					'salt' => $salt
				));

				Session::flash('home', 'Пароль был изменен');
				Redirect::to('index.php');
			}

		} else {
			foreach ($validation->errors() as $error) {
				echo $error, '<br>';
			}
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
	<h1>Сменить пароль:</h1>
	<hr>
	<b>Редактирование:</b>
	<form action="" method="post" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
		<input type="password" name="pass_current" id="" placeholder="Текущий пароль"><br>
		<input type="password" name="pass_new" id="" placeholder="Новый пароль"><br>
		<input type="password" name="pass_confirm" id="" placeholder="Подтвердить пароль"><br>
		<input type="submit" value="Сохранить">
		<input type="hidden" name="token" value="<?php echo Token::generate();?>">
	</form>
	<a href="index.php">Назад</a>
</body>
</html>