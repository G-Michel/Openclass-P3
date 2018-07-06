<?php

namespace app\backend\lib;

class Dbclass{

protected $dBName="mysql:host=localhost;dbname=projetoc;charset=UTF8";
protected $user="root";
protected $password="";
protected static $instance=NULL;
protected $dbAccess;

public function __construct()
{
	$this->setDBAccess();
}

//GETTERS
protected function getDBName()
{
	return $this->dBName;
}
protected function getUser()
{
	return $this->user;
}
protected function getPassword()
{
	return $this->password;
}
public function getDBAccess()
{
	return $this->dbAccess;
}

//SETTERS
protected function setDBAccess()
{
	try {
		$this->dbAccess = new \PDO($this->getDBName(),$this->getUser(),$this->getPassword());
		
	} catch (PDOException $e) {
		echo("erreur systeme");		
	}
}

//STATIC FUNCTION TO GET DBACCESS
public static function getInstance()
{
	if (is_null(self::$instance))
		{
			self::$instance = new Dbclass();
		}
	return self::$instance;

}
}