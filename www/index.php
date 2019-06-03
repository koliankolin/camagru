<?php

require "config/database.php";
require_once "src/User.php";
require_once "src/functions.php";

session_start();

$db = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
$queryBuilder = new QueryBuilder(["db" => $db]);


$logins = $queryBuilder->getAllLogins();
$path = $_SERVER["QUERY_STRING"];

if (empty($path)) {
    require "src/home.php";
}
else if ($path === "login") {
    require "src/login.php";
}
else if (in_array($path, $logins)) {
    header("Location: ./src/profile.php?$path");
}
else if ($path === "find-person") {
    header("Location: ./src/find-person.php");
}
else if ($path === "camera") {
    header("Location: ./src/camera.php");
}
else if ($path === "logout") {
    header("Location: ./src/logout.php");
}
else if ($path === "register") {
    require "src/register.php";
}
else if ($path === "my-profile") {
    $login = $_SESSION["logged"]["login"];
    header("Location: ./src/profile.php?$login");
}