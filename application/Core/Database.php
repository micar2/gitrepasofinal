<?php
//revisar
namespace Mini\Core;
use PDO;
class Database
{
	private static $instancia=null;

	private $db=null;
	private function __construct()
	{
		$options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING ];

		try{
			$this->db = new PDO(DB_TYPE . ':host=' . DB_HOST .
				';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
				DB_USER,
				DB_PASS,
				$options);
		}catch(PDOEsception $e){
			exit('la vase de datos no esta accesible');
		}

	}

	public static function getInstance()
	{
		if(is_null(self::$instancia)){
			self::$instancia = new Database();
		}
		return self::$instancia;
	}

	public function getDatabase(){
		return $this->db;
	}

    public static function getRow($date, $type, $table, $more=false)
    {
        //echo $date.$type.$table;
        $conn = Database::getInstance()->getDatabase();
        $ssql = 'SELECT * FROM '.$table.' WHERE '.$type.'=:'.$type.';';
        $query = $conn->prepare($ssql);
        $params = [':'.$type => $date];
        $query->execute($params);
        if ($more){
            $query = $query->fetchAll();
        }else{
            $query = $query->fetch();
        }
        return $query;
    }

    public static function getAll($table)
    {
        $conn = Database::getInstance()->getDatabase();
        $ssql = 'SELECT * FROM '.$table.';';
        $query = $conn->prepare($ssql);
        $query->execute();
        $query = $query->fetchAll();
        return $query;
    }

    public static function relationTable($reservations, $type, $table, $search, $id)
    {//**cambiar por una busqueda larga**
        $customers = [];
        foreach ($reservations as $reservation){
            $row=Database::getRow($reservation->$id, $type , $table);
            $customers[$reservation->id] = $row->$search;
        }
        return $customers;
    }

    public static function destroy($table, $type, $date)
    {
        $conn = Database::getInstance()->getDatabase();
        $ssql = 'DELETE FROM '.$table.' WHERE '.$type.'='.$date.';';
        $query = $conn->prepare($ssql);
        if($query->execute()){
            return true;
        }else{
            return false;
        }

    }


}