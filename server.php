<?php
require_once __DIR__.'/vendor/autoload.php';
use Artemis\Core\DataBases\DB;
use Artemis\Core\Router\Router;

$app = Router::getInstance();
$db = new DB("JSON","students");
$alerts = new DB("JSON","alerts");



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
    global $alerts;
    try {
        $data = $db->con->find([]);
        $alert = $alerts->con->find([]);
        $res->json(["alerts" => end($alert) ?? '',"data" => $data]);
        $res->status(200);
        $alerts->con->deleteMany([]);
    }   
    catch(Exception $e) {
        $alerts->con->create(["alert" => ["type" => 'danger','message' => 'ERROR: could not get students']]);
        $res->status(500);
    }

});
$app->get("/students/:id", function($req,$res){
    global $db;
    global $alerts;
    try {
  
        $data = $db->con->findById($req->params()['id']);
        $res->json($data);
        $res->status(200);
    }
    catch(Exception $e) {
        $alerts->con->create(["alert" => ["type" => 'danger','message' => 'ERROR: could not get student with id ' . $req->params()['id']]]);
        $res->status(500);
    }
});

$app->put("/students/:id", function($req,$res){
    global $db;
    global $alerts;
    try {
        $data = $db->con->updateById($req->params()['id'],$req->body());
        $alerts->con->create(["alert" => ["type" => 'success','message' => 'Succesfully updated student with id ' . $req->params()['id']]]);
        $res->json($data);
        $res->status(200);
    }
    catch(Exception $e) {
        $alerts->con->create(["alert" => ["type" => 'danger','message' => 'ERROR: could not update student']]);
        $res->status(500);
    }
});

$app->delete("/students/:id", function($req,$res){
    global $db;
    global $alerts;
    try {
        $data = $db->con->deleteById($req->params()['id']);
        $alerts->con->create(["alert" => ["type" => 'success','message' => 'Succesfully deleted student with id ' . $req->params()['id']]]);
        $res->json($data);
        $res->status(200);
    }
    catch(Exception $e) {
        $alerts->con->create(["alert" => ["type" => 'danger','message' => 'ERROR: could not delete student']]);
        $res->status(500);
    }
      
});
$app->get("/students/edit/:id", function($req,$res){
    $res->render(__DIR__ . "/src/edit.html");
    $res->status(200);    
});

$app->post("/students", function($req,$res){
    global $db;
    global $alerts;
    try {
        $data = $req->body();
        $db->con->create($data);
        $alerts->con->create(["alert" => ["type" => 'success','message' => 'Succesfully created student']]);
        $res->json($data);
        $res->status(200);
    }

    catch(Exception $e) {
        $alerts->con->create(["alert" => ["type" => 'danger','message' => 'ERROR: could not create student']]);
        $res->status(500);
    }

      
});

$app->get("/public/:file", function($req,$res){
    $path_to_file = explode("/",$req->path())[2];
    header("Content-type:" . $res->getContentType($path_to_file));

    $file = "public/$path_to_file";
    readfile($file);
  
});

$app->listen("/", function(){
});