<?php

class Manager{

	protected $db;

	public function __construct($connection)
	{
		$this->setDB($connection);
	}
	
	//getter 
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


	//pour l'instant on va faire une classe qui va gérer directement tout ça aprés on pourra réfléchir à un strategy pattern pour addContent pour train XD
	public function addContent(array $content)
	{
		if (isset($content))
		{
			$request = $this->getDB()->prepare("INSERT INTO posts (title,content,author) VALUES (?,?,?)");
			$request->execute(array(
				htmlspecialchars($content["title"]),
				htmlspecialchars($content["content"]),
				htmlspecialchars($content["author"])));
		}
	}

	public function updateContent(UserContent $content)
	{
			$request = $this->getDB()->prepare("UPDATE posts SET (title=?,content=?,author=?,modificationDate=NOW())");
			$request->execute(array(
				htmlspecialchars($content->getTitle()),
				htmlspecialchars($content->getContent()),
				htmlspecialchars($content->getAuthor())));
	}

	public function deleteContent(UserContent $content)
	{
		$this->getDB()->exec("DELETE post WHERE ID=". $content->getID());
	}
	public function getContent($ID)
	{
		$request = $this->getDB()->query("SELECT * FROM posts WHERE ID=".$ID);
		while ($reponse = $request->fetch())
		{
			$object = new Post($reponse);
		}
		return $object;
		
	}
	public function getContents()
	{
		$request = $this->getDB()->query("SELECT * FROM posts ORDER BY ID LIMIT 10");
		$i=0;
		while ($reponse = $request->fetch())
		{
			$object[$i] = new Post($reponse);
			$i++;
		}
		return $object;
	}

}