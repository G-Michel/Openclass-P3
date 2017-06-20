<?php
	
	use app\frontend\lib\form;
	use Symfony\Component\HttpFoundation\Request;
	use app\backend\models\UserManager;


	// COMMENTS FORM HANDLER
	$app->post("/article/comment",function () use ($app){
		return include "commFormHandler.php";
	});
	$app->post("/login/connectionHandler",function () use ($app){
		return include "loginFormHandler.php";
	});


	//Disconnect
	$app->get("/login/disconnect", function(request $request) use($app) {
			unset($_SESSION["user"]);
			unset($_SESSION["password"]);
			unset($_SESSION["status"]);
			session_destroy();
			return $app->redirect("../../");
	});

	//login route
	$app->get("/login/connection", function(request $request) use($app){
		$form = new Form();
		$route = $request->getPathInfo();
		// vérrification si l'utilisateur est connecté 
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
			}
		}

		return $app['twig']->render("/misc/login.html.twig",array(
			"form"=>$form,
			"route"=>$route,
			"status"=>$_SESSION["status"]
			));

	});

	//Articles route
	$app->get("/article/{id}",function ($id, request $request) use ($app,$commManager,$manager)
	{

		if (isset($_SESSION["status"]) && $_SESSION["status"] == "connected")
		{
		 $userManager = new UserManager("mysql:host=localhost;dbname=projetoc;charset=UTF8");
		 if ($user = $userManager->getContent($_SESSION["user"]))
			{
				if ($user->getPassword()!= $_SESSION["password"])
				{
					unset($_SESSION["user"]);
					unset($_SESSION["password"]);
					$_SESSION["status"]="error";
					
				}
			}
		}


		if ($post = $manager->getContent($id))
		{
			$route = $request->getPathInfo();
			$comments = $commManager->getContents($id);
			$form = new Form();	
			return $app['twig']->render("/frontend/post.html.twig",array(
				'post' => $post,
				"comments" => $comments,
				"form" => $form,
				"route" => $route,
				"status"=>$_SESSION["status"]
				));
		}
		else return $app['twig']->render("/misc/erreur404.html.twig");
	});

	// MainPage route
	$app->get("/",function (request $request,$name="") use ($app,$manager,$commManager)
	{

		if (isset($_SESSION["status"]) && $_SESSION["status"] == "connected")
		{
		 $userManager = new UserManager("mysql:host=localhost;dbname=projetoc;charset=UTF8");
		 if ($user = $userManager->getContent($_SESSION["user"]))
			{
				if ($user->getPassword()!= $_SESSION["password"])
				{
					unset($_SESSION["user"]);
					unset($_SESSION["password"]);
					$_SESSION["status"]="error";
					
				}
			}
		}
		$route = $request->getPathInfo();
		$posts = $manager->getContents();
		$i=0;
		foreach ($posts as $value) {
			$count[$value->getID()] = $commManager->getCommNbre($value->getID());
		}
		return $app['twig']->render("/frontend/mainBody.html.twig",array(
			'posts' => $posts,
			 "commCount" => $count,
			 "status"=>$_SESSION["status"],
			 "route"=>$route
			 ));

	});

	$app->get("/{name}", function ($name) use ($app){

		if (isset($_SESSION["status"]) && $_SESSION["status"] == "connected")
		{
		 $userManager = new UserManager("mysql:host=localhost;dbname=projetoc;charset=UTF8");
		if ($user = $userManager->getContent($_SESSION["user"]))
			{
				if ($user->getPassword()!= $_SESSION["password"])
				{
					unset($_SESSION["user"]);
					unset($_SESSION["password"]);
					$_SESSION["status"]="error";
					
				}
			}
		}


		return $app['twig']->render("/misc/erreur404.html.twig",array(
		 	"status"=>$_SESSION["status"]
		 	));
	});
