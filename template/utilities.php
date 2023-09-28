<?php
    function database($hostname, $dbname, $user, $password){
        try {
            $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $user, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
            return $conn;

        } catch(PDOException $e) {
            // echo "Connection failed: " . $e->getMessage();
        }
    }
    // login
    function login(){
        if(isset($_COOKIE['token']) || isset($_SESSION['token'])){
            header("Location: ./dashboard.php");
        }
    }

   // not login
    function notLogin(){
        if(empty($_SESSION['token'])){
            if(empty($_COOKIE['token'])){
                header("Location: ./index.php");
            }
        }
    }

      // userId
    function userId(){
        if(isset($_COOKIE['userId'])){
            $length = strlen($_COOKIE['userId']) - 17;
            $userId = substr($_COOKIE['userId'],7,$length);
            return $userId;
        }
    }

    // flash message
    function flash($message){
        if(isset($_COOKIE[$message])){
            echo $_COOKIE[$message];
            setcookie($message,"",time() - 3600);
        }
    }

    function oldData($data){
        if(isset($_COOKIE[$data])){
            echo htmlentities($_COOKIE[$data]);
        }
    }

    function block($userId, $currentUserId){
        if($userId != $currentUserId){
            header("Location: ./404.php");
        }
    }

?>