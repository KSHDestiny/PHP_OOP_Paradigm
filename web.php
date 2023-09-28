<?php

use App\Controllers\PageController;
use App\Controllers\TaskController;
use App\Controllers\UserController;

    $routes = [
        '/index' => [UserController::class,'index'],
        '/login' => [UserController::class,'login'],
        '/registerPage' => [UserController::class,'registerPage'],
        '/register' => [UserController::class,'register'],
        '/logout' => [UserController::class,'logout'],
        '/users/dashboard' => [TaskController::class,'index'],
        '/users/create' => [TaskController::class,'create'],
        '/users/store' => [TaskController::class,'store'],
        '/users/edit' => [TaskController::class,'edit'],
        '/users/update' => [TaskController::class,'update'],
        '/users/delete' => [TaskController::class,'delete'],
        '/users/done' => [TaskController::class,'done'],
        '/403' => [PageController::class,'forbidden'],
        '/404' => [PageController::class,'notFound'],
    ];

    if($_SERVER['PATH_INFO']){
        $route = $_SERVER['PATH_INFO'];
    }else{
        $route = "./index";
    }

    if(array_key_exists($route, $routes)){
        $controller = $routes[$route][0];
        $method = $routes[$route][1];
    }else{
        notFound();
        die();
    }

    $home = new $controller();
    $home->$method();