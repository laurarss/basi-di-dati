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
        $queryTF = "record cancellato";
        //header("Location: visual_blog.php?idBlog=$idBlog");
    } else {
        $queryTF = "Errore nel cancellare il record: " . $conn->error;
    }

    // close connection
    $conn->close();
}
?>

<div class="alert alert-success" role="alert">
    <p>
        <strong><?php echo $queryTF; ?></strong>
    </p>
    <a class="btn btn-outline-secondary btn-sm" href="visual_blog.php?idBlog=<?php echo $idBlog; ?>">
        <i class="fa fa-arrow-left"></i>
        Torna al blog
    </a>
</div>