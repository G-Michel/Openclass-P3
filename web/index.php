<?php

session_start();

require_once "/../vendor/autoload.php";
require "../app/models/Manager.php";
require "../app/models/PostManager.php";
require "../app/models/CommentManager.php";
require "../app/lib/UserContent.php";
require "../app/lib/Post.php";

$manager = new PostManager("mysql:host=localhost;dbname=projetoc;charset=UTF8");
$posts = $manager->getContents();
$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => '../app/views/',
));

include "../app/routes.php";





$app->run();