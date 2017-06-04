<?php

session_start();

require_once "/../vendor/autoload.php";
require "/../app/lib/SplClassLoader.php";

use app\frontend\models\CommentManager;
use app\frontend\models\PostManager;
use app\frontend\lib\Post;
use app\frontend\lib\Comment;


$classLoader = new \app\lib\SplClassLoader("app",dirname(__DIR__));
$classLoader->register();

$manager = new PostManager("mysql:host=localhost;dbname=projetoc;charset=UTF8");
$commManager = new CommentManager("mysql:host=localhost;dbname=projetoc;charset=UTF8");

$app = new Silex\Application();
$app['debug'] = true;

//register silex components
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => '../app/frontend/views/',
));

include "../app/frontend/routes.php";
$app->run();