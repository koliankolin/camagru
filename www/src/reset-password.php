<?php

if ($_GET["login"] && $_GET["hash"]) {
    require_once "init.php";

    $urlToRedirect = $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].':'.$_SERVER["SERVER_PORT"].'/src/reset-password.php?login='
                     . $_GET["login"] . '&hash=' . $_GET["hash"];

    $user = $queryBuilder->filterDataByCol("users", "hash", $_GET["hash"])[0];


    if ($_POST["new_password"] && $_POST["confirm_password"]) {
        if ($_POST["new_password"] !== $_POST["confirm_password"]) {
            header("Location: $urlToRedirect");
        }
        if ($queryBuilder->updateDataById("users", "id", $user["id"], [
            "password" => hash("whirlpool", $_POST["new_password"])
        ])) {
            QueryBuilder::printAlertRedirect("Password was changed !!",
                "../index.php");
        }
    }
}

require_once "template/header.php";
?>
<div class="form-group text-center">
    <form action="" method="post">
        <label for="new_password">Enter new password:
            <input id="new_password" class="form-control" name="new_password" type="password"></label><br>
        <label for="new_password">Confirm new password:
            <input id="confirm_password" class="form-control" name="confirm_password" type="password"></label><br>
        <button class="btn btn-primary" type="submit">Save Changes</button>
    </form>
</div>
    <script>
        let password = document.getElementById("new_password");
        let confirmPassword = document.getElementById("confirm_password");

        for (let elem of [password, confirmPassword]) {
            elem.addEventListener("keyup", function () {
                if (password.value === confirmPassword.value) {
                    confirmPassword.style = "color: green; font-weight: bold;";
                } else {
                    confirmPassword.style = "color: red; font-weight: bold;";
                }
            });
        }
    </script>
<?require_once "template/footer.php";?>
