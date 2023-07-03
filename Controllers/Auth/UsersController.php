<?php

namespace Controllers\Auth;

require_once __DIR__ . "/../../config/db.config.php";

use Artemis\Core\DataBases\DB;
use Artemis\Core\Forms\Forms;
use Exception;

class UsersController
{

    public $register;
    public $login;
    public $update;
    public $signout;

    public function __construct()
    {
  
        $db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);
        $this->register = function ($req, $res) use ($db) {
            $validate = new Forms;
            $query = "INSERT INTO Users (first_name, last_name, contact_email, contact_phone, avatar , address, city, country, password, type, last_login_ip)
            VALUES (?, ?, ?,?,?, ?, ?, ?, ?, ?, ?)";
         /** 
             * 
             * @var $db DB
            */
            $statement = $db->conn()->prepare($query);
            $type = "student";
            $data = [
                $req->sanitized["first_name"],
                $req->sanitized["last_name"],
                $req->sanitized["contact_email"],
                $req->sanitized["contact_phone"],
                "https://api.multiavatar.com/" .$req->sanitized["first_name"] . " " . $req->sanitized["last_name"],
                $req->sanitized["address"],
                $req->sanitized["city"],
                $req->sanitized["country"],
                password_hash($req->sanitized["password"], PASSWORD_BCRYPT),
                $type,
                $req->ip()["ip"]
            ];

            //validate password
            if($validate->validatePassword($req->sanitized["password"]) === false) {
                setAlert("danger","Minimum length of 8 characters and must contain at least one uppercase letter, one lowercase letter, one digit, and one special character ");
                $db->close();
                $res->status(301);
                $res->redirect("/register");
                exit();
            }
             //validate email and check if unique
            if(!$validate->isEmail($req->sanitized["contact_email"])) {
                setAlert("danger","Invalid email");
                $db->close();
                $res->status(301);
                $res->redirect("/register");
                exit();
            }
    
                $emailCheck = $db->find([
                    "sql" => "SELECT contact_email FROM users WHERE contact_email = :email",
                    "params" => [
                        "email" => $req->sanitized["contact_email"]
                    ]
                    ]);
                    
                if (count($emailCheck) > 0) {
                    setAlert("danger","Email already taken");
                    $db->close();
                    $res->status(301);
                    $res->redirect("/register");
                    $db->close();
                    exit();
                } 
                
     
            


            foreach ($data as $index => $value) {
                $statement->bindValue($index + 1, $value);
            } 

            $statement->execute();
            $statement->closeCursor();

            if ($type == "student") {
                $query = [
                    "sql" => "SELECT * FROM users
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
            $res->redirect("/login");
        };
        $this->login = function ($req, $res) use ($db) {
            $query = "SELECT * FROM Users WHERE contact_email = :email";
            $statement = $db->conn()->prepare($query);
            $email = $req->sanitized["contact_email"];
            $statement->bindParam(':email', $email);
            $statement->execute();
            $user = $statement->fetch($db->conn()::FETCH_ASSOC); // Fetch the user from the database

            if ($user && password_verify($req->sanitized["password"], $user["password"])) {
                $_SESSION["user"] = $user;   //add user as whole array or object 
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["first_name"] = $user["first_name"];
                $_SESSION["last_login"] = $user["last_login"];
                $_SESSION["type"] = $user["type"];

                $type = $user["type"];
                if($type !== "admin"){
                    $query = [
                        "sql" => "SELECT " . $type . "_id FROM " . $type  . "s WHERE user_id = " . $_SESSION["user_id"]
                    ];
                    $_SESSION[$type] = $db->find($query)[0];
                    $_SESSION[$type] = $db->find($query)[0];
                    $notificationsQuery = [
                        "sql" => "SELECT * FROM notifications WHERE user_id = " . $_SESSION[$type][$type . "_id"] . " AND is_read = 0 AND is_archived = 0 LIMIT 20"
                    ];
                    
              
                    $_SESSION["notifications"] = $db->find($notificationsQuery);

                } else {
                    $_SESSION["admin"]["admin_id"] = 1;
                    
                }
            
                
                $db->close();

                // Redirect the user based on their type
                switch ($user["type"]) {
                    case "admin":
                        $res->redirect("/admin");
                        break;
                    case "teacher":
                        $res->redirect("/teachers");
                        break;
                    case "student":
                        $res->redirect("/students");
                        break;
                }
                exit();
            } else {
                $res->redirect("back");
                setAlert("danger","Incorrect username or password.");
            }

            $db->close();
        };

        $this->signout = function ($req, $res) {
            $_SESSION = [];
            session_destroy();
            $res->redirect("/");
        };
        $this->update = function ($req, $res) use ($db) {
        };
    }
}
