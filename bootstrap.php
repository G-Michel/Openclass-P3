<?php

require_once __DIR__."./vendor/autoload.php";

$app = new Silex\Application();
$app['debug'] = true;

$app->get("/test/",function ($name="default") use ($app){

return "hello world". $app->escape($name);


});
$app->run();