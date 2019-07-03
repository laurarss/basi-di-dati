<!-- collegamento al file server.php, qui c'è il codice che accoglie i dati inseriti in questa pagina -->
<?php include('server.php') ?>

<!DOCTYPE html>
<html lang="it">

<head>

    <meta charset="UTF-8">
    <title>BDD App</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

    <!-- Link css generale -->
    <link rel="stylesheet" type="text/css" href="css/general.css">

    <!-- Link css bootstrap -->
    <link href="css/bootstrap/bootstrap.css" rel="stylesheet"/>

    <!-- todo: scaricare jquery e popper per install locale   -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>

    <!-- collegamento javascript bootstrap -->
    <script src="js/bootstrap/bootstrap.min.js"></script>

</head>

<body>

<div class="container" style="padding-top: 18vh;">

    <div class="row justify-content-center">

        <div class="col-6">

            <div class="card bg-light shadow">

                <div class="card-body">

                    <h4 class="card-title text-center">Registrazione</h4>

                    <form method="post" action="register.php">
                        <?php include('errors.php'); ?>

                        <div class="row">

                            <div class="col-12">

                                <!-- INPUT username -->
                                <div class="form-group">
                                    <label for="usernameInput"><strong>Username</strong></label>
                                    <input id="usernameInput"
                                           required
                                           type="text"
                                           class="form-control"
                                           aria-describedby="usernameHelp"
                                           placeholder="Inserisci un nome utente..."
                                           name="nome_utente" //roba aggiunta per php
                                           value="<?php echo $nome_utente; ?>">
                                    <small id="usernameHelp" class="form-text text-muted">
                                        Il nome utente e' riservato
                                    </small>
                                </div>

                            </div>

                            <div class="col-12">

                                <!-- INPUT password 1 -->
                                <div class="form-group">
                                    <label for="inputPassword"><strong>Password</strong></label>
                                    <input id="inputPassword"
                                           type="password"
                                           required
                                           class="form-control"
                                           placeholder="Inserisci la password..."
                                           name="password_1">
                                </div>

                            </div>

                            <div class="col-12">

                                <!-- INPUT password 2 -->
                                <div class="form-group">
                                    <label for="inputPassword"><strong>Conferma password</strong></label>
                                    <input id="inputPassword"
                                           type="password"
                                           required
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
                                           required
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
                                </div>

                            </div>

                        </div>

                        <!--                        <div class="form-check">-->
                        <!--                            <input type="checkbox" class="form-check-input" id="exampleCheck1">-->
                        <!--                            <label class="form-check-label" for="exampleCheck1">Check me out</label>-->
                        <!--                        </div>-->

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

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>