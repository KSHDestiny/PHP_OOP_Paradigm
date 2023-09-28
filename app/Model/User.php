<?php
namespace App\Model;
use \Illuminate\Database\Eloquent\Model;

class User extends Model{
    protected $table = "users";
    protected $fillable = ['name','email','password'];
    public $timestamps = false;
}