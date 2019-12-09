<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');

$titolo = $data = $categoria = $descrizione = $banner = ''; //inizializzo le variabili vuote (altrimenti php dà errore quando le uso senza avere mai cliccato submit)
$errors = array('titolo' => '', 'categoria' => '', 'descrizione' => ''); //array associativo che immagazzina gli errori

// mi prendo le categorie per i controlli sul form
$sqlCategorie = "SELECT * FROM categorie";
$risCategorie = mysqli_query($conn, $sqlCategorie);
$categorie = mysqli_fetch_all($risCategorie, MYSQLI_ASSOC);

echo "ecco le categorie già esistenti: ";
print_r($categorie);

if (isset($_POST['crea_blog_submit'])) {

    // check titolo
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
//        if (!preg_match('/^[a-zA-Z\s]+$/', $categoria)) { // la validazione con regex non va bene
//            $errors['categoria'] = 'Categoria deve contenere solo lettere e spazi';
//        }
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
        echo count($errors) . ' errori nel form';
        print_r($errors);
    } else {

        //escape sql chars
        $titolo = mysqli_real_escape_string($conn, $_POST['titolo']);
        $autore = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']); //autore, aggiunto da me (non so se è giusto, deve recuperare l'user della sessione)
        $data = $timestamp;
        $descrizione = mysqli_real_escape_string($conn, $_POST['descrizione']);
        $categoria = mysqli_real_escape_string($conn, $_POST['categoria']);
        $banner = $targetFile;

        //tabella sql in cui inserire il dato
        $sql = "INSERT INTO blog (idBlog, titolo, autore, data, descrizione, categoria, banner) VALUES('NULL', '$titolo', '$autore', '$data', '$descrizione', '$categoria', '$banner')";

        echo "query eseguita su database: " . $sql;

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

<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">

            <div class="card bg-light shadow">
                <div class="card-body">

                    <h4 class="card-title text-center">Crea un Blog</h4>

                    <form method="POST"
                          name="creaBlog"
                          action="crea_blog.php"
                          enctype="multipart/form-data"
                          novalidate>
                        <div class="form-row">
                            <!-- titolo -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="validation1">Titolo</label>
                                    <input type="text" required
                                           class="form-control"
                                           id="validation1"
                                           placeholder="Dai un titolo"
                                           value="<?php echo htmlspecialchars($titolo) ?>"
                                           name="titolo">
                                    <!--  sopra ho "echo" le variabili vuote nei campi // htmlspecialchars() aggiunto per evitare script maligni-->
                                    <div class="invalid-feedback">
                                        Titolo non corretto
                                    </div>
                                </div>
                            </div>

                            <!-- categoria -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="validation2">Categoria:</label>
                                    <input type="text"
                                           class="form-control"
                                           id="validation2"
                                           placeholder="Dai un nome alla categoria"
                                           value="<?php echo htmlspecialchars($categoria) ?>"
                                           name="categoria">
                                    <div class="form-text invalid-feedback">
                                        Categoria non corretta
                                    </div>
                                </div>
                            </div>

                            <!-- descrizione -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="validation3">Descrizione:</label>
                                    <input type="text"
                                           class="form-control"
                                           id="validation3"
                                           placeholder="Aggiungi una descrizione"
                                           value="<?php echo htmlspecialchars($descrizione) ?>"
                                           name="descrizione">
                                    <div class="invalid-feedback">
                                        Descrizione non corretta
                                    </div>
                                </div>
                            </div>

                            <!-- media(immagine o video) -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="validation4">Carica immagine blog:</label>
                                    <div class="custom-file">
                                        <input type="file"
                                               class="custom-file-input"
                                               id="validation4" required
                                               placeholder="Carica uno sfondo per il blog"
                                               value="<?php echo htmlspecialchars($banner) ?>"
                                               accept="image/png/jpg"
                                               name="blog_banner">
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

