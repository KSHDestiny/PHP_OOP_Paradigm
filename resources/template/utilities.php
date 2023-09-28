<?php

    // login
    function login(){
        if(isset($_COOKIE['token']) || isset($_SESSION['token'])){
            header("Location: /application/index.php/users/dashboard");
        }
    }

   // not login
    function notLogin(){
        if(empty($_SESSION['token'])){
            if(empty($_COOKIE['token'])){
                header("Location: /application/index.php/index");
            }
        }
    }

    // flash message
    function flash($message){
        if(isset($_COOKIE[$message])){
            echo htmlentities($_COOKIE[$message]);
            setcookie($message,"",time() - 3600);
        }
    }

    function oldData($data){
        if(isset($_COOKIE[$data])){
            echo htmlentities($_COOKIE[$data]);
        }
    }
?>