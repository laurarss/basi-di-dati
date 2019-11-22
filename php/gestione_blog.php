<?php

/**
 * Gestione blog e' la pagine che gestisce i blog dell'utente loggato.
 * Permette di creare nuovi blog, eliminare propri blog, modificare propri blog.
 * Si puo' anche aggiornare i blog seguiti, seguendone di nuovi o togliendo i segui messi fino ad ora.
 */

// todo valutare se possibile inserire analitics con i dati dei propri blog (i.e. mi piace ricevuti, top blog eccetera)

include('db_connect.php');
include('header.php');

// write query
$sqlGetAllBlogs = "SELECT titolo, descrizione FROM blog";
$sqlGetBlogsByAutore = "SELECT titolo, descrizione, autore FROM blog WHERE autore IN '$nomeUtente'";

print($nomeUtente);

// get the result set (set of rows)
$result = mysqli_query($conn, $sqlGetAllBlogs);

// fetch the resulting rows as an array
$blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free the $result from memory (good practise)
mysqli_free_result($result);

// close connection
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="it">

<div class="container"> <!-- tutte le row e le col di bootstrap devono stare dentro un unico container -->

    <div class="row py-2">
        <h3 class="text-left grey-text">Gestione Blogs</h3>
    </div>

    <div class="row">
        <?php foreach ($blogs as $blog) { ?>

            <div class="col-sm-3">
                <div class="card h-100 z-depth-0">

                    <div class="card-header">
                        <?php echo htmlspecialchars($blog['titolo']); ?>
                    </div>

                    <div class="card-body text-center">

                        <div class="row py-2">
                            <div class="col-12">
                                <div class="card-text"><?php echo htmlspecialchars($blog['descrizione']); ?></div>
                            </div>
                        </div>

                        <!-- card commands row -->
                        <div class="row py-2">
                            <div class="col-6">
                                <a class="btn btn-sm btn-primary" href="#">Apri</a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-sm btn-danger">
                                    Elimina
                                </button>
                                <!-- todo gestire delete blog con jquery + ajax ! -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        <?php } ?>
    </div>

</div> <!-- fine container -->

<?php include('footer.php'); ?>

</html>
