<?php

namespace Controllers\Admin;

use Artemis\Core\DataBases\DB;

class CoursesController
{

    public $showIndex;
    public $showEdit;
    public $create;

    public function __construct()
    {
        $db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);
        $this->showIndex = function ($req, $res) use ($db) {
            $query = [
                "sql" => "SELECT * FROM courses
                INNER JOIN teachers ON courses.teacher_id = teachers.teacher_id"];
                $data = [
                    "template" => "courses.php",
                    "courses" => $db->find($query)
                ];
                $res->render("admin/index", $data);
                $res->status(200);
        };
        $this->showEdit = function ($req, $res) use ($db) {
          
        };
        $this->create = function ($req, $res) use ($db) {
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
        };
    }
}
