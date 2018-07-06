<?php

namespace app\frontend\lib;

 class Form {
	protected $form;

	public function __construct( $presets ="none")
	{

	}

//essayons de s'imaginer 
	public static function commentForm()
	{


		
	}



	public function buildComment()
	{

	}

	public function getForm()
	{
		return $this->form;
	}
	public function setForm()
	{

	}
	


	public function input($type,$name)
	{
		return '<input class="form-control" type="'.$type.'" name="'.$name .'"><br/>';
	}

	public function textarea ($name)
	{
		return '<textarea class="form-control" rows="5" name='.$name .'></textarea><br/>';

	}



	

}

?> 