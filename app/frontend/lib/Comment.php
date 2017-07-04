<?php

namespace app\frontend\lib;

class Comment extends UserContent{

	protected $idPost;
	protected $idNextTo;
	protected $report;

	public function __construct(array $values)
	{
		parent::__construct($values);
		$this->setIdPost($values["idPost"]);
		$this->setIdNextTo($values["idNextTo"]);
		$this->setReport($values["report"]);
	}

	//getter 
	public function getIdPost()
	{
		return $this->idPost;
	}
	public function getReport()
	{
		return $this->report;
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
	public function setReport($report)
	{
		$this->report = $report;
	}

}