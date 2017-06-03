<?php


	$app->get("/",function ($name="accueil") use ($app,$posts)
	{

		return $app['twig']->render("mainBody.html.twig",array('posts' => $posts));
	});

	$app->get("/article/{id}",function ($id) use ($app,$manager)
	{
		if ($post = $manager->getContent($id))
		{
		
			return $app['twig']->render("post.html.twig",array('post' => $post));
		}
		return  "erreur 411";
	});
