<?php
require_once('core/init.php');

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {

		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'email' => array(
				'required' => true,
				'min' => 2,
				'max' => 20,
				'min' => 2,
				'unique' => 'users', // table name
			),
			'pass' => array(
				'required' => true,
				'min' => 6,
			),
			'passconfirm' => array(
				'required' => true,
				'matches' => 'pass',
			)/*,
			'name' => array(
				'required' => true,
				'min' => 2,
				'max' => 50,
			)*/
		));

		if ($validation->passed()) {
			$user = new User();

			$salt = Hash::salt(32);
			
			try {
				$user->create(array(
					'email' => Input::get('email'),
					'pass' => Hash::make(Input::get('pass'), $salt),
					'salt' => $salt,
					'name' => Input::get('name'),
					'lname' => Input::get('lname'),
					'joined' => time(),
					'group' => 1
				));

				Session::flash('home', 'You have been registered and can now log in');
				Redirect::to('index.php');

			} catch (Exception $e) {
				die($e->getMessage());
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
	<form action="" method="post" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
		<input type="text" name="email" id="" placeholder="Логин" required="required" value="<?php echo escape(Input::get('email'));?>">
		<input type="password" name="pass" id="" placeholder="Пароль" required="required">
		<input type="password" name="passconfirm" id="" placeholder="Подтверждение пароля" required="required"><br>
		<input type="hidden" name="token" value="<?php echo Token::generate();?>">
		<input type="submit" value="Зарегистрироваться">
	</form>
</body>
</html>