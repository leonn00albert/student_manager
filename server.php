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


/// TODO CREATE CONSTANTS FOR STASTUSCODES AND VARIABLES
$db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);

    Routes\Auth\UsersRoutes::register($app, new Controllers\Auth\UsersController());
    if (isset($_SESSION["type"]) && $_SESSION["type"] === "admin") {
        //ADMIN ROUTES --TODO add auth for admin only
        Routes\Admin\UsersRoutes::register($app, new Controllers\Admin\UsersController());
        Routes\Admin\ClassroomsRoutes::register($app, new Controllers\Admin\ClassroomsController());
        Routes\Admin\CoursesRoutes::register($app, new Controllers\Admin\CoursesController());
        Routes\Admin\CMSRoutes::register($app, new Controllers\Admin\CMSController());
        Routes\Admin\StudentsRoutes::register($app, new Controllers\Admin\StudentsController());
    }

    if (isset($_SESSION["type"]) && $_SESSION["type"] === "teacher") {
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
            $res->status(200);
        });
        $app->get("/bulletins/:id/delete", function ($req, $res) use ($db) {
                $db->selectTable("bulletins");
                $db->deleteById($req->params()["id"]);
                $res->redirect($_SERVER['HTTP_REFERER']);
        });
        
        $app->post("/bulletins",$app->form->sanitize, function ($req, $res) use ($db) {
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
            $res->status(301);
            $res->redirect("/teachers/classrooms/" . $req->sanitized["classroom_id"],);
    
        });
    }

    if (isset($_SESSION["type"]) && $_SESSION["type"] === "student") {
        Routes\Students\ClassroomsRoutes::register($app, new Controllers\Students\ClassroomsController());
        Routes\Students\ModulesRoutes::register($app, new Controllers\Students\ModulesController());
        Routes\Students\CoursesRoutes::register($app, new Controllers\Students\CoursesController());

        //STUDENT ROUTES 
        $app->get("/students", function ($req, $res) {
            $data = [
                "template" => "dashboard.php"
            ];
            $res->render("students/index", $data);
            $res->status(200);
        });


        $app->post("/enrollments", $app->form->sanitize, function ($req, $res) use ($db) {

            //todo add only one time per student
            $enrollment_date =  date("Y-m-d");

            $sql = "SELECT classroom_id FROM enrollments WHERE course_id = :courseid";
            $stmt = $db->conn()->prepare($sql);
            $stmt->bindValue(':courseid', $req->sanitized['course_id']);
            $stmt->execute();
            $classroom_id = null;
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $classroom_id = $row["classroom_id"];
            } else {
                $classroom_name = "New Classroom for course_id: " . $req->sanitized["course_id"];
                $insertQuery = "INSERT INTO classrooms (classroom_name, teacher_id, course_id) VALUES (:classroom_name, :teacher_id, :course_id)";
                $stmt = $db->conn()->prepare($insertQuery);
                $stmt->bindParam(':classroom_name', $classroom_name);
                $stmt->bindParam(':teacher_id',  $req->sanitized["teacher_id"]);
                $stmt->bindParam(':course_id',  $req->sanitized["course_id"]);
                $stmt->execute();
                $classroom_id = $db->conn()->lastInsertId();
                $updateCourseQuery = "UPDATE courses SET classroom_id = :classroom_id WHERE course_id = :course_id";
                $stmt = $db->conn()->prepare($updateCourseQuery);
                $stmt->bindParam(':classroom_id',  $classroom_id);
                $stmt->bindParam(':course_id',  $req->sanitized["course_id"]);
                $stmt->execute();
            }

            $insertQuery = "INSERT INTO enrollments (student_id, course_id, enrollment_date, classroom_id) VALUES (:student_id, :course_id, :enrollment_date, :classroom_id)";
            $stmt = $db->conn()->prepare($insertQuery);
            $stmt->bindParam(':student_id', $_SESSION["student"]["student_id"]);
            $stmt->bindParam(':course_id', $req->sanitized["course_id"]);
            $stmt->bindParam(':enrollment_date', $enrollment_date);
            $stmt->bindParam(':classroom_id', $classroom_id);
            $stmt->execute();

            $res->redirect("/students/classrooms");
        });

        $app->get("/students/sections/:id", function ($req, $res) use ($db) {
            $id = $req->params()["id"];
            $sections = [
                "sql" => "SELECT * FROM sections WHERE section_id = " . $id . " LIMIT 1"
            ];

            $data = [
                "template" => "sections/show.php",
                "section" => $db->find($sections)[0]
            ];
            $res->render("students/index", $data);
            $res->status(200);
        });

        $app->post("/grades", $app->form->sanitize, function ($req, $res) use ($db) {
            //todo add only one time per student 
            //add error and alerts
            $submit_date = date("Y-m-d");

            $studentQuery = [
                "sql" => "SELECT students.student_id ,enrollments.classroom_id FROM students 
        INNER JOIN enrollments ON students.student_id = enrollments.student_id 
        WHERE students.user_id = " . $_SESSION["user_id"] . " LIMIT 1"
            ];

            $student = $db->find($studentQuery)[0];

            $insertQuery = "INSERT INTO grades (student_id, section_id, classroom_id, submit_date, assignment, grade_answer) VALUES (:student_id, :section_id, :classroom_id,:submit_date, :assignment, :grade_answer)";
            $stmt = $db->conn()->prepare($insertQuery);
            $stmt->bindParam(':student_id', $student["student_id"]);
            $stmt->bindParam(':section_id', $req->sanitized["section_id"]);
            $stmt->bindParam(':classroom_id',  $student["classroom_id"]);
            $stmt->bindParam(':submit_date', $submit_date);
            $stmt->bindParam(':assignment', $req->sanitized["assignment"]);
            $stmt->bindParam(':grade_answer', $req->sanitized["grade_answer"]);
            $stmt->execute();
            $res->redirect("/students/classrooms");
        });
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
