<?php

session_start();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Magic Site !!</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
</head>
<body class="container" style="background-color: #edeef0;">
    <header class="main-header" style="margin-bottom: 2vw;">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="../index.php">42 Insta</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>

                    <? if(!isset($_SESSION["logged"])){?>
                        <li class="nav-item"><a class="nav-link" href="../index.php?login">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="../index.php?register">Sign Up</a><br></li>
                    <?} else {?>
                        <li class="nav-item"><a class="nav-link" href="../index.php?find-person">Find Person</a></li>
                        <li class="nav-item"><a class="nav-link" href="../index.php?camera">Take Photo</a></li>
                        <li class="nav-item"><a class="nav-link" href="../index.php?my-profile">My Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="../index.php?logout">LogOut</a></li>
                    <?}?>
                </ul>
            </div>
        </nav>
    </header>

