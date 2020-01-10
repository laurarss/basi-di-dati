<?php

/**
 * La pagina index è la prima pagina che compare a chiunque visiti il sito.
 * gli utenti sloggati vedranno l'elenco dei blog a sx e l'elenco delle categorie a dx.
 * per tutti è possibile visionare blog cercati per titolo o elencati per categoria.
 */

//connessione al db
include('db_connect.php');
//header & nav
include('header.php');

$nomeUtente = '';
if (isset($_SESSION['nomeUtente'])) {
    // recupero nome utente dalla sessione
    $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);
}

// sql blog
$sqlGetBlogData = "SELECT blog.idBlog, blog.titolo, blog.autore, categorie.nomeCategoria, blog.data, blog.descrizione, blog.categoria, blog.banner
FROM categorie , blog
WHERE  categorie.idCategoria = blog.categoria";
// sql categorie
$sqlCategorie = "SELECT * FROM `categorie`";

// righe risultato
$resultBlogData = mysqli_query($conn, $sqlGetBlogData);
$resultCategorie = mysqli_query($conn, $sqlCategorie);

// righe risultato "fetchate" in array
$blogs = mysqli_fetch_all($resultBlogData, MYSQLI_ASSOC);
$categorie = mysqli_fetch_all($resultCategorie, MYSQLI_ASSOC);

// libero memoria
mysqli_free_result($resultBlogData);
mysqli_free_result($resultCategorie);

// chiusura connessione al db
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="it">
<?php
//includo file header
include 'head.php';
?>
<body>
<div class="container">

    <!--alert grigio di benvenuto utente (solo se utente loggato)-->
    <?php if (!empty($nomeUtente)) : ?>

    <div id="benvenuto" class="alert alert-secondary col-sm-3" role="alert">
        <!--  apre gestione blog memorizzando il nomeUtente della sessione-->
        Benvenuto <strong><?php echo ucfirst($nomeUtente); ?></strong>
    </div>
    <?php endif; ?>

    <div class="row py-2">
        <div class="col-12">
            <h3 class="text-left grey-text">Esplora blog</h3>
        </div>
    </div>

    <div class="row py-2">

        <div class="col-10">

            <div class="row">
                <div class="col-3">
                    <a class="btn btn-sm btn-primary"
                       href="gestione_blog.php?nomeUtente=<?php if (!empty($nomeUtente)){ echo $nomeUtente; } ?>">
                        Gestisci i tuoi blog
                    </a>
                </div>


                <div class="col-9">
                    <!--form ricerca-->
                    <div class="form-inline my-2 my-lg-0 float-right">
                        <input id="titoloCercato"
                               name="titoloCercato"
                               type="text"
                               class="form-control mr-sm-2"
                               placeholder="Cerca blog per titolo..">
                    </div>
                </div>
            </div>

            <!-- lista dei blog -->
            <div class="row">
                <div class="col-12">
                    <div class="row" id="containerBlogs">

                        <?php foreach ($blogs as $blog) { ?>

                            <!-- assegno alla colonna di bootstrap l'id del blog come id del tag -->
                            <div id="<?php echo $blog['idBlog']; ?>" class="col-lg-4 py-3">
                                <div class="card card-bg text-white h-100 z-depth-0"
                                     style="background-image: url('<?php echo htmlspecialchars($blog['banner']) ?>');">
                                    <div class="card-header text-center h-50r">
                                        <?php echo ucfirst(htmlspecialchars($blog['titolo'])); ?>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-title">
                                            <small>Autore: </small><?php echo ucfirst(htmlspecialchars($blog['autore'])); ?>
                                        </h6>
                                        <small class="card-text">
                                            Categoria: <?php echo htmlspecialchars($blog['nomeCategoria']); ?></small>
                                        <div class="card-text"><?php echo htmlspecialchars($blog['descrizione']); ?></div>
                                        <!-- card commands row -->
                                        <div class="row py-2">
                                            <div class="col-12">
                                                <!--  passa il codice del blog(array che stiamo scorrendo col for) alla pagina visual_blog  -->
                                                <a class="btn btn-md btn-primary"
                                                   href="visual_blog.php?idBlog=<?php echo $blog['idBlog']; ?>">Apri</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>

        <!-- colonna delle categorie -->
        <div class="col-2">

            <h6 class="lead display-6">Categorie</h6>

            <ul id="listaCateg" class="list-group list-group-flush">
                <?php foreach ($categorie as $categoria) { ?>
                    <!-- assegno al li di bootstrap l'id della cateoria come id del tag -->
                    <a href="*" id="<?php echo $categoria['idCategoria']; ?>"
                       class="list-group-item"><?php echo ucwords(htmlspecialchars($categoria['nomeCategoria'])); ?></a>
                <?php } ?>
            </ul>

        </div>

    </div>
</div> <!-- fine container -->

<?php include('footer.php') ?>
</body>

<!-- script che fa scomparire msg di benvenuto dopo alcuni sec -->
<script type="text/javascript">
    setTimeout(fade_out, 3000);

    function fade_out() {
        $("#benvenuto").fadeOut().empty();
    }
</script>

<!-- ricerca blog per titolo jquery -->
<script type="text/javascript">

    // al caricamento dello script mi salvo la lista di blog caricata
    blogList = <?php echo json_encode($blogs) ?>;

    /**
     * Listener evento keyup su text box per ricerca blog per titolo
     * Lo usiamo per rimuove e aggiungere elementi html blog dal container di blog
     * in base al loro titolo
     */
    $(document).ready(function () {

        $('#titoloCercato').keyup(function () {

            // assegno ad una variabile il testo scritto nel box di ricerca
            const titoloCercato = $(this).val();

            // ciclo tutti i blog html che sono nel dom
            $('#containerBlogs').children().each(function () {
                // console.log('elemento div sul quale sto ciclando con la filter: ', this);
                // console.log('id elementi div sul quale sto ciclando:', this['id']);

                // assegno l'id del div del blog sul quale sto ciclando per usarlo dentro la find
                // senza questa variabile avrei avuto problemi di scope con la keyword this dentro la funzione find
                const idBlogDiv = this['id'];

                // recupero l'oggetto blog a partire dall'id del blog html sul quale sto ciclando
                const oggettoBlog = blogList.find(function (blog) {
                    return blog['idBlog'] === idBlogDiv;
                });

                // se il campo di ricerca e' vuoto mostro tutti i div dei blog
                if (!titoloCercato || titoloCercato.length === 0) {
                    this['hidden'] = false;
                } else if (oggettoBlog) { // in caso contrario controllo se il titolo del blog contiene la stringa cercata

                    // versione leggibile
                    if (oggettoBlog['titolo'].includes(titoloCercato)) {
                        this['hidden'] = false
                    } else {
                        this['hidden'] = true;
                    }

                    // versione ottimizzata per il codice
                    // this['hidden'] = !oggettoBlog['titolo'].includes(titoloCercato);
                }
            });

        });
    });

    //ricerca per categorie
    $(document).ready(function () {
        $('#listaCateg').on("click", "a", function (event) {

            // assegno ad una variabile la categoria cliccata
            const idCategCliccata = this['id'];

            // ciclo tutti i blog html che sono nel dom
            $('#containerBlogs').children().each(function () {
                // console.log('elemento div sul quale sto ciclando con la filter: ', this);
                // console.log('id elementi div sul quale sto ciclando:', this['id']);

                // assegno l'id del div del blog sul quale sto ciclando per usarlo dentro la find
                // senza questa variabile avrei avuto problemi di scope con la keyword "this" dentro la funzione "find"
                const idBlogDiv = this['id'];

                // recupero l'oggetto blog a partire dall'id della categoria cliccata
                const oggettoBlog = blogList.find(function (blog) {
                    return blog['categoria'] === idCategCliccata;
                });

                if (oggettoBlog) { // se oggettoBlog return true
                    this['hidden'] = false;
                } else {
                    this['hidden'] = true;
                }
            });

        });
    });
</script>

</html>