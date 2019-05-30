<?php

require_once "init.php";

if ($_GET["email"] && $_GET["hash"]) {
    $user = $queryBuilder->filterDataByCol("users", "hash", $_GET["hash"])[0];
    if ($user["email"] === $_GET["email"]) {
        $queryBuilder->updateDataById("users", "id",
            $user["id"], [
                "activated" => 1
            ]);
        QueryBuilder::printAlertRedirect("Your account was activated !! Thanks :)",
            "../index.php");
    }

}
