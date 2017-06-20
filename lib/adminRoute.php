<?php
	
	use app\frontend\lib\form;
	use Symfony\Component\HttpFoundation\Request;
	use app\backend\models\UserManager;

	//POSTHANDLER améliorer la sécurité ^^ 
	$app->post("/admin/postHandler", function (request $request) {
		$route = $request->getPathInfo();
		return include "postFormHandler.php";
	});


	//All admin webpages
	$app->get("/admin/{place}",function ($place="home",request $request) use($app , $commManager, $manager){
		
		$route = $request->getPathInfo();
		if (isset($_SESSION["status"]) && $_SESSION["status"] == "connected")
		{
			$userManager = new UserManager("mysql:host=localhost;dbname=projetoc;charset=UTF8");
		 	if ($user = $userManager->getContent($_SESSION["user"]))
			{

				if ($user->getPassword() != $_SESSION["password"] )
				{
					unset($_SESSION["user"]);
					unset($_SESSION["password"]);
					$_SESSION["status"]="error";
					
				}
				else
				{
					
					switch($place)
					{
						case"home":
						
						return $app['twig']->render("/backend/adminHome.html.twig",array(
							"status"=>$_SESSION["status"],
							"route"=>$route
							));
						break;

						case "rediger":
							if (isset($_GET["submit"])&& $_GET["submit"]=="Modifier")
							{
								$post = $manager->getContent($_GET["id"]);
								$updateArticle=true;
								$form = new Form();
								return $app['twig']->render("/backend/adminRediger.html.twig",array(
								"status"=>$_SESSION["status"],
								"route"=>$route,
								"form"=>$form,
								"author"=>$_SESSION["user"],
								"updateArticle"=>$updateArticle,
								"post"=>$post
								));
							}
							else{
							$form = new Form();
							return $app['twig']->render("/backend/adminRediger.html.twig",array(
							"status"=>$_SESSION["status"],
							"route"=>$route,
							"form"=>$form,
							"author"=>$_SESSION["user"],
							));
							}
							break;

						case"gererArticles":

							$posts = $manager->getContents();
							return $app['twig']->render("/backend/adminListeArticles.html.twig",array(
								"status"=>$_SESSION["status"],
								"route"=>$route,
								"posts"=>$posts
							));
						break;

						case "gererProfil":
							return $app['twig']->render("/backend/adminGererProfil.html.twig",array(
								"status"=>$_SESSION["status"],
								"route"=>$route,
								"user"=>$user
							));
							
						break;
					}
				}
			}
		}

		return $app['twig']->render("/misc/erreur404.html.twig",array(
		 	"status"=>$_SESSION["status"]
		 	));

	});

