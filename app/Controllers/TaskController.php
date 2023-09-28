<?php

namespace App\Controllers;

use App\Model\Task;
use App\Controllers\DatabaseController;

    class TaskController extends DatabaseController{
        public function index(){
            $userId = userId();
            $tasks = Task::where('user_id',$userId)->get();
            return view('users/dashboard.php',["tasks"=>$tasks]);
        }

        public function create(){
            return view('users/create.php');
        }

        public function store(){
            if(isset($_POST['createBtn'])){

                $status = $this->taskValidate();

                if($status){
                    $userId = userId();

                    Task::insert([
                        "user_id" => $userId,
                        "title" => $this->post->get('title'),
                        "deadline" => $this->post->get('deadline')
                    ]);

                    setcookie("oldCreateTitle","",time()-3600);
                    setcookie("oldCreateDeadline","",time()-3600);
                    setcookie("success","You have successfully created a list!");
                    return redirect('users/dashboard');
                }else{
                    setcookie("oldCreateTitle",$this->post->get('title'));
                    setcookie("oldCreateDeadline",$this->post->get('deadline'));
                    return redirect('users/create');
                }
            }
        }

        public function edit(){
            $task = Task::where('id',$this->get->get('id'))->first();

            $currentUserId = userId();
            $this->block($task['user_id'],$currentUserId);
            return view('users/edit.php',["task"=>$task]);
        }

        public function update(){
            // edit data
            if(isset($_POST['editBtn'])){

                $status = $this->taskValidate();

                if($status){
                    Task::where('id',$this->post->get('id'))->update([
                        "title" => $this->post->get('title'),
                        "deadline" => $this->post->get('deadline')
                    ]);

                    setcookie('success',"You have edited a list.");
                    setcookie("oldTitle","",time() - 3600);
                    setcookie("oldDeadline","",time() - 3600);
                    return redirect('users/dashboard');
                }else{
                    setcookie("oldTitle",$this->post->get('title'));
                    setcookie("oldDeadline",$this->post->get('deadline'));
                    return redirect('users/edit?id='.$this->post->get('id'));
                }
            }
        }

        public function delete(){

            $userId = Task::where('id',$this->post->get('id'))->select('user_id')->first()->user_id;
            $currentUserId = userId();
            $this->block($userId,$currentUserId);

            Task::where("id",$this->post->get('id'))->delete();

            setcookie('success',"You have deleted a list.");
            return redirect('users/dashboard');
        }

        public function done(){
            $userId = Task::where('id',$this->post->get('id'))->select('user_id')->first()->user_id;
            $currentUserId = userId();
            $this->block($userId,$currentUserId);

            $id = $this->post->get('id');
            $checked = $this->post->get('checked');
            Task::where("id",$this->post->get('id'))->update(['done' => $checked]);
        }


        private function taskValidate(){
            $status = true;

            if(empty($this->post->get('title')) || $this->post->get('title') == ""){
                setcookie("emptyTitle", "You need to fill list title.");
                $status = false;
            }

            if(empty($this->post->get('deadline')) || $this->post->get('deadline') == ""){
                setcookie("emptyDeadline", "You need to fill list deadline.");
                $status = false;
            }

            return $status;
        }

        // block unauthorized user
        private function block($userId, $currentUserId){
            if($userId != $currentUserId){
                header("Location: /application/index.php/403");
            }
        }
    }