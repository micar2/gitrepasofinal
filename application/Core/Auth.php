<?php 

namespace Mini\Core;

use Mini\Libs\Sesion;

class Auth
{
	public static function checkAutentication()
	{
		Sesion::init();
		if ( ! Sesion::userIsLoggedIn()){
			Sesion::destroy();
			Sesion::init();
			Sesion::set('origen', $_SERVER['REQUEST_URI']);
			header('location: /login');
			exit();
		}
	}
}