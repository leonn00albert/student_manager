<?php


$app->get("/classroom/new", function ($req, $res) {
    $res->render("src/views/classroom/new.php");
    $res->status(200);
});

$app->post("/api/classrooms", function ($req, $res) {
    global $classrooms;
    global $alerts;
    global $logs;
    try {
        $data = $classrooms->con->create($req->body());
        $res->json($data);
        $res->status(201);
        $alerts->con->create(["alert" => ["type" => "success", "message" => "Succesfully created classroom"]]);
        $logs->con->create(["level" => "info", "source" => "POST /students", "date" => date("D M j G:i:s T Y"), "message" => "created classroom"]);
    } catch (Exception $e) {
        $logs->con->create(["level" => "danger", "source" => "POST /students", "date" => date("D M j G:i:s T Y"), "message" => "ERROR: could not create classroom"]);
        $alerts->con->create(["alert" => ["type" => "danger", "message" => "ERROR: could not create classroom"]]);
        $res->json(["error" =>  $e->getMessage()]);
        $res->status(400);
    }
});

$app->get("/api/classrooms", function ($req, $res) {
    global $classrooms;
    global $alerts;
    global $logs;
    try {
        $data = $classrooms->con->find([]);
        $res->json($data);
        $res->status(200);
    } catch (Exception $e) {
        $logs->con->create(["level" => "danger", "source" => "GET /api/classrooms", "date" => date("D M j G:i:s T Y"), "message" => "ERROR: could not get classroom"]);
        $alerts->con->create(["alert" => ["type" => "danger", "message" => "ERROR: could not get classroom"]]);
        $res->json(["error" =>  $e->getMessage()]);
        $res->status(400);
    }
});


