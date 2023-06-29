<?php

namespace Controllers\Teachers;
require_once __DIR__ . "/../../Utils/utils.php";
use Artemis\Core\DataBases\DB;
use Exception;
use Utils\Notifications\Notification;

class GradesController
{

    public $showIndex;
    public $showEdit;
    public $update;
    public $show;

    public function __construct()
    {
        $db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);
        $this->showIndex = function ($req, $res) use ($db) {

        };

        $this->show = function ($req, $res) use ($db) {
            $id = $req->params()["id"];
            $gradesQuery = [
                "sql" => "SELECT * FROM grades
                          INNER JOIN students ON grades.student_id = students.student_id
                          INNER JOIN users ON students.user_id = users.user_id
                          INNER JOIN sections ON grades.section_id = sections.section_id
    
                          WHERE grades.grade_id = " .  $id ." LIMIT 1"
            ];
    
            $data = [
                "template" => "grades/show.php",
                "grade" => $db->find($gradesQuery)[0]
            ];
            $res->render("teachers/index", $data);
            $res->status(200);
        };
        $this->showEdit = function ($req, $res) use ($db) {

        };
        $this->update = function ($req, $res) use ($db) {
            try {
                $notification = new Notification($db);
                $id = $req->params()["id"];
                $score =  $req->sanitized['score'];
                $query = $db->conn()->prepare("UPDATE grades SET 
                score = :score
                WHERE grade_id = :grade_id");
                $query->bindParam(':score',  $score);
                $query->bindParam(':grade_id', $id);
                $studentQuery = [
                    "sql" => "SELECT * FROM grades 
                    WHERE grades.grade_id = " .  $id
                ];

                $student = $db->find($studentQuery)[0];

                if($req->sanitized['score'] >= 6) {
                  $notification->create($student["student_id"],"Your assignment was accepted with a score of: " .$score , "/students/grades/" . $student["classroom_id"] ); 

                } else {
                   $notification->create($student["student_id"],"Your assignment was declined with a score of: " .$score , "/students/grades/" . $student["classroom_id"] ); 

                }

                if ($query->execute()) {
                    setAlert("success","Succusefully graded assignment");

                    $res->status(301);
                    $res->redirect("/teachers/classrooms/" . $req->sanitized["classroom_id"]);
                } else {
                    echo "Error updating record.";
                }
            
                $db->close();

            }catch(Exception $e) {
                setAlert("danger","Something went wrong: " .  $e->getMessage());
            }
        
        };
    }
}
