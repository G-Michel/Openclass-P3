<?php

namespace app\frontend\models;
use app\frontend\lib\Comment;

class CommentManager extends Manager{

	protected $tableName= "comments";


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

	public function updateContent(UserContent $content)
	{

			$request = $this->getDB()->prepare("UPDATE $this->tableName SET (content=?,author=?,modificationDate=NOW())");
			$request->execute(array(
				htmlspecialchars($content->getContent()),
				htmlspecialchars($content->getAuthor())));
	}


	public function getContents($postID)
	{
		$request = $this->getDB()->query("SELECT * FROM $this->tableName WHERE idPost = $postID ORDER BY publishDate LIMIT 20");
		$i=0;
		while ($reponse = $request->fetch())
		{	
			$object[$i] = new Comment($reponse);
			$i++;
		}
		if (isset($object)) return $object;
		else return null;
		
	}

	public function getCommNbre($idPost)
	{
		$request =  $this->getDB()->query("SELECT COUNT($idPost) as dbcount FROM $this->tableName WHERE idPost=$idPost" );
		$reponse = $request->fetch();
		return $reponse["dbcount"];

	}
}