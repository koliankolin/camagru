<?php

require_once "init.php";

if (isset($_POST["getData"])) {
    $start = $_POST["start"];
    $offset = $_POST["offset"];

    if ($photos = $queryBuilder->selectAll("photos")) {
        $photos = array_slice(array_reverse($photos), $start, $offset);
        $sessionLogin = $_SESSION["logged"]["login"];

        $data = [];

        for ($idxData = 0; $idxData < count($photos); $idxData++) {
            $data[$idxData]["user_id"] = $photos[$idxData]["user_id"];
            $data[$idxData]["login"] = $queryBuilder->filterDataByCol("users", "id", $photos[$idxData]["user_id"])[0]["login"];
            $data[$idxData]["photo"] = $photos[$idxData]["photo"];
            $data[$idxData]["photo_id"] = $photos[$idxData]["id"];
        }
        $response = "";

        $idxId = $start;
        for ($idxData = 0; $idxData < count($data); $idxData++) {
            $response .= '
                  
            <div class="card">
                    
                    <img src='.$data[$idxData]["photo"].' alt=\'photo\' class=\'card-img-top\'>
                <div class="card-body text-center">
                <h5 class="card-title"><a href=\'../index.php?'.$data[$idxData]["login"].'\'>'.$data[$idxData]["login"].'</a> added photo:</h5>
                <p class="card-text">COMMENTS:</p>
                <div id=\'comments_'.$idxId.'\'>';
            if (($comments = $queryBuilder->filterDataByCol("comments", "photo_id", $data[$idxData]["photo_id"]))) {
                foreach ($comments as $comment) {
                    $response .= '<p class="card-text">'.$comment["comment"].'</p>';
                }
            }
            if (isset($_SESSION["logged"])) {

                $response .= '<div class="form-group"><form class="addComment" action=\'src/add-comment-home.php?photo_id='
                    . $data[$idxData]["photo_id"] .
                    '&login='
                    . $data[$idxData]["login"] .
                    '&id_block='
                    . $idxData . '\' method="post">';
                $response .= '<input class="comment form-control" id=\'comment_'
                    . $idxId .
                    '\' name="comment" type="text" width="500" required="required"><br>
                        <button type="submit" class="btn btn-primary">Add Comment</button>
                    </form>
                </div>
                ';
            }
            $response .= '
                <div id=\'likes_'.$idxId.'\'>';

            $likes = $queryBuilder->filterDataByCol("likes", "photo_id", $data[$idxData]["photo_id"]);
            $arrLiked = [];
            foreach ($likes as $like) {
                $arrLiked[] = $like["login_who_likes"];
            }
            $isLiked = in_array($sessionLogin, $arrLiked);
            if (isset($_SESSION["logged"])) {
                $response .= '
                <form class="formLike" action=\'src/add-like-home.php?photo_id='
                    . $data[$idxData]["photo_id"] .
                    '&user_id='
                    . $data[$idxData]["user_id"] .
                    '&login='
                    . $data[$idxData]["login"] .
                    '&id_block='
                    . $idxData . '\' method="post">
                    <button id=\'btnLike_'
                    . $idxId . '\' type="submit" class=\'';
                if ($isLiked)
                    $response .= "btn btn-primary";
                else
                    $response .= "btn btn-outline-primary";
                $response .= '\'>Like</button></form>';
            }
            if ($likes) {
                $countLikes = count($likes);
                $response .= '<p id=\'countLikes_'.$idxId.'\'>';
                $response .= (!isset($_SESSION["logged"])) ? "likes: " : "";
                $response .= $countLikes.'</p>';
            }
            $response .='</div></div></div></div>';
            $idxId++;
        }
        echo $response;
    } else
        echo "reachedEnd";
}
