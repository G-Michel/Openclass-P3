<?php

namespace app\backend\lib;

class User{
	private $_id;
	private $_user;
	private $_password;

	public function __construct(array $user)
	{
		$this->setUser($user["user"]);
		$this->setPassword($user["password"]);
		$this->setId($user["ID"]);
	}
	//getter
	public function getUser()
	{
		return $this->_user;
	}
	public function getPassword()
	{
		return $this->_password;
	}
	public function getId()
	{
		return $this->_id;
	}
	//SETTERS
	public function setUser($user){
		if (isset($user) && is_string($user))
		{
			$this->_user = $user;
		}
	}
	public function setPassword($password){
		if (isset($password) && is_string($password))
		{
			$this->_password = $password;
		}
	}
	public function setId($id){
		if (isset($id))
		{
			$this->_id=$id;
		}
	}
}