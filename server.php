<?php
session_start();
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/config/db.config.php";
require_once __DIR__ . "/config/const.config.php";
require_once __DIR__ . "/config/http_status.config.php";
require_once __DIR__ . "/Utils/utils.php";


use Utils\Notifications\Notification;
use Artemis\Core\DataBases\DB;
use Artemis\Core\Router\Router;
use Artemis\Core\Forms\Forms;
use Artemis\Core\TemplateEngine\TemplateEngine;

$db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);

$app = Router::getInstance();
$app->set("view_engine", new TemplateEngine(__DIR__ . "/views"));
$app->use("form", new Forms());
$app->use("notification", new Notification($db));

// Register and Login
Routes\Auth\UsersRoutes::register($app, new Controllers\Auth\UsersController());


//ADMIN ROUTES
if (isset($_SESSION[USER_TYPE]) && $_SESSION[USER_TYPE] === TYPE_ADMIN) {

    Routes\Admin\UsersRoutes::register($app, new Controllers\Admin\UsersController());
    Routes\Admin\ClassroomsRoutes::register($app, new Controllers\Admin\ClassroomsController());
    Routes\Admin\CoursesRoutes::register($app, new Controllers\Admin\CoursesController());
    Routes\Admin\CMSRoutes::register($app, new Controllers\Admin\CMSController());
    Routes\Admin\StudentsRoutes::register($app, new Controllers\Admin\StudentsController());

    //miscelaneous routes  here
    Routes\Admin\AdminRoutes::register($app, null, $db);
}

 //TEACHER ROUTES
if (isset($_SESSION[USER_TYPE]) && $_SESSION[USER_TYPE] === TYPE_TEACHER) {
   
    Routes\Teachers\CoursesRoutes::register($app, new Controllers\Teachers\CoursesController());
    Routes\Teachers\ModulesRoutes::register($app, new Controllers\Teachers\ModulesController());
    Routes\Teachers\SectionsRoutes::register($app, new Controllers\Teachers\SectionsController());
    Routes\Teachers\ClassroomsRoutes::register($app, new Controllers\Teachers\ClassroomsController());
    Routes\Teachers\GradesRoutes::register($app, new Controllers\Teachers\GradesController());

    //miscelaneous routes  here
    Routes\Teachers\TeachersRoutes::register($app, null, $db);
}


//STUDENT ROUTES

if (isset($_SESSION[USER_TYPE]) && $_SESSION[USER_TYPE] === TYPE_STUDENT) {
    Routes\Students\ClassroomsRoutes::register($app, new Controllers\Students\ClassroomsController());
    Routes\Students\ModulesRoutes::register($app, new Controllers\Students\ModulesController());
    Routes\Students\CoursesRoutes::register($app, new Controllers\Students\CoursesController());
    
    //miscelaneous routes  here
    Routes\Students\StudentsRoutes::register($app, null, $db);
}



// Other routes

$app->get("/", function ($req, $res) use ($db) {
    $query = [
        "sql" => "SELECT * FROM homepage_cms 
                  INNER JOIN courses ON courses.course_id = homepage_cms.featured_course
                  WHERE homepage_cms.id = 1",
    ];
    $data = array_map(fn ($e) => $e, $db->find($query)[0]);
    $res->render("home/index", $data);
    $res->status(HTTP_200_OK);
});

$app->post("/messages", $app->form->sanitize, function ($req, $res) use ($db) {
    if ($req->sanitized["sender_id"] == $_SESSION["user_id"]) {
        try {
            $insertQuery = "INSERT INTO messages (sender_id,recipient_id,message) VALUES (:sender_id, :recipient_id, :message)";
            $stmt = $db->conn()->prepare($insertQuery);
            $stmt->bindParam(':sender_id', $req->sanitized["sender_id"]);
            $stmt->bindParam(':recipient_id', $req->sanitized["recipient_id"]);
            $stmt->bindParam(':message', $req->sanitized["message"]);
            $stmt->execute();
            $_SESSION["alert"]["type"] = "success";
            $_SESSION["alert"]["message"] = "Sucessfully submitted message ";
            $res->status(HTTP_201_CREATED);
            $res->status(HTTP_301_MOVED_PERMANENTLY);
            $res->redirect("/students/messages?from=" . $req->sanitized["sender_id"] . "&to=" . $req->sanitized["recipient_id"]);
        } catch (Exception $e) {
            $_SESSION["alert"]["type"] = "danger";
            $_SESSION["alert"]["message"] = "Something went wrong! : " . $e->getMessage();
            $res->redirect("/students/messages");
        }
    } else {
        $_SESSION["alert"]["type"] = "danger";
        $_SESSION["alert"]["message"] = "Something went wrong! : not allowed to send message";
        $res->redirect("/students/messages");
    }
});

$app->put("/notifications/:id", function ($req, $res) use ($db) {
    $query = [
        "sql" => "UPDATE notifications
                  SET
                  is_read = 1
                  WHERE notification_id = " . $req->params()["id"]
    ];
    $db->update($query);


    $type = $_SESSION["type"];
    $notificationsQuery = [
        "sql" => "SELECT * FROM notifications WHERE user_id = " . $_SESSION[$type][$type . "_id"] . " AND is_read = 0 AND is_archived = 0 LIMIT 20"
    ];

    $_SESSION["notifications"] = $db->find($notificationsQuery);
    $res->status(HTTP_200_OK);
});
$app->get("/login", function ($req, $res) {
    $res->render("home/login");
    $res->status(HTTP_200_OK);
});

$app->get("/register", function ($req, $res) {
    $res->render("home/register");
    $res->status(HTTP_200_OK);
});


$app->get("/login", function ($req, $res) {
    $res->render("home/login");
    $res->status(HTTP_200_OK);
});



//wildcard route

$app->get("*", function ($req, $res) {
    $res->send("404");
    $res->status(HTTP_404_NOT_FOUND);
});

$app->listen("/", function () {
});
