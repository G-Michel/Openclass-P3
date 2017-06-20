<?php

namespace app\frontend\lib;

class Comment extends UserContent{

	protected $idPost;
	protected $idNextTo;

	public function __construct(array $values)
	{
		parent::__construct($values);
		$this->setIdPost($values["idPost"]);
		$this->setIdNextTo($values["idNextTo"]);

	}

	//getter 
	public function getIdPost()
	{
		return $this->idPost;
	}
	public function getIdNextTo()
	{
		return $this->idNextTo;
	}
	//setter
	public function setIdPost($idPost)
	{
	
			$this->idPost = $idPost;
		
	}
		public function setIdNextTo($idNextTo)
	{

			$this->idNextTo = $idNextTo;
		
	}

}