<?php

namespace Controllers\Teachers;
require_once __DIR__ . "/../../Utils/utils.php";

use Artemis\Core\DataBases\DB;
use Exception;

class ModulesController
{

    public $showIndex;
    public $showEdit;
    public $showNew;
    public $create;
    public $delete;

    public function __construct()
    {
        $db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);
        $this->showIndex = function ($req, $res) use ($db) {
        };
        $this->showEdit = function ($req, $res) use ($db) {
            $id = $req->params()["id"];
            $query = [
                "sql" => "SELECT * FROM sections
                          WHERE 
                          is_archived = 0
                          AND
                          sections.module_id = " . $id
            ];
            $moduleQuery =
                [
                    "sql" => "SELECT * FROM modules
                          WHERE module_id = " . $id
                ];
            $data = [
                "template" => "modules/edit.php",
                "sections" => $db->find($query),
                "module" => $db->find($moduleQuery)[0]
            ];

            $res->render("teachers/index", $data);
            $res->status(200);
        };

        $this->showNew = function ($req, $res) {
            $data = [
                "template" => "modules/new.php",
                "course_id" => $req->query()["course_id"]
            ];
            $res->render("teachers/index", $data);
            $res->status(200);
        };

        $this->delete = function ($req, $res) use ($db) {
            try {
                $id = $req->params()["id"];
                $query = $db->conn()->prepare("UPDATE modules SET 
                is_archived = :is_archived
                WHERE module_id = :module_id");
                $isArchived = 1; // Set is_archived to 1 (archived)
                $query->bindParam(':is_archived', $isArchived);
                $query->bindParam(':module_id', $id);
        
                if ($query->execute()) {
                    setAlert("success", "Successfully archived module");
        
                } else {
                    setAlert("danger", "Something went wrong: " . $e->getMessage());

                }
        
                $db->close();
            } catch (Exception $e) {
                setAlert("danger", "Something went wrong: " . $e->getMessage());
            }
        };
        $this->create = function ($req, $res) use ($db) {
            try {
                $query = "INSERT INTO modules (module_name, course_id)
                VALUES (?, ?)";
    
                $statement = $db->conn()->prepare($query);
    
                $courseData = [
                    $req->sanitized["module_name"],
                    $req->sanitized["course_id"],
                ];
                $statement->execute($courseData);
                $statement->closeCursor();
                $db->close();
                setAlert("success", "Created a new module");
                $res->status(301);
                $res->redirect("/teachers/courses/" . $req->sanitized["course_id"] . "/edit");
            }
            catch(Exception $e) {
                setAlert("danger", "Something went wrong: " . $e->getMessage());
                $res->status(301);
                $res->redirect("/teachers/courses/" . $req->sanitized["course_id"] . "/edit");
            }
        
        };
    }
}
