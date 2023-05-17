<?php
require_once __DIR__.'/vendor/autoload.php';
use Artemis\Core\DataBases\DB;
use Artemis\Core\Router\Router;

$app = Router::getInstance();
$db = new DB("JSON","students");
$app->get("/", function($req,$res){
    $res->render(__DIR__ . "/src/index.html");
    $res->status(200);
      
});

$app->get("/students/new", function($req,$res){
    $res->render(__DIR__ . "/src/new.html");
    $res->status(200);
      
});
$app->get("/students", function($req,$res){
    global $db;
    $data = $db->con->find([]);
    $res->json($data);
    $res->status(200);
    

});
$app->get("/students/:id", function($req,$res){
    global $db;


    $data = $db->con->findById($req->params()['id']);
    $res->json($data);
    $res->status(200);
      
});

$app->put("/students/:id", function($req,$res){
    global $db;
    $data = $db->con->updateById($req->params()['id'],$req->body());
    $res->json($data);
    $res->status(200);
      
});
$app->get("/students/edit/:id", function($req,$res){

    $res->render(__DIR__ . "/src/edit.html");
    $res->status(200);    
});

$app->post("/students", function($req,$res){
    global $db;
    $data = $req->body();
    $db->con->create($data);
    $res->json($data);
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