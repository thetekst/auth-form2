<?php
require_once('core/init.php');

if (Session::exists('home')) {
	echo '<p>'.Session::flash('home').'</p>';
}

$user = new User();
if ($user->isLoggedIn()) {
	?>
	<p>Здравствуйте, <a href="profile.php?email=<?php echo escape($user->data()->email); ?>"><?php echo escape($user->data()->email); ?></a>!</p>
	<ul>
		<li><a href="logout.php">Выйти</a></li>
		<li><a href="update.php">Редактировать профиль</a></li>
		<li><a href="changepassword.php">Сменить пароль</a></li>
	</ul>
	<?php

	if ($user->hasPermission('moderator')) {
		echo 'moderator<br>';
	}

	if ($user->hasPermission('admin')) {
		echo 'admin<br>';
	}

} else {
	echo 'Пожалуйста <a href="login.php">войдите</a> или <a href="register.php">зарегистрируйтейсь</a> на сайте';
}