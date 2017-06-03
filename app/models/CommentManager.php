<?php
class CommentManager extends Manager{

	protected $tableName= "comments";


	public function addContent(array $content)
	{
		if (isset($content))
		{
			$request = $this->getDB()->prepare("INSERT INTO $this->tableName (content,author) VALUES (?,?)");
			$request->execute(array(
				htmlspecialchars($content["$content"]),
				htmlspecialchars($content["$author"])));
		}
	}

	public function updateContent(UserContent $content)
	{

			$request = $this->getDB()->prepare("UPDATE $this->tableName SET (content=?,author=?,modificationDate=NOW())");
			$request->execute(array(
				htmlspecialchars($content->getContent()),
				htmlspecialchars($content->getAuthor())));
	}


	public function getContents()
	{
		$request = $this->getDB()->query("SELECT * FROM $this->tableName WHERE ORDER BY ID LIMIT 20");
		$i=0;
		while ($reponse = $request->fetch())
		{
			$object[$i] = new Post($reponse);
			$i++;
		}
		return $object;
	}

}