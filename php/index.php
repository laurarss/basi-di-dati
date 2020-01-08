<!-- connessione al db e caricamento blog -->
<?php
include('db_connect.php');
//header & nav
include('header.php');

$nomeUtente = '';
if (isset($_SESSION['nomeUtente'])) {
    $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);
}

// write query
$sqlGetBlogData = "SELECT * FROM `blog`";

// get the result set (set of rows)
$resultBlogData = mysqli_query($conn, $sqlGetBlogData);

// fetch the resulting rows as an array
$blogs = mysqli_fetch_all($resultBlogData, MYSQLI_ASSOC);

// free the $result from memory (good practise)
mysqli_free_result($resultBlogData);

// close connection
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="it">
<?php
//includo file header
include 'head.php';
?>

<div class="container">
    <!--alert grigio di benvenuto utente -->
    <?php if (isset($nomeUtente)) : ?>
    <div id="benvenuto" class="alert alert-secondary col-sm-3" role="alert">
        <!--  apre gestione blog memorizzando il nomeUtente della sessione-->
        Benvenuto <strong><?php echo $nomeUtente; ?></strong>
    </div>
    <div class="row py-2">
        <div class="col-8">
            <a class="btn btn-sm btn-primary"
               href="gestione_blog.php?nomeUtente=<?php echo $nomeUtente; ?>">Gestisci i tuoi blog</a>
        </div>
        <?php endif ?>
        <!--form ricerca-->
        <div class="form-inline my-2 my-lg-0 col-4">
            <input id="titoloCercato" name="titoloCercato" type="text" class="form-control mr-sm-2"
                   placeholder="Cerca blog per titolo..">
        </div>
    </div>

    <div class="row" id="containerBlogs">

        <?php foreach ($blogs as $blog) { ?>

            <!-- assegno alla colonna di bootstrap l'id del blog come id del tag -->
            <div id="<?php echo $blog['idBlog']; ?>" class="col-sm-4 py-3">
                <div class="card h-100 z-depth-0">
                    <div class="card-header text-center">
                        <?php echo htmlspecialchars($blog['titolo']); ?>
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-title"> autore: <?php echo htmlspecialchars($blog['autore']); ?></h6>
                        <div class="card-text"><?php echo htmlspecialchars($blog['descrizione']); ?></div>
                        <!-- card commands row -->
                        <div class="row py-2">
                            <div class="col-12">
                                <!--  passa il codice del blog(array che stiamo scorrendo col for) alla pagina visual_blog  -->
                                <a class="btn btn-sm btn-primary"
                                   href="visual_blog.php?idBlog=<?php echo $blog['idBlog']; ?>">Apri</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div> <!-- fine container -->

<?php include('footer.php') ?>

<!-- script che fa scomparire msg di benvenuto dopo alcuni sec -->
<script type="text/javascript">
    setTimeout(fade_out, 3000);

    function fade_out() {
        $("#benvenuto").fadeOut().empty();
    }
</script>

<!-- ricerca blog per titolo jquery/ajax -->
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
            })

            // if (txt !== '') {
            //     $.ajax({
            //         url: "cerca_blog.php",
            //         method: "post",
            //         data: {search: txt},
            //         dataType: "text",
            //         success: function (data) {
            //             $('#titoliTrovati').html(data);
            //         }
            //     });
            // }
        });
    });
</script>

</html>