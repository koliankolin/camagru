<? if(isset($data)):?>
    <? for ($idxData = 0; $idxData < count($data); $idxData++):?>

        <div class="image">
            <p><a href="../index.php?<?= $data[$idxData]["login"]?>"><?= $data[$idxData]["login"]?></a> added photo:</p>
            <img src="<?= $data[$idxData]["photo"]?>" alt="" width="150" height="150">
            <div id="comments_<?= $idxData;?>">
                <? if (($comments = $queryBuilder->filterDataByCol("comments", "photo_id", $data[$idxData]["photo_id"]))):?>
                    <? foreach ($comments as $comment):?>
                        <p><?= $comment["comment"];?></p>
                    <? endforeach;?>

                <?endif;?>
                <? if (isset($_SESSION["logged"])):?>
                <form class="addComment" action="src/add-comment.php?photo_id=<?= $data[$idxData]["photo_id"];?>&login=<?= $data[$idxData]["login"];?>&id_block=<?= $idxData;?>" method="post">
                    <label for="comment_<?= $idxData;?>">Enter comment:
                        <input class="comment" id="comment_<?= $idxData;?>" name="comment" type="text" width="500" required="required"></label>
                    <button type="submit">Add Comment</button>
                </form>
            </div>
            <div id="likes_<?= $idxData;?>">
                <? $likes = $queryBuilder->filterDataByCol("likes", "photo_id", $data[$idxData]["photo_id"]);?>
                <? $arrLiked = [];
                foreach ($likes as $like) {
                    $arrLiked[] = $like["login_who_likes"];
                }
                $isLiked = in_array($sessionLogin, $arrLiked);
                ?>
                <form class="formLike" action="src/add-like.php?photo_id=<?= $data[$idxData]["photo_id"];?>&user_id=<?= $data[$idxData]["user_id"];?>&login=<?= $data[$idxData]["login"];?>&id_block=<?= $idxData;?>" method="post">
                    <button id="btnLike_<?= $idxData;?>" type="submit" class="<?= ($isLiked) ? "btn btn-primary" : "btn btn-outline-primary";?>">Like</button>
                </form>
                <? if ($likes):?>
                    <p id="countLikes_<?= $idxData;?>"><?= count($likes);?></p>
                <? endif;?>
            </div>
            <?endif;?>
        </div>
    <? endfor;?>
<? endif;?>
