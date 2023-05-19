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


function pagination(array $data, string $current, int $perPage = 10): array
{
    $perPage = 10;
    $totalRecords = count($data);
    $totalPages = ceil($totalRecords / $perPage);
    if (isset($current) && is_numeric($current)) {
        $currentPage = $current;
    } else {
        $currentPage = 1;
    }
    $startIndex = ($currentPage - 1) * $perPage;
    return [array_slice($data, $startIndex, $perPage), $totalPages, $currentPage, $totalRecords];
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
