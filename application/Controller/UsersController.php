<?php

namespace Mini\Controller;

use Mini\Core\Controller;
use Mini\Libs\Validation;
use Mini\Model\Reservation;
use Mini\Model\User;

class UsersController extends Controller
{

    public function register()
    {
        $val= new Validation();
        if (!$_POST){
            echo $this->view->render('forms/register');
        }else{
                if ($val->valRegistro($_POST)){
                    if(User::create($_POST)){
                        unset($_POST);
                        echo $this->view->render('forms/login');
                    };
                }else{
                    echo $this->view->render('forms/register');
                }
        }
    }

    public function login()
    {
        if(!$_POST){
            echo $this->view->render('forms/login');
        }else{
                if (User::login($_POST)){
                    Reservation::clean();//**cambiar de sitio **
                    echo $this->view->render('home/private');
                }else{
                    echo $this->view->render('forms/login');
                }
        }
    }


}