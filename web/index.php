<?php

session_start();

require_once __DIR__."/../vendor/autoload.php";
require "../app/models/Manager.php";
require "../app/lib/UserContent.php";
require "../app/lib/Post.php";

$manager = new Manager("mysql:host=localhost;dbname=projetoc;charset=UTF8");
$posts = $manager->getContents();
$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => '../app/views/',
));

include "../app/routes.php";





$app->run();