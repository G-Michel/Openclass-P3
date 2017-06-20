<?php

namespace app\backend\models;
use app\frontend\models\Manager;
use app\backend\lib\User;


class UserManager extends Manager{

	protected $tableName= "users";

	public function addContent(array $content)
	{
		if (isset($content))
		{
			$request = $db->prepare("INSERT INTO $tableName (user,password) SET (?,?)");
			$request->execute(array($content["user"],$content["password"]));
		}
	}


	public function getContent($user)
	{
		$request = $this->getDB()->query("SELECT * FROM users WHERE user='eguibs'");
		if($request != false)
		{
			while ($reponse = $request->fetch())
			{
			
				$object = new User($reponse);
			}
			
			return $object;
			
		}
		else return null;
		
	}

	public function updateContent(UserContent $content)
	{

			$request = $this->getDB()->prepare("UPDATE $this->tableName SET (user=?,password=?)");
			$request->execute(array(
				htmlspecialchars($content->getUser()),
				htmlspecialchars($content->getPassword())));
	}

}