<?php
require_once "template/header.php";
?>
<div class="form-group">
    <form id="formPasswordReset" action="store-new-password.php" method="post">
        <label for="email">Enter email:
            <input id="email" class="form-control" name="email" type="email" required></label><br>
        <button class="btn btn-primary" type="submit">Request new password</button>
    </form>
</div>
<script>
    $(document).ready(function () {
        let formPasswordReset = $("#formPasswordReset");
        formPasswordReset.submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: formPasswordReset.attr("method"),
                url: formPasswordReset.attr("action"),
                data: formPasswordReset.serialize(),
                dataType: "text",
                success: function (response) {
                    if (response === "email") {
                        let divForm = document.getElementsByClassName("form-group")[0];
                        divForm.removeChild(divForm.lastChild);

                        let caution = document.createElement("p");
                        caution.className = "alert alert-info";
                        caution.textContent = "There is no such email. Sorry :(";

                        divForm.appendChild(caution);
                    } else {
                        window.location.href = "email-was-sent.php";
                    }
                }
            })
        });
    });
</script>
<?require_once "template/footer.php";?>
