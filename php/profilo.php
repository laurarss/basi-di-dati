<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');

$datiUtente = $risUtente = '';
if (isset($_SESSION['nomeUtente'])) {

    $nomeUtente = $_SESSION['nomeUtente'];

    // sql codice
    $sqlUtente = "SELECT * FROM `utenti` WHERE nomeUtente = '$nomeUtente'"; //dati utente

    if (!$sqlUtente) {
        echo "Errore nell'sql inerente all'utente";
        return;
    }

    // risultato righe query
    $risUtente = mysqli_query($conn, $sqlUtente);

    // fetch righe risultato in un array
    $datiUtente = mysqli_fetch_all($risUtente, MYSQLI_ASSOC); // si usa assoc e non all perchè prendiamo solo una riga della tab risultato

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
    <div class="row justify-content-center">
        <div class="col-8">

            <div class="card bg-light shadow">
                <div class="card-body">

                    <h4 class="card-title text-center">Il tuo profilo, <?php echo $nomeUtente; ?></h4>
                    <div class="row">

                        <!-- titolo -->
                        <div class="col-6 text-left">
                            <p class="lead">Nome utente:</p>
                        </div>

                        <div class="col-6 text-right">
                            <p class="lead"><?php echo $datiUtente[0]['nomeUtente']; ?></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
</div>

<?php include('footer.php'); ?>

</body>
</html>


