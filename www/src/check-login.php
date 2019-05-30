<?php

require_once "init.php";

if ($_POST["login"] && $_POST["password"]) {
    $user = new User($_POST);
    try {
        $success = $user->loginUser();
    } catch (Exception $exception) {
        $message = $exception->getMessage();
        echo $message;
    }
    if ($success) {
        $login = $_SESSION["login"];
        echo "enter";
    }
    else {
        echo "invalid";
    }
} else {
    echo "invalid";
}
