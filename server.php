<?php
session_start();
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/config/db.config.php";
require_once __DIR__ . "/src/util/create-pdf.php";
require_once __DIR__ . "/src/util/util.php";

use Artemis\Core\DataBases\DB;
use Artemis\Core\Router\Router;
use Artemis\Core\Forms\Forms;
use Artemis\Core\TemplateEngine\TemplateEngine;

$app = Router::getInstance();
$app->set("view_engine", new TemplateEngine(__DIR__ . "/views"));
$app->use("form", new Forms());
//routes
//AUTH ROUTES
$db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);

Routes\Auth\UsersRoutes::register($app, new Controllers\Auth\UsersController());
if ($_SESSION["type"] === "admin") {
//ADMIN ROUTES --TODO add auth for admin only
Routes\Admin\UsersRoutes::register($app, new Controllers\Admin\UsersController());
Routes\Admin\ClassroomsRoutes::register($app, new Controllers\Admin\ClassroomsController());
Routes\Admin\CoursesRoutes::register($app, new Controllers\Admin\CoursesController());
Routes\Admin\CMSRoutes::register($app, new Controllers\Admin\CMSController());
Routes\Admin\StudentsRoutes::register($app, new Controllers\Admin\StudentsController());

}

if ($_SESSION["type"] === "teacher") {
    //TEACHER ROUTES
    Routes\Teachers\CoursesRoutes::register($app, new Controllers\Teachers\CoursesController());
    Routes\Teachers\ModulesRoutes::register($app, new Controllers\Teachers\ModulesController());
    Routes\Teachers\SectionsRoutes::register($app, new Controllers\Teachers\SectionsController());

    $app->get("/teachers", function ($req, $res) {
        $data = [
            "template" => "dashboard.php"
        ];
        $res->render("teachers/index", $data);
        $res->status(200);
    });

    $app->get("/teachers/classrooms", function ($req, $res) {
        $data = [
            "template" => "classrooms.php"
        ];
        $res->render("teachers/index", $data);
        $res->status(200);
    });
}

if ($_SESSION["type"] === "student") {
    //STUDENT ROUTES 
    $app->get("/students", function ($req, $res) {
        $data = [
            "template" => "dashboard.php"
        ];
        $res->render("students/index", $data);
        $res->status(200);
    });

    $app->get("/students/courses", function ($req, $res) use ($db) {
        $query = [
            "sql" => "SELECT * FROM courses"
        ];
        $data = [
            "template" => "courses.php",
            "courses" => $db->find($query)
        ];
        $res->render("students/index", $data);
        $res->status(200);
    });

    $app->get("/students/courses/:id", function ($req, $res) use ($db) {
        $id = $req->params()["id"];
        $query = [
            "sql" => "SELECT * FROM courses WHERE course_id = " . $id 
        ];
        $modulesQuery = [
            "sql" => "SELECT * FROM modules WHERE course_id = " . $id 
        ];
        $data = [
            "template" => "courses/show.php",
            "course" => $db->find($query)[0],
            "modules" => $db->find($modulesQuery)
        ];
        $res->render("students/index", $data);
        $res->status(200);
    });
}



$db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);
// un auth 
$app->get("/", function ($req, $res) use ($db) {
    $query = [
        "sql" => "SELECT * FROM homepage_cms WHERE ID = 1",
    ];
    $data = array_map(fn ($e) => $e, $db->find($query)[0]);

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

// Students routes only for students and admin-root available
$app->get("/login", function ($req, $res) {
    $res->render("home/login");
    $res->status(200);
});




//only auth 

//only admin *
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


$app->get("/admin/teachers", function ($req, $res) use ($db) {
    $query = [
        "sql" => "SELECT * FROM teachers
        INNER JOIN users ON teachers.user_id = users.user_id"
    ];
    $data = [
        "template" => "teachers.php",
        "teachers" => $db->find($query)
    ];
    $res->render("admin/index", $data);
    $res->status(200);
});


//wildcard route

$app->get("*", function ($req, $res) {
    $res->send("404");
    $res->status(404);
});

$app->listen("/", function () {
});
