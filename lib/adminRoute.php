<?php
	
	use Symfony\Component\HttpFoundation\Request;
	use app\backend\models\UserManager;
	use app\SecurityChecker;
	use app\FormHandler;

	//article handler
	$app->post("/admin/postHandler", function (request $request) {
		$route = $request->getPathInfo();
		if (SecurityChecker::checkLoginSecurity()) {
		return FormHandler::postFormHandler();
		}
		else
		{
			return $app->redirect("../../");
		}
	});

	// comment handler into manager
	$app->post("/admin/commHandler", function (request $request) {
		$route = $request->getPathInfo();
		if (SecurityChecker::checkLoginSecurity()) {
			return FormHandler::commFormHandler(true);
		}
		else
		{
			return $app->redirect("../../");
		}
	});

	// User password modification
	$app->post("/admin/changePass", function (request $request) {
		$route = $request->getPathInfo();
		if (SecurityChecker::checkLoginSecurity()) {
			return FormHandler::changePass();
		}
		else
		{
			return $app->redirect("../../");
		}
	});

	//All admin webpages
	$app->get("/admin/{place}",function ($place="home",request $request) use($app , $commManager, $manager, $userManager,$notification){
		
		$route = $request->getPathInfo();
		if (SecurityChecker::checkLoginSecurity() == true)
			{
			
			switch($place)
			{
				case"home"://Admin home Page
				$comments = $commManager->getReportedContents(5);
				
				return $app['twig']->render("/backend/adminHome.html.twig",array(
					"comments"=>$comments,
					"notification"=>$notification,
					"status"=>$_SESSION["status"],
					"route"=>$route
					));
				break;

				case "rediger":// redact a new article
					if (isset($_GET["submit"])&& $_GET["submit"]=="Modifier")
					{
						$post = $manager->getContent($_GET["id"]);
						$updateArticle=true;
						return $app['twig']->render("/backend/adminRediger.html.twig",array(
							"status"=>$_SESSION["status"],
							"route"=>$route,
							"notification"=>$notification,
							"author"=>$_SESSION["user"],
							"updateArticle"=>$updateArticle,
							"post"=>$post
						));
					}
					else
					{
					
						return $app['twig']->render("/backend/adminRediger.html.twig",array(
							"status"=>$_SESSION["status"],
							"route"=>$route,
							"notification"=>$notification,
							"author"=>$_SESSION["user"]
						));
					}
					break;

				case"gererArticles":// handle all articles

					$posts = $manager->getContents();
					return $app['twig']->render("/backend/adminListeArticles.html.twig",array(
						"status"=>$_SESSION["status"],
						"route"=>$route,
						"notification"=>$notification,
						"posts"=>$posts
					));
				break;

				case"commEdit": // Edit Comment Page
					$comment = $commManager->getContent($_GET["id"]);
					$posts = $manager->getContents();
					return $app['twig']->render("/backend/adminEditComm.html.twig",array(
						"status"=>$_SESSION["status"],
						"comment"=>$comment,
						"notification"=>$notification,
						"route"=>$_GET["route"],
						"posts"=>$posts
					));
				break;

				case"GererReportComm": // Handle list of reported comm
					$comments = $commManager->getReportedContents(100);
					$posts = $manager->getContents();
					return $app['twig']->render("/backend/adminListeComm.html.twig",array(
						"status"=>$_SESSION["status"],
						"comments"=>$comments,
						"notification"=>$notification,
						"posts"=>$posts
					));
				break;

				case "gererProfil": //Handle profile
					$user = $userManager->getContent($_SESSION["user"]);
					return $app['twig']->render("/backend/adminGererProfil.html.twig",array(
						"status"=>$_SESSION["status"],
						"route"=>$route,
						"notification"=>$notification,
						"user"=>$user
					));	
				break;

				default:
					return $app['twig']->render("/misc/erreur404.html.twig",array(
						"notification"=>$notification,
		 				"status"=>$_SESSION["status"]
			 		));

				break;
			}
		}
			
		else //If login is incorrect !
		{
				return $app['twig']->render("/misc/erreur404.html.twig",array(
					"notification"=>$notification,
		 			"status"=>$_SESSION["status"]
		 		));
		}
	});

