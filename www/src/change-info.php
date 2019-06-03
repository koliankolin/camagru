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
<div class="form-group text-center">
    <form action="save-new-info.php?<?= $login;?>" method="post">
        <label for="first_name">Enter New Real Name:
            <input id="first_name" class="form-control" name="first_name" type="text" placeholder="Name" value="<?= $userInfo[0]["first_name"];?>"></label><br>
        <label for="surname">Enter New Real Surname:
            <input id="surname" class="form-control" name="surname" type="text" placeholder="Surname" value="<?= $userInfo[0]["surname"];?>"></label><br>
        <label for="age">Enter New Real Age:
            <input id="age" class="form-control" name="age" type="number" placeholder="Age" value="<?= $userInfo[0]["age"];?>"></label><br>
        <p>Enter New Real Sex: </p>
            <input id="sex_f" style="margin-right: 0.5vw;" name="sex" type="radio" value="2" <?if($isMale) echo "checked";?>><label for="sex_f" style="margin-right: 0.5vw;">Female</label>
            <input id="sex_m" style="margin-right: 0.5vw;" name="sex" type="radio" value="1" <?if(!$isMale) echo "checked";?>><label for="sex_m" style="margin-right: 0.5vw;">Male</label><br>
        <button class="btn btn-primary" type="submit">Save Changes</button>
    </form>
</div>
<?require_once "template/footer.php";?>