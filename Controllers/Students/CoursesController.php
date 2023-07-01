<?php

namespace Controllers\Students;

use Artemis\Core\DataBases\DB;

class CoursesController
{

    public $show;
    public $showIndex;
    public $showEdit;
    public $create;

    public function __construct()
    {
        $db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);
        $this->showIndex = function ($req, $res) use ($db) {
            $query = [
                "sql" => "SELECT * FROM courses"
            ];
            $data = [
                "template" => "courses.php",
                "courses" => $db->find($query)
            ];
            $res->render("students/index", $data);
            $res->status(HTTP_200_OK);
        };
        $this->show = function ($req, $res) use ($db) {
            $id = $req->params()["id"];
            $query = [
                "sql" => "SELECT *  , c.course_id FROM courses c
                          WHERE c.course_id = " . $id 
                    
            ];

            $enrollQuery = [
                "sql" => "SELECT *  , c.course_id FROM courses c
                LEFT JOIN Enrollments e ON e.course_id = c.course_id
                WHERE c.course_id = " . $id . "
                AND (e.student_id = " . $_SESSION["student"]["student_id"] . " OR e.student_id IS NULL)"
            ];
            $modulesQuery = [
                "sql" => "SELECT * FROM modules WHERE course_id = " . $id
            ];
            $data = [
                "template" => "courses/show.php",
                "course" => $db->find($query)[0],
                "modules" => $db->find($modulesQuery),
                "enrollment" => $db->find($enrollQuery)[0] ?? []
            ];
            $res->render("students/index", $data);
            $res->status(HTTP_200_OK);
        };
        $this->create = function ($req, $res) use ($db) {
   
        };
    }
}
