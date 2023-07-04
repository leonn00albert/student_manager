<?php

namespace Routes\Teachers;

class TeachersRoutes
{
    static function register($app, $controller, $db = null)
    {

        $app->get("/teachers", function ($req, $res) {
            $data = [
                "template" => "dashboard.php"
            ];
            $res->render("teachers/index", $data);
            $res->status(HTTP_200_OK);
        });

        $app->get("/teachers/dashboard", function ($req, $res) {
            $data = [
                "template" => "dashboard.php"
            ];
            $res->render("teachers/index", $data);
            $res->status(HTTP_200_OK);
        });
        $app->get("/bulletins/:id/delete", function ($req, $res) use ($db) {
            $db->selectTable("bulletins");
            $db->deleteById($req->params()["id"]);
            $res->redirect("back");
        });

        $app->post("/bulletins", $app->form->sanitize, function ($req, $res) use ($db) {
            try {
                $query = "INSERT INTO bulletins (title, type,message, classroom_id)
                    VALUES (?, ?, ?,?)";

                $statement = $db->conn()->prepare($query);

                $data = [
                    $req->sanitized["title"],
                    $req->sanitized["type"],
                    $req->sanitized["message"],
                    $req->sanitized["classroom_id"],
                ];
                $statement->execute($data);
                $statement->closeCursor();
                $db->close();
                setAlert("success", "Created a new notification");
                $res->status(HTTP_201_CREATED);
                $res->status(HTTP_301_MOVED_PERMANENTLY);
                $res->redirect("/teachers/classrooms/" . $req->sanitized["classroom_id"],);
            } catch (Exception $e) {
                setAlert("danger", "Something went wrong! : " . $e->getMessage());
            }
        });

        $app->get("/teachers/messages", function ($req, $res) use ($db) {
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
            $res->render("teachers/index", $data);
            $res->status(HTTP_200_OK);
        });

        $app->get("/teachers/reports", function ($req, $res) use ($db) {

            $progressQuery = [
                "sql" => "SELECT * FROM progress
                INNER JOIN classrooms ON progress.classroom_id = classrooms.classroom_id
                WHERE classrooms.teacher_id = :id",
                "params" => [
                    "id" => $_SESSION[TYPE_TEACHER]["teacher_id"]
                ]
            ];
            
            if (isset($req->query()["sort"])) {
                $sortColumn = $req->query()["sort"];
                $sortDirection = strtoupper($req->query()["direction"]) === "ASC" ? "ASC" : "DESC";
                $progressQuery = [
                    "sql" => "SELECT * FROM progress
                    INNER JOIN classrooms ON progress.classroom_id = classrooms.classroom_id
                    WHERE classrooms.teacher_id = :id
                    ORDER BY $sortColumn $sortDirection ",
                    "params" => [
                        "id" => $_SESSION[TYPE_TEACHER]["teacher_id"]
                    ]
                ];
            }


            $progress = array_map(function ($elm) {
                $total_points = (int) $elm["sections"] * 10;
                $student_score = (int) $elm["total_score"];
                $elm["grade"] = calculateGrade($total_points, $student_score);
                $elm["max_score"] = $total_points;
                return $elm;
            }, $db->find($progressQuery));

            $data = [
                "template" => "report.php",
                "progress" => $progress,
            ];
            $res->render("teachers/index", $data);
            $res->status(HTTP_200_OK);
        });
    }
}
