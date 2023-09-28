<?php

namespace App\Controllers;

use App\Controllers\DatabaseController;
use App\Model\User;

    class UserController extends DatabaseController{
        public function index(){
            return view('index.php');
        }

        public function login(){
            if($this->post->get('login')){

                $status = $this->loginValidate();

                if($status){
                    $db_password = User::where('email',$this->post->get('email'))->select('password')->first()->password;

                    if(password_verify($this->post->get('password'), $db_password)){

                         // store session for login
                        $_SESSION['token'] = rand(0000000,9999999) . "_" . $this->post->get('email') . rand(0000000,9999999);

                        // store cookie for login
                        setcookie('token',$_SESSION['token'], time() + (3600 * 24));

                        // get id from user table
                        $user_id = User::where('email',$this->post->get('email'))->select('id')->first()->id;

                        // store user id in cookie
                        setcookie('userId',rand(0000000,9999999). $user_id . rand(0000000000,9999999999), time() + (3600 * 24));

                        return redirect('users/dashboard');
                    }else{
                        // wrong password
                        setcookie("wrongPassword","Wrong Password");

                        // old email
                        setcookie("oldEmail",$this->post->get('email'));

                        return redirect('index');
                    }
                }else{
                    // old email
                    setcookie("oldEmail",$this->post->get('email'));
                    // empty data
                    return redirect('index');
                }
            }
        }

        public function registerPage(){
            return view('register.php');
        }

        public function register(){
            if($this->post->get('register')){

                [$status, $strongPassword] = $this->registerValidate();

                if($status && $strongPassword){
                    // delete old data
                    setcookie("oldRegisterName","",time() - 3600);
                    setcookie("oldRegisterEmail","",time() - 3600);

                    // insert data into user table
                    User::insert([
                        'name' => $this->post->get('name'),
                        'email' => $this->post->get('email'),
                        'password' => password_hash($this->post->get('password'), PASSWORD_DEFAULT),
                    ]);

                    // store session for login
                    $_SESSION['token'] = rand(0000000,9999999) . "_" . $this->post->get('name') . rand(0000000,9999999);

                    // store cookie for login
                    setcookie('token',$_SESSION['token'], time() + (3600 * 24));

                    // get id from user table
                    $user_id = User::where('email',$this->post->get('email'))->select('id')->first()->id;

                    // store user id in cookie
                    setcookie('userId',rand(0000000,9999999). $user_id . rand(0000000000,9999999999), time() + (3600 * 24));

                    return redirect('users/dashboard');
                }else{
                    // old data
                    setcookie("oldRegisterName",$this->post->get('name'));
                    setcookie("oldRegisterEmail",$this->post->get('email'));

                    return redirect('registerPage');
                }
            }
        }

        public function logout(){
            session_destroy();

            foreach($_COOKIE as $key => $value){
                setcookie($key, "", time() - 3600);
            }

            return redirect('index');
        }

        private function loginValidate(){
            $status = true;

            // empty email
            if($this->post->get('email') == null || $this->post->get('email') == ""){
                $status = false;
                setcookie("emptyEmail", "You need to fill your email.");
            }

            // empyt pasword
            if($this->post->get('password') == null || $this->post->get('password') == ""){
                $status = false;
                setcookie("emptyPassword", "You need to fill your password.");
            }

            return $status;
        }

        private function registerValidate(){
                $status = true;
                $strongPassword = true;

                // empty name
                if($this->post->get('name') == null || $this->post->get('name') == ""){
                    $status = false;
                    setcookie("emptyName", "You need to fill your name.");
                }

                // empty email
                if($this->post->get('email') == null || $this->post->get('email') == ""){
                    $status = false;
                    setcookie("emptyEmail", "You need to fill your email.");
                }else{
                    // email already taken
                    $row = User::where('email',$this->post->get('email'))->first();

                    if($row){
                        $status = false;
                        setcookie("sameEmail", "Email has already been taken.");
                    }
                }

                // empyt pasword
                if($this->post->get('password') == null || $this->post->get('password') == ""){
                    $status = false;
                    setcookie("emptyPassword", "You need to fill your password.");
                }else{
                    // strong password

                    if(!preg_match("/[a-z]/",$this->post->get('password'))){
                        $strongPassword = false;
                    }elseif(!preg_match("/[A-Z]/",$this->post->get('password'))){
                        $strongPassword = false;
                    }elseif(!preg_match("/[0-9]/",$this->post->get('password'))){
                        $strongPassword = false;
                    }elseif(!preg_match("/[!@#$%^&*()]/",$this->post->get('password'))){
                        $strongPassword = false;
                    }

                    if($strongPassword == false){
                        setcookie("weakPassword","Password must contain capital letter, small letter, number and special charactor");
                    }
                }

                // password & confirm password not match
                if($this->post->get('password') != $this->post->get('confirmPassword')){
                    $status = false;
                    setcookie("notMatchPassword","Passwords do not match.");
                }

                return [$status, $strongPassword];
        }
    }