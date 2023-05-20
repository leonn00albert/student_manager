
<?php
require('src/util/fpdf185/fpdf.php');

class PDF extends FPDF
{
function LoadData($file)
{   
    $json = file_get_contents("students/.json");
    if($json === false) {
        return [];
      
    } else {
        return json_decode($json,true);
    }
 
}

function BasicTable($header, $data)
{
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
 
    foreach($data as $row)
    {
        $row = array_slice($row,0,count($header));
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

}
