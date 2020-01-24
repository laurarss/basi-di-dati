<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');
include('head.php');

if (isset($_GET['idBlog'])){
    $idBlog = $_GET['idBlog'];
}

if (isset($_GET['idCommento'])) {
    $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);
    $idCommento = $_GET['idCommento'];

    // sql to delete a record
    $sql = "DELETE FROM `commenti` WHERE `idCommento` = $idCommento";

    if ($conn->query($sql) === TRUE) {
        //se la query è andata a buon fine
        header("Location: visual_blog.php?idBlog=$idBlog");
    } else {
        echo '<div class="alert alert-danger" role="alert"><p><strong>' . "Si è verificato un errore" . '</strong></p></div>';
    }

    // close connection
    $conn->close();
}
?>
