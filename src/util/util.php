<?php 


function sortByKey(array $arr, string $key, bool $desc = false):array
{

    $tmp = [...$arr];
    usort($tmp, function ($a, $b) use ($key) {
        $a = (array) $a;
        $b = (array) $b;
        return $a[$key] <=> $b[$key];
    });
    return $tmp;
}


function pagination(array $data, string $current,int $perPage=10):array{
    $perPage = 10; 
    $totalRecords = count($data); 
    $totalPages = ceil($totalRecords / $perPage); 
    if (isset($current) && is_numeric($current)) {
        $currentPage = $current;
    }
    else {
        $currentPage = 1;
    }
    $startIndex = ($currentPage - 1) * $perPage;
    return [array_slice($data, $startIndex, $perPage),$totalPages,$currentPage,$totalRecords] ;
}