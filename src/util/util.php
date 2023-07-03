<?php


function sortByKey(array $arr, string $key, bool $desc = false): array
{

    $tmp = [...$arr];
    usort($tmp, function ($a, $b) use ($key) {
        $a = (array) $a;
        $b = (array) $b;
        return $a[$key] <=> $b[$key];
    });
    return $tmp;
}


function getLocation():string
{
    if(isset($_SERVER['HTTP_REFERER'])) {
        $refererUrl = $_SERVER['HTTP_REFERER'];
        $refererParts = parse_url($refererUrl);
        $ip = $refererParts['host'];
        $apiUrl = "http://ip-api.com/json/{$ip}";

        $response = file_get_contents($apiUrl);
        $data = json_decode($response, true);
    }
    if ($data["status"] == "success") {
        return $data["countryCode"];
     
    }   
    return "";
}
