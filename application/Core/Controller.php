<?php 

namespace Mini\Core ;

use Mini\Libs\Sesion;


class Controller
{
	public $view=null;
	protected $titulo;

	public function __construct()
	{
		$this->view = TemplatesFactory::templates();
		Sesion::init();
	}
}