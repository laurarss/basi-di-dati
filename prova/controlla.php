<?php
    $user = "paolo";
    $pass = "poldo";
    if ($_POST['username'] == $user && $_POST['password'] == $pass)
    { // user e pass corrette
        session_start();
        $_SESSION['login'] = "ok"; // sessione login ok
    } else {
        header("Location: login.php");
    }
?>
