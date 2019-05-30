<?php

require_once "init.php";

if ($_POST["login"] && $_POST["password"] && $_POST["email"]) {
    $user = new User($_POST);
    try {
        $user->registerUser();
        echo "enter";
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
}