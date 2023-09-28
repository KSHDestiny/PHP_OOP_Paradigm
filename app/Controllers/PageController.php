<?php

namespace App\Controllers;

    class PageController{
        public function forbidden(){
            return view('403.php');
        }

        public function notFound(){
            return view('404.php');
        }
    }