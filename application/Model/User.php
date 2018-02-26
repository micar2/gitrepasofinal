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

class User
{
    public static function create($dates)//**cambiar, simplificar**
    {

        foreach ($dates as $date) {
            $dates[$date] = strip_tags($date);
        }

            $conn = Database::getInstance()->getDatabase();
        if ($dates['type']=='users'){
            $ssql = 'INSERT INTO users (name, email, section, password) 
                      VALUES (:name, :email, :section, :password)';
            $query = $conn->prepare($ssql);
            $parametros = [
                ':name' => $dates['name'],
                ':email' => $dates['email'],
                ':section' => User::asignedSection(),
                ':password' => md5($dates['password']),
            ];
        }
        if ($dates['type']=='customers'){
            $ssql = 'INSERT INTO customers (name, email, password) 
                      VALUES (:name, :email, :password)';
            $query = $conn->prepare($ssql);
            $parametros = [
                ':name' => $dates['name'],
                ':email' => $dates['email'],
                ':password' => md5($dates['password']),
            ];
        }
            $query->execute($parametros);
            return true;

    }

    public static function asignedSection()
    {

        $conn = Database::getInstance()->getDatabase();
        $ssql = 'SELECT * FROM section WHERE asigned=0 LIMIT 1;';
        $query = $conn->prepare($ssql);
        $query->execute();
        $query = $query->fetch();

        $section = $query->id;


        $ssql2 = 'UPDATE section SET asigned=1 WHERE id=:id;';
        $query2 = $conn->prepare($ssql2);
        $params=[':id' => $section];
        $query2->execute($params);

        return $section;
    }

    public static function desasignedSection($date)
    {
        $conn = Database::getInstance()->getDatabase();
        $ssql2 = 'UPDATE section SET asigned=0 WHERE id=:id;';
        $query2 = $conn->prepare($ssql2);
        $params=[':id' => Sesion::get('user_section')];
        $query2->execute($params);
    }

    public static function login($dates)//**cambiar, simplificar**
    {
       $val = new Validation();

        foreach ($dates as $date) {
            $dates[$date] = strip_tags($date);
        }
       if ($val->valLogin($dates)){
            if ($user=Database::getRow($dates['email'],'email','users')){
               Sesion::set('user_id', $user->id);
               Sesion::set('user_name', $user->name);
               Sesion::set('user_email', $user->email);
               Sesion::set('user_section', $user->section);
               Sesion::set('user_logged_in', true);
               return true;
           }
           if ($customer=Database::getRow($dates['email'],'email','customers')){
               Sesion::set('customer_id', $customer->id);
               Sesion::set('customer_name', $customer->name);
               Sesion::set('customer_email', $customer->email);
               Sesion::set('customer_logged_in', true);
               return true;
           }
       }else{
            return false;
       }

    }



}