<?php

namespace app;
use app\frontend\models\CommentManager;
use app\frontend\models\Manager;
use app\frontend\models\PostManager;
use app\backend\models\UserManager;

class FormHandler{

	const DB_ACCESS = "mysql:host=localhost;dbname=projetoc;charset=UTF8";

// codes that permit report an abusing comment
public static function commReport($id)
{	
	$commManager = new CommentManager(self::DB_ACCESS);
	$commentary = $commManager->getContent($id);
	if ($commentary !=null)
	{
		$report = $commentary->getReport();
		$report++;
		$commManager->updateContent(array(
			"id"=>$id,
			"report"=>$report
			));
		$_SESSION["notification"]="commentaire reporté";
		header('Location:' .$_POST["route"]);
		exit;
	}
	else
	{
		$_SESSION["notification"]="commentaire inconnu";
		header('Location: ../../');
		exit;
	}
}

//Password form
public static function changePass()
{	
	$userManager = new UserManager(self::DB_ACCESS);
	$user = $userManager->getContent($_SESSION["user"]);
	$oldPassword = sha1($_POST["oldPassword"])."blog";
	if ($user !=null && $_POST["newPassword"] == $_POST["passwordComfirm"])
	{
		$newPassword = sha1($_POST["newPassword"])."blog";
		
		
		if ($user->getPassword() == $oldPassword)
		{

			$userManager->updateContent(array(
				"id"=>$user->getID(),
				"password"=>$newPassword
			));
		}
		$_SESSION["notification"]="Mot de passe changé";
		$_SESSION["password"]=$newPassword;
		header('Location:' .$_POST["route"]);
		exit;
	}
	else
	{
		$_SESSION["notification"]="erreur de changement de mot de passe";
		header('Location: ../../');
		exit;
	}
}



//  handles commentaries' upload ,delete , update 
public static function commFormHandler($admin=false)
{
	$commManager = new CommentManager(self::DB_ACCESS);
	switch($_POST["submit"])
	{
	case "Repondre": // add a comment

		if (!isset($_POST["idNextTo"])) $_POST["idNextTo"]=null ;
		if (isset($_POST["author"]) && isset($_POST["content"]) )
		{
			$commManager->addContent(array(
				'author' => htmlspecialchars($_POST["author"]),
				'idPost' => htmlspecialchars($_POST["idPost"]),
				'content' =>htmlspecialchars($_POST["content"]),
				'idNextTo' =>htmlspecialchars($_POST["idNextTo"])));
		}
		$_SESSION["notification"]="Commentaire ajouté";
		header('Location:' .$_POST["route"]);
		exit;
	break;
	case "Supprimer": // dlete a comment
	if($admin==true) // reserved to admin
	{
		$commManager->deleteContent($_POST["id"]);
		$_SESSION["notification"]="Commentaire supprimé";
		header('Location:' .$_POST["route"]);
		exit;

	}
	else
	{
		header('Location:' .$_POST["route"]);
		exit;	
	}
	break;
	case "Editer": // edit a comment
	if($admin==true) // reserved to admin
	{
		$commManager->updateContent(array(
			"id"=>$_POST["id"],
			"report"=>0,
			"content"=>$_POST["content"],
			"author"=>$_POST["author"]
			));
		$_SESSION["notification"]="Commentaire mis à jour";
		header('Location:' .$_POST["route"]);
		exit;

	}
	else
	{
		header('Location:' .$_POST["route"]);
		exit;	
	}
	break;
	}
}

// handles Login 
public static function loginFormHandler()
{
	$userManager = new UserManager(self::DB_ACCESS);
	//Check values
	if (isset($_POST["user"])&& isset($_POST["password"]))
	{
		$password = sha1(htmlspecialchars($_POST["password"]));
		unset($_POST["password"]);
		$password .= "blog";
		$user = htmlspecialchars($_POST["user"]);


		// la qu'on a les info on va vérrifier si cet utilisateur existe 
		if($user = $userManager->getContent($_POST["user"]))
		{
			echo "utilisateur détecté";
			if($password == $user->getPassword())
			{
				$_SESSION["user"]=$user->getUser();
				$_SESSION["password"]=$user->getPassword();
				$_SESSION["status"]="connected";
				header("Location: ../admin/home");
				$_SESSION["notification"]="Connecté avec succés bienvenue ".$_SESSION["user"];
				exit;
			}
			else 
			{
				$_SESSION["notification"]="Mot de passe incorect";
				$_SESSION["status"]="error";
				header("Location:" .$_POST["route"]);
				exit;
			}
		}
		else
		{
			$_SESSION["notification"]="Identifiant incorrect";
			$_SESSION["status"]="error";
			header("Location:" .$_POST["route"]);
			exit;
		}
	}		
}

// used to manage Articles
public static function postFormHandler()
{
	$postManager = new PostManager(self::DB_ACCESS);
	$commManager = new CommentManager(self::DB_ACCESS);

	// supprimer
	if ($_POST["submit"]=="Supprimer")
	{
		$postManager->deleteContent($_POST["id"]);
		$comments = $commManager->getContents($_POST["id"]);
		foreach ($comments as $comment) {
		 	$commManager->deleteContent($comment->getID());
		}
		$_SESSION["notification"]="Article supprimé";
	}
	//Publier
	else if ($_POST["submit"]=="Publier")
	{
		$postManager->addContent(array(
			'author' => htmlspecialchars($_POST["author"]),
			'content' =>($_POST["content"]),
			'title' =>htmlspecialchars($_POST["title"])));
			$_SESSION["notification"]="Article publié";		
	}
	//Modifier
	else
	{
		$postManager->updateContent(array(
			'author' => htmlspecialchars($_POST["author"]),
			'content' =>($_POST["content"]),
			'id'=>$_POST["id"],
			'title' =>htmlspecialchars($_POST["title"])));
			$_SESSION["notification"]="Article mis à jour";

	}

		header('Location: /admin/gererArticles');
		exit;
}
}