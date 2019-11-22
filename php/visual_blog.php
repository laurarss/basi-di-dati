<?php
//header( "Location: visual_blog.php? blog = $blog" );
/**
 * La pagina visualizzazione blog permette di visualizzare un blog dell'utente loggato.
 * Mostra l'elenco di tutti i post al suo interno, con i relativi commenti.
 * Permette di aggiungere/rimuovere post e commenti.
 */

include('db_connect.php');
include('header.php');

//verifica la richiesta GET del parametro idBlog
if (isset($_GET['idBlog'])) {

    $idBlog = mysqli_real_escape_string($conn, $_GET['idBlog']);

    // sql codice
    $sqlBlog = "SELECT * FROM blog WHERE idBlog = $idBlog";
    $sqlPost = "SELECT * FROM post WHERE idBlog = $idBlog";

    //risultato query
    $risBlog = mysqli_query($conn, $sqlBlog);
    $risPost = mysqli_query($conn, $sqlPost);

    //fetch risultato in un array
    $blog = mysqli_fetch_assoc($risBlog); //si usa assoc e non all perchè prendiamo solo una riga della tab risultato
    $posts = mysqli_fetch_all($risPost, MYSQLI_ASSOC);

    // prendo dall'array associativo blog l'id della categoria associata, poi faccio la query che prende la categoria
    $idCategoriaBlog = $blog['categoria'];
    $sqlCategorie = "SELECT * FROM categorie WHERE codice = $idCategoriaBlog";
    $risCateg = mysqli_query($conn, $sqlCategorie);
    $categoriaBlog = mysqli_fetch_assoc($risCateg);

    //libera memoria
    mysqli_free_result($risBlog);
    mysqli_free_result($risPost);
    mysqli_free_result($risCateg);

    //chiudi connessione
    mysqli_close($conn);

//    print_r($blog);
//    print_r($posts);
//    print_r($categoria);
}
?>

<!DOCTYPE html>
<html lang="it">

<h4 class="text-center grey-text">Tutti i Blog!</h4>

<div class="container">
    <div class="row">
        <div class="col s6 md3">
            <?php if ($blog): ?>
                <h4><?php echo htmlspecialchars($blog['titolo']); ?></h4>
                <p>Creato da: <?php echo htmlspecialchars($blog['autore']); ?></p>
                <p><?php echo date($blog['data']); ?></p>
                <p><?php echo htmlspecialchars($blog['descrizione']); ?></p>
                <p><?php echo htmlspecialchars($categoriaBlog['nome']); //TODO prendere nome categoria da tab categorie?></p>
                <h5>Post:</h5>
                <?php //TODO bisogna scorrere i post relativi al blog e mostrarli?>

            <?php else: ?>

            <?php endif; ?>
        </div>
    </div>

    <!--        --><?php //foreach ($blogs as $blog) { ?>
    <!---->
    <!--            <div class="col s6 md3">-->
    <!--                <div class="card z-depth-0">-->
    <!--                    <div class="card-body text-center">-->
    <!--                        <h6 class="card-title">--><?php //echo htmlspecialchars($blog['titolo']); ?><!--</h6>-->
    <!--                        <div class="card-text">-->
    <?php //echo htmlspecialchars($blog['descrizione']); ?><!--</div>-->
    <!--                        <a class="card-link" href="visual_blog.php? blog = $blog">more info</a>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!---->
    <!--        --><?php //} ?>
</div>

<?php include('footer.php'); ?>

</html>
