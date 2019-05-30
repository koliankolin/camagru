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

        for ($idxData = 0; $idxData < count($data); $idxData++) {
            $response .= '
                  
            <div class="image">
                    <p><a href=\'../index.php?'.$data[$idxData]["login"].'\'>'.$data[$idxData]["login"].'</a> added photo:</p>
                    <img src='.$data[$idxData]["photo"].' alt=\'\' width=\'350\' height=\'350\'>
                <div id=\'comments_'.$idxData.'\'>';
            if (($comments = $queryBuilder->filterDataByCol("comments", "photo_id", $data[$idxData]["photo_id"]))) {
                foreach ($comments as $comment) {
                    $response .= '<p>'.$comment["comment"].'</p>';
                }
            }
            if (isset($_SESSION["logged"])) {

                $response .= '<form class="addComment" action=\'src/add-comment.php?photo_id='
                        .$data[$idxData]["photo_id"].
                        '&login='
                        .$data[$idxData]["login"].
                        '&id_block='
                        .$idxData.'\' method="post">';
                $response .= '<input class="comment" id=\'comment_'
                        .$idxData.
                        '\' name="comment" type="text" width="500" required="required">
                        <button type="submit" class="btn btn-primary">Add Comment</button>
                    </form>
                </div>
                ';
            }
            $response .= '
                <div id=\'likes_'.$idxData.'\'>';

            $likes = $queryBuilder->filterDataByCol("likes", "photo_id", $data[$idxData]["photo_id"]);
            $arrLiked = [];
            foreach ($likes as $like) {
                $arrLiked[] = $like["login_who_likes"];
            }
            $isLiked = in_array($sessionLogin, $arrLiked);
            $response .= '
                <form class="formLike" action=\'src/add-like.php?photo_id='
                .$data[$idxData]["photo_id"].
                '&user_id='
                .$data[$idxData]["user_id"].
                '&login='
                .$data[$idxData]["login"].
                '&id_block='
                .$idxData.'\' method="post">
                    <button id=\'btnLike_'
                .$idxData.'\' type="submit" class=\'';
                   if ($isLiked)
                       $response .= "btn btn-primary";
                    else
                        $response .= "btn btn-outline-primary";
                $response .= '\'>Like</button>';
            if ($likes) {
                $countLikes = count($likes);
                $response .= '</form><p id=\'countLikes_'.$idxData.'\'>'.$countLikes.'</p>';
            }
            $response .='</div></div>';
        }
        echo $response;
    } else
        echo "reachedEnd";
}
