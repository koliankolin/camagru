<?php

require_once "init.php";
require_once "functions.php";

$user = $queryBuilder->filterDataByCol("users", "login", $_SESSION["logged"]["login"])[0];

if ($user["login"] !== $_POST["login"]) {
    $queryBuilder->updateDataById("users", "id", $user["id"], [
        "login" => $_POST["login"]
    ]);
    unset($_SESSION["logged"]);
    rename("/var/www/html/data/" . $user["login"], "/var/www/html/data/" . $_POST["login"]);
    $photosAllInfo = $queryBuilder->filterDataByCol("photos", "user_id", $user["id"]);

    $photosNewPath = [];
    foreach ($photosAllInfo as $item) {
        $arr = preg_split("#/#", $item["photo"]);
        $arr[2] = $_POST["login"];
        $photosNewPath[] = implode("/", $arr);
    }
    $photosIds = [];
    foreach ($photosAllInfo as $item) {
        $photosIds[] = $item["id"];
    }
    for ($i = 0; $i < count($photosIds); $i++) {
        $queryBuilder->updateDataById("photos", "id", $photosIds[$i], [
                "photo" => $photosNewPath[$i]
        ]);
    }
}
if ($_POST["email"] !== $user["email"]) {
    $queryBuilder->updateDataById("users", "id", $user["id"], [
        "email" => $_POST["email"],
        "activated" => 0
    ]);
    $message = '

    Hello, dear ' . $user["login"] . '

    Your email was changed and you need to verify it. Follow that link to do that:
    '
        .$_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].':'.$_SERVER["SERVER_PORT"].'/src/verify.php?email=' . $_POST["email"] .
        '&hash='. $user["hash"] . '
    ';
    mail($_POST["email"], "Verify email", $message);
}
QueryBuilder::printRedirect("../index.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>All information was updated !! <br>REMEMBER !! If you changed your email CHECK YOUR email box !!<br>
    If changed your login you'd need to login again</h1>
<!--    <script>-->
<!--        setTimeout(function () {-->
<!--            window.location.href = "../index.php";-->
<!--        }, 5000);-->
<!--    </script>-->
</body>
</html>
