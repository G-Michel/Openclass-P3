<?php

require_once __DIR__."/../vendor/autoload.php";

$app = new Silex\Application();
$app['debug'] = true;

$app->get("/",function ($name="default") use ($app){

require "../app/view/header.php";
return "hello world". $app->escape($name);


});
$app->run();