<?php

use app\frontend\models\CommentManager;
use app\frontend\models\PostManager;
use app\frontend\lib\Post;
use app\frontend\lib\Comment;
use app\backend\models\UserManager;


// Autoload of all classes 
require_once "../vendor/autoload.php";
require "../app/SplClassLoader.php";



session_start();
if (isset($_SESSION["status"]) == false) $_SESSION["status"]="unconnected";

//Instanciation 
$classLoader = new \app\SplClassLoader("app",dirname(__DIR__));
$classLoader->register();

$manager = new PostManager("mysql:host=localhost;dbname=projetoc;charset=UTF8");
$commManager = new CommentManager("mysql:host=localhost;dbname=projetoc;charset=UTF8");
$userManager = new UserManager("mysql:host=localhost;dbname=projetoc;charset=UTF8");
$app = new Silex\Application();
$app['debug'] = true;

//register silex components
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => '../views/',
));
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));

//Handles notifications
	if (isset($_SESSION["notification"]))
	{
		$notification = $_SESSION["notification"];
		unset($_SESSION["notification"]);
	}
	else $notification="";


//Launch controller 
include "../lib/routes.php";
include "../lib/adminRoute.php";
$app->run();