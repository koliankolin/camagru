<?php

require_once "init.php";
require_once "functions.php";

try {
    $login = $_SESSION["logged"]["login"];
    if (!empty($_FILES["myImage"]["name"])) {
        $imgName = $_FILES["myImage"]["name"];

        if (!in_array(pathinfo($imgName)["extension"], ["png", "gif", "jpg", "jpeg"])) {
            QueryBuilder::printAlertRedirect("Please, choose photo to load BUT NOT another file !!", "../index.php?$login");
            die;
        }

        $imgContent = file_get_contents($_FILES["myImage"]["tmp_name"]);

        $dirLoad = "/var/www/html/data/" . $_SESSION["logged"]["login"] . "/";
        $fileName = $dirLoad . $imgName;
        file_put_contents($fileName, $imgContent);
        $userId = $queryBuilder->filterDataByCol("users",
            "login", $_SESSION["logged"]["login"])[0]["id"];

        $imgBaseName = "../data/" . $login . "/" . $imgName;

        $data = [
            "user_id" => $userId,
            "photo" => $imgBaseName
        ];

        $allImagesUser = getImagesFromPhotos($queryBuilder->filterDataByCol("photos", "user_id", $userId));
        if (in_array($imgBaseName, $allImagesUser)) {
            throw new RuntimeException("That photo already exists !!");
        }
        if ($queryBuilder->insertDataIntoTable("photos", $data)) {
            QueryBuilder::printAlertRedirect("Your image was upload successfully !!",
            "../index.php?$login");
        }
    }
    else {
        QueryBuilder::printAlertRedirect("Please, choose photo to load !!", "../index.php?$login");
    }

} catch (Exception $exception) {
    QueryBuilder::printAlertRedirect("That name of image already exists !!", "../index.php?$login");
}

