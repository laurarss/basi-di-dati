<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');
include('head.php');

$queryErr = '';

if (isset($_GET['idBlog'])) {
    $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);
    $idBlog = $_GET['idBlog'];

//controllo sul numero di post del blog

    /**
     * questa sezione serve per chiedere all'utente conferma,
     * quando il blog che vuole eliminare ha al suo interno uno o più post,
     * che quindi verranno cancellati con esso
     */
//    $postBlog = "SELECT * FROM post WHERE idBlog = $idBlog";
//    $risPostBlog = mysqli_query($conn, $postBlog);
//    $posts = mysqli_num_rows($risPost, MYSQLI_ASSOC);
//    if ($posts > 0) {
//       //rivedere echo "<td> <a href='padamfail.php?FailID=$id' onClick=\"return confirm('Sicuro? Cancellando il blog verranno eliminati anche i suoi post');\"><p class='text-center'>Cancella</p></a>";
//    } else {

// sql cancella blog
    $cancBlog = "DELETE FROM `blog` WHERE `idBlog` = $idBlog";

    if ($conn->query($cancBlog) === TRUE) {
        //se la query è andata a buon fine
        header("Location: gestione_blog.php?nomeUtente=$nomeUtente ?>");
    } else {
        echo $queryErr = "Errore nel cancellare il record: " . $conn->error;
    }

    // close connection
    $conn->close();
}
?>

<div class="alert alert-danger" role="alert">
    <p>
        <strong><?php echo $queryErr; ?></strong>
    </p>
</div>
<a class="btn btn-outline-secondary btn-sm" href="gestione_blog.php?nomeUtente=<?php echo $nomeUtente; ?>">
    <i class="fa fa-arrow-left"></i>
    Torna ai blog
</a>