<?php
require_once __DIR__.'/vendor/autoload.php';

use Artemis\Core\Router\Router;
$app = Router::getInstance();

$app->get("/", function($req,$res){
    $res->render(__DIR__ . "/src/index.html");
    $res->status(200);
      
});

$app->get("/public/:file", function($req,$res){
    $path_to_file = explode("/",$req->path())[2];
    header("Content-type:" . $res->getContentType($path_to_file));

    $file = "public/$path_to_file";
    readfile($file);
  
});

$app->listen("/", function(){
});