<?php

require_once "init.php";


$photo_id = $_POST["photo_id"];

$queryBuilder->deleteRowByCond("comments", [
    "photo_id" => $photo_id
]);

$queryBuilder->deleteRowByCond("likes", [
    "photo_id" => $photo_id
]);

$success = $queryBuilder->deleteRowByCond("photos", [
    "id" => $photo_id
]);


echo $_POST["block_id"];
