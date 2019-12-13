<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');

$titolo = $data = $categoria = $descrizione = $banner = $successMess = ''; //inizializzo le variabili vuote (altrimenti php dà errore quando le uso senza avere mai cliccato submit)
$errors = array('titolo' => '', 'categoria' => '', 'descrizione' => ''); //array associativo che immagazzina gli errori

// mi prendo le categorie per i controlli sul form
$sqlCategorie = "SELECT * FROM categorie";
$risCategorie = mysqli_query($conn, $sqlCategorie);
$categorie = mysqli_fetch_all($risCategorie, MYSQLI_ASSOC);



if (isset($_POST['crea_blog_submit'])) {

    // check titolo
    if (empty($_POST['titolo'])) {
        $errors['titolo'] = 'Manca un titolo per il tuo blog!<br>';
    } else {
        $titolo = $_POST['titolo'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $titolo)) {
            $errors['titolo'] = 'Il titolo deve contenere solo lettere e spazi<br>';
        }
    }

    //check categoria
    if (empty($_POST['categoria'])) {
        $errors['categoria'] = 'Manca una categoria per il tuo blog!<br>';
    } else {

        /**
         * controllare che la categ inserita dall'utente non esista già(facendo lowercase)
         * se categ esiste già allora assegno a $categoria l'id della categ già persistita
         * se categ non esiste crearla con relativa insert, e prenderne l'id
         */

        $nome_categoria = $_POST['categoria']; // variabili di utility per nome categoria inserito da utente

        if (!preg_match('/^[a-zA-Z\s]+$/', $categoria)) { // la validazione con regex non va bene
            $errors['categoria'] = 'Categoria deve contenere solo lettere e spazi<br>';
        }

        $trovato = $i = 0;
        while ($i < sizeof($categorie) and !$trovato) {
            if (strtolower($nome_categoria) === $categorie[$i]['nome']) {
                $categoria = $categorie[$i]['idCategoria'];
                $trovato = 1;
            }
            $i = $i + 1;
        }

        if (!$trovato && empty($errors)) {
            $sqlInserisciCateg = "INSERT INTO categorie (idCategoria, nome) VALUES('NULL', '$nome_categoria')";

            if (mysqli_query($conn, $sqlInserisciCateg)) {
                $categoria = mysqli_insert_id($conn);
            } else {
                echo "Inserimento fallito per la nuova categoria";
            }
            echo "ID della nuova categoria: " . $categoria;
        }
    }

    //check descrizione
    if (empty($_POST['descrizione'])) {
        $errors['descrizione'] = 'Manca una descrizione per il tuo blog!<br>';
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
        //se ci sono errori
    } else {

        //escape sql chars
        $titolo = mysqli_real_escape_string($conn, $_POST['titolo']);
        $autore = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']); //autore, aggiunto da me (non so se è giusto, deve recuperare l'user della sessione)
        $data = $timestamp;
        $descrizione = mysqli_real_escape_string($conn, $_POST['descrizione']);
        $banner = $targetFile;

        //tabella sql in cui inserire il dato
        $sql = "INSERT INTO blog (idBlog, titolo, autore, data, descrizione, categoria, banner) VALUES('NULL', '$titolo', '$autore', '$data', '$descrizione', '$categoria', '$banner')";

        //controlla e salva sul db
        if (mysqli_query($conn, $sql)) {
            //successo
            $successMess = '<div class="alert alert-success" role="alert"><p><strong>Blog inserito! Torna ai <a href="gestione_blog.php">Blog</a> </strong></p></div>';
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
                    <!-- div che fa comparire errori trovati dal js con l'id e dal php -->
                    <div id="errore">
                        <?php echo $successMess?><? foreach ($errors as $value) {echo "$value\r\n";} ?>
                    </div>

                    <form method="POST"
                          name="creaBlog"
                          action="crea_blog.php"
                          enctype="multipart/form-data"
                          novalidate>
                        <div class="form-row">
                            <!-- titolo -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="titoloCreaBlog">Titolo</label>
                                    <input type="text" required
                                           class="form-control"
                                           id="titoloCreaBlog"
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
                                    <label for="categoriaCreaBlog">Categoria:</label>
                                    <input type="text"
                                           class="form-control"
                                           id="categoriaCreaBlog"
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
                                    <label for="descrizioneCreaBlog">Descrizione:</label>
                                    <input type="text"
                                           class="form-control"
                                           id="descrizioneCreaBlog"
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
                                    <label for="fileInput">Carica immagine blog:</label>
                                    <div class="custom-file">
                                        <input type="file"
                                               class="custom-file-input"
                                               id="fileInput"
                                               required
                                               placeholder="Carica uno sfondo per il blog"
                                               value="<?php echo htmlspecialchars($banner) ?>"
                                               accept="image/png/jpg"
                                               name="blog_banner">
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
                                        class="btn btn-secondary float-left"
                                        name="crea_blog_submit">
                                    Crea
                                </button>
                            </div>

                        </div>

                    </form>

                    <script type="text/javascript">
                        $("form").submit(function (event) {
                            event.preventDefault();//fa in modo che il form non si refreshi al "submit" ma mi permetta di validare i dati prima di mandarli al server

                            let errore = "";

                            if ($("#titoloCreaBlog").val() === "") { //se il campo è vuoto
                                errore += "Il è titolo obbligatorio.<br>";
                            }
                            if ($("#categoriaCreaBlog").val() === "") { //se il campo è vuoto
                                errore += "La categoria è obbligatoria.<br>";
                            }
                            if ($("#descrizioneCreaBlog").val() === "") { //se il campo è vuoto
                                errore += "Non hai inserito una descrizione.<br>";
                            }

                            if (errore !== "") {
                                $("#errore").html('<div class="alert alert-danger" role="alert"><p><strong>Nel form sono stati trovati i seguenti errori:</strong></p>' + errore + '</div>');
                            } else {
                                $("form").unbind('submit').submit();
                            }
                        });
                    </script>


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

