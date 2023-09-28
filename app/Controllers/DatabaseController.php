<?php
namespace App\Controllers;

require_once __DIR__ . "/../../vendor/autoload.php";

use Illuminate\Database\Capsule\Manager as DB;
use Symfony\Component\HttpFoundation\Request;

class DatabaseController{
    protected $get, $post;

    public function __construct(){
        $db = new DB;

        [$driver,$dbHost,$dbName,$dbUserName,$dbPassword] = my_database();
        $db->addConnection([
            'driver' => $driver,
            'host' => $dbHost,
            'database' => $dbName,
            'username' => $dbUserName,
            'password' => $dbPassword,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        $db->setAsGlobal();
        $db->bootEloquent();

        $request = Request::createFromGlobals();
        $this->get = $request->query;
        $this->post = $request->request;
    }
}
