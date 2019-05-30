<?php

require_once "init.php";

if (!$_SESSION["logged"]) {
    QueryBuilder::printAlertRedirect("You need to login",
        "../index.php");
}

require_once "template/header.php";
?>
    <div class="images">
        <div id="pizza" class="fill" draggable="true"></div>
    </div>
    <div class="container" >
        <canvas id="photo" class="empty" width="800" height="600">
            Your browser doesn't support canvas tag
        </canvas>
        <button id="takePhoto" onclick="drawOnHiddenCanvas();" disabled>Take Photo</button>
        <canvas id="hidden" width="800" height="600">
            Your browser doesn't support canvas tag
        </canvas>
        <a href="#" id="saveImg" download="image.png" onclick="saveLocally();">Save image LOCALLY</a>
        <? if($_SESSION["logged"]["login"]):?>
            <form action="save-image.php" method="post" name="saveToBase">
                <input type="hidden" name="image" id="image">
                <button id="btnSaveToBase" onclick="saveImageToBase()" type="submit">Save Image to PROFILE</button>
            </form>
        <?endif;?>
    </div>
    <div id="gallery">

    </div>
    <script src="js/main.js"></script>
<?require_once "template/footer.php";?>