<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');

$titolo = $data = $categoria = $descrizione = $banner = ''; //inizializzo le variabili vuote (altrimenti php dà errore quando le uso senza avere mai cliccato submit)
$errors = array('titolo' => '', 'categoria' => '', 'descrizione' => ''); //array associativo che immagazzina gli errori
print_r($errors);//TODO:SISTEMARE NON SALVA GLI ERRORIII

if (isset($_POST['crea_blog_submit'])) {
    //check titolo
    if (empty($_POST['titolo'])) {
        $errors['titolo'] = 'Manca un titolo per il tuo blog!';
    } else {
        $titolo = $_POST['titolo'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $titolo)) {
            $errors['titolo'] = 'Il titolo deve contenere solo lettere e spazi';
        }
    }

    //check categoria
    if (empty($_POST['categoria'])) {
        $errors['categoria'] = 'Manca una categoria per il tuo blog!';
    } else {
        $categoria = $_POST['categoria'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $categoria)) {
            $errors['categoria'] = 'Categoria deve contenere solo lettere e spazi';
        }
    }

    //check descrizione
    if (empty($_POST['descrizione'])) {
        $errors['descrizione'] = 'Manca una descrizione per il tuo blog!';
    } else {
        $descrizione = $_POST['descrizione'];
//        if (!preg_match('/^[a-zA-Z\s,]+$/', $descrizione)) { //sistemare espressione regolare per lettere, spazi e PUNTEGGIATURA
//            $errors['descrizione'] = 'la descrizione deve contenere solo lettere, spazi e virgole';
//        }
    }

    // check immagine
    $nomeBannerBlog = $_FILES['blog_banner']['name']; // salvo il nome dell'immagine uploadata
    $targetDir = "../img/";
    $targetFile = $targetDir . basename($_FILES['blog_banner']['name']);

    // debug
    echo "debug tommy: " . $targetFile;


    // get image file type
    $tipoImg = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // creo un array di stringhe nei quali scrivo i formati accettati di immagine
    $estensioniAccettate = array("jpg", "png", "jpeg");

    // controllo se l'estensione e' tra quelle accettate
    // in caso contrario creo un errore
    if (!in_array($tipoImg, $estensioniAccettate)) {
        $errors['banner'] = 'Il formato del banner selezionato non è accettato';
    }

    //retrieve timestamp
    $timestamp = date("Y-m-d H:i:s");

    if (array_filter($errors)) {
        //echo 'errori nel form';
    } else {

        //escape sql chars
        $titolo = mysqli_real_escape_string($conn, $_POST['titolo']);
        $autore = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']); //autore, aggiunto da me (non so se è giusto, deve recuperare l'user della sessione)
        $data = mysqli_real_escape_string($conn, $_POST['timestamp']);
        $descrizione = mysqli_real_escape_string($conn, $_POST['descrizione']);
        $categoria = mysqli_real_escape_string($conn, $_POST['categoria']);
        $banner = mysqli_real_escape_string($conn, $_POST['banner']);


        //tabella sql in cui inserire il dato
        $sql = "INSERT INTO blog (idBlog, titolo, autore, data, descrizione, categoria, banner) VALUES('NULL', '$titolo', '$autore', '$data', '$descrizione', '$categoria', '$banner')";

        //controlla e salva sul db
        if (mysqli_query($conn, $sql)) {
            //successo
            header('Location: gestione_blog.php');
        } else {
            //errore
            echo 'errore query: ' . mysqli_error($conn);
        }
    }

}
?>

<!DOCTYPE html>
<html lang="it">

<body>

<div class="container" style="padding-top: 18vh">
    <div class="row justify-content-center">
        <div class="col-8">

            <div class="card bg-light shadow">
                <div class="card-body">

                    <h4 class="card-title text-center">Crea un Blog</h4>

                    <form method="POST" action="crea_blog.php" enctype="multipart/form-data">

                        <div class="row">
                            <!-- titolo -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Titolo</label>
                                    <input type="text" required
                                           class="form-control"
                                           value="<?php echo htmlspecialchars($titolo) ?>"
                                           name="titolo">
                                    <!--  sopra ho "echo" le variabili vuote nei campi // htmlspecialchars() aggiunto per evitare script maligni-->
                                    <div class="invalid-feedback">
                                        <?php echo $errors['titolo']; ?>
                                        Please enter a message in the textarea.
                                    </div>
                                </div>
                            </div>

                            <!-- categoria -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Categoria:</label>
                                    <input type="text"
                                           class="form-control"
                                           value="<?php echo htmlspecialchars($categoria) ?>"
                                           name="categoria">
                                    <div class="form-text invalid-feedback">
                                        <?php echo $errors['categoria']; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- descrizione -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Descrizione:</label>
                                    <input type="text"
                                           class="form-control"
                                           value="<?php echo htmlspecialchars($descrizione) ?>"
                                           name="descrizione">
                                    <div class="invalid-feedback">
                                        <?php echo $errors['descrizione']; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- media(immagine o video) -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Carica immagine blog:</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="validatedCustomFile" required
                                               accept="image/png/jpg" name="blog_banner">
                                        <label class="custom-file-label" for="validatedCustomFile">Scegli
                                            file...</label>
                                        <div class="invalid-feedback">Esempio file non accettato</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group p-3">
                                <button type="submit"
                                        value="Crea"
                                        class="btn btn-secondary float-left"
                                        name="crea_blog_submit">
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

</body>
</html>