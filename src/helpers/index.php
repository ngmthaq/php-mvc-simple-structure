<?php

function view(string $_path, array $_data = [])
{
    foreach ($_data as $_key => $_value) {
        $$_key = $_value;
    }

    include_once("./src/views" . $_path);
}

function component($_path, array $_data = [])
{
    foreach ($_data as $_key => $_value) {
        $$_key = $_value;
    }

    include("./src/views/components" . $_path);
}

function model(string $name = "")
{
    if ($name === "") {
        include_once("./src/models/model.php");
    } else {
        include_once("./src/models/$name.model.php");
    }
}

function clog(mixed $output, bool $withScriptTags = true, bool $forceEncode = true)
{
    if ($forceEncode) {
        $jsCode = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
    } else {
        $jsCode = 'console.log(' . $output . ');';
    }

    if ($withScriptTags) {
        $jsCode = '<script>' . $jsCode . '</script>';
    }

    echo $jsCode;
}

function route(string $controller, string $action, array $query = [])
{
    $handleQuery = [];
    foreach ($query as $key => $value) {
        $handleQuery[] = "$key=$value";
    }

    $queryString = implode("&", $handleQuery);
    $queryString = $queryString === "" ? $queryString : "&$queryString";

    echo "?c=$controller&a=$action$queryString";
}

function redirect(string $controller, string $action, array $query = [])
{
    $handleQuery = [];
    foreach ($query as $key => $value) {
        $handleQuery[] = "$key=$value";
    }

    $queryString = implode("&", $handleQuery);
    $queryString = $queryString === "" ? $queryString : "&$queryString";

    header("Location: ?c=$controller&a=$action$queryString");
}
