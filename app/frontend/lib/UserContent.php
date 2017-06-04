<?php

namespace app\frontend\lib;


abstract class UserContent{

	protected $ID;
	protected $content;
	protected $author;
	protected $publishDate;

	//constructeur
	public function __construct(array $values)
	{
		$this->setID($values["ID"]);
		$this->setAuthor($values["author"]);
		$this->setContent($values["content"]);
		$this->setPublishDate($values["publishDate"]);
	}

//Getters 
	public function getID()
	{
		return $this->ID;
	}
	public function getContent()
	{
		return $this->content;
	}
	public function getAuthor()
	{
		return $this->author;
	}
	public function getPublishDate()
	{
		return $this->publishDate;
	}

//Setters
	public function setContent($content)
	{
		if (isset($content)) 
			{$this->content = htmlspecialchars($content);}
	}
	public function setAuthor($author)
	{
		if (isset($author)) 
			{$this->author = htmlspecialchars($author);}
	}
	public function setID($ID)
	{
		if (isset($ID)) 
			{$this->ID = htmlspecialchars($ID);}
	}
	public function setPublishDate($publishDate)
	{
		if (isset($publishDate)) 
			{$this->publishDate = htmlspecialchars($publishDate);}
	}
	
	

}