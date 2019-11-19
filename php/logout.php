<?php
session_start();
session_destroy();
//echo 'You have been logged out. <a href="/">Go back</a>';
?>

<div class="alert alert-warning col-sm-3" role="alert">
    <!-- logged in user information php -->
    <?php if (!isset($_SESSION['nome_utente'])) : ?>
        Sei stato disconnesso, a presto <strong><?php echo $_SESSION['nome_utente']; ?></strong>
    <?php endif ?>
</div>


