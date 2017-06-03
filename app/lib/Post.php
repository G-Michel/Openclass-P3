<?php

class Post extends UserContent{

protected $modificationDate;
protected $title;

//constructor
	public function __construct(array $values)
	{
		parent::__construct($values);
		$this->setTitle($values["title"]);
		$this->setModificationDate($values["modificationDate"]);
	}

//GETTERS
public function getModificationDate()
{
	return $this->modificationDate;
}

public function getTitle()
{
	return $this->title;
}
//SETTERS
public function setModificationDate($modificationDate)
{
	if (isset($modificationDate)) 
			{$this->modificationDate = htmlspecialchars($modificationDate);}
}
public function setTitle($title)
{
	if (isset($title)) 
		{$this->title = htmlspecialchars($title);}
}




}