<?php

    // includo file connessione al db
    include('db_connect.php');

    if ($_POST['idPost']) {

        $idPost = $_POST['idPost'];

        // sql to delete a record
        $sqlDeletePost = "DELETE FROM `post` WHERE `idPost` = '$idPost'";
        $risDeletePost = mysqli_query($conn, $sqlDeletePost);

        if ($risDeletePost === false) {
            echo 'false';
        } else {
            echo 'true';
        }
    }
