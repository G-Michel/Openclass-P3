<?php

abstract class Manager{

	protected $db;
	protected $tableName;


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
			$this->db = new PDO($connection,"root","");	
		} catch (PDOException $e) {
			echo "ERREUR DE CHARGEMENT DE LA BASE DE DONNEE!!!";
		}
	}

	abstract public function addContent(array $content);
	abstract public function updateContent(UserContent $content);
	abstract public function getContents();

	public function deleteContent(UserContent $content)
	{
		$this->getDB()->exec("DELETE $this->tableName WHERE ID=". $content->getID());
	}
	public function getContent($ID)
	{
		$request = $this->getDB()->query("SELECT * FROM $this->tableName WHERE ID=".$ID);
		while ($reponse = $request->fetch())
		{
			$object = new Post($reponse);
		}
		return $object;
		
	}


}