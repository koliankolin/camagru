<?php
require_once "template/header.php";
?>
    <h1>Email was sent. Check your email box</h1>
    <p>You'll be redirected after: </p>
    <p id="seconds"></p>
    <script>
        let seconds = document.getElementById("seconds");
        let num = 5;

        function funcTimer () {
            if (num === 0) {
                window.location.href = "../index.php";
            }
            num--;
            seconds.textContent = num.toString();
            setTimeout(funcTimer, 1000);
        }

        seconds.addEventListener("load", funcTimer);
    </script>
<? require_once "template/footer.php";?>