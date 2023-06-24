<?php

namespace Controllers\Admin;

use Artemis\Core\DataBases\DB;

class ClassroomsController
{

    public $showIndex;
    public $showEdit;
    public $update;
    public $create;
    public function __construct()
    {
        $db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);
        $this->showIndex = function ($req, $res) use ($db) {
            $teachersQuery = [
                "sql" => "SELECT * FROM teachers
                INNER JOIN users ON teachers.user_id = users.user_id"
            ];
            $coursesQuery = [
                "sql" => "SELECT * FROM courses"
            ];

            $classroomsQuery = [
                "sql" => "SELECT * FROM classrooms" // inner join later   
            ];
            $data = [
                "template" => "classrooms.php",
                "courses" => $db->find($coursesQuery),
                "teachers" => $db->find($teachersQuery),
                "classrooms" => $db->find($classroomsQuery)
            ];
            $res->render("admin/index", $data);
            $res->status(200);
        };
        $this->showEdit = function ($req, $res) use ($db) {
            // --TODO MAKE ADMIN ONLY 
            $id = $req->params()["id"];
            $teachersQuery = [
                "sql" => "SELECT * FROM teachers
             INNER JOIN users ON teachers.user_id = users.user_id"
            ];
            $coursesQuery = [
                "sql" => "SELECT * FROM courses"
            ];

            $classroomsQuery = [
                "sql" => "SELECT * FROM classrooms WHERE classroom_id = $id " // inner join later   
            ];
            $data = [
                "template" => "classrooms/edit.php",
                "courses" => $db->find($coursesQuery),
                "teachers" => $db->find($teachersQuery),
                "classroom" => $db->find($classroomsQuery)[0]
            ];

            $res->render("admin/index", $data);
            $res->status(200);
        };
        $this->create = function ($req, $res) use ($db) {
            $query = "INSERT INTO classrooms (classroom_name, teacher_id, course_id)
            VALUES (?, ?, ?)";

            $statement = $db->conn()->prepare($query);
            $classroomData = [
                $req->sanitized["classroom_name"],
                $req->sanitized["teacher_id"],
                $req->sanitized["course_id"],
            ];
            $statement->execute($classroomData);
            $statement->closeCursor();
            $db->close();
            $res->status(301);
            $res->redirect("/admin/classrooms");
        };

        $this->update = function ($req, $res) use ($db) {
            $id = $req->params()["id"];
            $query = "UPDATE classrooms SET 
                        classroom_name = ?,
                        course_id = ?,
                        teacher_id = ?
                      WHERE classroom_id = ?";

            $userData = [
                $req->sanitized["classroom_name"],
                $req->sanitized["course_id"],
                $req->sanitized["teacher_id"],
                $id
            ];

            $statement = $db->conn()->prepare($query);

            foreach ($userData as $index => $value) {
                $statement->bindValue($index + 1, $value);
            }

            $statement->execute();

            if ($statement->rowCount() > 0) {
                $res->redirect("/admin/classrooms");
                $res->status(301);
            } else {
                $res->status(404);
                $res->send("Classroom not found");
            }

            $db->close();
        };
    }
}
