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
    $sqlGetBlogsByAutore = "SELECT blog.idBlog, blog.titolo, blog.autore, categorie.nomeCategoria, blog.data, blog.descrizione, blog.categoria, blog.banner
FROM categorie , blog WHERE categorie.idCategoria = blog.categoria AND blog.autore = '$nomeUtente'";

    // sql categorie
    $sqlCategorie = "SELECT * FROM `categorie`";

    // sql tipo utente
    $sqlTipoUtente = "SELECT tipoUtente FROM utenti WHERE nomeUtente = '$nomeUtente'";

    // righe risultato
    $result = mysqli_query($conn, $sqlGetBlogsByAutore);
    $resultCategorie = mysqli_query($conn, $sqlCategorie);
    $resTipoUtente = mysqli_query($conn, $sqlTipoUtente);

    //conto i blog creati dall'utente
    $numBlog = mysqli_num_rows($result);

    // righe risultato "fetchate" in array
    $blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $categorie = mysqli_fetch_all($resultCategorie, MYSQLI_ASSOC);
    $tipoUtente = mysqli_fetch_assoc($resTipoUtente);


    // libero memoria
    mysqli_free_result($result);
    mysqli_free_result($resultCategorie);

    // chiusura connessione al db
    mysqli_close($conn);
} else {
    header("Location: ops.php");
}
?>

<!DOCTYPE html>
<html lang="it">
<body>
<?php
//includo file header
include 'head.php';
?>

<div class="container"> <!-- tutte le row e le col di bootstrap devono stare dentro un unico container -->

    <div class="row py-2">
        <h3 class="text-left grey-text">Gestisci i tuoi blog, <?php echo ucfirst($nomeUtente); ?></h3>
    </div>

    <div class="row">
        <!--- mostra le card con i blog dell'utente -->
        <?php foreach ($blogs as $blog) { ?>

            <div class="col-lg-3 py-3">
                <div class="card h-100 z-depth-0">
                    <div class="card-header card-header-bg text-center"
                         style="background-image: url(<?php echo htmlspecialchars($blog['banner']); ?>">
                        <?php echo htmlspecialchars($blog['titolo']); ?>
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-text">
                            <small>Autore: </small>
                            <?php echo htmlspecialchars($blog['autore']); ?>
                        </h6>
                        <small class="card-text"><small>Categoria: </small><?php echo ucwords(htmlspecialchars($blog['nomeCategoria'])); ?>
                        </small>
                        <div class="card-text"><?php echo ucfirst(htmlspecialchars($blog['descrizione'])); ?></div>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>


        <?php // mostro pulsante crea blog solo agli utenti normali che hanno meno di 3 blog o a quelli che sono premium
        if (($tipoUtente['tipoUtente'] == "Normale" && $numBlog < 3) ||  $tipoUtente['tipoUtente'] == "Premium") { ?>
        <!--aggiunta card di crea blog-->
        <div class="cardCreaBlog col-lg-3 py-3">
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
        <?php } ?>

    </div>


</div> <!-- fine container -->
</body>
<?php include('footer.php'); ?>

</html>