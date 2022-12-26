<?php

importController();
importModel("user");

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $userModel = new User();
        $user = $userModel->first();

        return view("/page/index.php", compact("user"));
    }

    public function test()
    {
        echo $this->getAuth() ? "Auth" : "Guest";
        echo PHP_EOL;
        echo $_GET["query"];
    }
}
