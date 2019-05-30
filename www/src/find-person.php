<?php



require_once "template/header.php";

?>
    <h1>Find another person</h1>
<div id="divFind" class="form-group">
    <form id="findForm" action="check-find-person-form.php" method="get">
        <label for="name">Name:
            <input id="name" class="form-control" name="first_name" type="text"></label><br>
        <label for="surname">Surname:
            <input id="surname" class="form-control" name="surname" type="text"></label><br>
        <label for="age_from">Age From:
            <input id="age_from" class="form-control" name="age_from" type="number"></label><br>
        <label for="age_to">Age To:
            <input id="age_to" class="form-control" name="age_to" type="number"></label><br>
        <input id="sex_f" class="form-control" name="sex" value="2" type="radio" checked><label for="sex_f">Female</label><br>
        <input id="sex_m" class="form-control" name="sex" value="1" type="radio"><label for="sex_m">Male</label><br>
        <button class="btn btn-primary" type="submit">Find Somebody</button>
    </form>
</div>
    <div id="idUsers" class="users"></div>
<script>
    $(document).ready(function () {
        let findForm = $("#findForm");
        findForm.submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: findForm.attr("method"),
                url: findForm.attr("action"),
                data: findForm.serialize(),
                dataType: "json",
                success: function (users) {
                    let idUsers = document.getElementById("idUsers");
                    idUsers.innerHTML = "";

                    let divFind = document.getElementById("divFind");

                    if (!users) {
                        if (divFind.lastChild.tagName === "P") {
                            divFind.removeChild(divFind.lastChild);
                        }

                        let caution = document.createElement("p");
                        caution.textContent = "Nobody was found. Sorry :(";
                        caution.className = "alert alert-info";

                        divFind.appendChild(caution);
                        return ;
                    }

                    for (let user of users) {
                        if (divFind.lastChild.tagName === "P") {
                            divFind.removeChild(divFind.lastChild);
                        }
                        let userElem = document.createElement("p");

                        let userUrl = document.createElement("a");
                        userUrl.href = "../index.php?" + user;
                        userUrl.textContent = user;

                        userElem.appendChild(userUrl);
                        idUsers.appendChild(userElem);
                    }
                }
            })
        })
    });
</script>
<?require_once "template/footer.php";?>
