<?php

namespace Controllers\Teachers;

use Artemis\Core\DataBases\DB;

class SectionsController
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
                          WHERE section_id = " . $id
            ];
            $data = [
                "template" => "sections/edit.php",
                "section" => $db->find($query)[0],
            ];
        
            $res->render("teachers/index", $data);
            $res->status(200);
        };

        $this->showNew = function ($req, $res) use ($db) {
            $data = [
                "template" => "sections/new.php",
                "module_id" => $req->query()["module_id"]
            ];
            $res->render("teachers/index", $data);
            $res->status(200);
        };

        $this->update = function ($req, $res) use ($db) {
            $id = $req->params()["id"];
            $query = $db->conn()->prepare("UPDATE sections SET 
            section_name = :section_name,
            section_content = :section_content,
            section_resources = :section_resources,
            module_id = :module_id,
            assignment = :assignment
            WHERE section_id = :section_id");
            $query->bindParam(':section_name', $req->sanitized['section_name']);
            $query->bindParam(':section_content', $req->sanitized['section_content']);
            $query->bindParam(':section_resources', $req->sanitized['section_resources']);
            $query->bindParam(':module_id', $req->sanitized['module_id']);
            $query->bindParam(':assignment', $req->sanitized['assignment']);
            $query->bindParam(':section_id', $id);
        
            if ($query->execute()) {
                $res->status(301);
                $res->redirect("/teachers/modules/" . $req->sanitized["module_id"] . "/edit");
            } else {
                echo "Error updating record.";
            }
        
            $db->close();
        };

        $this->create = function ($req, $res) use ($db) {
            $query = $db->conn()->prepare("INSERT INTO sections (section_name, section_content, section_resources, module_id, assignment) 
            VALUES (:section_name, :section_content, :section_resources, :module_id, :assignment)");
            $query->bindParam(':section_name', $req->sanitized['section_name']);
            $query->bindParam(':section_content', $req->sanitized['section_content']);
            $query->bindParam(':section_resources', $req->sanitized['section_resources']);
            $query->bindParam(':module_id', $req->sanitized['module_id']);
            $query->bindParam(':assignment', $req->sanitized['assignment']);


            if ($query->execute()) {
                $res->status(301);
                $res->redirect("/teachers/modules/" . $req->sanitized["module_id"] . "/edit");
            } else {
                echo "Error inserting record.";
            }


            $db->close();
        };
    }
}
