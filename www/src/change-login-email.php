<?php
require_once "init.php";

if(isset($_SESSION["logged"]))
    $user = $queryBuilder->filterDataByCol("users", "login", $_SESSION["logged"]["login"])[0];

require_once "template/header.php";
?>
<div class="form-group text-center">
    <form action="store-new-login-email.php" method="post">
        <label for="login">Enter New Login:
            <input id="login" class="form-control" name="login" type="text" value="<?= $user["login"];?>"></label><br>
        <label for="email">Enter New Email:
            <input id="email" class="form-control" name="email" type="email" value="<?= $user["email"];?>"></label>
        <p style="margin-top: 1vw;"><b>CAUTION !! Be careful !!</b><br> If you change the email you'll need to verify it again !!</p>
        <button class="btn btn-primary" type="submit">Save Changes</button>
    </form>
</div>
<?require_once "template/footer.php";?>