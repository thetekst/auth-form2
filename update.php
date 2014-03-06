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
			'name' => array(
				'min' => 2,
				'max' => 50
			),
			'lname' => array(
				'min' => 2,
				'max' => 50
			)
		));

		if ($validation->passed()) {
			try {
				$user->update(array(
					'name' => Input::get('name'),
					'lname' => Input::get('lname')
				));

				Session::flash('home', 'Ваши данные обновлены');
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
	<h1>Профиль пользователя:</h1>
	<hr>
	<b>Редактирование:</b>
	<form action="" method="post" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
		<label for="email">E-mail:
			<input type="email" name="email" id="" placeholder="E-mail" required="required" value="<?php echo escape($user->data()->email);?>" disabled="disabled">
		</label><br>
		<label for="group">Группа:
			<input type="text" name="group" id="" placeholder="Группа" value="<?php echo escape($user->data()->group);?>" disabled="disabled">
		</label><br>
		<label for="name">Имя:
			<input type="text" name="name" id="" placeholder="Имя" value="<?php echo escape($user->data()->name);?>">
		</label><br>
		<label for="lname">Фамилия:
			<input type="text" name="lname" id="" placeholder="Фамилия" value="<?php echo escape($user->data()->lname);?>">
		</label><br>
		<input type="submit" value="Сохранить">
		<input type="hidden" name="token" value="<?php echo Token::generate();?>">
	</form>
	<a href="index.php">Назад</a>
</body>
</html>