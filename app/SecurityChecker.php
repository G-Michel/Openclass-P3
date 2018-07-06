<?php

namespace app;
use app\backend\models\UserManager;
use app\backend\lib\User;


class SecurityChecker{


	public static function checkLoginSecurity()
	{
		$userManager = new UserManager();

		if (isset($_SESSION["status"]) && $_SESSION["status"] == "connected")
		{
		 	if ($user = $userManager->getContent($_SESSION["user"]))
			{
				if ($user->getPassword()!= $_SESSION["password"])
				{
					unset($_SESSION["user"]);
					unset($_SESSION["password"]);
					$_SESSION["notification"]="problème d'utilisateur";
					$_SESSION["status"]="error";
					return false;					
				}
				else return true;
			}
		}
		else
		{
			unset($_SESSION["user"]);
			unset($_SESSION["password"]);
			$_SESSION["status"]="unconnected";
			return false;
		}
	}
}