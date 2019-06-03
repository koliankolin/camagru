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

if(!empty($userId)){
    $photos = array_reverse($queryBuilder->filterDataByCol("photos", "user_id", $userId));
    $userInfo = $queryBuilder->filterDataByCol("users_info",
        "user_id", $userId);
}

require_once "template/header.php";
?>
<!--<div class="row" >-->
<!--    <div class="col-sm-2">-->
    <div class="card text-center" style="margin-bottom: 1vw;">
        <div class="card-body">
            <p><b class="card-title" style="font-size: 25px;">Login: </b><span style="font-size: 20px;"><?= $login;?></span></p>
            <p><b class="card-title" style="font-size: 25px;">Real Name: </b><span style="font-size: 20px;"><?= $userInfo[0]["first_name"];?></span></p>
            <p><b class="card-title" style="font-size: 25px;">Real Surname: </b><span style="font-size: 20px;"><?= $userInfo[0]["surname"];?></span></p>
            <p><b class="card-title" style="font-size: 25px;">Real Age: </b><span style="font-size: 20px;"><?= $userInfo[0]["age"];?></span></p>
            <p><b class="card-title" style="font-size: 25px;">Real Sex: </b><span style="font-size: 20px;"><?switch ($userInfo[0]["sex"]){
                    case 1:
                        echo "Male";
                        break;
                    case 2:
                        echo "Female";
                        break;
                    default:
                        echo "Undefined";
                }?></span></p>
    </div>

    <div class="change" >
        <? if($isYourProfile):?>
        <a href="change-password.php?<?= $login;?>" style="margin-bottom: 0.5vw; margin-left: 1vw;" class="btn btn-primary">Change password</a><br>
        <a href="change-login-email.php?<?= $login;?>" style="margin-bottom: 0.5vw; margin-left: 1vw;" class="btn btn-primary">Change login or email</a><br>
        <a href="change-info.php?<?= $login;?>" style="margin-bottom: 0.5vw; margin-left: 1vw;" class="btn btn-primary">Change Personal Info</a>
        <? endif;?>
    </div>
<!--    </div>-->
<!--    </div>-->
</div>
<div>
    <? if($isYourProfile):?>
<!--    <div class="row" style="margin-bottom: 1vw; margin-left: 2vw;">-->
<!--        <div class="row-md-5">-->
        <div class="card text-center" style="margin-bottom: 1vw;">
            <div class="card-body">
        <h3>Download your photo</h3>
        <div class="form-group" >
            <form action="upload-image.php" method="post" enctype="multipart/form-data">
                <input class="form-control" type="file" name="myImage"><br>
                <button class="btn btn-primary" type="submit">Upload Photo</button>
            </form>
        </div>
        </div>
        </div>
<!--    </div>-->
<!--    </div>-->
    <? endif;?>
</div>
    <div class="card-columns">
    <? if($photos) {
        for ($idxPhoto = 0; $idxPhoto < count($photos); $idxPhoto++):?>
            <div id="image_<?= $idxPhoto;?>" class="image card">
                <img src="<?= $photos[$idxPhoto]["photo"];?>" alt="photo" class="card-img-top">
                <div class="card-body">
                <div class="text-center card" id="comments_<?= $idxPhoto;?>">
                <? if (($comments = $queryBuilder->filterDataByCol("comments", "photo_id", $photos[$idxPhoto]["id"]))):?>
                    <b class="card-text">COMMENTS: </b>
                    <? foreach ($comments as $comment):?>
                        <p class="card-text"><?= $comment["comment"];?></p>
                    <? endforeach;?>

                <?endif;?>

                <? if (isset($_SESSION["logged"])):?>
                    <div class="form-group">
                    <form class="addComment" action="add-comment.php?photo_id=<?= $photos[$idxPhoto]["id"];?>&login=<?= $login;?>&id_block=<?= $idxPhoto;?>" method="post">
                        <label for="comment_<?= $idxPhoto;?>">Enter comment:
                            <input class="comment form-control" id="comment_<?= $idxPhoto;?>" name="comment" type="text" width="500" required="required">
                        </label><br>
                        <button type="submit" class="btn btn-primary">Add Comment</button>
                    </form>
                    </div>
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
                           <p class="card-text" id="countLikes_<?= $idxPhoto;?>" style="margin-bottom: 0.5vw;"><?= count($likes);?></p>
                        <? endif;?>
                    </div>
                <? endif;?>
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
            </div>
        <?endfor;?>
    <?}?>


    </div>

    <script src="js/ajaxProfile.js"></script>
<?require_once "template/footer.php";?>
