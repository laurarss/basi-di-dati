<?php

    // connetto al database
    $conn = mysqli_connect('localhost', 'tobet', 'tobet', 'bdd');

    //controllo la connessione
    if (!$conn) {
        echo 'Connection error: ' . mysqli_connect_error();
    }

    // imposto codifica
    mysqli_set_charset($conn, "utf8");
?>
