<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');

//dichiaro variabili
$titoloPost = $dataPost = $testoPost = $imgPost = $idBlog = '';
$errors = array('titoloPost' => '', 'testoPost' => '', 'imgPost' => ''); //array associativo che immagazzina gli errori
// verifica la richiesta GET del parametro idBlog - entro qui solo la prima volta che visito questa pagina dal blog
if (isset($_GET['idBlog'])) {

    // id del blog in cui inserire il post
    $idBlog = mysqli_real_escape_string($conn, $_GET['idBlog']);

    // sql codice per recuperare titolo blog avendo l'id
    $sqlIdBlog = "SELECT idBlog, titolo FROM blog WHERE idBlog = $idBlog";

    //risultato query
    $risIdBlog = mysqli_query($conn, $sqlIdBlog);

    // fetch risultato in un array
    $blog = mysqli_fetch_assoc($risIdBlog); // si usa assoc e non all perchè prendiamo solo una riga della tab risultato

    $_SESSION['idBlog'] = $idBlog;
}

// azioni conseguenti a submit
if (isset($_POST['crea_post_submit'])) {

    $idBlog = $_SESSION['idBlog'];
    echo $_SESSION['idBlog'];

    // check titolo post
    if (empty($_POST['titoloPost'])) {
        $errors['titoloPost'] = 'Manca un titolo per il tuo post!<br>';
    } else {
        $titoloPost = $_POST['titoloPost'];
    }

    //check testo post
    if (empty($_POST['testoPost'])) {
        $errors['testoPost'] = 'Manca una descrizione per il tuo blog!<br>';
    } else {
        $testoPost = $_POST['testoPost'];
    }

    // check immagine
    $nomeImgPost = $_FILES['imgPost']['name']; // salvo il nome dell'immagine uploadata
    $targetDir = "../img/";
    $targetFile = $targetDir . basename($_FILES['imgPost']['name']);

    // recupero estensione dell'img caricata
    $tipoImg = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // creo un array di stringhe nei quali scrivo i formati accettati di immagine
    $estensioniAccettate = array("jpg", "png", "jpeg");

    // controllo se l'estensione e' tra quelle accettate
    // in caso contrario creo un errore
    if (!in_array($tipoImg, $estensioniAccettate)) {
        $errors['imgPost'] = 'Il formato del file selezionato non è accettato';
    }

    // copio il file dalla locazione temporanea alla mia cartella upload
    if (move_uploaded_file($nomeBannerBlog_tmp, $targetDir . $nomeBannerBlog)) {

        //Se buon fine...
        print " inviato con successo. Alcune informazioni:\n";
        print_r($_FILES);
    } else {

        //Se fallita...
        print "Upload NON valido! Alcune informazioni:\n";
        print_r($_FILES);
        print_r($_FILES['blog_banner']['error']);
        print_r($_FILES['blog_banner']['size']);
    }

    //retrieve timestamp
    $timestamp = date("Y-m-d H:i:s");

    if (array_filter($errors)) {
        //se ci sono errori
        print_r($errors);
    } else {

        //escape sql chars
        $titoloPost = mysqli_real_escape_string($conn, $_POST['titoloPost']);
        $dataPost = $timestamp;
        $testoPost = mysqli_real_escape_string($conn, $_POST['testoPost']);
        $imgPost = $targetFile;

        //query creazione post
        $sqlNuovoPost = "INSERT INTO `post` (`idPost`, `titolo`, `data`, `testo`, `media`, `idBlog`, `cont_like`) VALUES (NULL, '$titoloPost', '$dataPost', '$testoPost', '$imgPost', '$idBlog', NULL)";

        //controlla e salva sul db
        if (mysqli_query($conn, $sqlNuovoPost)) {
            // successo: passo id blog appena creato all'url della pagina visual_blog e lo apro(per permettere all'utente di creare subito un nuovo post)
            $idBlog = $_SESSION['idBlog'];
            header("Location: visual_blog.php?idBlog=$idBlog");
        } else {
            //errore
            echo 'errore query: ' . mysqli_error($conn);
        }
    }

    //libera memoria (su msqli_query)
    mysqli_free_result($risIdBlog);

    //chiudi connessione
    mysqli_close($conn);

}


?>
<!DOCTYPE html>
<html lang="it">
<?php
//includo file header
include 'head.php';
?>
<body>

<div class="container" style="padding-top: 18vh">

    <div class="row justify-content-center">

        <div class="col-12">
            <div class="col-sm-2 text-left navbar.fixed-top">
                <a class="btn btn-outline-secondary btn-sm" href="visual_blog.php?idBlog=<?php echo $blog['idBlog'] ?>">
                    <i class="fa fa-arrow-left"></i>
                    Torna al blog
                </a>
            </div>
        </div>

        <div class="card bg-light shadow">
            <div class="card-body">

                <h4 class="card-title text-center">Stai creando un post in "<?php echo $blog['titolo']; ?>"</h4>
                <!-- div mostra errori -->
                <div id="errore">
                    <?php ?>
                </div>

                <form enctype="multipart/form-data"
                      method="POST"
                      action="crea_post.php">

                    <div class="row">

                        <!-- titolo -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="titoloCreaPost">Titolo post:</label>
                                <input type="text" required
                                       class="form-control"
                                       id="titoloCreaPost"
                                       value="<?php echo htmlspecialchars($titoloPost) ?>"
                                       name="titoloPost">
                                <!-- sopra ho "echo" le variabili vuote nei campi // htmlspecialchars() aggiunto per evitare script maligni -->
                            </div>
                        </div>

                        <!-- testo -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="testoPost">Testo:</label>
                                <input type="text" required
                                       class="form-control"
                                       id="testoPost"
                                       value="<?php echo htmlspecialchars($testoPost); ?>"
                                       name="testoPost">
                                <div class="invalid-feedback">
                                    Testo post non valido
                                </div>
                            </div>
                        </div>

                        <!-- media(immagine o video) -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="fileInput">Carica immagine post:</label>
                                <div class="custom-file">
                                    <input type="file"
                                           class="custom-file-input"
                                           id="fileInput"
                                           required
                                           placeholder="Carica un'immagine per il post"
                                           value="<?php echo htmlspecialchars($imgPost) ?>"
                                           accept="image/png/jpg"
                                           name="imgPost">
                                    <label class="custom-file-label" for="validatedCustomFile">
                                        Scegli file...
                                    </label>
                                    <div class="invalid-feedback">Esempio file non accettato</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group p-3">
                            <button type="submit"
                                    value="Crea"
                                    class="btn btn-secondary float-right"
                                    name="crea_post_submit">
                                Crea
                            </button>
                        </div>

                    </div>
                </form>

            </div>

        </div>

    </div>
</div>
</div>

<?php include('footer.php'); ?>

<!--
     Script per far apparire il nome del file nel relativo input.
     L'input file di bootstrap 4 di default non permetteva di far vedere il nome quindi, come spiegato nella documentazione
     si usa il javascript per ovviare al problema.
-->
<script>
    $('#fileInput').on('change', function () {

        // estraggo il nome del file facendo una substring sul percorso completo del file caricato
        const filePath = $(this).val();
        const fileName = filePath.substr(filePath.lastIndexOf('\\') + 1);

        // rimpiazzo la scritta di default con il nome del file
        $(this).next('.custom-file-label').html(fileName);
    })
</script>

</body>
</html>