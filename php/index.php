<!-- connessione al db e caricamento blog -->
<?php
include('db_connect.php');

// write query
$sqlGetBlogData = "SELECT titolo, descrizione FROM blog";

// get the result set (set of rows)
$resultBlogData = mysqli_query($conn, $sqlGetBlogData);

// fetch the resulting rows as an array
$blogs = mysqli_fetch_all($resultBlogData, MYSQLI_ASSOC);

// free the $result from memory (good practise)
mysqli_free_result($resultBlogData);

// close connection
mysqli_close($conn);

?>

<!--todo fare una  sidebar con i blog più recenti-->

<!DOCTYPE html>
<html lang="it">

<!--header & nav-->
<?php include('header.php'); ?>

<!-- aggiunto per php il div seguente-->
<div class="container">
    <!-- notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="error success">
            <h3>
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </h3>
        </div>
    <?php endif ?>
</div>



<div class="container">

    <!--alert grigio di benvenuto utente -->
    <?php if (isset($_SESSION['nome_utente'])) : ?>
        <div class="alert alert-secondary col-sm-3" role="alert">
            Benvenuto <strong><?php echo $_SESSION['nome_utente']; ?></strong>
        </div>
    <?php endif ?>

    <div class="container">

        <h4 class="text-left grey-text">Blogs</h4>

        <div class="row">

            <?php foreach ($blogs as $blog) { ?>

                <div class="col s6 md3">
                    <div class="card z-depth-0">
                        <div class="card-body text-center">
                            <h6 class="card-title"><?php echo htmlspecialchars($blog['titolo']); ?></h6>
                            <div class="card-text"><?php echo htmlspecialchars($blog['descrizione']); ?></div>
                            <a class="card-link" href="#">more info</a>
                        </div>
                    </div>
                </div>

            <?php } ?>

        </div>

    </div>

    <?php include('footer.php') ?>

</html>
