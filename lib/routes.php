<?php
	
	use Symfony\Component\HttpFoundation\Request;
	use app\backend\models\UserManager;
	use app\SecurityChecker;
	use app\FormHandler;


	// COMMENTS FORM HANDLER
	$app->post("/article/comment",function () use ($app){
		SecurityChecker::checkLoginSecurity();
		return FormHandler::commFormHandler();
	});
	// report a comment
	$app->post("/article/report/{id}",function ($id) use ($app){
		SecurityChecker::checkLoginSecurity();
		return FormHandler::commReport($id);
	});
	//verrify login !
	$app->post("/login/connectionHandler",function () use ($app){
		return FormHandler::loginFormHandler();
	});


	//Connect and Disconnect route
	$app->get("/login/{login}", function($login , request $request) use($app,$notification){
		SecurityChecker::checkLoginSecurity();
		switch($login)
		{
			case "connection":
				$route = $request->getPathInfo();

				SecurityChecker::checkLoginSecurity();


				return $app['twig']->render("/misc/login.html.twig",array(
					"route"=>$route,
					"notification"=>$notification,
					"status"=>$_SESSION["status"]
					));
			break;

			case "disconnect":
				unset($_SESSION["user"]);
				unset($_SESSION["password"]);
				unset($_SESSION["status"]);
				$_SESSION["notification"]="Utilisateur déconnecté";
				return $app->redirect("../../");
			break;
		}
	});

	//Articles route
	$app->get("/article/{id}",function ($id, request $request) use ($app,$commManager,$manager,$notification)
	{
		SecurityChecker::checkLoginSecurity();
		if ($post = $manager->getContent($id))
		{
			$route = $request->getPathInfo();
			$comments = $commManager->getContents($id);

			return $app['twig']->render("/frontend/post.html.twig",array(
				'post' => $post,
				"comments" => $comments,
				"notification"=>$notification,
				"route" => $route,
				"status"=>$_SESSION["status"]
				));
		}
		else return $app['twig']->render("/misc/erreur404.html.twig",array(
			"status"=>$_SESSION["status"]));
	});

	// MainPage route
	$app->get("/",function (request $request,$name="") use ($app,$manager,$commManager,$notification)
	{
		SecurityChecker::checkLoginSecurity();
		$route = $request->getPathInfo();
		$posts = $manager->getContents();
		$i=0;
		foreach ($posts as $value) {
			$count[$value->getID()] = $commManager->getCommNbre($value->getID());
		}
		return $app['twig']->render("/frontend/mainBody.html.twig",array(
			'posts' => $posts,
			 "commCount" => $count,
			 "notification"=>$notification,
			 "status"=>$_SESSION["status"],
			 "route"=>$route
			 ));

	});

	//other routes ROUTES
	$app->get("/{name}", function ($name) use ($app,$notification){

		SecurityChecker::checkLoginSecurity();

		switch($name)
		{
			case "contact":// Contact static page
				return $app['twig']->render("/frontend/contact.html.twig",array(
				"notification"=>$notification,
				"status"=>$_SESSION["status"]
		 		));
			break;

			default://mismatch Pages
				return $app['twig']->render("/misc/erreur404.html.twig",array(
				"notification"=>$notification,
				"status"=>$_SESSION["status"]
		 		));
		 	break;
		}
	});
