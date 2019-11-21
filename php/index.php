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

<!DOCTYPE html>
<html lang="it">

<!--header & nav-->
<?php include('header.php'); ?>

<div class="container">

    <!--alert grigio di benvenuto utente -->
    <?php if (isset($_SESSION['nomeUtente'])) : ?>
        <div class="alert alert-secondary col-sm-3" role="alert">
            Benvenuto <strong><?php echo $_SESSION['nomeUtente']; ?></strong>
        </div>
    <?php endif ?>

    <div class="container">
        <div class="row">

            <?php foreach ($blogs as $blog) { ?>

                <div class="col-sm-4 py-3">
                    <div class="card h-100 z-depth-0">
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
