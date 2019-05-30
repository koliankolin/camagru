<?php
require_once "init.php";

if (empty($_GET)) {
    header("Location: ../index.php?undefined");
}

$login = array_keys($_GET)[0];

$userId = $queryBuilder->filterDataByCol("users",
    "login", $login)[0]["id"];

$userInfo = $queryBuilder->filterDataByCol("users_info",
    "user_id", $userId);

$isMale = $userInfo[0]["sex"] === 1;

require_once "template/header.php";
?>
    <form action="save-new-info.php?<?= $login;?>" method="post">
        <label for="first_name">Enter New Real Name:
            <input id="first_name" name="first_name" type="text" value="<?= $userInfo[0]["first_name"];?>"></label><br>
        <label for="surname">Enter New Real Surname:
            <input id="surname" name="surname" type="text" value="<?= $userInfo[0]["surname"];?>"></label><br>
        <label for="age">Enter New Real Age:
            <input id="age" name="age" type="number" value="<?= $userInfo[0]["age"];?>"></label><br>
        Enter New Real Sex:
            <input id="sex_f" name="sex" type="radio" value="2" <?if($isMale) echo "checked";?>><label for="sex_f">Female</label>
            <input id="sex_m" name="sex" type="radio" value="1" <?if(!$isMale) echo "checked";?>><label for="sex_m">Male</label><br>
        <button class="btn" type="submit">Save Changes</button>
    </form>
<?require_once "template/footer.php";?>