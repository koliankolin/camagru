<?php

require_once "init.php";
require_once "functions.php";

if (empty($_GET)) {
    header("Location: ../index.php?undefined");
}

$login = array_keys($_GET)[0];

$sessionLogin = $_SESSION["logged"]["login"];

$isYourProfile = $login === $sessionLogin;

$db = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
$queryBuilder = new QueryBuilder(["db" => $db]);

$userId = $queryBuilder->filterDataByCol("users",
    "login", $login)[0]["id"];

$photos = array_reverse($queryBuilder->filterDataByCol("photos", "user_id", $userId));

$userInfo = $queryBuilder->filterDataByCol("users_info",
    "user_id", $userId);


require_once "template/header.php";
?>
    <div class="info">
        <p>Login: <?= $login;?></p>
        <p>Real Name: <?= $userInfo[0]["first_name"];?></p>
        <p>Real Surname: <?= $userInfo[0]["surname"];?></p>
        <p>Real Age: <?= $userInfo[0]["age"];?></p>
        <p>Real Male: <?switch ($userInfo[0]["sex"]){
                case 1:
                    echo "Male";
                    break;
                case 2:
                    echo "Female";
                    break;
                default:
                    echo "Undefined";
            }?></p>
    </div>
    <div class="change">
        <? if($isYourProfile):?>
        <a href="change-password.php?<?= $login;?>">Change password</a><br>
        <a href="change-login-email.php?<?= $login;?>">Change login or email</a><br>
        <a href="change-info.php?<?= $login;?>">Change Personal Info</a>
        <? endif;?>
    </div>
    <? if($photos) {
        for ($idxPhoto = 0; $idxPhoto < count($photos); $idxPhoto++):?>
            <div id="image_<?= $idxPhoto;?>" class="image">
                <img src="<?= $photos[$idxPhoto]["photo"];?>" alt="" width="150" height="150">
                <div id="comments_<?= $idxPhoto;?>">
                <? if (($comments = $queryBuilder->filterDataByCol("comments", "photo_id", $photos[$idxPhoto]["id"]))):?>
                    <? foreach ($comments as $comment):?>
                        <p><?= $comment["comment"];?></p>
                    <? endforeach;?>

                    <?endif;?>
                    <? if (isset($_SESSION["logged"])):?>
                    <form class="addComment" action="add-comment.php?photo_id=<?= $photos[$idxPhoto]["id"];?>&login=<?= $login;?>&id_block=<?= $idxPhoto;?>" method="post">
                        <label for="comment_<?= $idxPhoto;?>">Enter comment:
                            <input class="comment" id="comment_<?= $idxPhoto;?>" name="comment" type="text" width="500" required="required"></label>
                        <button type="submit">Add Comment</button>
                    </form>
                </div>
                    <div id="likes_<?= $idxPhoto;?>">
                        <? $likes = $queryBuilder->filterDataByCol("likes", "photo_id", $photos[$idxPhoto]["id"]);?>
                        <? $arrLiked = [];
                        foreach ($likes as $like) {
                            $arrLiked[] = $like["login_who_likes"];
                        }
                        $isLiked = in_array($sessionLogin, $arrLiked);
                        ?>
                        <form class="formLike" action="add-like.php?photo_id=<?= $photos[$idxPhoto]["id"];?>&user_id=<?= $userId;?>&login=<?= $login;?>&id_block=<?= $idxPhoto;?>" method="post">
                            <button id="btnLike_<?= $idxPhoto;?>" type="submit" class="<?= ($isLiked) ? "btn btn-primary" : "btn btn-outline-primary";?>">Like</button>
                        </form>
                        <? if ($likes):?>
                           <p id="countLikes_<?= $idxPhoto;?>"><?= count($likes);?></p>
                        <? endif;?>
                    </div>
                <?endif;?>
                <? if($isYourProfile):?>
                    <div class="delete">
                        <form id="frmDelete_<?= $idxPhoto;?>" class="frmDelete" action="delete-photo.php" method="post">
                            <input type="hidden" name="block_id" value="<?= $idxPhoto;?>">
                            <input type="hidden" name="photo_id" value="<?= $photos[$idxPhoto]["id"];?>">
                            <button id="btnDelete_<?= $idxPhoto;?>" type="submit" class="btn btn-danger btnDelete">Delete Photo</button>
                        </form>
                    </div>
                <? endif;?>
            </div>
        <?endfor;
    }?>
    <div>
        <? if($isYourProfile):?>
        <b>Download your photo</b>
        <form action="upload-image.php" method="post" enctype="multipart/form-data">
            <input type="file" name="myImage">
            <button type="submit">Upload Photo</button>
        </form>
        <? endif;?>
    </div>
    <script src="js/ajaxProfile.js"></script>
<?require_once "template/footer.php";?>
