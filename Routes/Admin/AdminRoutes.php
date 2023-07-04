<?php

namespace Routes\Admin;

use Exception;

class AdminRoutes
{
    static function register($app, $controller, $db=null)
    {
        $app->get("/admin", function ($req, $res) {
            $res->status(HTTP_301_MOVED_PERMANENTLY);
            $res->redirect("/admin/dashboard");
        });
        $app->get("/admin/dashboard", function ($req, $res) {

            $data = [
                "template" => "dashboard.php"
            ];
            $res->render("admin/index", $data);
            $res->status(HTTP_200_OK);
        });

        $app->get("/admin/library", function ($req, $res) use ($db){
            $query = [
                "sql" => "SELECT * FROM library"
            ];
            $data = [
                "template" => "library.php",
                "books" => $db->find($query)
            ];
            $res->render("admin/index", $data);
            $res->status(HTTP_200_OK);
        });

        $app->post("/admin/library",$app->form->sanitize, function ($req, $res) use ($db) {
            $query = [
                "sql" => "INSERT INTO library (book_image, book_title, book_url) VALUES (:book_image, :book_title, :book_url)",
                "params" => [
                    "book_image" => $req->sanitized["book_image"],
                    "book_title" => $req->sanitized["book_title"],
                    "book_url" => $req->sanitized["book_url"],
                ]
                ];
                try {
                    $db->create($query);
                    $res->status(HTTP_201_CREATED);
                    $res->redirect("/admin/library");
                }
                catch(Exception $e){

                }
     
            
        });

        $app->get("/admin/teachers", function ($req, $res) use ($db) {
            $query = [
                "sql" => "SELECT * FROM teachers
        INNER JOIN users ON teachers.user_id = users.user_id
        WHERE is_archived = 0"
            ];

            if (isset($req->query()["sort"])) {
                $sortColumn = $req->query()["sort"];
                $sortDirection = strtoupper($req->query()["direction"]) === "ASC" ? "ASC" : "DESC";
                $query = [
                    "sql" => "SELECT * FROM teachers
             INNER JOIN users ON teachers.user_id = users.user_id
             WHERE is_archived = 0
             ORDER BY $sortColumn $sortDirection 
            "
                ];
            }

            $data = [
                "template" => "teachers.php",
                "teachers" => $db->find($query)
            ];
            $res->render("admin/index", $data);
            $res->status(HTTP_200_OK);
        });
    }
}
