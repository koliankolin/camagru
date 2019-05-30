<?php

require_once "init.php";

if ($_POST["email"]) {
    $user = $queryBuilder->filterDataByCol("users", "email", $_POST["email"])[0];
    if (!$user) {
        echo "email";
//        QueryBuilder::printAlertRedirect("Not that email in base",
//            "change-password.php");
    }
    $message = '
        
        Hello, ' . $user["login"] . '!!
        
        
        To reset your password follow to that link below:
        '
        .$_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].':'.$_SERVER["SERVER_PORT"].'/src/reset-password.php?login='
        . $user["login"] . '&hash=' . $user["hash"] . PHP_EOL;
    mail($user["email"], "Reset password", $message);
    unset($_SESSION["logged"]);
}

