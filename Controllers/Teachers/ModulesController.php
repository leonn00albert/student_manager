<?php

namespace Controllers\Teachers;

use Artemis\Core\DataBases\DB;

class ModulesController
{

    public $showIndex;
    public $showEdit;
    public $showNew;
    public $create;

    public function __construct()
    {
        $db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);
        $this->showIndex = function ($req, $res) use ($db) {
        };
        $this->showEdit = function ($req, $res) use ($db) {
            $id = $req->params()["id"];
            $query = [
                "sql" => "SELECT * FROM sections
                          WHERE sections.module_id = " . $id
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

        $this->showNew = function ($req, $res) use ($db) {
            $data = [
                "template" => "modules/new.php",
                "course_id" => $req->query()["course_id"]
            ];
            $res->render("teachers/index", $data);
            $res->status(200);
        };
        $this->create = function ($req, $res) use ($db) {
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
            $res->status(301);
            $res->redirect("/teachers/courses/" . $req->sanitized["course_id"] . "/edit");
        };
    }
}
