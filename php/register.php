<!-- collegamento al file server.php, qui c'è il codice che accoglie i dati inseriti in questa pagina -->
<?php include('server.php') ?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>BDD App</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <!-- Link css generale -->
    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <!-- Link css bootstrap -->
    <link href="../css/bootstrap/bootstrap.css" rel="stylesheet"/>

    <!-- todo: scaricare jquery e popper per install locale   -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <!-- collegamento javascript bootstrap -->
    <script src="../js/bootstrap/bootstrap.min.js"></script>
</head>

<body>
<div class="container" style="padding-top: 18vh;">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card bg-light shadow">
                <div class="card-body">
                    <h4 class="card-title text-center">Registrazione</h4>
                    <div id="errore"></div>

                    <form class="was-validated" method="post" action="register.php">
                        <?php include('errors.php'); ?>

                        <div class="row">

                            <div class="col-12">

                                <!-- INPUT username -->
                                <div class="form-group">
                                    <label for="inputUsername"><strong>Username</strong></label>
                                    <div class="input-group">
                                        <input id="inputUsername"
                                               type="text"
                                               class="form-control invalid"
                                               aria-describedby="inputGroupPrepend"
                                               placeholder="Inserisci un nome utente..."
                                               name="nomeUtente"
                                               value="<?php echo $nomeUtente; ?>"//roba aggiunta per php >
                                    </div>
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
                                           name="password_1">
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
                                           name="password_2">
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
                                           name="nome">
                                </div>
                            </div>

                            <div class="col-6">

                                <!-- INPUT cognome -->
                                <div class="form-group">
                                    <label for="inputCognome"><strong>Cognome</strong></label>
                                    <input id="inputCognome"
                                           required
                                           type="text"
                                           class="form-control"
                                           placeholder="Inserisci il tuo cognome... "
                                           name="cognome">
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
                            event.preventDefault();//fa in modo che il form non si refreshi al "submit" ma mi permetta di validare i dati prima di mandarli al server

                            let errore = "";

                            if ($("#inputUsername").val() === "") { //se il campo è vuoto
                                errore += "Username obbligatorio.<br>";
                            }
                            if ($("#passwordUtente").val() === "") { //se il campo è vuoto
                                errore += "Password obbligatoria.<br>";
                            }
                            if ($("#passwordUtente").val() !== $("#passwordUtente2").val()) { //se il campo è vuoto
                                errore += "Le password non combaciano.<br>";
                            }
                            if ($("#inputEmail").val() === "") { //se il campo è vuoto
                                errore += "Email obbligatoria.<br>";
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
</body>
<?php include('footer.php'); ?>
</html>