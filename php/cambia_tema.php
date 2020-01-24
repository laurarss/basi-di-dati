<?php

    //includo file connessione al db
    include('db_connect.php');

    //verifica la richiesta GET del parametro idBlog
    if (isset($_POST['idBlog'])) {

        $idBlog = $_POST['idBlog'];
        $selectedTheme = $_POST['selectedTheme'];

        $sqlCambiaTema = "UPDATE `blog` SET `tema` = '$selectedTheme' WHERE `blog`.`idBlog` = $idBlog";

        if (mysqli_query($conn, $sqlCambiaTema)) {
            echo $selectedTheme;
        } else {
            echo('Errore');
        }
    }
