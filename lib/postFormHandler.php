<?php

// formulaire qui va gérer les commentaires XD
use app\frontend\models\PostManager;
use app\frontend\models\CommentManager;
$postManager = new PostManager("mysql:host=localhost;dbname=projetoc;charset=UTF8");
$commManager = new CommentManager("mysql:host=localhost;dbname=projetoc;charset=UTF8");

// supprimer
if ($_POST["submit"]=="Supprimer")
{
	$postManager->deleteContent($_POST["id"]);
	$comments = $commManager->getContents($_POST["id"]);
	foreach ($comments as $comment) {
	 	$commManager->deleteContent($comment->getID());
	}
}
//Publier
else if ($_POST["submit"]=="Publier")
{
	$postManager->addContent(array(
		'author' => htmlspecialchars($_POST["author"]),
		'content' =>($_POST["content"]),
		'title' =>htmlspecialchars($_POST["title"])));
}
//Modifier
else
{
	$postManager->updateContent(array(
		'author' => htmlspecialchars($_POST["author"]),
		'content' =>($_POST["content"]),
		'id'=>$_POST["id"],
		'title' =>htmlspecialchars($_POST["title"])));

}

	header('Location: /admin/gererArticles');
	exit;