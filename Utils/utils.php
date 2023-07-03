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

function pagination($totalItems,$itemsPerPage=10 ){
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($currentPage - 1) * $itemsPerPage;
    $limit = $itemsPerPage;
    $totalPages = ceil($totalItems / $itemsPerPage);
    $pagination = '';
    if ($totalPages > 1) {
        $pagination .= '<ul class="pagination" style="margin: 0 auto">';
        if ($currentPage > 1) {
            $pagination .= '<li class="page-item><a class="page-link" href="?page=' . ($currentPage - 1) . '">Previous</a></li>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $currentPage) ? 'active' : '';
            $pagination .= '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }
        if ($currentPage < $totalPages) {
            $pagination .= '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage + 1) . '">Next</a></li>';
        }

        $pagination .= '</ul>';
    }

    return [
        "html" =>  $pagination,
        "offset" =>  $offset,
        "limit" =>  $limit,
    ];
}
function calculateGrade($totalPoints, $studentScore) {
    if ($totalPoints == 0) {
        return 'N/A'; 
    }
    $percentage = ($studentScore / $totalPoints) * 100;

    if ($percentage >= 90) {
        return 'A';
    } elseif ($percentage >= 80) {
        return 'B';
    } elseif ($percentage >= 70) {
        return 'C';
    } elseif ($percentage >= 60) {
        return 'D';
    } elseif ($percentage >= 50) {
        return 'E';
    } else {
        return 'F';
    }
}