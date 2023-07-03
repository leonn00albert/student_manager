<?php

namespace Controllers\Admin;

use Artemis\Core\DataBases\DB;

class UsersController
{

    public $showIndex;
    public $showEdit;
    public $update;

    public function __construct()
    {
        $db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);
        $this->showIndex = function ($req, $res) use ($db) {
            $countSql = "SELECT COUNT(*) as total FROM users";
            $countResult = $db->find(["sql" =>  $countSql])[0];
            $totalItems = $countResult["total"];
            
            $pagination = pagination($totalItems, 5);


            $query = [
                "sql" => "SELECT * FROM users LIMIT {$pagination["offset"]}, {$pagination["limit"]};"
            ];
            

            if (isset($req->query()["sort"])) {
                $sortColumn = $req->query()["sort"];
                $sortDirection = strtoupper($req->query()["direction"]) === "ASC" ? "ASC" : "DESC";
                $query = [
                    "sql" => "SELECT * FROM users ORDER BY $sortColumn $sortDirection LIMIT {$pagination["offset"]}, {$pagination["limit"]};",
                ];
            }

            $data = [
                "template" => "users.php",
                "users" => $db->find($query),
                "pagination" => $pagination["html"]
             ];
            $res->render("admin/index", $data);
            $res->status(200);
        };
        $this->showEdit = function ($req, $res) use ($db) {
            $id = $req->params()["id"];
            $query = [
                "sql" => "SELECT * FROM users where user_id = $id;"
            ];

            $data = [
                "template" => "users/edit.php",
                ...$db->find($query)[0]
            ];
            $res->render("admin/index", $data);
            $res->status(200);
        };
        $this->update = function ($req, $res) use ($db) {
            $id = $req->params()["id"];

            $query = "UPDATE users SET 
                        first_name = ?,
                        last_name = ?,
                        contact_email = ?,
                        contact_phone = ?,
                        address = ?,
                        city = ?,
                        country = ?,
                        type = ?,
                        date_of_birth = ?,
                        gender = ?
                      WHERE user_id = ?";

            $userData = [
                $req->sanitized["first_name"],
                $req->sanitized["last_name"],
                $req->sanitized["contact_email"],
                $req->sanitized["contact_phone"],
                $req->sanitized["address"],
                $req->sanitized["city"],
                $req->sanitized["country"],
                $req->sanitized["type"],
                $req->sanitized["date_of_birth"],
                $req->sanitized["gender"],
                $id
            ];

            $statement = $db->conn()->prepare($query);

            foreach ($userData as $index => $value) {
                $statement->bindValue($index + 1, $value);
            }

            $statement->execute();

            if ($statement->rowCount() > 0) {

                if ($req->sanitized["type"] == "teacher") {
                    $query = "INSERT INTO Teachers (user_id) VALUES (:user_id)";
                    $statement = $db->conn()->prepare($query);
                    $statement->bindValue(":user_id", $id);
                    $statement->execute();
                }

                $res->redirect("/admin/users");
                $res->status(301);
            } else {
                $res->status(404);
                $res->send("User not found");
            }

            $db->close();
        };
    }
}
