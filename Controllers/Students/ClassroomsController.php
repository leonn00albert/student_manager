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
                "sql" => "SELECT student_id FROM students WHERE user_id = " . $_SESSION["user_id"]  // move it to session?
            ];

          
            $query = [
                "sql" => "SELECT * FROM enrollments
                          INNER JOIN classrooms ON enrollments.classroom_id = classrooms.classroom_id
                          WHERE enrollments.student_id = " . $_SESSION["student"]["student_id"]
            ];
            $data = [
                "template" => "classrooms.php",
                "classrooms" => $db->find($query)
            ];

            $db->close();
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
   

            // TODO ADD CACHING 


            $progress = [
                "sql" => "
                    SELECT 
                       *
                    FROM 
                        progress
                    WHERE 
                        student_id = " . $_SESSION["student"]['student_id'] . "
                    AND
                        classroom_id = " . $id 
            ];

            $sectionsQuery = [
                "sql" => "
                    SELECT 
                        COUNT(*) AS total_sections
                    FROM 
                        Sections s
                    LEFT JOIN 
                        Modules m ON m.module_id = s.module_id
                    LEFT JOIN 
                        Courses c ON c.course_id = m.course_id
                    WHERE 
                        c.classroom_id = " . $id 
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
        
            $progress = $db->find($progress)[0];
  
            

            $data = [
                "template" => "classrooms/show.php",
                "classroom" => $classroom,
                "modules" => $db->find($modulesQuery),
                "students" => $db->find($studentsQuery),
                "bulletins" => $db->find($bulletinsQuery),
                "progress" => $progress

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
