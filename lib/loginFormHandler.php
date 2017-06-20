<?php
/**
 * file used to connect with username And password
 * 
 * */
use app\backend\models\UserManager;
use app\frontend\models\Manager;

$userManager = new UserManager("mysql:host=localhost;dbname=projetoc;charset=UTF8");

if (isset($_POST["user"])&& isset($_POST["password"]))
{


	$password = sha1(htmlspecialchars($_POST["password"]));
	unset($_POST["password"]);
	$password .= "blog";
	$user = htmlspecialchars($_POST["user"]);


	// la qu'on a les info on va vérrifier si cet utilisateur existe 
	if($user = $userManager->getContent("eguibs"))
	{
		echo "utilisateur détecté";
		if($password == $user->getPassword())
		{
			echo "MDP correct";
			$_SESSION["user"]=$user->getUser();
			$_SESSION["password"]=$user->getPassword();
			$_SESSION["status"]="connected";
			header("Location: ../admin/home");
			exit;
		}
		else echo"mdp incorrect";

	}
	else
	{
		echo "raté";
		$_SESSION["status"]="error";
		header("Location:" .$_POST["route"]);
		exit;

	}

}