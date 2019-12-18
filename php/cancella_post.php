<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');
include('head.php');

$idBlog = $_SESSION['idBlog'];
$queryTF = '';

if (isset($_GET['idPost'])) {
    $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);
    $idPost = $_GET['idPost'];

// sql to delete a record
    $sql = "DELETE FROM `post` WHERE `idPost` = $idPost";

    if ($conn->query($sql) === TRUE) {
        //se la query è andata a buon fine
        echo '<div class="alert alert-success" role="alert"><p><strong>' . " Record cancellato" . '</strong></p></div>';
        //header("Location: visual_blog.php?idBlog=$idBlog");
    } else {
        echo '<div class="alert alert-danger" role="alert"><p><strong>' . "SI è verificato un errore" . '</strong></p></div>';
    }

    // close connection
    $conn->close();
}
?>


<div class="col-10 text-left">
    <a class="btn btn-outline-secondary btn-sm" href="visual_blog.php?idBlog=<?php echo $idBlog; ?>">
        <i class="fa fa-arrow-left"></i>
        Torna al blog
    </a>
</div>