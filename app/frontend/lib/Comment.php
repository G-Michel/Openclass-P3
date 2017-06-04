<?php

namespace app\frontend\lib;

class Comment extends UserContent{

	protected $idPost;


	//getter 
	public function getIdPost()
	{
		return $this->idPost;
	}
	//setter
	public function setIdPost($idPost)
	{
		if (is_int($idPost))
		{
			$this->idPost = $idPost;
		}
	}

}