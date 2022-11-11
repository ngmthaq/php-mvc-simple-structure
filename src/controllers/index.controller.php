<?php

model("user");

class IndexController
{
    public function index()
    {
        $userModel = new User();
        $user = $userModel->first();

        return view("/homepage/index.php", compact("user"));
    }

    public function test()
    {
        echo "test";
    }
}
