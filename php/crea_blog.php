<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');

$nomeUtente = $_SESSION['nomeUtente'];

// sql blog creati dall'utente loggato(se sono più di 3 e l'utente non è premium, devo nascondere la pagina)
$sqlContaBlog = "SELECT COUNT(*) as contati FROM blog WHERE autore = '$nomeUtente'";
$risContaBlog = mysqli_query($conn, $sqlContaBlog);
$numBlog = mysqli_fetch_assoc($risContaBlog);

// recupero tipo utente
$sqlTipoUtente = "SELECT tipoUtente FROM utenti WHERE nomeUtente = '$nomeUtente'";
$risTipoUtente = mysqli_query($conn, $sqlTipoUtente);
$tipoUtente = mysqli_fetch_assoc($risTipoUtente);


// accedono a crea blog solo gli utenti normali che hanno meno di 3 blog o quelli che sono premium
if (($tipoUtente['tipoUtente'] == "Normale" && $numBlog['contati'] < 3) || $tipoUtente['tipoUtente'] == "Premium") {

    //inizializzo le variabili vuote (altrimenti php dà errore quando le uso senza avere mai cliccato submit)
    $titolo = $autore = $data = $id_categoria = $nome_categoria = $descrizione = $banner = $idBlog = $tema = '';

    //array associativo che immagazzina gli errori
    $errors = array('titolo' => '', 'categoria' => '', 'descrizione' => '', 'banner' => '');

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

            $errors['titolo'] = '<p>' . 'Manca un titolo per il tuo blog.' . '</p>';

        } else {

            $titolo = $_POST['titolo'];

            if (!preg_match('/^[ A-Za-z]+$/', $titolo)) {
                $errors['titolo'] = '<p>' . 'Il titolo deve contenere solo lettere e spazi' . '</p>';
            }

        }

        //check categoria
        if (empty($_POST['categoria'])) {
            $errors['categoria'] = '<p>' . 'Manca una categoria per il tuo blog!' . '</p>';
        } else {
            /**
             * controllare che la categ inserita dall'utente non esista già(facendo lowercase)
             * se categ esiste già allora assegno a $categoria l'id della categ già persistita
             * se categ non esiste crearla con relativa insert, e prenderne l'id
             */
            $nome_categoria = mysqli_real_escape_string($conn, $_POST['categoria']); // variabili di utility per nome categoria inserito da utente

            if (!preg_match('/^[ A-Za-z]+$/', $nome_categoria)) {

                $errors['categoria'] = 'Categoria deve contenere solo lettere e spazi' . '</p>';

            } else {
                // cerco categoria in db tabella categorie
                $trovato = $i = 0;
                while ($i < sizeof($categorie) and !$trovato) {

                    if (strtolower($nome_categoria) === strtolower($categorie[$i]['nomeCategoria'])) {
                        $id_categoria = $categorie[$i]['idCategoria'];
                        $trovato = 1;
                    }
                    $i = $i + 1;

                }
                // se non la trovo la inserisco
                if (!$trovato) {
                    $sqlInserisciCateg = "INSERT INTO categorie (idCategoria, nomeCategoria) VALUES('NULL', '$nome_categoria')";

                    if (mysqli_query($conn, $sqlInserisciCateg)) {
                        $id_categoria = mysqli_insert_id($conn);
                    } else {
                        echo "Inserimento fallito per la nuova categoria";
                    }
                }

            }
        }

        //check descrizione
        if (empty($_POST['descrizione'])) {
            $errors['descrizione'] = '<p>' . 'Manca una descrizione per il tuo blog!' . '</p>';
        } else {
            $descrizione = $_POST['descrizione'];
        }

        // check immagine
        if (empty($_POST['$imgPost'])) {

            $nomeBannerBlog = "blogDefault.jpg";
            $nomeBannerBlog_tmp = "blogDefault.jpg";
            $targetDir = "../img/";
            $targetFile = $targetDir . basename($nomeBannerBlog); // concateno il path al nome img di default

        } else {
            if ($_FILES['blog_banner']['size'] < 1024 * 1024) { // se le dimensioni non sono troppo grandi

                $nomeBannerBlog = $_FILES['blog_banner']['name']; // salvo il nome dell'immagine
                $nomeBannerBlog_tmp = $_FILES['blog_banner']['tmp_name'];
                $targetDir = "../img/user_upload/";
                $targetFile = $targetDir . basename($nomeBannerBlog); // concateno il path al nome img

                // recupero estensione dell'img caricata
                $tipoImg = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // creo un array di stringhe nei quali scrivo i formati accettati di immagine
                $estensioniAccettate = array("jpg", "png", "jpeg");

                // controllo se l'estensione del banner e' tra quelle accettate
                // se non c'è creo un errore
                if (!in_array($tipoImg, $estensioniAccettate)) {
                    $errors['banner'] = '<p>' . 'Il formato del banner selezionato non è accettato' . '</p>';
                }

            } else {
                //se 1M < img < 2M
                $errors['banner'] = '<p>' . "Upload immagine troppo grande" . '</p>';
            }

            // se non ci sono errori
            if (!$errors['banner']) {

                // copio il file dalla locazione temporanea alla mia cartella upload
                if (!move_uploaded_file($nomeBannerBlog_tmp, $targetDir . $nomeBannerBlog)) {

                    //se non è trasferita l'img è troppo grande (non è stata proprio "presa" dal php in quanto >2M)
                    $errors['banner'] = '<p>' . "Upload immagine troppo grande" . '</p>';
                }

            }
        }

        //recupero data timestamp
        $timestamp = date("Y-m-d H:i:s");

        //se non ci sono errori
        if (!array_filter($errors)) {

            //escape sql chars
            $titolo = mysqli_real_escape_string($conn, strtolower($_POST['titolo']));// prende titolo (minuscolo)
            $descrizione = mysqli_real_escape_string($conn, $_POST['descrizione']);
            $autore = mysqli_real_escape_string($conn, $nomeUtente); //recupero user della sessione
            $data = $timestamp;
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
} else {
    header("Location: ops.php");
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
               href="gestione_blog.php?nomeUtente=<?php echo $nomeUtente; ?>">
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

                    <!-- div che fa comparire errori trovati dal js e dal php -->
                    <div id="errore" class="alert" role="alert">
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
                                           value="<?php echo htmlspecialchars($nome_categoria); ?>"
                                           name="categoria">
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
        if ($("#titoloCreaBlog").val() === "") { //se il campo titolo è vuoto
            errore += "Il titolo è obbligatorio.<br>";
            $("#titoloCreaBlog").css('border-color', '#b32d39');
        } else {
            $("#titoloCreaBlog").css('border-color', '#28a745');
        }
        if ($("#categoriaCreaBlog").val() === "") { //se il campo categoria è vuoto
            errore += "La categoria è obbligatoria.<br>";
            $("#categoriaCreaBlog").css('border-color', '#b32d39');
        } else {
            $("#categoriaCreaBlog").css('border-color', '#28a745');
        }
        if ($("#descrizioneCreaBlog").val() === "") { //se il campo descrizione è vuoto
            errore += "La descrizione è obbligatoria.<br>";
            $("#descrizioneCreaBlog").css('border-color', '#b32d39');
        } else {
            $("#descrizioneCreaBlog").css('border-color', '#28a745');
        }
        if (errore !== "") {
            event.preventDefault();//fa in modo che il form non si refreshi al "submit" ma mi permetta di validare i dati prima di mandarli al server
            $("#errore").addClass("alert-danger");
            $("#errore").html('<p><strong>Nel form sono stati trovati i seguenti errori:</strong></p>' + errore);
        }
    });
    // script colora di rosso errori dal php(aggiungendo classe alert-danger di bootstrap)
    if ($('#errore').children().length > 0) { //se div errore non è vuoto
        $("#errore").addClass("alert-danger");
    } else {
        $("#errore").removeClass("alert-danger");
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
    });
</script>


</body>
</html>