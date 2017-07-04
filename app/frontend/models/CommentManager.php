<?php

namespace app\frontend\models;
use app\frontend\lib\Comment;

class CommentManager extends Manager{

	protected $tableName= "comments";
	protected $className= "app\\frontend\\lib\\Comment";

	//abstract method to add content to database !
	public function addContent(array $content)
	{
		if (isset($content))
		{
			if (isset($content["idNextTo"]) && $content["idNextTo"] != null ) 
			{
				$request = $this->getDB()->prepare("INSERT INTO $this->tableName (idPost,content,author,idNextTo) VALUES (?,?,?,?)");
				$request->execute(array(
					htmlspecialchars($content["idPost"]),
					htmlspecialchars($content["content"]),
					htmlspecialchars($content["author"]),
					htmlspecialchars((int)$content["idNextTo"])));
			}
			else
			{
				$request = $this->getDB()->prepare("INSERT INTO $this->tableName (idPost,content,author,idNextTo) VALUES (?,?,?,NULL)");
				$request->execute(array(
					htmlspecialchars($content["idPost"]),
					htmlspecialchars($content["content"]),
					htmlspecialchars($content["author"])));
			}
		}
	}

	//get all reported comments
	public function getReportedContents($limit=20)
	{
		$request = $this->getDB()->query("SELECT * FROM $this->tableName WHERE report >0 ORDER BY publishDate LIMIT $limit");
		$i=0;
		while ($reponse = $request->fetch())
		{	
			$object[$i] = new Comment($reponse);
			$i++;
		}
		if (isset($object)) return $object;		
		else return null;	
	}


	//get nbre of comment from a selected article
	public function getCommNbre($idPost)
	{
		$request =  $this->getDB()->query("SELECT COUNT($idPost) as dbcount FROM $this->tableName WHERE idPost=$idPost" );
		if($request != null)
		{
		$reponse = $request->fetch();
		return $reponse["dbcount"];
		}
		else return 0;
	}
}