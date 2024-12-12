<?php
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($request_uri) {
    case '/':
    case '/ ':
    case '/Views':
    case '/Views/':
    case 'Views/':

        header('Location: /Views/login.php');
        exit();

    case '/login.php':

        require __DIR__ . '/Views/login.php';
        exit();
    
    default:

        if (http_response_code(404)){
            require __DIR__ . '/404.php';
            exit();
        }
        if (http_response_code(403)){
            require __DIR__ . '/403.php';
            exit();
        } 
}
?>
