<?php

require_once "config/database.php";
require_once "src/User.php";
require_once "src/functions.php";

session_start();

$db = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
$queryBuilder = new QueryBuilder(["db" => $db]);
$isLogged = isset($_SESSION["logged"]);

require_once "template/header.php";?>

    <div id="images" class="card-columns"></div>


<script src="src/js/ajaxProfileHome.js"></script>
<? require_once "template/footer.php";?>

