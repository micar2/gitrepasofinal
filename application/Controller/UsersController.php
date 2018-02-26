<?php

namespace Mini\Controller;

use Mini\Core\Controller;
use Mini\Core\Database;
use Mini\Libs\Sesion;
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

    public function down()
    {
        if (isset($_POST['down'])){
            if ($_POST['down']=='si'){
               //**no se por que no entra en ninguno de estos 2 ifs**
                if($_POST['typeId']=='customer'){
                   if(Database::destroy('resevations','customer_id',Sesion::get('customer_id'))){
                       if(Database::destroy('customers','id',Sesion::get('customer_id'))){
                           echo $this->view->render('home/goodbye');
                       }
                   }
                }
                if($_POST['typeId']=='user'){
                    if(Database::destroy('reservations','user_id',Sesion::get('user_id'))) {//**areglar esto para repartirlo ntre sus compañeros**
                        User::desasignedSection();
                        if (Database::destroy('users', 'id', Sesion::get('user_id'))) {
                            echo $this->view->render('home/goodbye');
                        }
                    }
                }
                echo $this->view->render('forms/sure');
            }
            if ($_POST['down']=='no'){
                echo $this->view->render('reservations/doit', ['message'=> 'Nos alegramos que estes a salvo']);
            }
        }else{
            echo $this->view->render('forms/sure');
        }
    }


}