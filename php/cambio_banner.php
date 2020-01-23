<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');

$banner = $errore = '';

//verifica la richiesta GET del parametro idBlog
if (isset($_GET['idBlog'])) {

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $idBlog = mysqli_real_escape_string($conn, $_GET['idBlog']);

    // sql codice
    $sqlBlog = "SELECT * FROM `blog` WHERE idBlog = $idBlog";
    // risultato righe query
    $risBlog = mysqli_query($conn, $sqlBlog);
    // fetch righe risultato in un array
    $blog = mysqli_fetch_assoc($risBlog); // si usa assoc e non all perchè prendiamo solo una riga della tab risultato

    if (isset($_POST['carica_banner_submit'])) {
        // check immagine
        if ($_FILES['blog_banner']['size'] < 1024 * 1024) { // se le dimensioni non sono troppo grandi

            $nomeBannerBlog = $_FILES['blog_banner']['name']; // salvo il nome dell'immagine
            $nomeBannerBlog_tmp = $_FILES['blog_banner']['tmp_name'];
            $targetDir = "../img/user_upload/";
            $targetFile = $targetDir . basename($nomeBannerBlog); //concateno il path al nome img

            // recupero estensione dell'img caricata
            $tipoImg = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // creo un array di stringhe nei quali scrivo i formati accettati di immagine
            $estensioniAccettate = array("jpg", "png", "jpeg");

            // controllo se l'estensione e' tra quelle accettate
            // se non c'è creo un errore
            if (!in_array($tipoImg, $estensioniAccettate)) {
                $errore = 'Il formato del banner selezionato non è accettato';
            }
        } else {
            //se 1M < img < 2M
            $errore = "Upload immagine troppo grande";
        }
        // copio il file dalla locazione temporanea alla mia cartella upload
        if ($errore == '') {
            if (!move_uploaded_file($nomeBannerBlog_tmp, $targetDir . $nomeBannerBlog)) {
                //se non è trasferita l'img è troppo grande (non è stata proprio "presa" dal php in quanto >2M)
                $errore = "Upload immagine troppo grande";
            }
        }

        if ($errore == '') {
            //se non ci sono errori
            $banner = $targetFile; //salvo path immagine
            //controlla e salva sul db
            if (mysqli_query($conn, "UPDATE `blog` SET `banner` = '$banner' WHERE `blog`.`idBlog` = '$idBlog' ")) {
                //successo
                //passo id all'url della pagina visual_blog e lo apro
                header("Location: visual_blog.php?idBlog=$idBlog");
            } else {
                //errore
                echo 'errore query: ' . mysqli_error($conn);
            }
        }
    }


// chiudi connessione
    mysqli_close($conn);

} else {
    header("Location: ops.php");
}
?>

<!DOCTYPE html>
<body xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="Content-Language" content="it"/>

<?php
//includo file header
include 'head.php';
?>

<!-- banner -->
<div class="container-bg" style="background-image: url('<?php echo htmlspecialchars($blog['banner']) ?>');">
    <h1 class="text-capitalize display-3 text-center m-0"><?php echo htmlspecialchars($blog['titolo']); ?></h1>

    <!-- intestazione blog -->
    <div class="row">
        <div class="col s6 md3 text-center">
            <?php if ($blog): ?>
                <p class="lead display-5">Creato da: <?php echo htmlspecialchars($blog['autore']); ?></p>

                <p class="lead text-muted display-5">Ultima modifica
                    il: <?php echo date_format(new DateTime($blog['data']), 'd M Y H:i:s'); ?></p>

                <p class="lead display-5"><?php echo htmlspecialchars($blog['descrizione']); ?></p>

            <?php else: ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container">

    <!-- div che fa comparire errori trovati dal js e dal php -->
    <?php if ($errore != '') : ?>
        <div id="errore" class="alert alert-danger" role="alert">
            <?php echo "$errore\r\n"; ?>
        </div>
    <?php endif ?>

    <form method="POST"
          name="cambiaBanner"
          action="cambio_banner.php?idBlog=<?php echo $blog['idBlog']; ?>"
          enctype="multipart/form-data"
          novalidate>
        <div class="form-row">

            <!-- carica immagine -->
            <div class="col-12 p-3">
                <h4 class="card-title text-center">Scegli un nuovo sfondo </h4>
                <label for="fileInput">Carica immagine:</label>
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
            <!-- bottone cambia -->
            <div class="col-12 text-center p-4">
                <button type="submit"
                        value="Carica banner"
                        class="btn btn-secondary"
                        name="carica_banner_submit">
                    Carica
                </button>
            </div>

        </div>
    </form>
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