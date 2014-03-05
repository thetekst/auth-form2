<?php
require_once('core/init.php');

//echo Session::get(Config::get('session/session_name'));

/*$res = DB::getInstance();

//$p = $res->get('user', array('id', '=', 27));
$p = $res->get('user', array('id', '=', 27));

print_r($p);*/

$user = new User();
if ($user->isLoggedIn()) {
	?>
	<p>Здравствуйте, <a href="#"><?php echo escape($user->data()->email); ?></a>!</p>
	<ul>
		<li><a href="logout.php">Выйти</a></li>
		<li><a href="update.php">Редактировать профиль</a></li>
		<li><a href="changepassword.php">Сменить пароль</a></li>
	</ul>
	<?php
} else {
	echo 'Пожалуйста <a href="login.php">войдите</a> или <a href="register.php">зарегистрируйтейсь</a> на сайте';
}