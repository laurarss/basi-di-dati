<?php

    // connect to the database
    $conn = mysqli_connect('localhost', 'laura', 'bl0gcr34t0r', 'progdb');

    // check connection
    if(!$conn){
        echo 'Connection error: '. mysqli_connect_error();
    }
?>
