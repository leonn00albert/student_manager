<?php
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/src/util/create-pdf.php";
require_once __DIR__ . "/src/util/util.php";

use Artemis\Core\DataBases\DB;
use Artemis\Core\Router\Router;
use Artemis\Core\Forms\Forms;
use Artemis\Core\TemplateEngine\TemplateEngine;


$app = Router::getInstance();
$app->set("view_engine", new TemplateEngine(__DIR__ . "/views"));

$form = new Forms();

$db = DB::new("PDO", "student_manager","","mysql","localhost","root");
// un auth 
$app->get("/", function ($req, $res) {
 
    $res->render("home/index");
    $res->status(200);
});
$app->get("/login", function ($req, $res) {
    $res->render("home/login");
    $res->status(200);
});

$app->get("/register", function ($req, $res) {
    $res->render("home/register");
    $res->status(200);
});
//only auth 

$app->get("/admin", function ($req, $res) {
    $data = [
        "template" => "dashboard.php"
    ];
    $res->render("admin/index",$data);
    $res->status(200);
});
$app->get("/admin/dashboard", function ($req, $res) {
    $data = [
        "template" => "dashboard.php"
    ];
    $res->render("admin/index",$data);
    $res->status(200);
});

$app->get("/admin/students", function ($req, $res) {
    $data = [
        "template" => "students.php"
    ];
    $res->render("admin/index",$data);
    $res->status(200);
});

//only admin 

require_once __DIR__ . "/src/routes/studentRoutes.php";  //student routes 
require_once __DIR__ . "/src/routes/classroomRoutes.php";  //classroom routes 
require_once __DIR__ . "/src/routes/toolRoutes.php";  //tool routes 


//wildcard route

$app->get("*", function ($req, $res) {
    $res->send("404");
    $res->status(404);

   
});

$app->listen("/", function () {
});
