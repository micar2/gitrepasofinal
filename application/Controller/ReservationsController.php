<?php

namespace Mini\Controller;

use Mini\Core\Controller;
use Mini\Core\Database;
use Mini\Libs\Sesion;
use Mini\Libs\Validation;
use Mini\Model\Reservation;
use Mini\Model\User;

class ReservationsController extends Controller
{

    public function seeUserReservation()
    {
        if ($reservations=Database::getRow(Sesion::get('user_id'), 'user_id', 'reservations', true)){
            if ($customers = Database::relationTable($reservations, 'id', 'customers', 'name', 'customer_id')){
                echo $this->view->render('reservations/user', ['reservations'  => $reservations, 'customers' => $customers]);
            }else{
                echo $this->view->render('reservations/user',['titulo'=>'no tiene citas adjudicadas']);
            }
        }else{
            echo $this->view->render('reservations/user',['titulo'=>'no tiene citas adjudicadas']);
    }
    }

    public function seeReservation()
    {
        if ($reservations=Database::getAll('reservations')){
            if ($customers = Database::relationTable($reservations, 'id', 'customers', 'name', 'customer_id'))
                if ($users = Database::relationTable($reservations, 'id', 'users', 'section', 'user_id'))
                    if ($name = Database::relationTable($reservations, 'id', 'users', 'name', 'user_id')){
                        echo $this->view->render('reservations/user', [
                            'reservations'  => $reservations,
                            'customers' => $customers,
                            'users' => $users,
                            'name' => $name
                        ]);
                    }

        }
    }

    public function reservation()
    {
        $calendar = Reservation::calendar();
        echo $this->view->render('reservations/calendar',([
            'month'=>$calendar['month'],
            'year'=>$calendar['year'],
            'diaActual'=>$calendar['diaActual'],
            'diaSemana'=>$calendar['diaSemana'],
            'ultimoDiaMes'=>$calendar['ultimoDiaMes'],
            'meses'=>$calendar['meses'],
            'ultimoDiaMes2'=>$calendar['ultimoDiaMes2'],
            ]));
    }

    public function see()
    {
        if (Sesion::get('customer_id')){
            $reservations = Reservation::myReservations(Sesion::get('customer_id'));
            echo $this->view->render('reservations/customer',([ 'reservations'=> $reservations]));
        }
    }

    public function cite()
    {
        $val = new Validation();
        if ($val->valDate($_POST)){
                if (isset($_POST['hour'])) {
                        if ($usersFree =$val->comproveHours($_POST)) {
                            if (Reservation::create($usersFree, $_POST)) {
                                echo $this->view->render('reservations/doit', ['message' => 'Su cita ha sido guardada']);
                            }
                        } else {
                            echo $this->view->render('reservations/hours');
                        }
                } else {
                    echo $this->view->render('reservations/hours');
                }
        }else{
            $this->reservation();
        }
    }

    public function destroy()
    {
        $val = new Validation();

        if ($val->valId($_POST['reservation_id'])){
            if (Database::destroy('reservations', 'id',$_POST['reservation_id'])){
                echo $this->view->render('reservations/doit', ['message'=>'Cita borrada']);
            }else{
                $this->see();
            }
        }else{
            $this->see();
        }

    }
}