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
<body>
    <header class="main-header">
        <nav class="menu">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../index.php?find-person">Find Person</a></li>
                <? if(!isset($_SESSION["logged"])){?>
                    <li><a href="../index.php?login">Login</a></li>
                    <li><a href="../index.php?register">Register</a><br></li>
                <?} else {?>
                    <li><a href="../index.php?camera">Take Photo</a></li>
                    <li><a href="../index.php?my-profile">My Profile</a></li>
                    <li><a href="../index.php?logout">LogOut</a></li>
                <?}?>
            </ul>
        </nav>
    </header>

