<?php
//includo file connessione al db
include('db_connect.php');
//includo php header
include('header.php');

$titolo = $autore = $data = $id_categoria = $descrizione = $banner = $idBlog = $tema = ''; //inizializzo le variabili vuote (altrimenti php dà errore quando le uso senza avere mai cliccato submit)
$errors = array('titolo' => '', 'categoria' => '', 'descrizione' => '', 'banner' => ''); //array associativo che immagazzina gli errori

// mi prendo le categorie per i controlli sul form
$sqlCategorie = "SELECT * FROM categorie";
$risCategorie = mysqli_query($conn, $sqlCategorie);
$categorie = mysqli_fetch_all($risCategorie, MYSQLI_ASSOC);

//recupero elenco temi
$sqlTemi = "SELECT * FROM `temi`"; //elenco temi
$risTemi = mysqli_query($conn, $sqlTemi); //ris temi
$temi = mysqli_fetch_all($risTemi, MYSQLI_ASSOC);

if (isset($_POST['crea_blog_submit'])) {

    // check titolo blog
    if (empty($_POST['titolo'])) {
        $errors['titolo'] = 'Manca un titolo per il tuo blog!<br>';
    } else {
        $titolo = $_POST['titolo'];
        if (!preg_match('/^[a-z][a-z\s]*$/', $titolo)) {
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
        if (!preg_match('/^\p{Latin}+$/', $nome_categoria)) {
            $errors['categoria'] = 'Categoria deve contenere solo lettere e spazi<br>';
        }

        $trovato = $i = 0;
        while ($i < sizeof($categorie) and !$trovato) {
            if (strtolower($nome_categoria) === strtolower($categorie[$i]['nomeCategoria'])) {
                $id_categoria = $categorie[$i]['idCategoria'];
                $trovato = 1;
            }
            $i = $i + 1;
        }

        if (!$trovato) {
            $sqlInserisciCateg = "INSERT INTO categorie (idCategoria, nomeCategoria) VALUES('NULL', '$nome_categoria')";

            if (mysqli_query($conn, $sqlInserisciCateg)) {
                $id_categoria = mysqli_insert_id($conn);
            } else {
                echo "Inserimento fallito per la nuova categoria";
            }
        }
    }

    //check descrizione
    if (empty($_POST['descrizione'])) {
        $errors['descrizione'] = 'Manca una descrizione per il tuo blog!<br>';
    } else {
        $descrizione = $_POST['descrizione'];
    }

    // check immagine
    if ($_FILES['blog_banner']['size'] > 800 * 1024) { // se le dimensioni sono troppo grandi
        $errors['banner'] = 'Immagine troppo grande';
    } else {
        $nomeBannerBlog = $_FILES['blog_banner']['name']; // salvo il nome dell'immagine
        $nomeBannerBlog_tmp = $_FILES['blog_banner']['tmp_name'];
        $targetDir = "../img/user_upload/";
        $targetFile = $targetDir . basename($nomeBannerBlog); // concateno il path al nome img

        // recupero estensione dell'img caricata
        $tipoImg = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // creo un array di stringhe nei quali scrivo i formati accettati di immagine
        $estensioniAccettate = array("jpg", "png", "jpeg");

        // controllo se l'estensione del banner e' tra quelle accettate
        // in caso contrario creo un errore
        if (!in_array($tipoImg, $estensioniAccettate)) {
            $errors['banner'] = 'Il formato del banner selezionato non è accettato';
        }

        // se non ci sono errori
        if (!$errors['banner']) {
            // copio il file dalla locazione temporanea alla mia cartella upload
            if (move_uploaded_file($nomeBannerBlog_tmp, $targetDir . $nomeBannerBlog)) {

                //Se buon fine...
                print "Upload completato.\n";
            } else {

                //Se fallita...
                print "Upload fallito!\n";
            }
        }
    }

    //recupero data timestamp
    $timestamp = date("Y-m-d H:i:s");

    if (array_filter($errors)) {

        //se ci sono errori
        //print_r($errors);
    } else {

        //escape sql chars
        $titolo = mysqli_real_escape_string($conn, strtolower($_POST['titolo']));// prende titolo (minuscolo)
        $autore = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']); //recupero user della sessione
        $data = $timestamp;
        $descrizione = mysqli_real_escape_string($conn, $_POST['descrizione']);
        $banner = $targetFile; //salvo path immagine
        $tema = mysqli_real_escape_string($conn, strtolower($_POST['selezTema']));

        //tabella sql in cui inserire il dato
        $sqlNuovoBlog = "INSERT INTO blog (idBlog, titolo, autore, data, descrizione, categoria, banner, tema) VALUES('NULL', '$titolo', '$autore', '$data', '$descrizione', '$id_categoria', '$banner', '$tema')";

        //controlla e salva sul db
        if (mysqli_query($conn, $sqlNuovoBlog)) {
            //successo
            //passo id blog appena creato all'url della pagina visual_blog e lo apro(per permettere all'utente di creare subito un nuovo post)
            $idBlog = mysqli_insert_id($conn);
            header("Location: visual_blog.php?idBlog=$idBlog");
        } else {
            //errore
            echo 'errore query: ' . mysqli_error($conn);
        }
    }
    //libera memoria
    mysqli_free_result($risCategorie);

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

<div class="container">
    <!-- pulsante torna indietro -->
    <div class="row">
        <div class="col-sm-12 px-5 py-4 text-left">
            <a class="btn btn-outline-secondary btn-sm"
               href="gestione_blog.php?nomeUtente=<?php echo $_SESSION['nomeUtente']; ?>">
                <i class="fa fa-arrow-left"></i>
                Torna alla gestione blog
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 px-5">

            <div class="card bg-light shadow">
                <div class="card-body">

                    <h4 class="card-title text-center">Crea un Blog</h4>
                    <!-- div che fa comparire errori trovati dal js con l'id e dal php -->
                    <div id="errore" class="alert">
                        <?php foreach ($errors as $value) {
                            echo "$value\r\n";
                        } ?>
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
                                    <label for="titoloCreaBlog">Titolo del blog:</label>
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
                                           value="<?php
                                               echo htmlspecialchars($id_categoria);
                                           ?>"
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
                                           value="<?php echo htmlspecialchars($descrizione); ?>"
                                           name="descrizione">
                                    <div class="invalid-feedback">
                                        Descrizione non corretta
                                    </div>
                                </div>
                            </div>

                            <!-- banner immagine -->
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
                                               name="blog_banner"/>

                                        <label class="custom-file-label" for="validatedCustomFile">
                                            Scegli file...
                                        </label>
                                        <div class="invalid-feedback">Esempio file non accettato</div>
                                    </div>
                                </div>
                            </div>

                            <!-- scelta tema -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="temaBlog">Scegli tema blog:</label>
                                    <select name="selezTema" class="form-control">
                                        <?php foreach ($temi as $nomeTema) { ?>
                                            <option value="<?php echo htmlspecialchars($nomeTema['nomeTema']); ?>"><?php echo htmlspecialchars($nomeTema['nomeTema']); ?></option>
                                        <?php } ?>

                                    </select>
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

<!-- script errori form -->
<script type="text/javascript">
    $("form").submit(function (event) {
        let errore = "";
        if ($("#titoloCreaBlog").val() === "") { //se il campo è vuoto
            errore += "Il titolo è obbligatorio.<br>";
        }
        if ($("#categoriaCreaBlog").val() === "") { //se il campo è vuoto
            errore += "La categoria è obbligatoria.<br>";
        }
        if ($("#descrizioneCreaBlog").val() === "") { //se il campo è vuoto
            errore += "Non hai inserito una descrizione.<br>";
        }
        if (errore !== "") {
            event.preventDefault();//fa in modo che il form non si refreshi al "submit" ma mi permetta di validare i dati prima di mandarli al server
            $("#errore").html('<div class="alert alert-danger" role="alert"><p><strong>Nel form sono stati trovati i seguenti errori:</strong></p>' + errore + '</div>');
        }
    });
    // script colora di rosso errori dal php
    if ($('div#errore').is(':empty')) {
        $("div#errore").addClass("alert_danger");
    } else {
        $("div#errore").removeClass("alert_danger");

    }
</script>

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

