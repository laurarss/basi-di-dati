<!-- collegamento al file server.php, qui c'è il codice che accoglie i dati inseriti in questa pagina -->
<?php include('server.php') ?>

<!DOCTYPE html>
<html lang="it">

<?php
//includo file header
include 'head.php';
?>

<body>

<!-- IMPLEMENTAZIONE LOGIN CON BOOTSTRAP -->

<div class="container" style="padding-top: 18vh;">

    <div class="row justify-content-center">

        <div class="col-6">

            <div class="card bg-light shadow">

                <div class="card-body">

                    <h4 class="card-title text-center">Login</h4>

                    <form class="needs-validation" method="post" action="login.php" novalidate>
                        <!-- aggiunte per php(POST) -->
                        <?php include('errors.php'); ?>

                        <div class="row">

                            <div class="col-12">
                                <!-- INPUT username -->
                                <div class="form-group">
                                    <label for="validationCustomUsername"><strong>Username</strong></label>
                                    <input id="validationCustomUsername" required
                                           type="text"
                                           class="form-control"
                                           aria-describedby="usernameHelp"
                                           placeholder="Nome utente"
                                           name="nomeUtente"
                                           value="<?php echo htmlspecialchars($nomeUtente) ?>"/>
                                </div>
                                <div>Scegli un username unico.</div>
                            </div>

                            <div class="col-12">
                                <!-- INPUT password -->
                                <div class="form-group">
                                    <label for="exampleInputPassword"><strong>Password</strong></label>
                                    <input id="exampleInputPassword"
                                           type="password" required
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
                </div>

            </div>

        </div>

    </div>

</div>

</body>

<?php include('footer.php') ?>

</html>