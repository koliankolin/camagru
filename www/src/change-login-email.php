<?php
require_once "init.php";

$user = $queryBuilder->filterDataByCol("users", "login", $_SESSION["logged"]["login"])[0];

require_once "template/header.php";
?>
<form action="store-new-login-email.php" method="post">
    <label for="login">Enter New Login:
        <input id="login" name="login" type="text" value="<?= $user["login"];?>"></label><br>
    <label for="email">Enter New Email:
        <input id="email" name="email" type="text" value="<?= $user["email"];?>"></label>
    <p>CAUTION !! Be careful !! If you change the email you'll need to verify it again !!</p>
    <button class="btn" type="submit">Save Changes</button>
</form>
<?require_once "template/footer.php";?>