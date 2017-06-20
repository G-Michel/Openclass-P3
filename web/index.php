<?php

use app\frontend\models\CommentManager;
use app\frontend\models\PostManager;
use app\frontend\lib\Post;
use app\frontend\lib\Comment;
use Silex\Provider\FormServiceProvider;

require_once "/../vendor/autoload.php";
require "/../app/SplClassLoader.php";

session_start();
if (isset($_SESSION["status"]) == false) $_SESSION["status"]="unconnected";


$classLoader = new \app\SplClassLoader("app",dirname(__DIR__));
$classLoader->register();

$manager = new PostManager("mysql:host=localhost;dbname=projetoc;charset=UTF8");
$commManager = new CommentManager("mysql:host=localhost;dbname=projetoc;charset=UTF8");
$app = new Silex\Application();
$app['debug'] = true;

//register silex components
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => '../views/',
));
$app->register(new FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());


include "../lib/routes.php";
include "../lib/adminRoute.php";
$app->run();