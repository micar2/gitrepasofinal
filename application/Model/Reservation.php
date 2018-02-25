<?php
/**
 * Created by PhpStorm.
 * User: jose
 * Date: 27/12/17
 * Time: 11:36
 */

namespace Mini\Model;

use Mini\Core\Database;
use Mini\Libs\Sesion;
use Mini\Libs\Validation;
use PDO;

class Reservation
{
    public static function calendar()
    {
        $month=date("n");
        $year=date("Y");
        $diaActual=date("j");
        $diaSemana=date("w",mktime(0,0,0,$month,1,$year))+7;
        $ultimoDiaMes=date("d",(mktime(0,0,0,$month+1,1,$year)-1));
        $ultimoDiaMes2=date("d",(mktime(0,0,0,$month+2,1,$year)-1));
        $meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        return (['month'=>$month, 'year'=>$year, 'diaActual'=>$diaActual, 'diaSemana'=>$diaSemana, 'ultimoDiaMes'=>$ultimoDiaMes, 'meses'=>$meses, 'ultimoDiaMes2'=>$ultimoDiaMes2]);
    }



    public static function create($dates, $time)
    {
        foreach ($dates as $date)
        {
            if($date->id){
                $conn = Database::getInstance()->getDatabase();
                $ssql = 'INSERT INTO reservations (user_id, customer_id, day, month, hour) VALUES (:user_id, :customer_id, :day, :month, :hour)';
                $query = $conn->prepare($ssql);
                $parametros = [
                    ':user_id' => $date->id,
                    ':customer_id' => Sesion::get('customer_id'),
                    ':day' => $time['day'],
                    ':month' => $time['month'],
                    ':hour' => $time['hour'],
                ];
                if($query->execute($parametros)){
                    return true;
                }

            }
        }
    }

    public static function myReservations($idCustomer)
    {
        $conn = Database::getInstance()->getDatabase();
        $ssql = 'SELECT U.name, U.section, R.day, R.month, R.hour FROM users U, customers C, reservations R WHERE U.id=R.user_id AND C.id=R.customer_id AND C.id='.$idCustomer.' ORDER BY R.month, R.day, R.hour;';
        $query = $conn->prepare($ssql);
        $query->execute();
        $query = $query->fetchAll();
        return $query;
    }

    public static function clean()
    {
        $now=getdate();
        $conn = Database::getInstance()->getDatabase();
        $ssql = 'DELETE FROM reservations WHERE day<'.$now['mday'].' AND month<'.$now['mon'].';';
        $query = $conn->prepare($ssql);
        $query->execute();
    }
}