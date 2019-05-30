<?php

require_once "init.php";

$dirLoad = "/var/www/html/data/" . $_SESSION["logged"]["login"] . "/";
$img = $_POST["image"];
$img = str_replace("data:image/png;base64,", "", $img);
$img = str_replace(" ", "+", $img);
$data = base64_decode($img);
try {
    $imgName = bin2hex(random_bytes(10)) . ".png";
} catch (Exception $exception) {
    $imgName = bin2hex(openssl_random_pseudo_bytes(10)) . ".png";
}
$fileName = $dirLoad . $imgName;
file_put_contents($fileName, $data);

$userId = $queryBuilder->filterDataByCol("users",
    "login", $_SESSION["logged"]["login"])[0]["id"];

$login = $_SESSION["logged"]["login"];

$imgBaseName = "../data/" . $login . "/" . $imgName;

$data = [
    "user_id" => $userId,
    "photo" => $imgBaseName
];

if ($queryBuilder->insertDataIntoTable("photos", $data)) {
    QueryBuilder::printAlertRedirect("Your image was upload successfully",
    "../index.php?$login");
}
