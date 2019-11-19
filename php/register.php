<!-- collegamento al file server.php, qui c'è il codice che accoglie i dati inseriti in questa pagina -->
<?php include('server.php') ?>

<!--includo file header-->
<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="it">

<body>

<div class="container" style="padding-top: 18vh;">

    <div class="row justify-content-center">

        <div class="col-6">
            <div class="card bg-light shadow">
                <div class="card-body">
                    <h4 class="card-title text-center">Registrazione</h4>

                    <form class="was-validated" method="post" action="register.php">
                        <?php include('errors.php'); ?>

                        <div class="row">

                            <div class="col-12">

                                <!-- INPUT username -->
                                <div class="form-group">
                                    <label for="validationCustomUsername"><strong>Username</strong></label>
                                    <div class="input-group">
                                        <input id="validationCustomUsername"
                                               required
                                               type="text"
                                               class="form-control invalid"
                                               aria-describedby="inputGroupPrepend"
                                               placeholder="Inserisci un nome utente..."
                                               name="nome_utente"
                                               value="<?php echo $nome_utente; ?>"//roba aggiunta per php >
                                        <div class="invalid-feedback">
                                            Please choose a username.
                                        </div>
                                    </div>
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
                                    <small id="pwHelp" class="form-text text-muted">
                                        La tua password deve essere minimo di 8 caratteri.
                                    </small>
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
                                    <small id="emailHelp" class="form-text text-muted">
                                        Non condivideremo la tua email con nessun'altro.
                                    </small>
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