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

$db = DB::new("PDO", "student_manager", "", "mysql", "localhost", "root");
// un auth 
$app->get("/", function ($req, $res) use ($db) {
    $query = [
        "sql" => "SELECT * FROM homepage_cms WHERE ID = 1",
    ];
    $data = array_map(fn ($e) => $e,$db->find($query)[0]);

    $res->render("home/index", $data);
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


//only admin 
$app->get("/admin", function ($req, $res) {
    $data = [
        "template" => "dashboard.php"
    ];
    $res->render("admin/index", $data);
    $res->status(200);
});
$app->get("/admin/dashboard", function ($req, $res) {
    $data = [
        "template" => "dashboard.php"
    ];
    $res->render("admin/index", $data);
    $res->status(200);
});

$app->get("/admin/students", function ($req, $res) {
    $data = [
        "template" => "students.php"
    ];
    $res->render("admin/index", $data);
    $res->status(200);
});

$app->get("/admin/classrooms", function ($req, $res) {
    $data = [
        "template" => "classrooms.php"
    ];
    $res->render("admin/index", $data);
    $res->status(200);
});


$app->get("/admin/cms", function ($req, $res) use ($db) {
    $query = [
        "sql" => "SELECT * FROM homepage_cms WHERE ID = 1",
    ];
    $data = [
        "template" => "cms.php",
        "data" => $db->find($query)[0]
    ];

    $res->render("admin/index", $data);
    $res->status(200);
});
$app->post("/admin/cms", function ($req, $res) use ($db) {
    $sql = "UPDATE homepage_cms
    SET title = :title,
        hero_image = :hero_image,
        hero_title = :hero_title,
        hero_text = :hero_text,
        cta_text = :cta_text,
        cta_url = :cta_url
    WHERE id = :id";

    $clean = [
        "title" => htmlspecialchars($_POST["title"]),
        "hero_image" => htmlspecialchars($_POST["hero_image"]),
        "hero_title" => htmlspecialchars($_POST["hero_title"]),
        "hero_text" => htmlspecialchars($_POST["hero_text"]),
        "cta_text" => htmlspecialchars($_POST["cta_text"]),
        "cta_url" => htmlspecialchars($_POST["cta_url"]),
    ];
    $stmt = $db->conn()->prepare($sql);
    $stmt->bindValue(':title',   $clean["title"]);
    $stmt->bindValue(':hero_image', $clean["hero_image"]);
    $stmt->bindValue(':hero_title', $clean["hero_title"]);
    $stmt->bindValue(':hero_text', $clean["hero_text"]);
    $stmt->bindValue(':cta_text', $clean["cta_text"]);
    $stmt->bindValue(':cta_url', $clean["cta_url"]);
    $stmt->bindValue(':id', 1);
    $stmt->execute();
    $data = [
        "template" => "cms.php"
    ];
    $db->close();
    $res->redirect("/admin/cms");
    $res->status(301);
});




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
