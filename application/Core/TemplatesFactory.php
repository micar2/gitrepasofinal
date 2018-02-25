<?php 

namespace Mini\Core ;

use Mini\Libs\Sesion;

class TemplatesFactory
{
	private static $templates;
	
	public static function templates()
	{
		if( ! TemplatesFactory::$templates) {
			TemplatesFactory::$templates = new \League\Plates\Engine(APP . 'view');
			TemplatesFactory::$templates->addData(['titulo' => 'Repaso Final']);
			TemplatesFactory::$templates->registerFunction(
				'borrar_msg_feedback', function(){
					Sesion::set('feedback_positive', null);
					Sesion::set('feedback_negative', null);
				});
		}
		return TemplatesFactory::$templates;
	}
}