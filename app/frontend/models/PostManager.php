<?php

namespace app\frontend\models;
use app\frontend\lib\Post;

class PostManager extends Manager{

	protected $tableName= "posts";
	protected $className= "app\\frontend\\lib\\Post";

	//abstract method to add content to database !
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
}