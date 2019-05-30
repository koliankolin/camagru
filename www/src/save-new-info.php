<?php

require_once "init.php";

if (empty($_GET)) {
    header("Location: ../index.php?undefined");
}

$login = array_keys($_GET)[0];
$userId = $queryBuilder->filterDataByCol("users",
    "login", $login)[0]["id"];

$isFilled = ($queryBuilder->filterDataByCol("users_info", "user_id", $userId))
            ? true : false;

$data = array_merge(array("user_id" => $userId), $_POST);

if (empty($data["age"])) {
    $data["age"] = 0;
}
if (($isFilled) ? $queryBuilder->updateDataById("users_info",
    "user_id", $userId, $data) :
    $queryBuilder->insertDataIntoTable("users_info", $data, false, true)) {
    QueryBuilder::printAlertRedirect("Your Profile Info was Updated SUCCESSFULLY !!",
        "../index.php?$login");
}
else
    QueryBuilder::printAlertRedirect("Smth went WRONG !!", "change-info.php");
