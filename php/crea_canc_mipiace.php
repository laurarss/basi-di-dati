<?php
//includo file connessione al db
include('db_connect.php');

if (!isset($_SESSION)) {
    session_start();
}

$miPiace = $utenteSession = $idPost = '';

if (isset($_SESSION['nomeUtente'])) {
    $utenteSession = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);
}

//se post piaciuto
if (isset($_POST['liked'])) {
    $idPost = $_POST['idPost'];
    $result = mysqli_query($conn, "SELECT * FROM post WHERE idPost = $idPost");
    $row = mysqli_fetch_array($result);
    $n = $row['cont_like'];

    mysqli_query($conn, "INSERT INTO mipiace (idUtente, idPost) VALUES (1, $idPost)");
    mysqli_query($conn, "UPDATE post SET cont_like = $n+1 WHERE idPost = $idPost");

    echo $n+1;
    exit();
}
//se post non piaciuto
if (isset($_POST['unliked'])) {
    $idPost = $_POST['idPost'];
    $result = mysqli_query($conn, "SELECT * FROM post WHERE idPost=$idPost");
    $row = mysqli_fetch_array($result);
    $n = $row['cont_like'];

    mysqli_query($conn, "DELETE FROM mipiace WHERE idPost = $idPost AND idUtente = 1");
    mysqli_query($conn, "UPDATE post SET cont_like = $n-1 WHERE idPost = $idPost");

    echo $n-1;
    exit();
}
?>