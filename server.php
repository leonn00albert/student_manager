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
    $res->render(__DIR__ . "/src/views//students/index.php");
    $res->status(200);
});

require_once __DIR__ . "/src/routes/studentRoutes.php";  //student routes 
require_once __DIR__ . "/src/routes/classroomRoutes.php";  //classroom routes 
require_once __DIR__ . "/src/routes/toolRoutes.php";  //tool routes 

//serve static files in public folder 

$app->get("/public/:file", function ($req, $res) {
    $path_to_file = explode("/", $req->path())[2];
    header("Content-type:" . $res->getContentType($path_to_file));
    $file = "public/$path_to_file";
    readfile($file);
});
//wildcard route
$app->get("*", function ($req, $res) {
    $res->send("404");
    $res->status(404);

   
});

$app->listen("/", function () {
});
