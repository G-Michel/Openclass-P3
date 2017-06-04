<?php
	


	$app->get("/",function ($name="accueil") use ($app,$manager)
	{
		$posts = $manager->getContents();
		return $app['twig']->render("mainBody.html.twig",array('posts' => $posts));
	});

	$app->get("/article/{id}",function ($id) use ($app,$commManager,$manager)
	{
		if ($post = $manager->getContent($id))
		{
			$comments = $commManager->getContents($id);
			return $app['twig']->render("post.html.twig",array('post' => $post, "comments" => $comments));
		}
		return  "erreur 411";
	});
