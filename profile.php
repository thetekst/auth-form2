<?php
require_once('core/init.php');

if (!$username = Input::get('email')) {
	Redirect::to('index.php');
} else {
	$user = new User($username);

	if (!$user->exists()) {
		Redirect::to(404);
	} else {
		$data = $user->data();
	}
	?>

	<h3><?php echo escape($data->email);?></h3>
	<p>Имя: <?php echo escape($data->name);?><br>
	Фамилия: <?php echo escape($data->lname);?></p>
	<a href="index.php">Назад</a>
	<?php
}