<?php
include('nav_unauth.php');
include('head.php');

session_start();
unset($_SESSION['nomeUtente']);
session_destroy();

?>

<div class="col-12">
<div class="alert alert-danger col-sm-3" role="alert">
    <!-- logged in user information php -->
    <?php if (!isset($_SESSION['nomeUtente'])) : ?>
        <strong>Sei stato disconnesso, a presto.</strong>
    <?php endif ?>

</div>

<div class="col-3 text-left">
    <a class="btn btn-outline-secondary btn-sm" href="index.php">
        <i class="fa fa-home"></i>
        Torna alla Home
    </a>
</div>
</div>


