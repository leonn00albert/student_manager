<?php

$app->get("/students/new", function ($req, $res) {
    $res->render("src/views/students/new.php");
    $res->status(200);
});

$app->get("/students/:id", function ($req, $res) {
    $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
    if( $request_uri !== '/students/new'){
    $res->render("src/views/students/show.php");
    $res->status(200);
    }
});

$app->get("/students/edit/:id", function ($req, $res) {
    $res->render("src/views/students/edit.php");
    $res->status(200);
});

//api routes

$app->get("/api/students", function ($req, $res) {
    global $db;
    global $alerts;
    try {
        $data = $db->con->find([]);
        $alert = $alerts->con->find([]);

        $result = pagination($data,$req->query()["page"]);
        list(   
            $records,
            $totalPages,
            $currentPage,
            $totalRecords
        )=$result;

        if (isset($req->query()["sortby"])) {
            $desc = (bool) $req->query()["desc"];
            $records = sortByKey($records, $req->query()["sortby"], $desc);
        }
        $res->json(["alerts" => end($alert) ?? "", "data" => $records ,"total_pages" => $totalPages, "current_page" => $currentPage, "total_records" => $totalRecords]);
        $res->status(200);
        $alerts->con->deleteMany([]);
    } catch (Exception $e) {
        $alerts->con->create(["alert" => ["type" => "danger", "message" => "ERROR: could not get students"]]);
        $res->status(500);
    }
});
$app->get("/api/students/:id", function ($req, $res) {
    global $db;
    global $alerts;
    try {

        $data = $db->con->findById($req->params()["id"]);
        $res->json($data);
        $res->status(200);
    } catch (Exception $e) {
        $alerts->con->create(["alert" => ["type" => "danger", "message" => "ERROR: could not get student with id " . $req->params()["id"]]]);
        $res->status(500);
    }
});

$app->put("/api/students/:id", function ($req, $res) {
    global $db;
    global $alerts;
    global $logs;
    try {
        $data = $db->con->updateById($req->params()["id"], $req->body());
        $logs->con->create(["level" => "info", "source" => "UPDATE /students/" . $req->params()["id"], "date" => date("D M j G:i:s T Y"), "message" => "updated student with id " . $req->params()["id"]]);

        $alerts->con->create(["alert" => ["type" => "success", "message" => "Succesfully updated student with id " . $req->params()["id"]]]);
        $res->json($data);
        $res->status(200);
    } catch (Exception $e) {
        $logs->con->create(["level" => "danger", "source" => "UPDATE /students/" . $req->params()["id"], "date" => date("D M j G:i:s T Y"), "message" => "ERROR: could not update student"]);

        $alerts->con->create(["alert" => ["type" => "danger", "message" => "ERROR: could not update student"]]);
        $res->status(500);
    }
});

$app->delete("/api/students/:id", function ($req, $res) {
    global $db;
    global $alerts;
    global $logs;
    try {
        $data = $db->con->deleteById($req->params()["id"]);
        $logs->con->create(["level" => "info", "source" => "DELETE /students/" . $req->params()["id"], "date" => date("D M j G:i:s T Y"), "message" => "deleted student with id" . $req->params()["id"]]);

        $alerts->con->create(["alert" => ["type" => "success", "message" => "Succesfully deleted student with id " . $req->params()["id"]]]);
        $res->json($data);
        $res->status(200);
    } catch (Exception $e) {
        $logs->con->create(["level" => "danger", "source" => "DELETE /students/" . $req->params()["id"], "date" => date("D M j G:i:s T Y"), "message" => "ERROR: could not delete student"]);
        $alerts->con->create(["alert" => ["type" => "danger", "message" => "ERROR: could not delete student"]]);
        $res->json(["error" =>  $e->getMessage()]);
        $res->status(400);
    }
});


$app->post("/api/students", $form->sanatize, function ($req, $res) {
    global $db;
    global $alerts;
    global $logs;
    try {
      
        $data = $req->body();
        $data['avatar'] = "https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_1280.png";
        $data['country'] = "eu";
        $data['age'] = rand(18,60);
        $data['email'] = "placeholder@email.com";
        $data['gender'] = "";
        

        $db->con->create($data);
        $alerts->con->create(["alert" => ["type" => "success", "message" => "Succesfully created student"]]);
        $logs->con->create(["level" => "info", "source" => "POST /students", "date" => date("D M j G:i:s T Y"), "message" => "created student"]);
        $res->json($data);
        $res->status(201);
    } catch (Exception $e) {
        $logs->con->create(["level" => "danger", "source" => "POST /students", "date" => date("D M j G:i:s T Y"), "message" => "ERROR: could not create student"]);
        $alerts->con->create(["alert" => ["type" => "danger", "message" => "ERROR: could not create student"]]);
        $res->json(["error" =>  $e->getMessage()]);
        $res->status(400);
    }
});
