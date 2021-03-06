<?php

    //includo file connessione al db
    include('db_connect.php');
    //includo file header
    include('header.php');

    if (isset($_SESSION['nomeUtente'])) {

        $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);
        // query
        $sqlGetFollowedBlogs =
            "SELECT follower.idUtente, blog.idBlog, blog.titolo, blog.autore, blog.data, blog.descrizione, blog.categoria, blog.banner
                FROM follower
                INNER JOIN blog ON follower.idBlog = blog.idBlog
                WHERE `idUtente` = '$nomeUtente'";

        // get the result set (set of rows)
        $result = mysqli_query($conn, $sqlGetFollowedBlogs);

        // fetch the resulting rows as an array
        $followedBlogs = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // free the $result from memory (good practise)
        mysqli_free_result($result);

        // close connection
        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html lang="it">

<?php
    //includo file header
    include 'head.php';
?>

<div class="container py-3">

    <?php if (count($followedBlogs) > 0) { ?>

        <!-- tutte le row e le col di bootstrap devono stare dentro un unico container -->
        <div class="row py-2">
            <h3 class="text-left grey-text">Blog seguiti da <?php echo $nomeUtente; ?></h3>
        </div>

        <div class="row">
            <!--- mostra le card con i blog seguiti dall'utente -->
            <?php foreach ($followedBlogs as $followedBlog) { ?>

                <div class="col-sm-3">
                    <div class="card h-100 z-depth-0">
                        <div class="card-header card-header-bg"
                             style="background-image: url(<?php echo htmlspecialchars($followedBlog['banner']); ?>">
                            <?php echo htmlspecialchars($followedBlog['titolo']); ?>
                        </div>
                        <div class="card-body text-center">
                            <div class="row py-2">
                                <div class="col-12">
                                    <h6 class="card-title">
                                        autore: <?php echo htmlspecialchars($followedBlog['autore']); ?></h6>
                                    <div class="card-text"><?php echo htmlspecialchars($followedBlog['descrizione']); ?></div>
                                </div>
                            </div>

                            <!-- card commands row -->
                            <div class="row py-2">
                                <div class="col-12">
                                    <!--  passa il codice del blog(array che stiamo scorrendo col for) alla pagina visual_blog  -->
                                    <a class="btn btn-sm btn-primary"
                                       href="visual_blog.php?idBlog=<?php echo htmlspecialchars($followedBlog['idBlog']); ?>">Apri</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    <?php } else { ?>

        <div class="row d-flex h-75 py-2">
            <div class="col-12 justify-content-center align-self-center text-center">
                <h1>Nessun blog seguito!</h1>
                <p>
                    Seguire i blog ti permette di raggiungere le tue informazioni preferite in maniera più rapida!
                </p>
            </div>
        </div>

    <?php } ?>

</div> <!-- fine container -->

<?php include('footer.php'); ?>

</html>
