<!-- collegamento al file server.php, qui c'è il codice che accoglie i dati inseriti in questa pagina -->
<?php include('server.php') ?>

<!DOCTYPE html>
<html lang="it">

<?php
//includo file header
include 'head.php';
?>

<body>

<!-- IMPLEMENTAZIONE REGISTRAZIONE CON BOOTSTRAP -->
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-sm-6">

            <div class="card bg-light shadow">
                <div class="card-body">
                    <h4 class="card-title text-center">Registrazione</h4>

                    <!-- div mostra errori da js e da php -->
                    <div id="errore">
                        <?php include('errors.php'); ?>
                    </div>

                    <form id="formReg" method="post" action="register.php">

                        <div class="row">

                            <div class="col-12">
                                <!-- INPUT username -->
                                <div class="form-group">
                                    <label for="inputUsername"><strong>Username</strong></label>
                                    <input id="inputUsername"
                                           type="text"
                                           class="form-control"
                                           aria-describedby="inputGroupPrepend"
                                           placeholder="Inserisci un nome utente..."
                                           name="nomeUtente"
                                           value="<?php echo $nomeUtente; ?>">
                                    <small id="usernameHelp" class="form-text text-muted">
                                        Il nome utente e' riservato
                                    </small>
                                </div>
                            </div>

                            <div class="col-12">
                                <!-- INPUT password 1 -->
                                <div class="form-group">
                                    <label for="passwordUtente"><strong>Password</strong></label>
                                    <input id="passwordUtente"
                                           type="password"
                                           class="form-control"
                                           placeholder="Inserisci la password..."
                                           name="password_1"
                                           value="<?php echo $password_1; ?>">
                                    <small id="pwHelp" class="form-text text-muted">
                                        La tua password deve essere minimo di 8 caratteri.
                                    </small>
                                </div>
                            </div>

                            <div class="col-12">
                                <!-- INPUT password 2 -->
                                <div class="form-group">
                                    <label for="passwordUtente2"><strong>Conferma password</strong></label>
                                    <input id="passwordUtente2"
                                           type="password"
                                           class="form-control"
                                           placeholder="Reinserisci la password..."
                                           name="password_2"
                                           value="<?php echo $password_2; ?>">
                                </div>
                            </div>

                            <div class="col-6">
                                <!-- INPUT nome -->
                                <div class="form-group">
                                    <label for="inputNome"><strong>Nome</strong></label>
                                    <input id="inputNome"
                                           type="text"
                                           class="form-control"
                                           placeholder="Inserisci il tuo nome..."
                                           name="nome"
                                           value="<?php echo $nome; ?>">
                                </div>
                            </div>

                            <div class="col-6">
                                <!-- INPUT cognome -->
                                <div class="form-group">
                                    <label for="inputCognome"><strong>Cognome</strong></label>
                                    <input id="inputCognome"
                                           type="text"
                                           class="form-control"
                                           placeholder="Inserisci il tuo cognome... "
                                           name="cognome"
                                           value="<?php echo $cognome; ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <!-- INPUT email -->
                                <div class="form-group">
                                    <label for="inputEmail"><strong>Email</strong></label>
                                    <input type="email"
                                           class="form-control"
                                           id="inputEmail"
                                           placeholder="Inserisci la tua email..."
                                           name="email"
                                           value="<?php echo $email; ?>">
                                    <small id="emailHelp" class="form-text text-muted">
                                        Non condivideremo la tua email con nessun'altro.
                                    </small>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-primary float-right" name="reg_btn">
                                Registrati
                            </button>
                        </div>
                        <p>
                            Sei già iscritto? Vai al <a href="login.php">Log in</a>
                        </p>
                    </form>

                    <script type="text/javascript">
                        $("form").submit(function (event) {
                            let errore = "";

                            if ($("#inputUsername").val() === "") { //se il campo è vuoto
                                errore += "Username obbligatorio.<br>";
                                $("#inputUsername").css('border-color', '#b32d39');
                            } else {
                                $("#inputUsername").css('border-color', '#28a745');
                            }
                            if ($("#passwordUtente").val() === "" || $("#passwordUtente2").val() === "") { //se il campo è vuoto
                                errore += "Password obbligatoria.<br>";
                                $("#passwordUtente").css('border-color', '#b32d39');
                            } else if ($("#passwordUtente").val().length < 8) {
                                errore += "La password deve essere almeno di 8 caratteri<br>";
                                $("#passwordUtente").css('border-color', '#b32d39');
                            } else {
                                $("#passwordUtente").css('border-color', '#28a745');
                            }
                            if ($("#passwordUtente").val() !== $("#passwordUtente2").val()) { //se il campo è vuoto
                                errore += "Le password non combaciano.<br>";
                                $("#passwordUtente").css('border-color', '#b32d39');
                                $("#passwordUtente2").css('border-color', '#b32d39');
                            }
                            if ($("#inputEmail").val() === "") { //se il campo è vuoto
                                errore += "Email obbligatoria.<br>";
                                $("#inputEmail").css('border-color', '#b32d39');
                            } else {
                                $("#inputEmail").css('border-color', '#28a745');
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
<?php include('footer.php'); ?>
</html>
