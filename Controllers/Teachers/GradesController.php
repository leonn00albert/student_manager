<?php

namespace Controllers\Teachers;

use Artemis\Core\DataBases\DB;

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
                $id = $req->params()["id"];
                $query = $db->conn()->prepare("UPDATE grades SET 
                score = :score
                WHERE grade_id = :grade_id");
                $query->bindParam(':score', $req->sanitized['score']);
                $query->bindParam(':grade_id', $id);
            
                if ($query->execute()) {
                    $res->status(301);
                    $res->redirect("/teachers/classrooms/" . $req->sanitized["classroom_id"]);
                } else {
                    echo "Error updating record.";
                }
            
                $db->close();
        
        };
    }
}
