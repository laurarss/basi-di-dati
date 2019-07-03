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

<!-- IMPLEMENTAZIONE LOGIN CON BOOTSTRAPPO -->

<div class="container" style="padding-top: 18vh;">

    <div class="row justify-content-center">

        <div class="col-6">

            <div class="card bg-light shadow">

                <div class="card-body">

                    <h4 class="card-title text-center">Login</h4>

                    <form method="post" action="login.php">  <!-- aggiunte per php(POST) -->
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
                                           placeholder="Nome utente..."
                                           name="nome_utente"> <!-- aggiunte per php -->
                                </div>

                            </div>

                            <div class="col-12">

                                <!-- INPUT password -->
                                <div class="form-group">
                                    <label for="exampleInputPassword"><strong>Password</strong></label>
                                    <input id="exampleInputPassword"
                                           type="password"
                                           required
                                           class="form-control"
                                           placeholder="Password..."
                                           name="password"> <!-- aggiunte per php -->
                                </div>

                            </div>

                            <div class="col-6">

                                <button type="submit"
                                        class="btn btn-primary float-right"
                                        name="login_user">
                                    Accedi
                                </button>

                            </div>

                            <div class="col-6 float-left"> <!-- aggiunto qui float-left se no non funge -->

                                <p>
                                    Non sei ancora registrato?
                                    <a href="register.php"
                                       class="btn btn-secondary">
                                        Registrati
                                    </a>
                                </p>

                            </div>

                        </div>

                        <!--                        <div class="form-check">-->
                        <!--                            <input type="checkbox" class="form-check-input" id="exampleCheck1">-->
                        <!--                            <label class="form-check-label" for="exampleCheck1">Check me out</label>-->
                        <!--                        </div>-->


                    </form>
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>