<?php

namespace Controllers\Students;

use Artemis\Core\DataBases\DB;

class ClassroomsController
{

    public $showIndex;
    public $showEdit;
    public $create;
    public $show;

    public function __construct()
    {
        $db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);
        $this->showIndex = function ($req, $res) use ($db) {
            $studentQuery = [
                "sql" => "SELECT student_id FROM students WHERE user_id = " . $_SESSION["user_id"]
            ];
    
            $student = $db->find($studentQuery)[0];
            $query = [
                "sql" => "SELECT * FROM enrollments
                          INNER JOIN classrooms ON enrollments.classroom_id = classrooms.classroom_id
                          WHERE student_id = " . $student["student_id"]
            ];
            $data = [
                "template" => "classrooms.php",
                "classrooms" => $db->find($query)
            ];
            $res->render("students/index", $data);
            $res->status(200);
        };

        $this->show = function ($req, $res) use ($db) {
            $id = $req->params()["id"];
            $query = [
                "sql" => "SELECT * FROM enrollments
                          INNER JOIN classrooms ON enrollments.classroom_id = classrooms.classroom_id
                          INNER JOIN courses ON classrooms.course_id = courses.course_id
                          INNER JOIN teachers ON teachers.teacher_id = teachers.teacher_id
                          INNER JOIN users ON users.user_id = teachers.user_id
    
                          WHERE classrooms.classroom_id = " . $id
            ];

            $bulletinsQuery = [
                "sql" => "SELECT * FROM bulletins
                          WHERE bulletins.classroom_id = " .  $id
            ];
    
            $studentsQuery = [
                "sql" => "SELECT users.first_name, students.student_id, users.user_id FROM enrollments
                INNER JOIN students ON enrollments.student_id = students.student_id
                INNER JOIN users ON users.user_id = students.user_id
                WHERE enrollments.classroom_id = " . $id
            ];
    
            $classroom = $db->find($query)[0];
            $modulesQuery = [
                "sql" => "SELECT * FROM modules WHERE course_id = " .  $classroom["course_id"]
            ];
            $data = [
                "template" => "classrooms/show.php",
                "classroom" => $classroom,
                "modules" => $db->find($modulesQuery),
                "students" => $db->find($studentsQuery),
                "bulletins" => $db->find($bulletinsQuery)
            ];
            $res->render("students/index", $data);
            $res->status(200);
        };
        $this->showEdit = function ($req, $res) use ($db) {

        };
        $this->create = function ($req, $res) use ($db) {
   
        };
    }
}
