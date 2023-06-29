<?php
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function setAlert($type, $message){
    $_SESSION["alert"]["type"] = $type;
    $_SESSION["alert"]["message"] = $message;
}