<?php

namespace Controllers\Teachers;

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
                          INNER JOIN teachers ON courses.teacher_id = teachers.teacher_id
                          WHERE teachers.user_id = " . $_SESSION["user_id"]
            ];
            $data = [
                "template" => "courses.php",
                "courses" => $db->find($query)
            ];
            $res->render("teachers/index", $data);
            $res->status(200);
        };
        $this->showEdit = function ($req, $res) use ($db) {
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
        };
        $this->create = function ($req, $res) use ($db) {
   
        };
    }
}
