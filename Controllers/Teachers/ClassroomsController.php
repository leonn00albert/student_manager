<?php

namespace Controllers\Teachers;

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

            $teacherQuery = [
                "sql" => "SELECT teacher_id FROM teachers WHERE user_id = " . $_SESSION["user_id"]
            ];
    
            $teacher = $db->find($teacherQuery)[0];
    
            $query = [
                "sql" => "SELECT * FROM courses
                INNER JOIN classrooms ON courses.classroom_id = classrooms.classroom_id
                WHERE courses.teacher_id = " . $teacher["teacher_id"]
            ];
    
            $data = [
                "template" => "classrooms.php",
                "classrooms" => $db->find($query)
            ];
            $res->render("teachers/index", $data);
            $res->status(200);
        };

        $this->show = function ($req, $res) use ($db) {
            $id = $req->params()["id"];
            $query = [
                "sql" => "SELECT * , enrollments.classroom_id FROM enrollments
                INNER JOIN classrooms ON enrollments.classroom_id = classrooms.classroom_id
                INNER JOIN students ON enrollments.student_id = students.student_id
                INNER JOIN users ON students.user_id = users.user_id
                WHERE classrooms.classroom_id = " .  $id
            ];
    
            $gradesQuery = [
                "sql" => "SELECT * FROM grades
                          INNER JOIN students ON grades.student_id = students.student_id
                          INNER JOIN users ON students.user_id = users.user_id
                          INNER JOIN sections ON grades.section_id = sections.section_id
    
                          WHERE grades.classroom_id = " .  $id . " AND grades.grade_status = 'Pending'"
            ];

            $bulletinsQuery = [
                "sql" => "SELECT * FROM bulletins
                          WHERE bulletins.classroom_id = " .  $id
            ];
            $result = $db->find($query);
            $data = [
                "template" => "classrooms/show.php",
                "classroom" =>   $result[0],
                "students" =>   $result,
                "grades" =>   $db->find($gradesQuery),
                "bulletins" =>   $db->find($bulletinsQuery)
            ];
            $res->render("teachers/index", $data);
            $res->status(200);
        };
        $this->showEdit = function ($req, $res) use ($db) {

        };
        $this->create = function ($req, $res) use ($db) {
   
        };
    }
}
