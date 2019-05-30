<?php


require_once "init.php";

$login = $_GET["login"];
$loginSentComment = $_SESSION["logged"]["login"];
$comment = '<a href="../index.php?' . $loginSentComment . '">' . $loginSentComment . '</a>, ' . htmlspecialchars($_POST["comment"]);
$photoId = $_GET["photo_id"];


$email = $queryBuilder->filterDataByCol("users", "login", $login)[0]["email"];

$message = '
    
    Hello, ' . $login . ' !!
    
    ' . $login . ' add comment "' . $comment . '" to your photo

';

$data = [
    "photo_id" => $photoId,
    "comment" => $comment
];

$dataJson = [
    "idBlock" => $_GET["id_block"],
    "loginSentComment" => $loginSentComment,
    "commentText" => htmlspecialchars($_POST["comment"])
];
//    echo json_encode($dataJson);

if ($queryBuilder->insertDataIntoTable("comments", $data)) {
    //TODO: switch sending email
//    if (mail($email, "Your photo was commented", $message)) {
    echo json_encode($dataJson);
//        QueryBuilder::printAlertRedirect("Comment was added", "../index.php?$login");
//    }
}


