<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');

//un utente diventa premium inserendo dati di pagamento in questa pagina


?>
<!DOCTYPE html>
<html lang="it">

<?php
//includo file header
include 'head.php';
?>

<body>
<!-- IMPLEMENTAZIONE LOGIN CON BOOTSTRAP -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <!-- errore accesso non andato a buon fine -->
            <div id="accessoF">
                <?php echo $accessoF; ?>
            </div>
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
                                <!-- INPUT username -->
                                <div class="form-group">
                                    <label for="numeroCarta"><strong>Numero carta</strong></label>
                                    <input id="numeroCarta"
                                           type="text"
                                           class="form-control"
                                           placeholder="Numero di carta a 16 cifre"
                                           name="numeroCarta"
                                           value="<?php echo htmlspecialchars($nomeUtente) ?>"/>
                                </div>
                            </div>

                            <div class="col-12">
                                <!-- INPUT scadenza -->
                                <div class="it-datepicker-wrapper">
                                    <div class="form-group">
                                        <label for="scadenzaCarta"><strong>Data scadenza</strong></label>
                                        <input class="form-control it-date-datepicker" id="scadenzaCarta" type="text"
                                               placeholder="inserisci la data in formato mm/aaaa">
                                    </div>
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
                                           name="codSicurezza">
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
                                           name="nome">
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
                                           name="cognome">
                                </div>
                            </div>

                            <div class="col-12 text-right">
                                <button type="submit"
                                        class="btn btn-primary"
                                        name="paga">
                                    Paga
                                </button>
                            </div>

                        </div>
                    </form>

                    <!-- validazione form -->
                    <script type="text/javascript">
                        $("form").submit(function (event) {
                            //nasconde l'avviso errore query quando reinserisco nuovi dati
                            $('#accessoF').hide();
                            let errore = "";

                            if ($("#loginUsername").val() === "") { //se il campo è vuoto
                                errore += "Numero carta obbligatorio.<br>";
                                $("#loginUsername").css('border-color', '#b32d39');
                            } else {
                                $("#loginUsername").css('border-color', '#28a745');
                            }
                            if ($("#loginPassword").val() === "") { //se il campo è vuoto
                                errore += "Data obbligatoria.<br>";
                                $("#loginPassword").css('border-color', '#b32d39');
                            } else {
                                $("#loginPassword").css('border-color', '#28a745');
                            }
                            if ($("#loginPassword").val() === "") { //se il campo è vuoto
                                errore += "Data obbligatoria.<br>";
                                $("#loginPassword").css('border-color', '#b32d39');
                            } else {
                                $("#loginPassword").css('border-color', '#28a745');
                            }
                            if (errore !== "") {
                                event.preventDefault(); // previene il submit di default
                                $("#errore").html('<div class="alert alert-danger" role="alert"><p><strong>Nel form sono stati trovati i seguenti errori:</strong></p>' + errore + '</div>');
                            }
                        });

                        //datepicker bootstrap per inserim date
                        $(document).ready(function () {
                            $('.datepicker').datepicker({
                                format: "mm/yyyy",
                                startView: "months",
                                minViewMode: "months",
                                outputFormat: 'MM/yyyy'
                            });
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