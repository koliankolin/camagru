<?php

require_once "init.php";
$isLogged = isset($_SESSION["logged"]);

require_once "template/header.php";?>
<? if(!$isLogged):?>
    <h1>Hello</h1>
<? endif;?>

<div id="images">


</div>
<script src="src/js/ajaxProfileHome.js"></script>
<? require_once "template/footer.php";?>

