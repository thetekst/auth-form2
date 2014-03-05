<?php
/**
* 
*/
class Hash
{
	
	function __construct()
	{
		# code...
	}

	public static function make($string, $salt = '') {
		return hash('sha256', $string.$salt);
	}

	public static function salt($length) {
		// return mcrypt_create_iv($length); // Разобраться, почему не сохраняет это значение в БД
		return uniqid(); // Отладочная функция
	}

	public static function unique() {
		return self::make(uniqid());
	}
}