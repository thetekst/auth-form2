<?php
require_once('core/init.php');

$user = DB::getInstance()->update('user', 14, array(
	'pass' => 'new',
	'name' => 'fff'
));
