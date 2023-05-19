<?php

$app->get("/students/new", function ($req, $res) {
    $res->render("src/views/students/new.php");
    $res->status(200);
});

$app->get("/students", function ($req, $res) {
    global $db;
    global $alerts;
    try {
        $data = $db->con->find([]);
        $alert = $alerts->con->find([]);
        $perPage = 10; 
        $totalRecords = count($data); 
        $totalPages = ceil($totalRecords / $perPage); 
        if (isset($req->query()["page"]) && is_numeric($req->query()["page"])) {
            $currentPage = $req->query()["page"];
        }
        else {
            $currentPage = 1;
        }
        $startIndex = ($currentPage - 1) * $perPage;
        $records = array_slice($data, $startIndex, $perPage);
        
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
$app->get("/students/:id", function ($req, $res) {
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

$app->put("/students/:id", function ($req, $res) {
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

$app->delete("/students/:id", function ($req, $res) {
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
        $res->status(500);
    }
});
$app->get("/students/edit/:id", function ($req, $res) {
    $res->render("src/views/students/edit.php");
    $res->status(200);
});

$app->post("/students", $form->sanatize, function ($req, $res) {
    global $db;
    global $alerts;
    global $logs;
    try {
        $data = $req->body();
        $db->con->create($data);
        $alerts->con->create(["alert" => ["type" => "success", "message" => "Succesfully created student"]]);
        $logs->con->create(["level" => "info", "source" => "POST /students", "date" => date("D M j G:i:s T Y"), "message" => "created student"]);
        $res->json($data);
        $res->status(200);
    } catch (Exception $e) {
        $logs->con->create(["level" => "danger", "source" => "POST /students", "date" => date("D M j G:i:s T Y"), "message" => "ERROR: could not create student"]);
        $alerts->con->create(["alert" => ["type" => "danger", "message" => "ERROR: could not create student"]]);
        $res->status(500);
    }
});