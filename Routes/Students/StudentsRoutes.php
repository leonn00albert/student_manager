<?php

namespace Routes\Students;
use Exception;

class StudentsRoutes
{
    static function register($app, $controller, $db=null)
    {
            //STUDENT ROUTES 
    $app->get("/students", function ($req, $res) {
        $res->status(HTTP_301_MOVED_PERMANENTLY);
        $res->redirect("/students/dashboard");
    });
    $app->get("/students/dashboard", function ($req, $res) use ($db){
        $query = [
            "sql" => "SELECT * FROM progress
            INNER JOIN courses on progress.course_id = courses.course_id
            WHERE student_id = :student_id" ,
            "params" => ["student_id" => $_SESSION[TYPE_STUDENT]["student_id"]]
        ];

        $progress = $db->find($query);

        $data = [
            "template" => "dashboard.php",
            "progress" => $progress
        ];
        $res->render("students/index", $data);
        $res->status(HTTP_200_OK);
    });
    $app->get("/students/messages", function ($req, $res) use ($db) {
        $query = [
            "sql" => "SELECT * FROM students INNER JOIN users ON students.user_id = users.user_id",
            "params" => []
        ];

        $messages = [];
        if (isset($req->query()["from"])  && $req->query()["from"] == $_SESSION[USER_ID]) {
            $messages = [
                "sql" => "SELECT * FROM messages WHERE (sender_id = :sender_id AND recipient_id = :recipient_id) OR (sender_id = :recipient_id AND recipient_id = :sender_id)",
                "params" => [
                    "recipient_id" => $req->query()["to"],
                    "sender_id" => $req->query()["from"]
                ]
            ];
            $messages = $db->find($messages);
        }

        $data = [
            "template" => "messages.php",
            "students" => $db->find($query),
            "messages" => $messages,
        ];
        $res->render("students/index", $data);
        $res->status(HTTP_200_OK);
    });



    $app->post("/enrollments", $app->form->sanitize, function ($req, $res) use ($db, $app) {

        //todo add only one time per student

        try {
            $enrollment_date =  date("Y-m-d");
            $courseQuery = [
                "sql" => "SELECT * FROM courses WHERE course_id = :courseid LIMIT 1",
                "params" => [
                    "courseid" => $req->sanitized['course_id']
                ]
            ];

            $course = $db->find($courseQuery)[0];

            $sql = "SELECT classroom_id FROM enrollments WHERE course_id = :courseid";
            $stmt = $db->conn()->prepare($sql);
            $stmt->bindValue(':courseid', $req->sanitized['course_id']);
            $stmt->execute();
            $classroom_id = null;
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch($db->conn()::FETCH_ASSOC);
                $classroom_id = $row["classroom_id"];
            } else {
                $classroom_name = $course["course_name"] . " " . chr(rand(65, 90)) . rand(0, 100);
                $insertQuery = "INSERT INTO classrooms (classroom_name, teacher_id, course_id) VALUES (:classroom_name, :teacher_id, :course_id)";
                $stmt = $db->conn()->prepare($insertQuery);
                $stmt->bindParam(':classroom_name', $classroom_name);
                $stmt->bindParam(':teacher_id',  $req->sanitized["teacher_id"]);
                $stmt->bindParam(':course_id',  $req->sanitized["course_id"]);
                $stmt->execute();
                $classroom_id = $db->conn()->lastInsertId();
                $updateCourseQuery = "UPDATE courses SET classroom_id = :classroom_id WHERE course_id = :course_id";
                $stmt = $db->conn()->prepare($updateCourseQuery);
                $stmt->bindParam(':classroom_id',  $classroom_id);
                $stmt->bindParam(':course_id',  $req->sanitized["course_id"]);
                $stmt->execute();
            }
            $teacherQuery = [
                "sql" => "SELECT teacher_id FROM classrooms 
                    WHERE classroom_id  = " . $classroom_id . " LIMIT 1"
            ];


            $teacher = $db->find($teacherQuery)[0];
            $app->notification->create($teacher["teacher_id"], "A new student enrolled for your course", "/teachers/classrooms/" . $classroom_id);
            $insertQuery = "INSERT INTO enrollments (student_id, course_id, enrollment_date, classroom_id) VALUES (:student_id, :course_id, :enrollment_date, :classroom_id)";
            $stmt = $db->conn()->prepare($insertQuery);
            $stmt->bindParam(':student_id', $_SESSION["student"]["student_id"]);
            $stmt->bindParam(':course_id', $req->sanitized["course_id"]);
            $stmt->bindParam(':enrollment_date', $enrollment_date);
            $stmt->bindParam(':classroom_id', $classroom_id);
            $stmt->execute();
            $_SESSION["alert"]["type"] = "success";
            $_SESSION["alert"]["message"] = "You have been enrolled for a new course!";
            $res->status(HTTP_201_CREATED);
            $res->status(HTTP_301_MOVED_PERMANENTLY);
            $res->redirect("/students/classrooms");
        } catch (Exception $e) {

            $_SESSION["alert"]["type"] = "danger";
            $_SESSION["alert"]["message"] = "Something went wrong! : " . $e->getMessage();
            $res->redirect("/students/classrooms");
        }
    });

    $app->get("/students/sections/:id", function ($req, $res) use ($db) {
        try {
            $id = $req->params()["id"];
            $sections = [
                "sql" => "SELECT * FROM sections
                              WHERE sections.section_id = " . $id . "
                              LIMIT 1"
            ];
            $grades = [
                "sql" => "SELECT * FROM sections
                              LEFT JOIN grades ON grades.section_id = sections.section_id
                              WHERE sections.section_id = " . $id . "
                              AND grades.student_id = " . $_SESSION["student"]["student_id"] . "
                              LIMIT 1"
            ];
            $data = [
                "template" => "sections/show.php",
                "section" => $db->find($sections)[0],
                "grades" => $db->find($grades)[0] ?? "",
            ];


            $res->render("students/index", $data);
            $res->status(HTTP_200_OK);
        } catch (Exception $e) {
            $_SESSION["alert"]["type"] = "danger";
            $_SESSION["alert"]["message"] = "Something went wrong! : " . $e->getMessage();
            $res->redirect("/students/classrooms");
        }
    });

    $app->post("/grades", $app->form->sanitize, function ($req, $res) use ($db, $app) {
        //todo add only one time per student 
        //add error and alerts

        try {
            $submit_date = date("Y-m-d");

            $classroomQuery = [
                "sql" => "SELECT *  FROM modules
                INNER JOIN courses ON modules.course_id = courses.course_id
                INNER JOIN classrooms  ON courses.classroom_id = classrooms.classroom_id
           
            WHERE modules.module_id = :id",
            "params" => [
                "id" => $req->sanitized["module_id"]            ]
            ];
            $teacherQuery = [
                "sql" => "SELECT teacher_id FROM classrooms 
            INNER JOIN enrollments ON classrooms.classroom_id = enrollments.classroom_id 
            WHERE enrollments.student_id = " . $_SESSION[TYPE_STUDENT]["student_id"] . " LIMIT 1"
            ];

            $classroom = $db->find($classroomQuery)[0];
            $teacher = $db->find($teacherQuery)[0];

            $app->notification->create($teacher["teacher_id"], $_SESSION["first_name"] . " Submmited a new assignment to grade", "/teachers/classrooms/" . $classroom["classroom_id"]);


            $insertQuery = "INSERT INTO grades (student_id, section_id, classroom_id, submit_date, assignment, grade_answer,course_id) VALUES (:student_id, :section_id, :classroom_id,:submit_date, :assignment, :grade_answer, :course_id)";
            $stmt = $db->conn()->prepare($insertQuery);
            $stmt->bindParam(':student_id', $_SESSION[TYPE_STUDENT]["student_id"]);
            $stmt->bindParam(':section_id', $req->sanitized["section_id"]);
            $stmt->bindParam(':course_id', $classroom["course_id"]);
            $stmt->bindParam(':classroom_id',  $classroom["classroom_id"]);
            $stmt->bindParam(':submit_date', $submit_date);
            $stmt->bindParam(':assignment', $req->sanitized["assignment"]);
            $stmt->bindParam(':grade_answer', $req->sanitized["grade_answer"]);
            $stmt->execute();
            $_SESSION["alert"]["type"] = "success";
            $_SESSION["alert"]["message"] = "Sucessfully submitted assignment ";
            $res->redirect("/students/classrooms");
        } catch (Exception $e) {
            $_SESSION["alert"]["type"] = "danger";
            $_SESSION["alert"]["message"] = "Something went wrong! : " . $e->getMessage();
            $res->redirect("/students/classrooms");
        }
    });
    }
}
