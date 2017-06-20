<?php

// formulaire qui va gérer les commentaires XD
use app\frontend\models\CommentManager;


$commManager = new CommentManager("mysql:host=localhost;dbname=projetoc;charset=UTF8");

if (!isset($_POST["idNextTo"])) $_POST["idNextTo"]=null ;
if (isset($_POST["author"]) && isset($_POST["content"]) )
{

	$commManager->addContent(array(
		'author' => htmlspecialchars($_POST["author"]),
		'idPost' => htmlspecialchars($_POST["idPost"]),
		'content' =>htmlspecialchars($_POST["content"]),
		'idNextTo' =>htmlspecialchars($_POST["idNextTo"])));

}
header('Location:' .$_POST["route"]);
exit;