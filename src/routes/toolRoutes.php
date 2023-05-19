<?php

$app->get("/logs", function ($req, $res) {
    $res->render("src/views/logs/index.html");
    $res->status(200);
});

$app->get("/api/logs", function ($req, $res) {
    global $logs;
    global $alerts;
    try {
        $data = $logs->con->find([]);
        $alert = $alerts->con->find([]);
        $res->json(["alerts" => end($alert) ?? "", "data" => $data]);
        $res->status(200);
        $alerts->con->deleteMany([]);
    } catch (Exception $e) {
        $res->status(500);
    }
});

$app->get("/api/seed", function ($req, $res) {
    global $db;
    global $logs;
    global $alerts;
    if (isset($req->query()["count"])) {
        $count = $req->query()["count"];
        try {
            $url = "https://randomuser.me/api/?results=$count&nat=us,uk,fr,ua,in,fi,de,dk,no,nl,es";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($response, true);

            $results = [];

            foreach ($data["results"] as $item) {
             
                $input = [
                    "name" => $item["name"]["first"] . " " . $item["name"]["last"],
                    "grade" => rand(0, 10),
                    "class" => "test",
                    "email" => $item["email"],
                    "avatar" => str_replace("\/",'/',$item["picture"]["thumbnail"]),
                    "age" => $item["dob"]["age"],  
                    "country" => $item["nat"],
                    "gender" => $item["gender"],

                ];
                $db->con->create($input);
                array_push($results, $input);
            }

            $logs->con->create(["level" => "info", "source" => "GET /api/seed", "date" => date("D M j G:i:s T Y"), "message" => "Created $count students"]);
            $alerts->con->create(["alert" => ["type" => "success", "message" => "Created $count students"]]);

            $res->status(201);
            $res->json($results);
        } catch (Exception $e) {
            $logs->con->create(["level" => "danger", "source" => "GET /api/seed", "date" => date("D M j G:i:s T Y"), "message" => "ERROR: could not create students"]);
            $alerts->con->create(["alert" => ["type" => "danger", "message" => "ERROR: could not create students"]]);
            $res->status(500);
        }
    } else {
        $res->send("include ?count=x");
    }
});
$app->get("/api/delete", function ($req, $res) {
    global $logs;
    global $db;
    global $classrooms;
    try {
        $db->con->deleteMany([]);
        $classrooms->con->deleteMany([]);
        $logs->con->create(["level" => "info", "source" => "GET /api/delete", "date" => date("D M j G:i:s T Y"), "message" => "deleted all data"]);
        $res->json([]);
        $res->status(200);
    } catch (Exception $e) {
        $logs->con->create(["level" => "danger", "source" => "GET /api/delete", "date" => date("D M j G:i:s T Y"), "message" => "ERROR: could not  delete all data"]);

        $res->status(500);
    }
});

$app->get("/api/report", function ($req, $res) {
    global $logs;

    try {
        $pdf = new PDF();
        $header = array("id", "Name", "Grade", "Class");
        $data = $pdf->LoadData("");
        $pdf->SetFont("Arial", "", 14);
        $pdf->AddPage();
        $pdf->BasicTable($header, $data);
        $pdf->Output("D", "students" . time() . ".pdf");

        $logs->con->create(["level" => "info", "source" => "GET /api/report", "date" => date("D M j G:i:s T Y"), "message" => "create pdf file"]);
    } catch (Exception $e) {
        $logs->con->create(["level" => "danger", "source" => "GET /api/report", "date" => date("D M j G:i:s T Y"), "message" => "ERROR: could not create pdf file"]);

        $res->status(500);
    }
});