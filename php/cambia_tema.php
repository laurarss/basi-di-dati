<?php
//includo file connessione al db
include('db_connect.php');
//includo php header
include('header.php');

//verifica la richiesta GET del parametro idBlog
if (isset($_GET['idBlog'])) {

    $idBlog = $_GET['idBlog'];
    var_dump($idBlog);
    $selectedOptionVal = $_POST['optionVal'];
    var_dump($selectedOptionVal);

    $sqlCambiaTema = "UPDATE `blog` SET `tema` = '$selectedOptionVal' WHERE `blog`.`idBlog` = $idBlog";
    if (mysqli_query($conn, $sqlCambiaTema)) {
        return $selectedOptionVal;
    } else {
        echo('Errore');
    }

}


