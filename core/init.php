<?php 
session_start();

$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => 'localhost',
		'username' => 'root',
		'password' => '',
		'db' => 'auth_form_db'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)
);

spl_autoload_register(function($class) {
	$path = dirname(__FILE__).'/classes/'.$class.'.php';
	if(is_file($path)) {
		require_once($path);
	}
});

require_once('functions/sanitize.php');

if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

	if ($hashCheck->count()) {
		echo $hashCheck->first()->user_id;
		$user = new User($hashCheck->first()->user_id);
		$user->login();
	}
}
