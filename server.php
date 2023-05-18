<?php
require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/create-pdf.php";
use Artemis\Core\DataBases\DB;
use Artemis\Core\Router\Router;
use Artemis\Core\Forms\Forms;
$app = Router::getInstance();
$db = new DB("JSON","students");
$logs = new DB("JSON","logs");
$alerts = new DB("JSON","alerts");
$classrooms = new DB("JSON","classrooms");
$form = new Forms();

function sortByKey(array $arr,string $key, bool $desc= false)
{

    $tmp = [...$arr];
    usort($tmp, function ($a, $b) use ($key) {
        $a = (array) $a;
        $b = (array) $b;
        return $a[$key] <=> $b[$key];
    });
    return $tmp;
 
}
$app->get("/", function($req,$res){
    $res->render(__DIR__ . "/src/students/index.html");
    $res->status(200);
      
});

$app->get("/students/new", function($req,$res){
    $res->render(__DIR__ . "/src/students/new.html");
    $res->status(200);
      
});
$app->get("/students",function($req,$res){
    global $db;
    global $alerts;
    try {
        $data = $db->con->find([]);
        $alert = $alerts->con->find([]);
       
        if(isset($req->query()["sortby"])) {
            $desc = (bool) $req->query()["desc"];
            $data = sortByKey($data,$req->query()["sortby"],$desc);
        }
        $res->json(["alerts" => end($alert) ?? "","data" => $data]);
        $res->status(200);
        $alerts->con->deleteMany([]);
    }   
    catch(Exception $e) {
        $alerts->con->create(["alert" => ["type" => "danger","message" => "ERROR: could not get students"]]);
        $res->status(500);
    }

});
$app->get("/students/:id", function($req,$res){
    global $db;
    global $alerts;
    try {
  
        $data = $db->con->findById($req->params()["id"]);
        $res->json($data);
        $res->status(200);
    }
    catch(Exception $e) {
        $alerts->con->create(["alert" => ["type" => "danger","message" => "ERROR: could not get student with id " . $req->params()["id"]]]);
        $res->status(500);
    }
});

$app->put("/students/:id", function($req,$res){
    global $db;
    global $alerts;
    global $logs;
    try {
        $data = $db->con->updateById($req->params()["id"],$req->body());
        $logs->con->create(["level" => "info" , "source" => "UPDATE /students/" .$req->params()["id"] , "date" => date("D M j G:i:s T Y"),"message" => "updated student with id " . $req->params()["id"] ] );

        $alerts->con->create(["alert" => ["type" => "success","message" => "Succesfully updated student with id " . $req->params()["id"]]]);
        $res->json($data);
        $res->status(200);
    }
    catch(Exception $e) {
        $logs->con->create(["level" => "danger" , "source" => "UPDATE /students/" .$req->params()["id"] , "date" => date("D M j G:i:s T Y"),"message" => "ERROR: could not update student" ] );

        $alerts->con->create(["alert" => ["type" => "danger","message" => "ERROR: could not update student"]]);
        $res->status(500);
    }
});

$app->delete("/students/:id", function($req,$res){
    global $db;
    global $alerts;
    global $logs;
    try {
        $data = $db->con->deleteById($req->params()["id"]);
        $logs->con->create(["level" => "info" , "source" => "DELETE /students/" .$req->params()["id"] , "date" => date("D M j G:i:s T Y"),"message" => "deleted student with id" . $req->params()["id"]  ] );

        $alerts->con->create(["alert" => ["type" => "success","message" => "Succesfully deleted student with id " . $req->params()["id"]]]);
        $res->json($data);
        $res->status(200);
    }
    catch(Exception $e) {
        $logs->con->create(["level" => "danger" , "source" => "DELETE /students/" .$req->params()["id"] , "date" => date("D M j G:i:s T Y"),"message" => "ERROR: could not delete student" ] );
        $alerts->con->create(["alert" => ["type" => "danger","message" => "ERROR: could not delete student"]]);
        $res->status(500);
    }
      
});
$app->get("/students/edit/:id", function($req,$res){
    $res->render(__DIR__ . "/src/students/edit.html");
    $res->status(200);    
});

$app->post("/students",$form->sanatize,function($req,$res){
    global $db;
    global $alerts;
    global $logs;
    try {
        $data = $req->body();
        $db->con->create($data);
        $alerts->con->create(["alert" => ["type" => "success","message" => "Succesfully created student"]]);
        $logs->con->create(["level" => "info" , "source" => "POST /students", "date" => date("D M j G:i:s T Y"),"message" => "created student" ] );
        $res->json($data);
        $res->status(200);
    }

    catch(Exception $e) {
        $logs->con->create(["level" => "danger" , "source" => "POST /students", "date" => date("D M j G:i:s T Y"),"message" => "ERROR: could not create student" ] );
        $alerts->con->create(["alert" => ["type" => "danger","message" => "ERROR: could not create student"]]);
        $res->status(500);
    }

      
});

$app->get("/public/:file", function($req,$res){
    $path_to_file = explode("/",$req->path())[2];
    header("Content-type:" . $res->getContentType($path_to_file));

    $file = "public/$path_to_file";
    readfile($file);
  
});

$app->get("/classroom/new",function ($req, $res) {
    $res->render(__DIR__ . "/src/classroom/new.html");
    $res->status(200);
});

$app->post("/api/classrooms",function ($req, $res) {
    global $classrooms;
    global $alerts;
    global $logs;
    try {
        $data = $classrooms->con->create($req->body());
        $res->json($data);
        $res->status(200);
        $alerts->con->create(["alert" => ["type" => "success","message" => "Succesfully created classroom"]]);
        $logs->con->create(["level" => "info" , "source" => "POST /students", "date" => date("D M j G:i:s T Y"),"message" => "created classroom" ] );

    } catch(Exception $e){
        $logs->con->create(["level" => "danger" , "source" => "POST /students", "date" => date("D M j G:i:s T Y"),"message" => "ERROR: could not create classroom" ] );
        $alerts->con->create(["alert" => ["type" => "danger","message" => "ERROR: could not create classroom"]]);
    }

 
});

$app->get("/api/classrooms",function ($req, $res) {
    global $classrooms;
    global $alerts;
    global $logs;
    try {
        $data = $classrooms->con->find([]);
        $res->json($data);
        $res->status(200);
    }
    catch(Exception $e){
        $logs->con->create(["level" => "danger" , "source" => "GET /api/classrooms", "date" => date("D M j G:i:s T Y"),"message" => "ERROR: could not get classroom" ] );
        $alerts->con->create(["alert" => ["type" => "danger","message" => "ERROR: could not get classroom"]]);
    }

 
});



$app->get("/logs",function ($req, $res) {
    $res->render(__DIR__ . "/src/logs/index.html");
    $res->status(200);
});

$app->get("/api/logs",function ($req, $res) {
    global $logs;
    global $alerts; 
    try {
        $data = $logs->con->find([]);
        $alert = $alerts->con->find([]);
        $res->json(["alerts" => end($alert) ?? "","data" => $data]);
        $res->status(200);
        $alerts->con->deleteMany([]);
    }   
    catch(Exception $e) {
        $res->status(500);
    }
});


$app->get("/api/report",function ($req, $res) {
    global $logs;

    try {
        $pdf = new PDF();
        $header = array("id", "Name", "Grade", "Class");
        $data = $pdf->LoadData("countries.txt");
        $pdf->SetFont("Arial","",14);
        $pdf->AddPage();
        $pdf->BasicTable($header,$data);   
        $pdf->Output("D","students" . time(). ".pdf"); 
 
        $logs->con->create(["level" => "info" , "source" => "GET /api/report", "date" => date("D M j G:i:s T Y"),"message" => "create pdf file" ] );

        
    }   
    catch(Exception $e) {
        $logs->con->create(["level" => "danger" , "source" => "GET /api/report", "date" => date("D M j G:i:s T Y"),"message" => "ERROR: could not create pdf file" ] );

        $res->status(500);
    }
});
$app->listen("/", function(){
});