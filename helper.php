<?php
    // database
    function my_database(){
        $envVars = parse_ini_file(__DIR__ . "/.env");

        $driver = $envVars['DB_CONNECTION'];
        $dbHost = $envVars['DB_HOST'];
        $dbName = $envVars['DB_DATABASE'];
        $dbUserName = $envVars['DB_USERNAME'];
        $dbPassword = $envVars['DB_PASSWORD'];

        return [$driver,$dbHost,$dbName,$dbUserName,$dbPassword];
    }

    function view($file_name, $data = []){
        extract($data);
        require_once __DIR__ . "/resources/views/$file_name";
    }

    function redirect($file_name){
        header("Location: /application/index.php/$file_name");
    }

    function notFound(){
        require_once __DIR__ . "/resources/views/404.php";
    }

    function userId(){
    if(isset($_COOKIE['userId'])){
        $length = strlen($_COOKIE['userId']) - 17;
        $userId = substr($_COOKIE['userId'],7,$length);
        return $userId;
    }
}