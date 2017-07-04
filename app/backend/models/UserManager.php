<?php

namespace app\backend\models;
use app\frontend\models\Manager;
use app\backend\lib\User;

class UserManager extends Manager{

	protected $tableName= "users";
	protected $className= "app\\backend\\lib\\User";

	//abstract method to add content to database !
	public function addContent(array $content)
	{
		if (isset($content))
		{
			$request = $db->prepare("INSERT INTO $this->tableName (id,user,password) SET (?,?,?)");
			$request->execute(array(
				$content["id"],
				$content["user"],
				$content["password"]));
		}
	}

	public function getContent($user)
	{
		$request = $this->getDB()->query("SELECT * FROM $this->tableName WHERE user='$user'");
		if($request != false)
		{
			while ($reponse = $request->fetch())
			{
				$object = new $this->className($reponse);
			}
			return $object;
		}
		else return null;
	}

		public function getContents($ID=null)
	{
		
		if ($ID !=null) $request = $this->getDB()->query("SELECT user FROM $this->tableName WHERE idPost = $ID LIMIT 20");
		else $request = $this->getDB()->query("SELECT user FROM $this->tableName ORDER BY ID DESC LIMIT 20");
		$i=0;
		while ($reponse = $request->fetch())
		{
			$object[$i] = new $this->className($reponse);
			$i++;
		}
		if (isset($object)) return $object;
		else return null;
	}
}
