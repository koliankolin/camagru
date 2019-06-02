<?php

require_once "init.php";
$isLogged = isset($_SESSION["logged"]);

require_once "template/header.php";?>

    <div id="images" class="card-columns"></div>


<script src="src/js/ajaxProfileHome.js"></script>
<? require_once "template/footer.php";?>

