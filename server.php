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

Routes\Auth\UsersRoutes::register($app, new Controllers\Auth\UsersController());

//ADMIN ROUTES --TODO add auth for admin only
Routes\Admin\UsersRoutes::register($app, new Controllers\Admin\UsersController());
Routes\Admin\ClassroomsRoutes::register($app, new Controllers\Admin\ClassroomsController());
Routes\Admin\CoursesRoutes::register($app, new Controllers\Admin\CoursesController());
Routes\Admin\CMSRoutes::register($app, new Controllers\Admin\CMSController());
Routes\Admin\StudentsRoutes::register($app, new Controllers\Admin\StudentsController());


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


if ($_SESSION["type"] === "teacher") {
    $app->get("/teachers", function ($req, $res) {
        $data = [
            "template" => "dashboard.php"
        ];
        $res->render("teachers/index", $data);
        $res->status(200);
    });

    $app->get("/teachers/courses", function ($req, $res)  use ($db) {
        $query = [
            "sql" => "SELECT * FROM courses
                      INNER JOIN teachers ON courses.teacher_id = teachers.teacher_id
                      WHERE teachers.user_id = " . $_SESSION["user_id"]
        ];
        $data = [
            "template" => "courses.php",
            "courses" => $db->find($query)
        ];
        $res->render("teachers/index", $data);
        $res->status(200);
    });

    $app->get("/teachers/courses/:id/edit", function ($req, $res)  use ($db) {
        $id = $req->params()["id"];
        $query = [
            "sql" => "SELECT * FROM courses
                      INNER JOIN teachers ON courses.teacher_id = teachers.teacher_id
                      WHERE teachers.user_id = " . $_SESSION["user_id"] . " AND course_id = " . $id
        ];
        $moduleQuery =
            [
                "sql" => "SELECT * FROM modules
                      WHERE course_id = " . $id
            ];
        $data = [
            "template" => "courses/edit.php",
            "course" => $db->find($query)[0],
            "modules" => $db->find($moduleQuery)
        ];

        $res->render("teachers/index", $data);
        $res->status(200);
    });

    $app->get("/teachers/modules/new", function ($req, $res) {
        $data = [
            "template" => "modules/new.php",
            "course_id" => $req->query()["course_id"]
        ];
        $res->render("teachers/index", $data);
        $res->status(200);
    });

    $app->get("/teachers/modules/:id/edit", function ($req, $res) use ($db) {
        $id = $req->params()["id"];
        $query = [
            "sql" => "SELECT * FROM sections
                      WHERE sections.module_id = " . $id
        ];
        $moduleQuery =
            [
                "sql" => "SELECT * FROM modules
                      WHERE module_id = " . $id
            ];
        $data = [
            "template" => "modules/edit.php",
            "sections" => $db->find($query),
            "module" => $db->find($moduleQuery)[0]
        ];

        $res->render("teachers/index", $data);
        $res->status(200);
    });


    $app->get("/teachers/sections/new", function ($req, $res) use ($db) {
        $data = [
            "template" => "sections/new.php",
            "module_id" => $req->query()["module_id"]
        ];
        $res->render("teachers/index", $data);
        $res->status(200);
    });

    $app->post("/modules", $app->form->sanitize, function ($req, $res) use ($db) {
        $query = "INSERT INTO modules (module_name, course_id)
        VALUES (?, ?)";

        $statement = $db->conn()->prepare($query);

        $courseData = [
            $req->sanitized["module_name"],
            $req->sanitized["course_id"],
        ];
        $statement->execute($courseData);
        $statement->closeCursor();
        $db->close();
        $res->status(301);
        $res->redirect("/teachers/courses/" . $req->sanitized["course_id"] . "/edit");
    });

    $app->post("/modules", $app->form->sanitize, function ($req, $res) use ($db) {
        $query = "INSERT INTO modules (module_name, course_id)
        VALUES (?, ?)";

        $statement = $db->conn()->prepare($query);

        $courseData = [
            $req->sanitized["module_name"],
            $req->sanitized["course_id"],
        ];
        $statement->execute($courseData);
        $statement->closeCursor();
        $db->close();
        $res->status(301);
        $res->redirect("/teachers/courses/" . $req->sanitized["course_id"] . "/edit");
    });
    $app->post("/sections", $app->form->sanitize, function ($req, $res) use ($db) {
        $query = $db->conn()->prepare("INSERT INTO sections (section_name, section_content, section_resources, module_id, assignment) 
                                VALUES (:section_name, :section_content, :section_resources, :module_id, :assignment)");
        $query->bindParam(':section_name', $req->sanitized['section_name']);
        $query->bindParam(':section_content', $req->sanitized['section_content']);
        $query->bindParam(':section_resources', $req->sanitized['section_resources']);
        $query->bindParam(':module_id', $req->sanitized['module_id']);
        $query->bindParam(':assignment', $req->sanitized['assignment']);


        if ($query->execute()) {
            $res->status(301);
            $res->redirect("/teachers/modules/" . $req->sanitized["module_id"] . "/edit");
        } else {
            echo "Error inserting record.";
        }


        $db->close();
    });

    $app->get("/teachers/classrooms", function ($req, $res) {
        $data = [
            "template" => "classrooms.php"
        ];
        $res->render("teachers/index", $data);
        $res->status(200);
    });
}


$app->get("/teachers/sections/:id/edit", function ($req, $res) use ($db) {
    $id = $req->params()["id"];
    $query = [
        "sql" => "SELECT * FROM sections
                  WHERE section_id = " . $id
    ];
    $data = [
        "template" => "sections/edit.php",
        "section" => $db->find($query)[0],
    ];

    $res->render("teachers/index", $data);
    $res->status(200);
});

$app->put("/sections/:id",$app->form->sanitize, function ($req, $res) use ($db) {
    $id = $req->params()["id"];
    $query = $db->conn()->prepare("UPDATE sections SET 
    section_name = :section_name,
    section_content = :section_content,
    section_resources = :section_resources,
    module_id = :module_id,
    assignment = :assignment
    WHERE section_id = :section_id");
    $query->bindParam(':section_name', $req->sanitized['section_name']);
    $query->bindParam(':section_content', $req->sanitized['section_content']);
    $query->bindParam(':section_resources', $req->sanitized['section_resources']);
    $query->bindParam(':module_id', $req->sanitized['module_id']);
    $query->bindParam(':assignment', $req->sanitized['assignment']);
    $query->bindParam(':section_id', $id);

    if ($query->execute()) {
        $res->status(301);
        $res->redirect("/teachers/modules/" . $req->sanitized["module_id"] . "/edit");
    } else {
        echo "Error updating record.";
    }

    $db->close();
});
// Teachers routes only for teachers and admin-root available


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
