<?php

namespace app\frontend\models;
use app\frontend\lib\Post;

class PostManager extends Manager{

	protected $tableName= "posts";

	public function addContent(array $content)
	{
		if (isset($content))
		{
			$request = $this->getDB()->prepare("INSERT INTO $this->tableName (title,content,author) VALUES (?,?,?)");
			$request->execute(array(
				htmlspecialchars($content["title"]),
				$content["content"],
				htmlspecialchars($content["author"])));
		}
	}

	public function updateContent(array $content)
	{
		var_dump($content);
			$request = $this->getDB()->prepare("UPDATE $this->tableName SET title=?,content=?,author=?,modificationDate=NOW() WHERE ID=".$content["id"]);
			var_dump($request);
			$request->execute(array(
				htmlspecialchars($content["title"]),
				$content["content"],
				htmlspecialchars($content["author"])
				));
	}


	public function getContents()
	{
		$request = $this->getDB()->query("SELECT * FROM $this->tableName ORDER BY ID DESC LIMIT 20");
		$i=0;
		while ($reponse = $request->fetch())
		{
			$object[$i] = new Post($reponse);
			$i++;
		}
		return $object;
	}




}