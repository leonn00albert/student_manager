<?php

namespace Controllers\Students;

use Artemis\Core\DataBases\DB;

class ModulesController
{

    public $showIndex;
    public $show;
    public $create;

    public function __construct()
    {
        $db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);
        $this->showIndex = function ($req, $res) use ($db) {

        };
        $this->show = function ($req, $res) use ($db) {
            $id = $req->params()["id"];
            $query = [
                "sql" => "SELECT * FROM modules WHERE module_id = " . $id . " LIMIT 1"
            ];
            $sections = [
                "sql" => "SELECT *, sections.section_id FROM sections 
                          LEFT JOIN grades ON sections.section_id = grades.section_id
                          WHERE module_id = " . $id
            ];
            
    
            $data = [
                "template" => "modules/show.php",
                "module" => $db->find($query)[0],
                "sections" => $db->find($sections)
            ];
            $res->render("students/index", $data);
            $res->status(200);
        };
        $this->create = function ($req, $res) use ($db) {
   
        };
    }
}
