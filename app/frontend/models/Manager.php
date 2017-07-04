<?php

namespace app\frontend\models;

// main class for managers
abstract class Manager{

	protected $db;
	protected $tableName;
	protected $className;

// constructor needs myqsl database
	public function __construct($connection)
	{
		$this->setDB($connection);
	}
	
	//GETTER 
	public function getDB()
	{
		return $this->db;
	}
	//SETTER
	public function setDB($connection)
	{
		try {
			$this->db = new \PDO($connection,"root","");	
		} catch (PDOException $e) {
			echo "ERREUR DE CHARGEMENT DE LA BASE DE DONNEE!!!";
		}
	}

	//abstract method to add content to database !
	abstract public function addContent(array $content);

	// update content into database 
	public function updateContent(array $content)
	{
		// une fonction qui explore le tableau
		$readRequest = $this->getDB()->query("SELECT * FROM $this->tableName WHERE ID=".$content["id"]);
		$reponse = $readRequest->fetch();
		foreach ($content as $key => $value) 
		{
			if(isset($reponse["$key"]))
			{
			$request = $this->getDB()->prepare("UPDATE $this->tableName SET $key=? WHERE ID=".$content["id"]);
			$request->execute(array($value));
			}
			$this->getDB()->exec("UPDATE $this->tableName SET modificationDate=NOW()");
		}
	}
	// delete content from database 
	public function deleteContent($ID)
	{
		$this->getDB()->exec("DELETE FROM $this->tableName WHERE ID=".$ID);	
	}

	// get a single content from database with ID
	public function getContent($ID)
	{
		$request = $this->getDB()->query("SELECT * FROM $this->tableName WHERE ID=".$ID);
		while ($reponse = $request->fetch())
		{
			$object = new $this->className($reponse);
		}
		if (isset($object)) return $object;
		else return null;	
	}
	//get multiple content from a database with an option to 
	public function getContents($ID=null)
	{
		
		if ($ID !=null) $request = $this->getDB()->query("SELECT * FROM $this->tableName WHERE idPost = $ID LIMIT 20");
		else $request = $this->getDB()->query("SELECT * FROM $this->tableName ORDER BY ID DESC LIMIT 20");
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