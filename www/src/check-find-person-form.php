<?php

require_once "init.php";

if (isset($_GET)) {
    foreach (array_keys($_GET) as $key) {
        if (empty($_GET[$key])) {
            $_GET[$key] = null;
        }
    }
    $users = $queryBuilder->filterDataBetween("users_info", "age",
        $_GET["age_from"], $_GET["age_to"]);
    if ($users) {
        foreach (["first_name", "surname", "sex"] as $key) {
            $users = userFilter($users, $key, $_GET[$key]);
        }
        if ($users) {
            $logins = [];
            foreach ($users as $user) {
                $logins[] = $queryBuilder->filterDataByCol("users", "id", $user["user_id"])[0]["login"];
            }
        }
    }
    echo json_encode($logins);
}
