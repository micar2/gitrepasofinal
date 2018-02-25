<?php

/**
 * Class HomeController
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */

namespace Mini\Controller;

use Mini\Core\Controller;
use Mini\Libs\Sesion;

class HomeController extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        $this->view->addData(['titulo' => 'Reapaso Final']);
        echo $this->view->render('home/index', ['titulo' => 'Pagina principal']);
    }

    public function priv()
    {
        echo $this->view->render('home/private');
    }

    public function ex()
    {
        Sesion::destroy();
        echo $this->view->render('home/goodbye');
    }

    
}
