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

$app->post("/users",$form->sanitize,  function ($req, $res) use ($db) {
    $query = "INSERT INTO Users (first_name, last_name, contact_email, contact_phone, address, city, country, password, type, last_login_ip)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $statement = $db->conn()->prepare($query);
    $type = "student";
    $data = [
        $req->sanitized["first_name"],
        $req->sanitized["last_name"],
        $req->sanitized["contact_email"],
        $req->sanitized["contact_phone"],
        $req->sanitized["address"],
        $req->sanitized["city"],
        $req->sanitized["country"],
        password_hash($req->sanitized["password"],PASSWORD_BCRYPT),
        $type ,
        $req->ip()["ip"]
    ];
    
    foreach ($data as $index => $value) {
        $statement->bindValue($index + 1, $value);
    }

    $statement->execute();
    $statement->closeCursor();

    if($type == "student"){
        $query= [
            "sql" =>"SELECT * FROM users
            ORDER BY user_id DESC
            LIMIT 1;"
        ];
        $user = $db->find($query)[0];
    
        $query = "INSERT INTO Students (user_id) VALUES (:user_id)";
        $statement = $db->conn()->prepare($query);
        $statement->bindValue(":user_id", $user["user_id"]);
        $statement->execute();
    }
    $db->close();
    $res->status(301);
    $res->redirect("/admin");
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

$app->get("/admin/students", function ($req, $res) use($db) {
    $query = [
        "sql" => "SELECT * FROM students
        INNER JOIN users ON students.user_id = users.user_id"];
    $data = [
        "template" => "students.php",
        "students" => $db->find($query)
    ];
    $res->render("admin/index", $data);
    $res->status(200);
});


$app->get("/admin/users", function ($req, $res) use ($db) {
    //make admin only
    $query = [
        "sql" => "SELECT * FROM users;"
    ];
    
    $data = [
        "template" => "users.php",
        "users" => $db->find($query)
    ];
    $res->render("admin/index", $data);
    $res->status(200);
});
$app->get("/admin/users/:id/edit", function ($req, $res) use ($db) {
     // --TODO MAKE ADMIN ONLY 
    $id = $req->params()["id"];
    $query = [
        "sql" => "SELECT * FROM users where user_id = $id;"
    ];
    
    $data = [
        "template" => "users/edit.php",
         ...$db->find($query)[0]
    ];
    $res->render("admin/index", $data);
    $res->status(200);
});

$app->put("/users/:id", $form->sanitize, function ($req, $res) use ($db) {

    $id = $req->params()["id"];
    
    $query = "UPDATE users SET 
                first_name = ?,
                last_name = ?,
                contact_email = ?,
                contact_phone = ?,
                address = ?,
                city = ?,
                country = ?,
                type = ?,
                date_of_birth = ?,
                gender = ?
              WHERE user_id = ?";
    
    $userData = [
        $req->sanitized["first_name"],
        $req->sanitized["last_name"],
        $req->sanitized["contact_email"],
        $req->sanitized["contact_phone"],
        $req->sanitized["address"],
        $req->sanitized["city"],
        $req->sanitized["country"],
        $req->sanitized["type"],
        $req->sanitized["date_of_birth"],
        $req->sanitized["gender"],
        $id 
    ];
    
    $statement = $db->conn()->prepare($query);

    foreach ($userData as $index => $value) {
        $statement->bindValue($index + 1, $value);
    }
    
    $statement->execute();

    if ($statement->rowCount() > 0) {

        if ($req->sanitized["type"] == "teacher") {
            $query = "INSERT INTO Teachers (user_id) VALUES (:user_id)";
            $statement = $db->conn()->prepare($query);
            $statement->bindValue(":user_id", $id);
            $statement->execute();
        }
        
        $res->redirect("/admin/users");
        $res->status(301);
    } else {
        $res->status(404);
        $res->send("User not found");
    }
    
    $db->close();
});


$app->get("/admin/courses", function ($req, $res) use ($db) {$query = [
    "sql" => "SELECT * FROM courses
    INNER JOIN teachers ON courses.teacher_id = teachers.teacher_id"];
    $data = [
        "template" => "courses.php",
        "courses" => $db->find($query)
    ];
    $res->render("admin/index", $data);
    $res->status(200);
});

$app->post("/courses",$form->sanitize, function ($req, $res) use($db) {
    $query = "INSERT INTO courses (course_name, teacher_id, course_description, course_image, start_date, end_date, course_status)
    VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $statement = $db->conn()->prepare($query);
    
    $courseData = [
        $req->sanitized["course_name"],
        $req->sanitized["teacher_id"],
        $req->sanitized["course_description"],
        $req->sanitized["course_image"],
        $req->sanitized["start_date"],
        $req->sanitized["end_date"],
        $req->sanitized["course_status"]
    ];

    $statement->execute($courseData);
    $statement->closeCursor();
    $db->close();
    $res->status(301);
    $res->redirect("/admin/courses");
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
        ...$db->find($query)[0]
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
