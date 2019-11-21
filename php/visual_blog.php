<?php

/**
 * La pagina visualizzazione blog permette di visualizzare un blog dell'utente loggato.
 * Mostra l'elenco di tutti i post al suo interno, con i relativi commenti.
 * Permette di aggiungere/rimuovere post e commenti.
 */

include('db_connect.php');
include('header.php');

// write query
$sqlblog = "SELECT idBlog, titolo, descrizione FROM blog"; //dovrebbe prendere i dati che l'utente ha cliccato nell'elenco blog
$sqlpost = "SELECT titolo, data, testo, media FROM post WHERE idBlog = "; //dovrebbe prendere i post con lo stesso idBlog del blog

print($nomeUtente);

// get the result set (set of rows)
$result = mysqli_query($conn, $sql);

// fetch the resulting rows as an array
$blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free the $result from memory (good practise)
mysqli_free_result($result);

// close connection
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="it">

<h4 class="text-center grey-text">Tutti i Blog!</h4>

<div class="container">
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

<?php include('footer.php'); ?>

</html>
