<?php

/**
 * Class Error
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */

namespace Mini\Controller;
use Mini\Core\Controller;

class ErrorController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * PAGE: index
     * This method handles the error page that will be shown when a page is not found
     */
    public function index()
    {
        $this->view->addData(['titulo' => 'Portada']);
        echo $this->view->render("error/index", ['titulo' => 'Pagina de error']);
    }
}
