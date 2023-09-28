<?php
namespace App\Model;
use \Illuminate\Database\Eloquent\Model;

class Task extends Model{
    protected $table = "tasks";
    protected $fillable = ['title','deadline','done'];
    public $timestamps = false;
}