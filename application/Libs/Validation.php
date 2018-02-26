<?php

namespace Mini\Libs;

use Mini\Libs\Sesion;
use Mini\Core\Database;
use Mini\Model\Categoria;
use PDO;

class Validation
{
    private $patternName = "/[A-Za-zñÑáéíóúÁÉÍÓÚÄËÏÖÜäëïöüàèìòùÀÈÌÔÙ\- ]{3,}$/";
    private $patternLastName = "/[A-Za-zñÑáéíóúÁÉÍÓÚÄËÏÖÜäëïöüàèìòùÀÈÌÔÙ\- ]{3,}$/";
    private $patternEmail = "/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/";
    private $patternNick = "/[A-Za-zñÑáéíóúÁÉÍÓÚÄËÏÖÜäëïöüàèìòùÀÈÌÔÙ, ]{3,}/";
    private $patternPassword = "/[0-9A-Za-zñÑáéíóúÁÉÍÓÚÄËÏÖÜäëïöüàèìòùÀÈÌÔÙ\- ]{6,}$/";
    private $patternTelefono = '/^[9|6|7][0-9]{8}$/';
    private $patternDireccion = "/[A-Za-z0-9ñÑáéíóúÁÉÍÓÚÄËÏÖÜäëïöüàèìòùÀÈÌÔÙº\- ]{3,}$/";
    private $patternSearch = "/[A-Za-zñÑáéíóúÁÉÍÓÚÄËÏÖÜäëïöüàèìòùÀÈÌÔÙ\- @.]{3,}$/";
    private $patternPalabras = "/[A-Za-zñÑáéíóúÁÉÍÓÚÄËÏÖÜäëïöüàèìòùÀÈÌÔÙ,]{3,30}/";
   // private $patternDay = "/(31)[/](0?[13578]|1[02])/";
   // private $patternMonth = "/(0?[1-9]|1[0-2])/";

    private $user;

    public function __construct()
    {
    }

    public function valSearch($date)
    {
        if (! $this->dateReceived($date)) {
            Sesion::add("feedback_negative", "No he recibido los dates del Buscador");
            return false;
        }
        if (! $this->dateEmpty($date)) {
            Sesion::add("feedback_negative", "No se ha introducido la palabra a buscar");
        }
        if (Sesion::get('feedback_negative')) {
            return false;
        }
        return true;
    }

    public function valRegistro($dates)
    {

        if (! $this->dateReceived($dates)) {
            Sesion::add("feedback_negative", "No he recibido los dates de login");
        }
        if (!isset($dates['name'])){
            Sesion::add("feedback_negative", "No se ha introducido el nombre");
        }
        if (!isset($dates['email'])) {
            Sesion::add("feedback_negative", "No se ha introducido el email");
        }
        if (isset($dates['password'])) {
            $error='';
            if (!preg_match("/[^a-zA-Z0-9]/", $dates['password'])) {
                $error.= " debe tener al menos un caracter especial\n";
            }
            if (strlen($dates['password']) < 6) {
                $error.= " debe tener al menos 6 caracteres\n";
            }
            if (strlen($dates['password']) > 16) {
                $error.= "  no puede tener más de 16 caracteres\n";
            }
            if (!preg_match('/[a-z]/', $dates['password'])) {
                $error.= "  debe tener al menos una letra minúscula\n";
            }
            if (!preg_match('/[A-Z]/', $dates['password'])) {
                $error.= "  debe tener al menos una letra mayúscula\n";
            }
            if (!preg_match('/[0-9]/', $dates['password'])) {
                $error.= " debe tener al menos un caracter numérico\n";
            }
            if ($dates['password']!=$dates['passwordR']){
                $error.= "  debe tener al menos una letra mayúscula\n";
            }
            if (strlen($error)>2){
            Sesion::add("feedback_negative", $error);
            }
        } else {
            Sesion::add("feedback_negative", "No he recibido la clave");
        }
        if (! $this->valCampo($dates["name"], "patternName")) {
            Sesion::add("feedback_negative", "El nombre debe ser valido");
        }
        if (! $this->valCampo($dates["email"], "patternEmail")) {
            Sesion::add("feedback_negative", "El email debe ser valido");
        }
        if (! $this->emailExist($dates['email'], $dates['type'])) {
            Sesion::add("feedback_negative", "El Nombre de usuario o la contraseña no coinciden");
        }
        if (Sesion::get('feedback_negative')) {
            return false;
        }

        return true;
    }

    public  function emailExist($email, $table){//**cambiar por funcion de database**
        $conn = Database::getInstance()->getDatabase();
        $ssql = "SELECT id, email, password FROM ".$table." WHERE email = :email";
        $query = $conn->prepare($ssql);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $find = $query->rowCount();

        if($find != 0){
            Sesion::add("feedback_negative", "Algunos de sus datos ya se encuentran en uso");
            return false;
        }
        return true;
    }



    public function valLogin($dates)
    {

        if (!$this->dateReceived($dates)) {
            Sesion::add("feedback_negative", "No he recibido los dates de login");
            return false;
        }

        if (!isset($dates['email'])) {
            Sesion::add("feedback_negative", "No he recibido el email");
        }
        if (!isset($dates['password'])) {
            Sesion::add("feedback_negative", "No he recibido la clave");
        }
        if ($user=$this->findPassword($dates['email'], 'email')) {
            if ($user->password!=md5($dates['password'])){
                Sesion::add("feedback_negative", "La contraseña o el email no son correctos");
            }
        }
        if (Sesion::get('feedback_negative')) {
            return false;
        }

        return true;
    }


    public function valDate($dates)
    {
        $weekDay =date("w",strtotime($dates["month"].'/'.$dates["day"].'/2018')) ;
        if($weekDay==6 || $weekDay==0){
            Sesion::add("feedback_negative", "Lo siento, no atendemos en Sabados o Domingos");
            return false;
        }
        if (!$dates["day"]<32 && !$dates["day"]>0){
            if (!preg_match('/[1-9]/', $dates['day'])) {
                Sesion::add("feedback_negative", "El dia tiene que ser valido");
            }
            Sesion::add("feedback_negative", "El dia tiene que ser valido");
            return false;
        }
        if (!$dates["month"]<13 && !$dates["month"]>0) {
            if (!preg_match('/[1-9]/', $dates['month'])) {
                Sesion::add("feedback_negative", "El mes tiene que ser valido");
            }
            Sesion::add("feedback_negative", "El mes tiene que ser valido");
            return false;
        }
        return true;
    }

    public function hourExist($dates)
    {
        $conn = Database::getInstance()->getDatabase();
        $ssql = 'SELECT C.id FROM customers C, reservations R WHERE C.id=R.customer_id AND R.month='
                .$dates['month'].' AND R.day='.$dates['day'].' AND R.hour='.$dates['hour']
                .' AND C.id='.Sesion::get('customer_id').';';
        $query = $conn->prepare($ssql);
        $query->execute();
        $find = $query->rowCount();
        if($find == 0){
            return true;
        }else{
            Sesion::add("feedback_negative", "Ya tenia cita a esa hora");
            return false;
        }


    }

    public  function comproveHours($dates)
    {

        if ($this->hourExist($dates)) {
            $conn = Database::getInstance()->getDatabase();
            $ssql = 'SELECT U.id FROM users U, reservations R WHERE U.id=R.user_id AND R.month=' . $dates['month'] . ' AND R.day=' . $dates['day'] . ' AND R.hour=' . $dates['hour'] . ';';
            $query = $conn->prepare($ssql);
            $query->execute();
            $query = $query->fetchAll();

            if (empty($query)) {
                $query = Database::getAll('users');
                return $query;
            }

            $ids = '';
            foreach ($query as $user) {
                $ids .= $user->id . ', ';
            }
            $ids = substr($ids, 0, -2);

            $ssql = 'SELECT id, name, section FROM users WHERE id NOT IN ( ' . $ids . ' );';
            echo $ssql;
            $query = $conn->prepare($ssql);
            $query->execute();
            $query = $query->fetchAll();

            if ($query) {
                return $query;
            } else {
                Sesion::add("feedback_negative", "Esa hora no se encuentra disponible");
                return false;
            }
        }else{
            return false;
        }
    }

    private function dateReceived($date)
    {
        if (! $date) {
            return false;
        } else {
            return true;
        }
    }

    private function dateEmpty($date)
    {
        if ( ! isset($date)) {
            return false;
        }
        if (empty($date)) {
            return false;
        } else {
            return true;
        }
    }

    private function valCampo($campo, $exp)
    {
        $campo = trim($campo);
        $campo = $this->removeSpaces($campo);
        if (!preg_match($this->$exp, $campo)) {
            return false;
        } else {
            return true;
        }
    }



    public function removeSpaces($campo) {
        $campo = str_replace(' ', '', $campo);
        return $campo;
    }

    public function findPassword($data, $type)
    {
        $conn = Database::getInstance()->getDatabase();
        $ssql = 'SELECT * FROM users WHERE '.$type.'=:'.$type;
        $query = $conn->prepare($ssql);
        $params = [':'.$type => $data];
        $query->execute($params);
        return $query->fetch();
    }


}
