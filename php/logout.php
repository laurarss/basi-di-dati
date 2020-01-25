<?php

    // imports logouts
    include('nav_unauth.php');
    include('head.php');

    session_start();
    unset($_SESSION['nomeUtente']);
    session_destroy();
?>

<body>

<div class="container-fluid">

    <div class="row h-75 d-flex">

        <div class="col-12 justify-content-center align-self-center text-center">

            <h1> Sei stato disconnesso dall'applicazione</h1>

            <p>Ci auguriamo di rivederti presto! Torna sui nostri blog per non perderti le ultime novità.</p>

            <a class="btn btn-outline-secondary btn-sm" href="index.php">
                <i class="fa fa-home"></i>
                Torna alla Home
            </a>
        </div>

    </div>

</div>

</body>

