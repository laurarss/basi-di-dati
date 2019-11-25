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

    //prendo dall'array associativo blog l'id della categoria associata, poi faccio la query che prende la categoria
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

    // debug
//    print_r($posts);
//    print_r($categoria);
}
?>

<!DOCTYPE html>
<html lang="it">

<!-- banner -->
<div class="jumbotron jumbotron-fluid jumbotron-background">
    <div class="container">
        <h1 class="display-3 text-center m-0"><?php echo htmlspecialchars($blog['titolo']); ?></h1>
    </div>
</div>

<div class="container">

    <!-- intestazione blog -->
    <div class="row">
        <div class="col s6 md3 text-center">
            <?php if ($blog): ?>
                <p class="lead display-4">Creato da: <?php echo htmlspecialchars($blog['autore']); ?></p>
                <p class="lead text-muted display-5">Ultima modifica il: <?php echo date($blog['data']); ?></p>
                <p class="lead text text-muted display-5">
                    Categoria: <?php echo htmlspecialchars($categoriaBlog['nome']); //TODO prendere nome categoria da tab categorie?></p>

                <p class="lead"><?php echo htmlspecialchars($blog['descrizione']); ?></p>

            <?php else: ?>

            <?php endif; ?>
            <h1 class="lead display-4">Post:</h1>
        </div>
    </div>

    <!-- mostra i post del blog:-->

    <?php foreach ($posts

                   as $post) { ?>

        <!-- riga intestazione post -->
        <div class="row py-2">
            <div class="col-sm-12">
                <h1 class="lead display-5 font-weight-bold"><?php echo htmlspecialchars($post['titolo']); ?></h1>
                <p class="text-muted"><?php echo htmlspecialchars($post['data']); ?></p>
            </div>
        </div>

        <!-- riga immagine descrizione e bottoni post -->
        <div class="row py-2">

            <div class="col-sm-5">
                <img class="img-fluid" alt="Immagine post" src="<?php echo htmlspecialchars($post['media']); ?>">
            </div>

            <div class="col-sm-5">
                <p><?php echo htmlspecialchars($post['testo']); ?></p>
            </div>

            <div class="col-sm-2 text-right">
                <!-- todo gestire delete blog con jquery + ajax ! -->
                <button class="btn btn-sm btn-danger fa fa-trash">
                </button>
            </div>

        </div>

    <?php } ?>

</div>

<?php include('footer.php'); ?>

</html>
