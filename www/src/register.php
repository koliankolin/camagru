<?php



require_once "template/header.php";
?>
<div id="divForm" class="form-group text-center">
    <form id="registerForm" action="src/check-register.php" method="post">
        <label for="login">Enter Login:
            <input id="login" class="form-control" name="login" type="text" required></label><br>
        <label for="email">Enter Email:
            <input id="email" class="form-control" name="email" type="email" required></label><br>
        <label for="password">Enter Password:
            <input id="password" class="form-control" name="password" type="password" required></label><br>
        <button type="submit" class="btn btn-primary">Register User</button>
    </form>
</div>

<script>
    $(document).ready(function () {
        let registerForm = $("#registerForm");
        registerForm.submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: registerForm.attr("method"),
                url: registerForm.attr("action"),
                data: registerForm.serialize(),
                dataType: "text",
                success: function (response) {
                    if (response !== "enter") {
                        let divForm = document.getElementById("divForm");
                        divForm.removeChild(divForm.lastChild);

                        let caution = document.createElement("p");
                        caution.className = "alert alert-info";
                        caution.textContent = (response === "email") ?
                            "That email is already in use. Sorry :(" :
                            "That login is already in use. Sorry :(";

                        divForm.appendChild(caution);
                    }
                    else {
                        window.location.href = "email-was-sent.php";
                    }
                }
            })
        })
    });
</script>

<?require_once "template/footer.php";?>