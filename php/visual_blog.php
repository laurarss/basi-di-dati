<?php

/**
 * La pagina visualizzazione blog permette di visualizzare un blog dell'utente loggato.
 * Mostra l'elenco di tutti i post al suo interno, con i relativi commenti e i mi piace per ogni post.
 * Permette all'utente proprietario di aggiungere/rimuovere post.
 * Permette l'aggiunta di commenti e mi piace da parte di un qualsiasi utente loggato.
 */

// includo file connessione al db
include('db_connect.php');

// includo file header
include('header.php');

$blog = $posts = $followers = $like = $utenteSession = '';

if (isset($_SESSION['nomeUtente'])) {

    //verifica la richiesta GET del parametro idBlog
    if (isset($_GET['idBlog'])) {

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $idBlog = mysqli_real_escape_string($conn, $_GET['idBlog']);

        // sql codice
        $sqlBlog = "SELECT * FROM `blog` WHERE idBlog = $idBlog"; //dati blog
        $sqlPost = "SELECT * FROM `post` WHERE idBlog = $idBlog"; //elenco post
        $sqlCommenti = "SELECT * FROM `commenti` ORDER BY data DESC"; //commenti per post
        $sqlTemi = "SELECT * FROM `temi`"; //elenco temi

        // risultato righe query
        $risBlog = mysqli_query($conn, $sqlBlog);
        $risPost = mysqli_query($conn, $sqlPost);
        $risCommenti = mysqli_query($conn, $sqlCommenti);
        $risTemi = mysqli_query($conn, $sqlTemi); //ris temi

        // fetch righe risultato in un array
        $blog = mysqli_fetch_assoc($risBlog); // si usa assoc e non all perchè prendiamo solo una riga della tab risultato
        $posts = mysqli_fetch_all($risPost, MYSQLI_ASSOC);
        $commenti = mysqli_fetch_all($risCommenti, MYSQLI_ASSOC);
        $temi = mysqli_fetch_all($risTemi, MYSQLI_ASSOC);

        // prendo dall'array associativo blog l'id della categoria associata, poi faccio la query che prende la categoria
        $idCategoriaBlog = $blog['categoria'];
        $sqlCategorie = "SELECT * FROM categorie WHERE idCategoria = $idCategoriaBlog";

        $risCateg = mysqli_query($conn, $sqlCategorie);
        $categoriaBlog = mysqli_fetch_assoc($risCateg);

        // serve a pulsante "segui" e "mi piace"
        if (isset($_SESSION['nomeUtente'])) {
            $utenteSession = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);
        }

        // query per cercare nella tab follower l'utente attualmente loggato
        // la risposta sarà un array di un elemento, nel caso venga trovato, o vuoto in caso contrario
        $sqlFollower = "SELECT * FROM follower WHERE idBlog = '$idBlog' AND idUtente = '$utenteSession'";
        $risFollow = mysqli_query($conn, $sqlFollower);
        $followers = mysqli_fetch_all($risFollow, MYSQLI_ASSOC);

        // se trovo il record nel db follower
        if (mysqli_num_rows($risFollow) === 1 AND $followers[0]['idUtente'] == $utenteSession) {
            $segui = '<a class="btn btn-primary btn-sm" id="following" value="following"><i class="fa fa-rss-square"></i>' . " Stai seguendo" . '</a>';
        } else {
            $segui = '<a class="btn btn-outline-primary btn-sm" id="follow" value="follow"><i class="fa fa-rss"></i>' . " Segui" . '</a>';
        }

        /** GESTIONE MI PIACE **/

        //se e' stato premuto un tasto like/dislike su un qualsiasi post
        if (isset($_POST['likeButtonIdPost'])) { // controllo se la POST è stata mandata alla pagina e ha un campo like

            $idPost = $_POST['likeButtonIdPost']; // prendiamo l'idPost inerente al post sul quale abbiamo cliccato like/dislike
            $isPostLiked = $_POST['likeButtonIsPostLiked']; // prendiamo lo stato del post -> true se c'e' gia' mi piace, false altrimenti

            if ($isPostLiked == true) { // se il post ha gia' il mi piace...

                $sqlDecrementLikeCounter = "UPDATE post SET cont_like = cont_like - 1 WHERE idPost = '$idPost'";
                $risDecrementLikeCounter = mysqli_query($conn, $sqlDecrementLikeCounter);

                $sqlRemoveMiPiace = "DELETE FROM mipiace WHERE idPost= '$idPost' AND idUtente = '$utenteSession'";
                $risRemoveMiPiace = mysqli_query($conn, $sqlRemoveMiPiace);
            } else { // se il post non ha il mi piace...

                $sqlUpdateLikeCounter = "UPDATE post SET cont_like = cont_like + 1 WHERE idPost = '$idPost'";
                $risUpdateLikeCounter = mysqli_query($conn, $sqlUpdateLikeCounter);

                $sqlAddMiPiace = "INSERT INTO mipiace (idLike, idPost, idUtente) VALUES (NULL, '$idPost', '$utenteSession')";
                $risAddMiPiace = mysqli_query($conn, $sqlAddMiPiace);
            }
        }
    }
} else {
    header("Location: ops.php");
}
?>

<!DOCTYPE html>

<!-- Link css custom personalizz blog -->
<link id="theme" href="../css/temi_blog/<?php echo $blog['tema']; ?>.css" rel="stylesheet" type="text/css"/>

<body xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it" class="user-bg user-text user-font">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="Content-Language" content="it"/>

<?php
//includo file header
include 'head.php';
?>

<!-- banner -->
<div class="container-bg" style="background-image: url('<?php echo htmlspecialchars($blog['banner']) ?>');">
    <div class="blackHover">
        <h1 class="text-capitalize display-3 text-center m-0"><?php echo htmlspecialchars($blog['titolo']); ?></h1>

        <!-- intestazione blog -->
        <div class="row">
            <div class="col s6 md3 text-center">
                <?php if ($blog): ?>

                    <p class="lead display-5">
                        Creato da: <?php echo htmlspecialchars($blog['autore']); ?>
                    </p>
                    <p class="lead display-5">
                        Ultima modifica il: <?php echo date_format(new DateTime($blog['data']), 'd M Y H:i:s'); ?>
                    </p>
                    <p class="lead text display-5">
                        Categoria: <?php echo ucwords(htmlspecialchars($categoriaBlog['nomeCategoria'])); //prende nome categoria da tab categorie?>
                    </p>
                    <p class="lead display-5">
                        <?php echo ucfirst(htmlspecialchars($blog['descrizione'])); ?>
                    </p>

                <?php endif; ?>

                <!-- pulsante segui -->
                <!-- la visual cambia in base all'esito della query sul db "follower" -->
                <div class="row">
                    <div class="segui col-12 text-center">
                        <?php echo $segui; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-left">
                        <!-- implementata procedura cambio sfondo con nuova pag php -->
                        <a class="daNascondere btn btn-outline-secondary btn-sm"
                           href="cambio_banner.php?idBlog=<?php echo $blog['idBlog']; ?>">
                            <i class="fa fa-edit"></i>
                            Cambia sfondo banner
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="container py-2">

    <!-- scelta tema -->
    <form class="form-inline">

        <p>Cambia tema:</p>

        <div class="form-row align-items-center">

            <label class="sr-only" for="selezTema">Scegli tema blog:</label>

            <select id="selezTema" data-id-blog="<?php echo $idBlog ?>"
                    class="form-control form-control-md mb-2 mx-sm-2">
                <?php foreach ($temi as $nomeTema) { ?>
                    <option <?php if ($blog['tema'] === $nomeTema['nomeTema']) echo 'selected' ?>
                            value="<?php echo htmlspecialchars($nomeTema['nomeTema']); ?>">
                        <?php echo htmlspecialchars($nomeTema['nomeTema']); ?>
                    </option>
                <?php } ?>
            </select>

            <button id="changeTheme" type="button" class="btn btn-primary btn-sm mb-2">
                Applica
            </button>
        </div>

    </form>

    <!-- messaggio assenza post -->
    <?php if (!$posts): ?>
        <div class="lead text-center">
            <?php echo "Non ci sono post"; ?>
        </div>
    <?php else: ?>
    <?php endif; ?>

    <!-- mostra i post del blog dal db -->
    <?php foreach ($posts as $post) { ?>

        <?php

        // recupero id post
        $idPost = $post['idPost'];

        // query per cercare nella tabella dei mi piace l'utente attualmente loggato
        // il risultato sara' necessario per aggiornare il tasto di mi piace al caricamento della pagina
        $sqlMiPiace = "SELECT * FROM mipiace WHERE idPost = '$idPost' AND idUtente = '$utenteSession'";
        $risMiPiace = mysqli_query($conn, $sqlMiPiace);
        $miPiace = mysqli_fetch_assoc($risMiPiace);

        ?>

        <!-- container del post: necessario per rimozione asicrona tramite ajax post request -->
        <div class="post-container" data-id-post="<?php echo $idPost ?>">

            <div class="row py-2">

                <!-- intestazione post -->
                <div class="col-sm-10">
                    <h1 class="lead display-5 font-weight-bold"><?php echo htmlspecialchars($post['titolo']); ?></h1>
                    <small class="text-muted"><?php echo date_format(new DateTime($post['data']), 'd M Y H:i:s'); ?></small>
                </div>

                <!-- bottone delete post -->
                <div class="col-sm-2 text-right">
                    <button class="delete-post-button daNascondere btn btn-sm btn-danger fa fa-trash"
                            data-id-post="<?php echo $idPost ?>"
                            type="button">
                    </button>
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

            <div class="text-right">
                <!-- pulsante mi piace -->
                <!-- la visual cambia in base all'esito della query sul db "mipiace" -->
                <div class="col-12 py-2">

                    <button class="like-button btn btn-md btn-outline-primary"
                            data-id-post="<?php echo $post['idPost']; ?>"
                            data-is-liked="<?php echo isset($miPiace) ?>"
                            data-cont-like="<?php echo $post['cont_like']; ?>">

                        <span class="cont_like py-3 px-2 text-primary">
                            <?php if ($miPiace !== null) { ?>
                                <i class="px-1 fas fa-thumbs-down"></i>
                            <?php } else { ?>
                                <i class="px-1 fas fa-thumbs-up"></i>
                            <?php } ?>
                            Mi piace
                            <!-- numero di like da tab post-->
                            (<?php echo $post['cont_like']; ?>)
                        </span>

                    </button>

                </div>
            </div>

            <!-- commenti -->
            <?php foreach ($commenti as $commento) {
                if ($commento['idPost'] === $post['idPost']) { ?>

                    <div class="row py-2 pl-5">

                        <div class="col-1 pt-4"><i class="far fa-comment-alt fa-2x"></i></div>

                        <div class="col-10">
                            <h6><?php echo htmlspecialchars($commento['autore']); ?></h6>
                            <small class="text-muted"><?php echo date_format(new DateTime($commento['data']), 'd M Y H:i:s'); ?></small>
                            <p><?php echo htmlspecialchars($commento['nota']); ?></p>
                        </div>

                        <div class="col-sm-1 text-right">
                            <a class="btn btn-sm btn-danger fa fa-trash"
                               href="canc_commento.php?idCommento=<?php echo $commento['idCommento']; ?>&idBlog=<?php echo $blog['idBlog']; ?>"></a>
                        </div>

                    </div>
                <?php } ?>
            <?php } ?>

            <!-- Card crea commento -->
            <form enctype="multipart/form-data"
                  class="formCreaCommento"
                  method="POST"
                  action="inser_commento.php?idPost=<?php echo $post['idPost'] ?>&idBlog=<?php echo $blog['idBlog'] ?>">

                <div class="row pl-5">
                    <h5 class="display-5">+ aggiungi un commento:</h5>
                </div>

                <div class="row py-2 pl-md-5 text-center">

                    <div class="col-sm-1 pt-4 pb-2">
                        <i class="fas fa-comment-alt fa-2x"></i>
                    </div>

                    <div class="col-sm-9">
                        <label class="sr-only" for="commentoFormInput">Nuovo Commento</label>
                        <textarea name="nuovoCommentoTextarea"
                                  class="form-control mb-2 mr-sm-2 nuovoCommentoTextarea user-bg user-text"
                                  rows="2"
                                  placeholder="Scrivi un commento">
                    </textarea>
                    </div>

                    <div class="col-sm-2">
                        <button name="crea_commento" type="submit"
                                class="btn btn-outline-primary btn-lg mb-2 crea_commento"
                                href="crea_post.php?idPost=<?php echo $post['idPost']; ?>">
                            <i class="fa fa-plus-circle"></i>
                        </button>
                    </div>

                </div>
            </form>

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
        $('.formCreaCommento').hide();//nasconde crea commenti ai non loggati
        $('.like-button').hide(); //nasconde pulsante mi piace ai non loggati
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

<script type="text/javascript">

    $(function () {

        /**
         * DELETE POST
         */
        $('.delete-post-button').on('click', function () {

            const idPost = $(this).data('id-post');

            $.ajax({
                type: "POST",
                url: "cancella_post.php",
                data: {idPost: idPost},
                dataType: 'text',
                success: function (response) {

                    // se la delete del post e' andata a buon fine mi ritorna una stringa true/false
                    if (response === 'true') {

                        // ciclo tutti i container di post e se trovo quello interessato rimuovo il post dal DOM
                        $('.post-container').each(function () {

                            const tempIdPost = $(this).data('id-post');

                            if (idPost === tempIdPost) {
                                $(this).remove();
                                return false;
                            }
                        })
                    } else {
                        console.error('Errore: eliminazione post fallita!');
                    }
                }
            })
        });

        /**
         * SEGUI
         * se il pulsante ha id "follow" NON sto seguendo e devo aggiungere il record dal db
         */
        $('#follow').on('click', function () {

            $.ajax({
                type: "POST",
                url: "crea_follower.php?idBlog=<?php echo $blog['idBlog'] ?>",
                dataType: "html",
                success: function (response) {
                    $(".segui").html(response);
                }
            });
        });

        /**
         * NON SEGUIRE PIU'
         * se il pulsante ha id "following" sto già seguendo e devo rimuovere il record dal db
         */
        $('#following').on('click', function () {
            $.ajax({
                type: "POST",
                url: "cancella_follower.php?idBlog=<?php echo $blog['idBlog'] ?>",
                dataType: "html",
                success: function (response) {
                    $(".segui").html(response);
                }
            });
        });

        /**
         * MI PIACE
         */
        $(".like-button").on('click', function () {

            const button = $(this); // elemento html corrispondente al bottone
            const idPost = $(button).data('id-post');
            const isPostLiked = $(button).data('is-liked');

            $.post(
                "visual_blog.php?idBlog=<?php echo $blog['idBlog'] ?>",
                {
                    // parametri che sto per salvare nella costante post di php
                    likeButtonIdPost: idPost,
                    likeButtonIsPostLiked: isPostLiked,
                },
                (data, status) => {

                    // dato che la pagina non ricarica a causa della chiamata asincrona,
                    // aggiorno i dati dell'elemento html relativo al like button con data(chiave_valore, nuovo_valore)

                    if (isPostLiked === 1) {
                        $(button).html("<i class=\"px-1 fas fa-thumbs-up\"></i>Mi piace (" + ($(button).data('cont-like') - 1) + ")");
                        $(button).data('cont-like', $(button).data('cont-like') - 1); // aggiorno cont like
                        $(button).data('is-liked', '');// aggiorno is-liked
                    } else {
                        $(button).html("<i class=\"px-1 fas fa-thumbs-down\"></i>Non mi piace più (" + ($(button).data('cont-like') + 1) + ")");
                        $(button).data('cont-like', $(button).data('cont-like') + 1);
                        $(button).data('is-liked', 1); // aggiorno is-liked
                    }
                }
            )
        });

        /**
         * AGGIUNGI COMMENTO
         */
        $('#crea_commento').on('click', function () {

            const testoCommento = $("#nuovoCommentoTextarea").serialize();

            $.post({
                data: testoCommento,
                url: "inser_commento.php?idPost=<?php echo $post['idPost'] ?>",
                dataType: "text",
                success: function () {
                    location.reload();
                }
            });
        });

        /**
         * CAMBIO TEMA
         */
        $('#changeTheme').on('click', function () {

            // prendo il nome del tema, che per definizione corrisponde a quello del file css da impostare
            const themeName = $("#selezTema option:selected").val();
            const idBlog = $("#selezTema").data('id-blog');

            $.ajax({
                type: "POST",
                url: "cambia_tema.php",
                data: {
                    idBlog: idBlog,
                    selectedTheme: themeName,
                },
                dataType: "text",
                success: function (response) {
                    $('#theme').attr('href', '../css/temi_blog/' + response + '.css');
                }
            });
        });
    });
</script>

</body>
