<?php

if ($_GET["login"] && $_GET["hash"]) {
    require_once "init.php";

    $urlToRedirect = 'http://192.168.22.27:8001/src/reset-password.php?login='
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
    <form action="" method="post">
        <label for="new_password">Enter new password:
            <input id="new_password" name="new_password" type="password"></label><br>
        <label for="new_password">Confirm new password:
            <input id="confirm_password" name="confirm_password" type="password"></label><br>
        <button class="btn" type="submit">Save Changes</button>
    </form>
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
