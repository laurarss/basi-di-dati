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
    $sqlGetBlogData = "SELECT blog.idBlog, blog.titolo, blog.autore, categorie.idCategoria, categorie.nomeCategoria, blog.data, blog.descrizione, blog.categoria, blog.banner
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
<div class="container py-3">

    <?php if (count($blogs) > 0) { ?>

        <div class="row py-2">

            <div class="col-10">

                <div class="row">
                    <div class="col-3">
                        <h3 class="text-left grey-text">Esplora blog</h3>
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
                                <div id="<?php echo $blog['idBlog']; ?>" class="blog col-lg-4 py-3">
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

                    <li id="allCategorie" class="list-group-item">Tutte</li>

                    <?php foreach ($categorie as $categoria) { ?>
                        <!-- assegno al li di bootstrap l'id della cateoria come id del tag -->
                        <li style="cursor: pointer"
                            id="<?php echo $categoria['idCategoria']; ?>"
                            class="list-group-item"><?php echo ucwords(htmlspecialchars($categoria['nomeCategoria'])); ?>
                        </li>
                    <?php } ?>
                </ul>

            </div>

        </div>

    <?php } else { ?>

        <div class="row d-flex h-75 py-2">
            <div class="col-12 justify-content-center align-self-center text-center">
                <h1>Ancora nessun blog presente</h1>
                <p>
                    Benvenuto! Sembra che non sia stato creato nessun blog, per il momento.
                    <br>
                    <?php if(empty($nomeUtente)) {?> Registrati ed esegui l'accesso se vuoi creare un tuo blog! <?php } ?>
                </p>
            </div>
        </div>

    <?php } ?>

</div> <!-- fine container -->

<?php include('footer.php') ?>
</body>

<!-- ricerca blog per titolo jquery -->
<script type="text/javascript">

    // al caricamento dello script mi salvo la lista di blog caricata
    blogList = <?php echo json_encode($blogs) ?>;

    /**
     * Listener evento keyup su text box per ricerca blog per titolo
     * Lo usiamo per rimuovere e aggiungere elementi html blog dal container di blog
     * in base al loro titolo
     */
    $(document).ready(function () {

        $('#titoloCercato').keyup(function () {

            // assegno ad una variabile il testo scritto nel box di ricerca
            const titoloCercato = $(this).val().toLowerCase();

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
                    if (oggettoBlog['titolo'].toLowerCase().includes(titoloCercato)) {
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

    // ricerca per categorie
    /**
     * Funziona in modo simile a ricerca per titolo, ma prende l'id della categoria in base al pulsante
     * cliccato, poi mette "hidden" tutti gli elem blog che non sono di quella categoria.
     */
    $(document).ready(function () {
        $('#listaCateg').on("click", "li", function (event) {

            if (this['id'] === 'allCategorie') {

                $('#containerBlogs').children().each(function () {
                    this['hidden'] = false;
                });

                return;
            }

            // assegno ad una variabile id della categoria cliccata
            const idCategCliccata = this['id'];

            // ciclo tutti i blog html che sono nel dom
            $('#containerBlogs').children().each(function () {
                // assegno l'id del div del blog sul quale sto ciclando per usarlo dentro la find
                // senza questa variabile avrei avuto problemi di scope con la keyword "this" dentro la funzione "find"
                const idBlogDiv = this['id'];

                // recupero l'oggetto blog a partire dall'id della categoria cliccata
                const oggettoBlog = blogList.find(function (blog) {
                    return idBlogDiv === blog['idBlog'];
                });

                if (oggettoBlog) { // se oggettoBlog return true

                    if (oggettoBlog['idCategoria'] === idCategCliccata) {
                        this['hidden'] = false;
                    } else {
                        this['hidden'] = true;
                    }

                } else {
                    console.error('Errore durante il filtro per categorie');
                }
            });

            // controllo se tutti i blog sono nascosti
            // creo la variabile areAllBlogHidden dando per assunto che siano tutti nascosti
            // poi ciclo i div dei blog: se ne trovo uno non nascosto invalido la variabile di controllo e interrompo il ciclo
            let areAllBlogHidden = true;
            $('#containerBlogs').children(".blog").each(function () {
                if (this['hidden'] === false) {
                    areAllBlogHidden = false;
                    return;
                }
            });

            // se tutti i blog sono nascosti aggiungo un messaggio al container dei blog
            if (areAllBlogHidden) {
                $('#containerBlogs').children().remove('h1'); // rimuovo il precedente, se no si duplica se clicco categorie vuote una dopo l'altra
                $('#containerBlogs').append("<h1 class=\"col-12 text-center \">Nessun blog presente</h1>");

            } else {
                $('#containerBlogs').children().remove('h1'); // rimuove il messaggio nel caso fosse stato inserito
            }
        });
    });
</script>

</html>
