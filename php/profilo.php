<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');

$datiUtente = $risUtente = $risBlog = $numBlog = '';
if (isset($_SESSION['nomeUtente'])) {

    $nomeUtente = $_SESSION['nomeUtente'];

    // sql codice
    $sqlUtente = "SELECT * FROM `utenti` WHERE nomeUtente = '$nomeUtente'"; //dati utente
    $sqlBlog = "SELECT COUNT(*) as contBlog FROM `blog` WHERE autore = '$nomeUtente'"; //conteggio blog per autore

    if (!$sqlUtente) {
        echo "Errore nell'sql inerente all'utente";
        return;
    }
    if (!$sqlBlog) {
        echo "Errore nell'sql inerente al conteggio blog";
        return;
    }

    // risultato righe query
    $risUtente = mysqli_query($conn, $sqlUtente);
    $risBlog = mysqli_query($conn, $sqlBlog);

    // fetch righe risultato in un array
    $datiUtente = mysqli_fetch_assoc($risUtente); // si usa assoc e non all perchè prendiamo solo una riga della tab risultato
    $numBlog = mysqli_fetch_assoc($risBlog); // si usa assoc e non all perchè prendiamo solo una riga della tab risultato

//    printf("Select returned %d rows.\n", $risUtente->num_rows);
//    print_r($datiUtente);

    // chiudi connessione
    mysqli_close($conn);
} else {
    header("Location: ops.php");
}

?>

<!DOCTYPE html>
<html lang="it">
<body>
<?php
include 'head.php';
?>
<div class="container">
    <div class="row py-2 justify-content-center">
        <div class="col-8">

            <div class="card bg-light shadow">
                <div class="card-body">
                    <div class="row py-3 px-4">
                        <div class="col-12 text-center">
                            <i class="far fa-user fa-3x"></i>
                        </div>
                    </div>

                    <h4 class="card-title text-center">Il tuo profilo, <?php echo $nomeUtente; ?></h4>
                    <div class="row py-2 px-4">

                        <!-- titoli riga a sx -->
                        <div class="col-6 text-left">
                            <p class="lead">Nome utente:</p>
                            <?php
                            //non echo nomi degli elem non obbligatori, se vuoti(nome e cognome)
                            $nome = $datiUtente['nome'];
                            $cognome = $datiUtente['cognome'];
                            if ($nome != NULL) {
                                echo ' <p class="lead">Nome:</p>';
                            }
                            if ($cognome != NULL) {
                                echo '<p class="lead">Cognome:</p>';
                            }
                            ?>
                            <p class="lead">email:</p>
                            <p class="lead">Tipo utente:</p>
                            <p class="lead">Blog creati:</p>
                        </div>

                        <!-- valori dal db nella riga a dx -->
                        <div class="col-6 text-right">
                            <p class="lead"><?php echo $datiUtente['nomeUtente']; ?></p>
                            <?php
                            //non echo gli elem non obbligatori, se vuoti(nome e cognome)
                            $nome = $datiUtente['nome'];
                            $cognome = $datiUtente['cognome'];
                            if ($nome != NULL) {
                                    echo '<p class="lead">'. ucfirst($datiUtente['nome']).'</p>';
                                }
                            if ($cognome != NULL) {
                                    echo '<p class="lead">'. ucfirst($datiUtente['cognome']).'</p>';
                                }
                            ?>
                            <p class="lead"><?php echo $datiUtente['email']; ?></p>
                            <p class="lead"><?php echo $datiUtente['tipoUtente']; ?></p>
                            <p class="lead"><?php echo $numBlog['contBlog']; ?></p>
                        </div>
                    </div>
                    <?php if ($datiUtente['tipoUtente'] == 'Normale') : ?>
                        <div class="row py-2 px-4">
                            <div class="col-12 text-center">
                                <a id="utPremium" class="btn btn-secondary btn-sm" href="premium.php">
                                    Passa a premium
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row py-2 px-4">
                            <div class="col-12 text-center">
                            <span id="utPremium" class="text-secondary">
                                Sei premium<br>
                                <small>Crea tutti i blog che vuoi</small>
                            </span>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <!-- pulsante cancella profilo -->
    <div class="row py-3 px-4">
        <div class="col-12 text-center">
            <a id="cancProfilo" class="btn btn-danger btn-sm" href="cancella_profilo.php">
                Cancella profilo
            </a>
        </div>
    </div>

</div>
</div>

<?php include('footer.php'); ?>

</body>
</html>


