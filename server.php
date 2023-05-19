<?php
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/create-pdf.php";

use Artemis\Core\DataBases\DB;
use Artemis\Core\Router\Router;
use Artemis\Core\Forms\Forms;

$app = Router::getInstance();
$db = new DB("JSON", "students");
$logs = new DB("JSON", "logs");
$alerts = new DB("JSON", "alerts");
$classrooms = new DB("JSON", "classrooms");
$form = new Forms();

function sortByKey(array $arr, string $key, bool $desc = false)
{

    $tmp = [...$arr];
    usort($tmp, function ($a, $b) use ($key) {
        $a = (array) $a;
        $b = (array) $b;
        return $a[$key] <=> $b[$key];
    });
    return $tmp;
}
$app->get("/", function ($req, $res) {
    $res->render(__DIR__ . "/src/students/index.php");
    $res->status(200);
});

require_once __DIR__ . "/studentRoutes.php";  //student routes 


$app->get("/public/:file", function ($req, $res) {
    $path_to_file = explode("/", $req->path())[2];
    header("Content-type:" . $res->getContentType($path_to_file));

    $file = "public/$path_to_file";
    readfile($file);
});

$app->get("/classroom/new", function ($req, $res) {
    $res->render(__DIR__ . "/src/classroom/new.html");
    $res->status(200);
});

$app->post("/api/classrooms", function ($req, $res) {
    global $classrooms;
    global $alerts;
    global $logs;
    try {
        $data = $classrooms->con->create($req->body());
        $res->json($data);
        $res->status(200);
        $alerts->con->create(["alert" => ["type" => "success", "message" => "Succesfully created classroom"]]);
        $logs->con->create(["level" => "info", "source" => "POST /students", "date" => date("D M j G:i:s T Y"), "message" => "created classroom"]);
    } catch (Exception $e) {
        $logs->con->create(["level" => "danger", "source" => "POST /students", "date" => date("D M j G:i:s T Y"), "message" => "ERROR: could not create classroom"]);
        $alerts->con->create(["alert" => ["type" => "danger", "message" => "ERROR: could not create classroom"]]);
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
    }
});



$app->get("/logs", function ($req, $res) {
    $res->render(__DIR__ . "/src/logs/index.html");
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
            $url = "https://randomuser.me/api/?results=$count&nat=us";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($response, true);

            $results = [];

            foreach ($data['results'] as $item) {

                $input = ["name" => $item['name']['first'] . " " . $item['name']['last'], 'grade' => rand(0, 10), 'class' => "test"];
                $db->con->create($input);
                array_push($results, $input);
            }

            $logs->con->create(["level" => "info", "source" => "GET /api/seed", "date" => date("D M j G:i:s T Y"), "message" => "Created $count students"]);
            $alerts->con->create(["alert" => ["type" => "success", "message" => "Created $count students"]]);

            $res->status(200);
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
        $data = $pdf->LoadData("countries.txt");
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
$app->listen("/", function () {
});
