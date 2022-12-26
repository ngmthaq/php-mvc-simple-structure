<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="<?php root("/public/css/main.css") ?>">
</head>

<body>
    <p>Hello <?php echo $user["name"] ?></p>
    <a href="<?php route("index", "test", ["query" => "thang"]) ?>">Redirect</a>

    <script src="<?php root("/public/js/main.js") ?>"></script>
</body>

</html>
