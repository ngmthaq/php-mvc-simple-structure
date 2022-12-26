<?php

function view(string $_path, array $_data = []): void
{
    if (file_exists("./src/views" . $_path)) {
        foreach ($_data as $_key => $_value) {
            $$_key = $_value;
        }

        include_once("./src/views" . $_path);
    } else {
        throw new Exception("VIEW NOT FOUND");
    }
}

function component(string $_path, array $_data = []): void
{
    if (file_exists("./src/views/components" . $_path)) {
        foreach ($_data as $_key => $_value) {
            $$_key = $_value;
        }

        include("./src/views/components" . $_path);
    } else {
        throw new Exception("COMPONENT NOT FOUND");
    }
}

function importModel(string $name = ""): void
{
    if ($name === "") {
        if (file_exists("./src/models/model.php")) {
            include_once("./src/models/model.php");
        } else {
            throw new Exception("MODEL NOT FOUND");
        }
    } else {
        if (file_exists("./src/models/$name.model.php")) {
            include_once("./src/models/$name.model.php");
        } else {
            throw new Exception("MODEL NOT FOUND");
        }
    }
}

function importController(string $name = ""): void
{
    if ($name === "") {
        if (file_exists("./src/controllers/controller.php")) {
            include_once("./src/controllers/controller.php");
        } else {
            throw new Exception("CONTROLLER NOT FOUND");
        }
    } else {
        if (file_exists("./src/controllers/$name.controller.php")) {
            include_once("./src/controllers/$name.controller.php");
        } else {
            throw new Exception("CONTROLLER NOT FOUND");
        }
    }
}

function cl(mixed $output, bool $withScriptTags = true, bool $forceEncode = true): void
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

function ce(mixed $output, bool $withScriptTags = true, bool $forceEncode = true): void
{
    if ($forceEncode) {
        $jsCode = 'console.error(' . json_encode($output, JSON_HEX_TAG) . ');';
    } else {
        $jsCode = 'console.error(' . $output . ');';
    }

    if ($withScriptTags) {
        $jsCode = '<script>' . $jsCode . '</script>';
    }

    echo $jsCode;
}

function route(string $controller = "", string $action = "", array $query = []): void
{
    $handleQuery = [];
    foreach ($query as $key => $value) {
        $handleQuery[] = "$key=$value";
    }

    $queryString = implode("&", $handleQuery);
    $queryString = $queryString === "" ? $queryString : "&$queryString";

    echo "?c=$controller&a=$action$queryString";
}

function redirect(string $controller = "", string $action = "", array $query = []): void
{
    $handleQuery = [];
    foreach ($query as $key => $value) {
        $handleQuery[] = "$key=$value";
    }

    $queryString = implode("&", $handleQuery);
    $queryString = $queryString === "" ? $queryString : "&$queryString";

    header("Location: ?c=$controller&a=$action$queryString");
}

function convertUploadFileToB64(mixed $file): string
{
    if (!$file) {
        throw new Exception("MISSING FILE");
    }

    $fileTmp = $file['tmp_name'];
    $type = pathinfo($fileTmp, PATHINFO_EXTENSION);
    $data = file_get_contents($fileTmp);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

    return $base64;
}

function convertStringToSlug(string $string): string
{
    if (!$string) {
        throw new Exception("MISSING INPUT STRING");
    }

    $search = array(
        '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
        '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
        '#(ì|í|ị|ỉ|ĩ)#',
        '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
        '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
        '#(ỳ|ý|ỵ|ỷ|ỹ)#',
        '#(đ)#',
        '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
        '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
        '#(Ì|Í|Ị|Ỉ|Ĩ)#',
        '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
        '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
        '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
        '#(Đ)#',
        "/[^a-zA-Z0-9\-\_]/",
    );
    $replace = array(
        'a',
        'e',
        'i',
        'o',
        'u',
        'y',
        'd',
        'A',
        'E',
        'I',
        'O',
        'U',
        'Y',
        'D',
        '-',
    );
    $string = preg_replace($search, $replace, $string);
    $string = preg_replace('/(-)+/', '-', $string);
    $string = strtolower($string);

    return $string;
}

function uploadFile(mixed $file, string $dir = "public/img"): string
{
    if (!$file || !$dir) {
        throw new Exception("MISSING FILE OR DIRECTORY");
    }

    $fileName = strtolower(pathinfo($file['name'], PATHINFO_FILENAME));
    $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $finalFileName = "$fileName.$fileExt";
    $tmpFile = $file['tmp_name'];
    if (!is_dir($dir)) {
        mkdir($dir);
    }

    return move_uploaded_file($tmpFile, "$dir/$finalFileName") ? "/$dir/$finalFileName" : "";
}

function root(string $path = ""): void
{
    echo "." . $path . "?v=" . time();
}
