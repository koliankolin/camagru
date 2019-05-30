<?php
require_once "config/database.php";
require_once "User.php";
require_once "functions.php";

session_start();

$db = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
$queryBuilder = new QueryBuilder(["db" => $db]);