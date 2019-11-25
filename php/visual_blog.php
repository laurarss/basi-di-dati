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


//    print_r($posts);
//    print_r($categoria);
}
?>

<!DOCTYPE html>
<html lang="it">

<div class="container-bg">
    <div class="container-fluid">
        <h1 class="display-3 text-center mt-5 mb-5"><?php echo htmlspecialchars($blog['titolo']); ?></h1>
    </div>
</div>

<div class="container">
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
<!--    mostra i post del blog:-->
    <div class="container">
    <div class="row">
        <?php foreach ($posts as $post) { ?>

            <div class="container-post text-center h-75 d-inline-block">
                <h1 class="lead display-5"><?php echo htmlspecialchars($post['titolo']); ?></h1>
                <div class="row py-2">
                    <div class="col-12">
                        <p class="text-muted"><?php echo htmlspecialchars($post['data']); ?></p>
                        <img class="w-75 p-3" src="<?php echo htmlspecialchars($post['media']); ?>">
                        <p><?php echo htmlspecialchars($post['testo']); ?></p>
                    </div>
                </div>
                    <button class="btn btn-sm btn-danger">
                        Elimina
                    </button>
                    <!-- todo gestire delete blog con jquery + ajax ! -->
            </div>
        </div>
    </div>

    <?php } ?>
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
