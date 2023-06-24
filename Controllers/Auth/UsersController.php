<?php
namespace Controllers\Auth;
use Artemis\Core\DataBases\DB;

class UsersController
{

    public $register;
    public $login;
    public $update;

    public function __construct()
    {
        $db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);
        $this->register = function ($req, $res) use ($db) {
            $query = "INSERT INTO Users (first_name, last_name, contact_email, contact_phone, address, city, country, password, type, last_login_ip)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
            $statement = $db->conn()->prepare($query);
            $type = "student";
            $data = [
                $req->sanitized["first_name"],
                $req->sanitized["last_name"],
                $req->sanitized["contact_email"],
                $req->sanitized["contact_phone"],
                $req->sanitized["address"],
                $req->sanitized["city"],
                $req->sanitized["country"],
                password_hash($req->sanitized["password"],PASSWORD_BCRYPT),
                $type ,
                $req->ip()["ip"]
            ];
            
            foreach ($data as $index => $value) {
                $statement->bindValue($index + 1, $value);
            }
        
            $statement->execute();
            $statement->closeCursor();
        
            if($type == "student"){
                $query= [
                    "sql" =>"SELECT * FROM users
                    ORDER BY user_id DESC
                    LIMIT 1;"
                ];
                $user = $db->find($query)[0];
            
                $query = "INSERT INTO Students (user_id) VALUES (:user_id)";
                $statement = $db->conn()->prepare($query);
                $statement->bindValue(":user_id", $user["user_id"]);
                $statement->execute();
            }
            $db->close();
            $res->status(301);
            $res->redirect("/admin");
        };
        $this->login = function ($req, $res) use ($db) {

        };
        $this->update = function ($req, $res) use ($db) { 
            
        };
    }
}
