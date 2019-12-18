<!-- connessione al db e caricamento blog -->
<?php
include('db_connect.php');
//header & nav
include('header.php');

// write query
$sqlGetBlogData = "SELECT * FROM `blog`";

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
<?php
//includo file header
include 'head.php';
?>

<div class="container">

    <!--alert grigio di benvenuto utente -->
    <?php if (isset($_SESSION['nomeUtente'])) : ?>
        <div class="alert alert-secondary col-sm-3" role="alert">
            <!--  apre gestione blog memorizzando il nomeUtente della sessione-->
            Benvenuto <strong><?php echo $_SESSION['nomeUtente']; ?></strong>
        </div>
        <div class="row py-2">
            <div class="col-6">
                <a class="btn btn-sm btn-primary"
                   href="gestione_blog.php?nomeUtente=<?php echo $_SESSION['nomeUtente'] ?>">Gestisci i tuoi blog</a>
            </div>
        </div>
    <?php endif ?>

    <div class="container">
        <div class="row">
            <?php foreach ($blogs as $blog) { ?>

                <div class="col-sm-4 py-3">
                    <div class="card h-100 z-depth-0">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($blog['titolo']); ?></h5>
                            <h6 class="card-title"><?php echo htmlspecialchars($blog['autore']); ?></h6>
                            <div class="card-text"><?php echo htmlspecialchars($blog['descrizione']); ?></div>
                            <a class="card-link" href="visual_blog.php?idBlog=<?php echo $blog['idBlog'] ?>">more
                                info</a>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>

    </div>

    <?php include('footer.php') ?>

</html>