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