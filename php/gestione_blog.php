<?php

/**
 * Gestione blog e' la pagine che gestisce i blog dell'utente loggato.
 * Permette di creare nuovi blog, eliminare propri blog, modificare propri blog.
 * Si puo' anche aggiornare i blog seguiti, seguendone di nuovi o togliendo i segui messi fino ad ora.
 */

// todo valutare se possibile inserire analitics con i dati dei propri blog (i.e. mi piace ricevuti, top blog eccetera)

//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');

if (isset($_SESSION['nomeUtente'])) {
    // recupero nome utente dalla sessione
    $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);

    // sql blog creati dall'utente loggato
    $sqlGetBlogsByAutore = "SELECT * FROM `blog` WHERE autore = '$nomeUtente'";

    // righe risultato
    $result = mysqli_query($conn, $sqlGetBlogsByAutore);

    // righe risultato "fetchate" in array
    $blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // libero memoria
    mysqli_free_result($result);

    // chiusura connessione al db
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="it">

<?php
//includo file header
include 'head.php';
?>

<div class="container"> <!-- tutte le row e le col di bootstrap devono stare dentro un unico container -->

    <div class="row py-2">
        <h3 class="text-left grey-text">Gestisci i tuoi blog, <?php echo $nomeUtente ?></h3>
    </div>


    <div class="row">
        <!--- mostra le card con i blog dell'utente -->
        <?php foreach ($blogs as $blog) { ?>
            <div class="col-lg-3 py-3">
                <div class="card h-100 z-depth-0">
                    <div class="card-header">
                        <?php echo htmlspecialchars($blog['titolo']); ?>
                    </div>
                    <div class="card-body text-center">
                        <div class="row py-2">
                            <div class="col-12">
                                <h6 class="card-title"> autore: <?php echo htmlspecialchars($blog['autore']); ?></h6>
                                <div class="card-text"><?php echo htmlspecialchars($blog['descrizione']); ?></div>
                            </div>
                        </div>
                        <!-- card commands row -->
                        <div class="row py-2">
                            <div class="col-6">
                                <!--  passa il codice del blog(array che stiamo scorrendo col for) alla pagina visual_blog  -->
                                <a class="btn btn-sm btn-primary"
                                   href="visual_blog.php?idBlog=<?php echo $blog['idBlog'] ?>">Apri</a>
                            </div>
                            <div class="col-6">
                                <a class="btn btn-sm btn-danger"
                                   href="cancella_blog.php?idBlog=<?php echo $blog['idBlog'] ?>">Elimina</a>
                                <!-- todo gestire delete blog con jquery + ajax ! -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!--aggiunta card di crea blog-->
        <div class="col-lg-3 py-3">
            <div class="card h-100 z-depth-0">

                <div class="card-header">
                    Nuovo Blog
                </div>

                <div class="card-body text-center">

                    <div class="row py-2">
                        <div class="col-12">
                            <div class="card-text">Crea un nuovo blog</div>
                        </div>
                    </div>

                    <!-- card commands row -->
                    <div class="row py-2">
                        <div class="col-12 text-center">
                            <!--  pulsante crea nuovo blog  -->
                            <a class="btn btn-outline-primary" href="crea_blog.php"> <i class="fa fa-plus-circle"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>


</div> <!-- fine container -->

<?php include('footer.php'); ?>

</html>