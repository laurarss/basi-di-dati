<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');
include('head.php');

$esito = '';
$daCancellare = false;

if (isset($_GET['idBlog'])) {
    $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);
    $idBlog = $_GET['idBlog'];

//salvo categoria del blog da cancellare
//    $sqlCatBlog = "SELECT blog.categoria FROM `blog` WHERE `idBlog` = $idBlog";
//    $result = mysqli_query($conn, $sqlCatBlog);
//    var_dump($result);
//    $catBlog = mysqli_fetch_all($result, MYSQLI_ASSOC);
//    var_dump($catBlog);
//
//    // cerco nella tab categorie
//    $sqlCercaCat = "SELECT categorie.nomeCategoria FROM `categorie` WHERE `idCategoria` = $catBlog";
//    $risCercaCat = mysqli_query($conn, $sqlCercaCat);
//    var_dump($risCercaCat);
//    // se c'è solo un record significa che dopo la cancellazione blog la categoria rimarrà vuota, quindi la devo cancellare
//    if (mysqli_num_rows($risCercaCat) == 1) {
//        $sqlCancCat = "DELETE FROM `categorie` WHERE `idCategoria` = $catBlog";
//        $daCancellare = true;
//    }


// sql cancella blog
    $cancBlog = "DELETE FROM `blog` WHERE `idBlog` = $idBlog";

    if ($conn->query($cancBlog) === TRUE) {
        // se la query è andata a buon fine
    $cancCatVuota = "DELETE FROM categorie AS a 
Where a.idCategoria = ?
And not exists(
 Select 1
 From blog b
 Where b.categoria = a.idCategoria
)";
    $conn->query($cancCatVuota);
        $esito = '<br><div class="alert alert-success" role="alert"><p><strong>' . " Record cancellato" . '</strong></p></div>';
    } else {
        // se query fallita
        $esito = '<br><div class="alert alert-danger" role="alert"><p><strong>' . "Si è verificato un errore:" . $conn->error . '</strong></p></div>';
    }

    // close connection
    $conn->close();
}
?>
<div class="col-sm-3">
    <br>
    <?php echo $esito; ?>
    <a class="btn btn-outline-secondary btn-sm" href="gestione_blog.php?nomeUtente=<?php echo $nomeUtente; ?>">
        <i class="fa fa-arrow-left"></i>
        Torna ai blog
    </a>
</div>
