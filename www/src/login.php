<?php

require_once "template/header.php"?>
<div id="divLoginForm" class="form-group text-center">
    <form id="loginForm" method="post" action="src/check-login.php">
        <label for="login">Enter Login:
            <input id="login" class="form-control" type="text" name="login" placeholder="login" required></label>
        <br>
        <label for="password">Enter Password:
            <input id="password" class="form-control" type="password" name="password" placeholder="password" required></label><br>
        <button class="btn btn-primary" type="submit">Login</button>
    </form>
    <a href="src/change-password.php">Forgot password</a><br>
</div>
<script>
    $(document).ready(function () {
        let loginForm = $("#loginForm");
        loginForm.submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: loginForm.attr("method"),
                url: loginForm.attr("action"),
                data: loginForm.serialize(),
                dataType: "text",
                success: function (response) {
                    if (response !== "enter") {
                        let divForm = document.getElementById("divLoginForm");
                        divForm.removeChild(divForm.lastChild);

                        let caution = document.createElement("p");
                        caution.textContent = (response === "invalid") ?
                            "Invalid login or password" :
                            "You need to activate your account. Sorry :(";
                        caution.className = "alert alert-info";

                        divForm.appendChild(caution);

                    } else {
                        window.location.href = "../index.php";
                    }
                }
            })
        })
    });
</script>
<?require_once "template/footer.php"?>

