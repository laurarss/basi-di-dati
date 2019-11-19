<?php

include('db_connect.php');
include('header.php');

// write query
$sql = "SELECT titolo, descrizione FROM blog";
$sql2 = "SELECT titolo, descrizione FROM blog WHERE 'autore = $nome_utente'";

print($nome_utente);

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
<html>

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
