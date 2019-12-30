<?php

/**
 * La pagina visualizzazione blog permette di visualizzare un blog dell'utente loggato.
 * Mostra l'elenco di tutti i post al suo interno, con i relativi commenti.
 * Permette di aggiungere/rimuovere post e commenti.
 */
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');

$blog = $posts = $post = $followers = $segui = '';

//verifica la richiesta GET del parametro idBlog
if (isset($_GET['idBlog'])) {

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $idBlog = mysqli_real_escape_string($conn, $_GET['idBlog']);

// sql codice
    $sqlBlog = "SELECT * FROM blog WHERE idBlog = $idBlog";
    $sqlPost = "SELECT * FROM post WHERE idBlog = $idBlog";

//risultato query
    $risBlog = mysqli_query($conn, $sqlBlog);
    $risPost = mysqli_query($conn, $sqlPost);

//fetch risultato in un array
    $blog = mysqli_fetch_assoc($risBlog); // si usa assoc e non all perchè prendiamo solo una riga della tab risultato
    $posts = mysqli_fetch_all($risPost, MYSQLI_ASSOC);

//prendo dall'array associativo blog l'id della categoria associata, poi faccio la query che prende la categoria
    $idCategoriaBlog = $blog['categoria'];
    $sqlCategorie = "SELECT * FROM categorie WHERE idCategoria = $idCategoriaBlog";

    $risCateg = mysqli_query($conn, $sqlCategorie);
    $categoriaBlog = mysqli_fetch_assoc($risCateg);

//serve a "segui"
    $utenteSession = $_SESSION['nomeUtente'];
    $sqlFollower = "SELECT * FROM follower WHERE idUtente != '$utenteSession' AND idBlog = '$idBlog'";
    $risFollow = mysqli_query($conn, $sqlFollower);
    $followers = mysqli_fetch_all($risFollow);

    if (mysqli_num_rows($risFollow) === 1) {
        $segui = "Stai seguendo";
    } else{
        $segui = "Segui";
    }

    //chiudi connessione
    mysqli_close($conn);

    // debug
//    print_r($posts);
//    print_r($categoria);

} else {
    header("Location: ops.php");
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="Content-Language" content="it"/>

<?php
//includo file header
include 'head.php';
?>

<!-- banner -->
<div class="container-bg" style="background-image: url('<?php echo htmlspecialchars($blog['banner']) ?>');">
    <h1 class="text-capitalize display-3 text-center m-0"><?php echo htmlspecialchars($blog['titolo']); ?></h1>

    <!-- intestazione blog -->
    <div class="row">
        <div class="col s6 md3 text-center">
            <?php if ($blog): ?>
                <p class="lead display-5">Creato da: <?php echo htmlspecialchars($blog['autore']); ?></p>

                <p class="lead text-muted display-5">Ultima modifica
                    il: <?php echo date_format(new DateTime($blog['data']), 'd M Y H:i:s'); ?></p>
                <p class="lead text text-muted display-5">
                    Categoria: <?php echo htmlspecialchars($categoriaBlog['nome']); //prende nome categoria da tab categorie?></p>

                <p class="lead display-5"><?php echo htmlspecialchars($blog['descrizione']); ?></p>

            <?php else: ?>
            <?php endif; ?>
            <a class="segui btn btn-outline-primary btn-sm" href="*">
                <i class="fa fa-edit"></i>
                <?php echo $segui; ?>
                <!-- la visual cambia in base all'esito della query sul db "follower" -->
            </a>
            <div class="text-left">
                <a class="daNascondere btn btn-outline-secondary btn-sm" href="*">
                    <i class="fa fa-edit"></i>
                    Cambia sfondo banner
                </a>
                <!-- TODO implementare procedura cambio sfondo -->
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- mostra i post del blog dal db:-->
    <?php foreach ($posts as $post) { ?>
        <!-- riga intestazione post -->
        <div class="row py-2">
            <div class="col-sm-10">
                <h1 class="lead display-5 font-weight-bold"><?php echo htmlspecialchars($post['titolo']); ?></h1>
                <p class="text-muted"><?php echo htmlspecialchars($post['data']); ?></p>
            </div>
            <div class="col-sm-2 text-right">
                <a class="daNascondere btn btn-sm btn-danger fa fa-trash"
                   href="cancella_post.php?idPost=<?php echo $post['idPost'] ?>"></a>
                <!-- todo gestire delete post con jquery + ajax ! -->
            </div>
        </div>
        <!-- riga immagine descrizione e bottoni post -->
        <div class="row py-2">
            <div class="col-sm-6">
                <img class="img-fluid" alt="Immagine post" src="<?php echo htmlspecialchars($post['media']); ?>">
            </div>
            <div class="col-sm-6">
                <p><?php echo htmlspecialchars($post['testo']); ?></p>
            </div>
        </div>
    <?php } ?>

    <!--Card crea post-->
    <div class="daNascondere row py-2">
        <div class="col-sm-10">
            <h1 class="lead display-5 font-weight-bold">+ Crea un nuovo post</h1>
            <p class="text-muted">nuovo post</p>
        </div>
        <div class="col-sm-2">
            <a class="btn btn-outline-primary btn-lg" href="crea_post.php?idBlog=<?php echo $blog['idBlog']; ?>">
                <i class="fa fa-plus-circle"></i>
            </a>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<!-- nasconde tutti i bottoni blog(con la classe daNascondere) a chi non è loggato -->
<?php if (!isset($_SESSION['nomeUtente'])): ?>
    <script type="text/javascript">
        $('.daNascondere').hide();
        $('.segui').hide();
    </script>

<?php elseif ($_SESSION['nomeUtente'] !== $blog['autore']): ?>
    <!-- nasconde pulsanti di un blog di un utente diverso dal visualizzatore, ma mostrare segui -->
    <script type="text/javascript">
        $('.daNascondere').hide();
        $('.segui').show();
    </script>

<?php else: ?>
    <!-- se visualizzo uno dei miei blog vedo tutti i pulsanti tranne il segui -->
    <script type="text/javascript">
        $('.daNascondere').show();
        $('.segui').hide();
    </script>

<?php endif; ?>

</html>