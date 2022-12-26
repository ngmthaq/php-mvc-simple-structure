<?php

session_start();

require_once("./env.php");
require_once("./helpers.php");

try {
    $controllerDir = "./src/controllers/";
    $controllerFile = array_key_exists("c", $_GET) ? $_GET["c"] . ".controller.php" : "index.controller.php";
    $controllerName = str_replace(".php", "", $controllerFile);
    $controllerName = str_replace(".controller", "Controller", $controllerName);
    $controllerName = ucfirst($controllerName);

    $controller = $controllerDir . $controllerFile;
    $action = array_key_exists("a", $_GET) ? $_GET["a"] : "index";

    if (file_exists($controller)) {
        require_once($controller);
        $con = new $controllerName();
        if (method_exists($con, $action)) {
            $con->$action();
        } else {
            require_once("./src/views/errors/_404.php");
        }
    } else {
        require_once("./src/views/errors/_404.php");
    }
} catch (\Throwable $th) {
    ce($th->getMessage());
    ce($th->getTraceAsString());
    require_once("./src/views/errors/_500.php");
}
