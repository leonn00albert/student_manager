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

//routes
//AUTH ROUTES


/// TODO CREATE CONSTANTS FOR STASTUSCODES AND VARIABLES

Routes\Auth\UsersRoutes::register($app, new Controllers\Auth\UsersController());
if (isset($_SESSION[USER_TYPE]) && $_SESSION[USER_TYPE] === TYPE_ADMIN) {
    //ADMIN ROUTES --TODO add auth for admin only
    Routes\Admin\UsersRoutes::register($app, new Controllers\Admin\UsersController());
    Routes\Admin\ClassroomsRoutes::register($app, new Controllers\Admin\ClassroomsController());
    Routes\Admin\CoursesRoutes::register($app, new Controllers\Admin\CoursesController());
    Routes\Admin\CMSRoutes::register($app, new Controllers\Admin\CMSController());
    Routes\Admin\StudentsRoutes::register($app, new Controllers\Admin\StudentsController());
    Routes\Admin\AdminRoutes::register($app, null, $db);
}


if (isset($_SESSION[USER_TYPE]) && $_SESSION[USER_TYPE] === TYPE_TEACHER) {
    //TEACHER ROUTES
    Routes\Teachers\CoursesRoutes::register($app, new Controllers\Teachers\CoursesController());
    Routes\Teachers\ModulesRoutes::register($app, new Controllers\Teachers\ModulesController());
    Routes\Teachers\SectionsRoutes::register($app, new Controllers\Teachers\SectionsController());
    Routes\Teachers\ClassroomsRoutes::register($app, new Controllers\Teachers\ClassroomsController());
    Routes\Teachers\GradesRoutes::register($app, new Controllers\Teachers\GradesController());

    $app->get("/teachers", function ($req, $res) {
        $data = [
            "template" => "dashboard.php"
        ];
        $res->render("teachers/index", $data);
        $res->status(HTTP_200_OK);
    });

    $app->get("/teachers/dashboard", function ($req, $res) {
        $data = [
            "template" => "dashboard.php"
        ];
        $res->render("teachers/index", $data);
        $res->status(HTTP_200_OK);
    });
    $app->get("/bulletins/:id/delete", function ($req, $res) use ($db) {
        $db->selectTable("bulletins");
        $db->deleteById($req->params()["id"]);
        $res->redirect("back");
    });

    $app->post("/bulletins", $app->form->sanitize, function ($req, $res) use ($db) {
        try {
            $query = "INSERT INTO bulletins (title, type,message, classroom_id)
                VALUES (?, ?, ?,?)";

            $statement = $db->conn()->prepare($query);

            $data = [
                $req->sanitized["title"],
                $req->sanitized["type"],
                $req->sanitized["message"],
                $req->sanitized["classroom_id"],
            ];
            $statement->execute($data);
            $statement->closeCursor();
            $db->close();
            setAlert("success", "Created a new notification");
            $res->status(HTTP_201_CREATED);
            $res->status(HTTP_301_MOVED_PERMANENTLY);
            $res->redirect("/teachers/classrooms/" . $req->sanitized["classroom_id"],);
        } catch (Exception $e) {
            setAlert("danger", "Something went wrong! : " . $e->getMessage());
        }
    });

    $app->get("/teachers/messages", function ($req, $res) use ($db) {
        $query = [
            "sql" => "SELECT * FROM students INNER JOIN users ON students.user_id = users.user_id",
            "params" => []
        ];

        $messages = [];
        if (isset($req->query()["from"])  && $req->query()["from"] == $_SESSION[USER_ID]) {
            $messages = [
                "sql" => "SELECT * FROM messages WHERE (sender_id = :sender_id AND recipient_id = :recipient_id) OR (sender_id = :recipient_id AND recipient_id = :sender_id)",
                "params" => [
                    "recipient_id" => $req->query()["to"],
                    "sender_id" => $req->query()["from"]
                ]
            ];
            $messages = $db->find($messages);
        }

        $data = [
            "template" => "messages.php",
            "students" => $db->find($query),
            "messages" => $messages,
        ];
        $res->render("teachers/index", $data);
        $res->status(HTTP_200_OK);
    });

    $app->get("/teachers/reports", function ($req, $res) use ($db) {
        $progressQuery = [
            "sql" => "SELECT * FROM progress
            INNER JOIN classrooms ON progress.classroom_id = classrooms.classroom_id
            WHERE classrooms.teacher_id = :id",
            "params" => [
                "id" => $_SESSION[TYPE_TEACHER]["teacher_id"]
            ]
        ];
    
        $progress = array_map(function ($elm) {
            $total_points = (int) $elm["sections"] * 10;
            $student_score = (int) $elm["total_score"];
            $elm["grade"] = calculateGrade($total_points, $student_score);
            $elm["max_score"] = $total_points;
            return $elm;
        }, $db->find($progressQuery));
    
        $data = [
            "template" => "report.php",
            "progress" => $progress,
        ];
        $res->render("teachers/index", $data);
        $res->status(HTTP_200_OK);
    });
    
    
}

if (isset($_SESSION[USER_TYPE]) && $_SESSION[USER_TYPE] === TYPE_STUDENT) {
    Routes\Students\ClassroomsRoutes::register($app, new Controllers\Students\ClassroomsController());
    Routes\Students\ModulesRoutes::register($app, new Controllers\Students\ModulesController());
    Routes\Students\CoursesRoutes::register($app, new Controllers\Students\CoursesController());
    Routes\Students\StudentsRoutes::register($app, null ,$db);

}



$db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);
// un auth 
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

// Students routes only for students and admin-root available
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
