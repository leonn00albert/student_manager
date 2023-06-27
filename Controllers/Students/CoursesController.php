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
            $res->status(200);
        };
        $this->show = function ($req, $res) use ($db) {
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
        };
        $this->create = function ($req, $res) use ($db) {
   
        };
    }
}
