<?php
//includo file connessione al db
include('db_connect.php');

if (!isset($_SESSION)) {
    session_start();
}

$segui = $utenteSession = '';

if (isset($_GET['idBlog'])) {
    $idBlog = $_GET['idBlog'];
}

if (isset($_SESSION['nomeUtente'])) {
    $utenteSession = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);
}

// sql cancellazione follower
$sqlDelFollow = "DELETE FROM `follower` WHERE `idBlog` = $idBlog AND idUtente = '$utenteSession'";

if ($conn->query($sqlDelFollow) === TRUE) {
    $segui = '<a class="btn btn-outline-primary btn-sm" id="follow" value="follow"><i class="fa fa-rss"></i>' . " Segui" . '</a>';
} else {
    $segui = '<a class="btn btn-primary btn-sm" id="following" value="following"><i class="fa fa-rss-square"></i>' . " Stai seguendo" . '</a>';
}

echo $segui;

// close connection
$conn->close();

?>