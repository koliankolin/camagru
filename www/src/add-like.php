<?php

require_once "init.php";

$login = $_GET["login"];
$userIdWhoseLike = $_GET["user_id"];
$photoId = $_GET["photo_id"];
$loginAddLike = $_SESSION["logged"]["login"];
$likes = $queryBuilder->filterDataByCol("likes", "photo_id", $photoId);

$whoLiked = [];
foreach ($likes as $like) {
    $whoLiked[] = $like["login_who_likes"];
}

$data = [
  "blockId" => $_GET["id_block"]
];

if (in_array($loginAddLike, $whoLiked)) {
    if ($queryBuilder->deleteRowByCond("likes", [
        "photo_id" => $photoId,
        "user_id" => $userIdWhoseLike,
        "login_who_likes" => $loginAddLike
    ])) {
        $data["action"] = "delete";
//        QueryBuilder::printAlertRedirect("Like was deleted", "../index.php?$login");
    }
} else {
    $queryBuilder->insertDataIntoTable("likes", [$photoId, $userIdWhoseLike, $loginAddLike]);
    $data["action"] = "add";
//    QueryBuilder::printAlertRedirect("Like was added", "../index.php?$login");
}
echo json_encode($data);

