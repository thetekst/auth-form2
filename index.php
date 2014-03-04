<?php
require_once('core/init.php');

$user = DB::getInstance()->insert('user', array(
	'email' => 'new@dsf.ru',
	'pass' => 'new',
	'name' => 'fff'
));
