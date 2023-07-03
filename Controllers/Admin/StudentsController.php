<?php
namespace Controllers\Admin;
use Artemis\Core\DataBases\DB;

class StudentsController
{
    public $showIndex;
    public function __construct()
    {
        $db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);
        $this->showIndex = function ($req, $res) use ($db) {
            $query = [
                "sql" => "SELECT * FROM students
                INNER JOIN users ON students.user_id = users.user_id"
            ];

            if (isset($req->query()["sort"])) {
                $sortColumn = $req->query()["sort"];
                $sortDirection = strtoupper($req->query()["direction"]) === "ASC" ? "ASC" : "DESC";
                $query = [
                    "sql" => "SELECT * FROM students
                     INNER JOIN users ON students.user_id = users.user_id
                     WHERE is_archived = 0
                     ORDER BY $sortColumn $sortDirection 
                    "
                ];
            }
            $data = [
                "template" => "students.php",
                "students" => $db->find($query)
            ];
            $res->render("admin/index", $data);
            $res->status(200);
        };
    }
}
