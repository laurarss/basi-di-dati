<!DOCTYPE html>
<html lang="it">

<body>
<div class="container col-12">
    <?php
    //includo file header
    include 'head.php';
    include('server.php');
    ?>
</div>

<!-- IMPLEMENTAZIONE LOGIN CON BOOTSTRAP -->

<div class="container" style="padding-top: 18vh;">
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div id="accessoF">
                <!-- collegamento al file server.php, qui c'è il codice che accoglie i dati inseriti in questa pagina-->
                <?php echo $accessoF; ?>
            </div>
            <div class="card bg-light shadow">
                <div class="card-body">
                    <h4 class="card-title text-center">Login</h4>
                    <div id="errore">
                        <?php include('errors.php'); ?>
                    </div>

                    <form id="formLogin" method="post" action="login.php">

                        <div class="row">

                            <div class="col-12">
                                <!-- INPUT username -->
                                <div class="form-group">
                                    <label for="loginUsername"><strong>Username</strong></label>
                                    <input id="loginUsername"
                                           type="text"
                                           class="form-control"
                                           aria-describedby="usernameHelp"
                                           placeholder="Nome utente"
                                           name="nomeUtente"
                                           value="<?php echo htmlspecialchars($nomeUtente) ?>"/>
                                </div>
                            </div>

                            <div class="col-12">
                                <!-- INPUT password -->
                                <div class="form-group">
                                    <label for="loginPassword"><strong>Password</strong></label>
                                    <input id="loginPassword"
                                           type="password"
                                           class="form-control"
                                           placeholder="Password..."
                                           name="password">
                                </div>
                            </div>

                            <div class="col-6 text-left">
                                <button type="submit"
                                        class="btn btn-primary"
                                        name="login_user">
                                    Accedi
                                </button>
                            </div>

                            <div class="col-6 text-right">
                                <a href="register.php"
                                   class="btn btn-secondary">
                                    Registrati
                                </a>
                            </div>

                        </div>
                    </form>

                    <!-- validazione form -->
                    <script type="text/javascript">
                        $("form").submit(function (event) {
                            $('#accessoF').hide();
                            let errore = "";

                            if ($("#loginUsername").val() === "") { //se il campo è vuoto
                                errore += "Username obbligatorio.<br>";
                                $("#loginUsername").css('border-color', '#b32d39');
                            } else {
                                $("#loginUsername").css('border-color', '#28a745');
                            }
                            if ($("#loginPassword").val() === "") { //se il campo è vuoto
                                errore += "Password obbligatoria.<br>";
                                $("#loginPassword").css('border-color', '#b32d39');
                            } else {
                                $("#loginPassword").css('border-color', '#28a745');
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