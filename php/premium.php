<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');

//un utente diventa premium inserendo dati di pagamento in questa pagina
//variabili usate
$nomeUtente = $numeroCarta = $scadenzaCarta = $codSicurezza = $nome = $cognome = '';
//array errori
$errors = array();

if (isset($_SESSION['nomeUtente'])) {
    $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);

    // azioni conseguenti a submit
    if (isset($_POST['paga_submit'])) {

        // ricevo valori dal form
        $numeroCarta = mysqli_real_escape_string($conn, $_POST['numeroCarta']);
        $scadenzaCarta = mysqli_real_escape_string($conn, $_POST['scadenzaCarta']);
        $codSicurezza = mysqli_real_escape_string($conn, $_POST['codSicurezza']);
        $nome = mysqli_real_escape_string($conn, $_POST['nome']);
        $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);

        //check numero carta
        if (empty($numeroCarta)) {
            array_push($errors, 'Manca il numero della tua carta!');
        } else {
            //controllo se 16 cifre inserite
            if (!preg_match('/^[0-9]{16}+$/', $numeroCarta)) {
                array_push($errors, 'Il campo "Numero carta" deve contenere il numero a 16 cifre della tua carta');
            }
        }

        //check data scadenza
        if (empty($scadenzaCarta)) {
            array_push($errors, 'Manca data di scadenza della tua carta!');
        } else {
            //controllo se data inserita nel formato desiderato
            if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])$/', $scadenzaCarta)) {
                array_push($errors, 'Il campo "Data scadenza" deve contenere la data di scadenza della tua carta');
            }
        }

        //check codice sicurezza
        if (empty($codSicurezza)) {
            array_push($errors, 'Manca il codice di sicurezza della tua carta!');
        } else {
            //controllo se sono cifre in input
            if (!preg_match('/^[0-9]{3}$/', $codSicurezza)) {
                array_push($errors, 'Il campo "Codice di sicurezza" deve contenere il codice a 3 cifre sul retro della tua carta');
            }
        }

        //check nome
        if (empty($nome)) {
            array_push($errors, 'Manca nome intestatario.');
        } else {
            if (!preg_match('/^[ A-Za-z]+$/', $nome)) {
                array_push($errors, 'Inserisci nome intestatario');
            }
        }

        //check cognome
        if (empty($cognome)) {
            array_push($errors, 'Manca cognome intestatario.');
        } else {
            if (!preg_match('/^[ A-Za-z]+$/', $cognome)) {
                array_push($errors, 'Inserisci cognome intestatario');
            }
        }

        if (count($errors) == 0) {

            //inserisco dati pagamento in db
            $sqlDatiPagam = "INSERT INTO `pagamenti` (`numeroCarta`, `scadenzaCarta`, `codSicurezza`,`nome`,`cognome`,`idUtente`) VALUES ('$numeroCarta', '$scadenzaCarta', '$codSicurezza', '$nome', '$cognome', '$nomeUtente')";
            $insDatiPagam = mysqli_query($conn, $sqlDatiPagam);

            // sql aggiorna utente a premium
            $sqlAggiornaUtente = "UPDATE `utenti` SET `tipoUtente` = 'Premium' WHERE `utenti`.`nomeUtente` = '$nomeUtente'";
            $risAggiornaUtente = '';

            //aggiorno utente se inserim dati pagamento a buon fine
            if ($insDatiPagam) {

                //risultato query aggiorna utente a premium
                $risAggiornaUtente = mysqli_query($conn, $sqlAggiornaUtente);
            } else {
                echo "Errore richiesta";
            }

            if (!empty($risAggiornaUtente)) {
                header('Location: profilo.php');
            } else {
                echo "Errore richiesta";
            }
        }
    }
} else {
    header('Location: ops.php');
}
?>
<!DOCTYPE html>
<html lang="it">
<?php
//includo file header
include 'head.php';
?>

<body>

<!-- pulsante torna indietro -->
<div class="col-sm-3 py-4">
    <a class="btn btn-outline-secondary btn-sm" href="profilo.php">
        <i class="fa fa-arrow-left"></i>
        Torna al profilo
    </a>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-6">

            <h4 class="card-title text-center">Diventa premium!</h4>

            <div class="card bg-light shadow">
                <div class="card-body">
                    <h4 class="card-title text-center">Inserisci i tuoi dati di pagamento</h4>

                    <!-- div mostra errori da js -->
                    <div id="errore">
                        <?php include('errors.php'); ?>
                    </div>

                    <form id="formPagam" method="post" action="premium.php">

                        <div class="row">

                            <div class="col-12">
                                <!-- INPUT numero carta -->
                                <div class="form-group">
                                    <label for="numeroCarta"><strong>Numero carta</strong></label>
                                    <input id="numeroCarta"
                                           type="text"
                                           class="form-control"
                                           placeholder="Numero di carta a 16 cifre"
                                           name="numeroCarta"
                                           value="<?php echo $numeroCarta; ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <!-- INPUT scadenza -->
                                <div class="form-group">
                                    <label for="scadenzaCarta"><strong>Data scadenza</strong></label>
                                    <input id="scadenzaCarta"
                                           class="form-control"
                                           type="month"
                                           placeholder="inserisci la data"
                                           name="scadenzaCarta"
                                           value="<?php echo $scadenzaCarta; ?>">
                                </div>
                            </div>


                            <div class="col-12">
                                <!-- INPUT cod sicurezza -->
                                <div class="form-group">
                                    <label for="codSicurezza"><strong>Codice di sicurezza</strong></label>
                                    <input id="codSicurezza"
                                           type="text"
                                           class="form-control"
                                           placeholder="Codice di sicurezza..."
                                           name="codSicurezza"
                                           value="<?php echo $codSicurezza; ?>">
                                </div>
                            </div>

                            <div class="col-6">
                                <!-- INPUT Nome -->
                                <div class="form-group">
                                    <label for="nome"><strong>Nome</strong></label>
                                    <input id="nome"
                                           type="text"
                                           class="form-control"
                                           placeholder="Nome..."
                                           name="nome"
                                           value="<?php echo $nome; ?>">
                                </div>
                            </div>

                            <div class="col-6">
                                <!-- INPUT Cognome-->
                                <div class="form-group">
                                    <label for="loginPassword"><strong>Cognome</strong></label>
                                    <input id="cognome"
                                           type="text"
                                           class="form-control"
                                           placeholder="Cognome.."
                                           name="cognome"
                                           value="<?php echo $cognome; ?>">
                                </div>
                            </div>

                            <div class="col-12 text-right">
                                <button type="submit"
                                        class="btn btn-primary"
                                        name="paga_submit">
                                    Paga
                                </button>
                            </div>
                    </form>

                    <!-- validazione form -->
                    <script type="text/javascript">
                        $("form").submit(function (event) {
                            //nasconde l'avviso errore query quando reinserisco nuovi dati
                            $('#accessoF').hide();
                            let errore = "";

                            if ($("#numeroCarta").val() === "") { //se il campo numero carta è vuoto
                                errore += "Numero carta obbligatorio.<br>";
                                $("#numeroCarta").css('border-color', '#b32d39');
                            } else {
                                $("#numeroCarta").css('border-color', '#28a745');
                            }

                            if ($("#scadenzaCarta").val() === "") { //se il campo scadenza è vuoto
                                errore += "Data obbligatoria.<br>";
                                $("#scadenzaCarta").css('border-color', '#b32d39');
                            } else {
                                $("#scadenzaCarta").css('border-color', '#28a745');
                            }

                            if ($("#codSicurezza").val() === "") { //se il campo codice sicurezza è vuoto
                                errore += "Codice obbligatorio.<br>";
                                $("#codSicurezza").css('border-color', '#b32d39');
                            } else {
                                $("#codSicurezza").css('border-color', '#28a745');
                            }

                            if ($("#nome").val() === "") { //se il campo nome è vuoto
                                errore += "Nome intestatario obbligatorio.<br>";
                                $("#nome").css('border-color', '#b32d39');
                            } else {
                                $("#nome").css('border-color', '#28a745');
                            }

                            if ($("#cognome").val() === "") { //se il campo cognome è vuoto
                                errore += "Cognome intestatario obbligatorio.<br>";
                                $("#cognome").css('border-color', '#b32d39');
                            } else {
                                $("#cognome").css('border-color', '#28a745');
                            }

                            if (errore !== "") {
                                event.preventDefault(); // previene il submit di default
                                $("#errore").html('<div class="alert alert-danger" role="alert"><p><strong>Nel form sono stati trovati i seguenti errori:</strong></p>' + errore + '</div>');
                            }
                        });

                    </script>
                </div>

            </div>

        </div>

    </div>

</div>

</body>

<?php include('footer.php') ?>

</html>