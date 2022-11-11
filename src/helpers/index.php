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

function importModel(string $name = "")
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

function convertUploadFileToB64($file)
{
    $fileTmp = $file['tmp_name'];
    $type = pathinfo($fileTmp, PATHINFO_EXTENSION);
    $data = file_get_contents($fileTmp);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

    return $base64;
}

function convertStringToSlug($string)
{
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

function uploadFile($file, $dir = "public/img")
{
    $fileName = strtolower(pathinfo($file['name'], PATHINFO_FILENAME));
    $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $finalFileName = "$fileName.$fileExt";
    $tmpFile = $file['tmp_name'];
    if (!is_dir($dir)) {
        mkdir($dir);
    }

    return move_uploaded_file($tmpFile, "$dir/$finalFileName") ? "/$dir/$finalFileName" : null;
}
