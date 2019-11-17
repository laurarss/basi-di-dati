
<!-- connessione al db e caricamento blog -->
<?php
    include('db_connect.php');

//    /* impostiamo la query*/
//    $sqlquery = "SELECT * FROM blog ";
//
//    //esegui query e ottieni il risultato
//    $result = mysqli_query($conn, $sqlquery);
//
//    //fetch del risultato come array
//    $blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);
//
//    //elimina result dalla memoria
//    mysqli_free_result($result);
//
//    //chiudi connessione
//    mysqli_close($conn);
//
//    print_r($blogs);

?>

<!DOCTYPE html>
<html lang="it">

<!--includo file header-->
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

    <!--alert grigio di benvenuto utente-->
    <div class="alert alert-secondary col-sm-3" role="alert">
        <!-- logged in user information php -->
        <?php if (isset($_SESSION['nome_utente'])) : ?>
            Benvenuto <strong><?php echo $_SESSION['nome_utente']; ?></strong>
            <!--        <p><a href="index.php?logout='1'" style="color: red;">logout</a></p>-->
        <?php endif ?>
    </div>


    <div class="row">

        <div class="card" style="width: 18rem;">
            <img src="img/prova1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <p class="card-text">
                    <?php
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<br>" .
                                "<h5 class='card-title'>Titolo Blog:" . $row["titolo"] . "<br>" . "</h5>" .
                                "<h6 class=\"card-subtitle mb-2 text-muted\">Autore: " . $row["autore"] . "<br>" . "</h6>" .
                                "<p class='lead'>Descrizione: " . $row["descrizione"] . "<br>"."<p>";
                        }
                    } else {
                        echo "0 results";
                    }
                    $conn->close();
                    ?>
                </p>
            </div>
        </div>

    </div>


    <div class="container">

        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores aspernatur, assumenda
            cupiditate distinctio dolor ducimus eaque, enim, fugiat impedit ipsa iste iusto placeat quaerat quasi
            ratione
            totam voluptatibus? Amet dolorem eos eum excepturi impedit iste perspiciatis quisquam, repudiandae. Dicta,
            maiores.</p>

        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores aspernatur, assumenda
            cupiditate distinctio dolor ducimus eaque, enim, fugiat impedit ipsa iste iusto placeat quaerat quasi
            ratione
            totam voluptatibus? Amet dolorem eos eum excepturi impedit iste perspiciatis quisquam, repudiandae. Dicta,
            maiores.</p>

        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores aspernatur, assumenda
            cupiditate distinctio dolor ducimus eaque, enim, fugiat impedit ipsa iste iusto placeat quaerat quasi
            ratione
            totam voluptatibus? Amet dolorem eos eum excepturi impedit iste perspiciatis quisquam, repudiandae. Dicta,
            maiores.</p>

        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores aspernatur, assumenda
            cupiditate distinctio dolor ducimus eaque, enim, fugiat impedit ipsa iste iusto placeat quaerat quasi
            ratione
            totam voluptatibus? Amet dolorem eos eum excepturi impedit iste perspiciatis quisquam, repudiandae. Dicta,
            maiores.</p>

        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores aspernatur, assumenda
            cupiditate distinctio dolor ducimus eaque, enim, fugiat impedit ipsa iste iusto placeat quaerat quasi
            ratione
            totam voluptatibus? Amet dolorem eos eum excepturi impedit iste perspiciatis quisquam, repudiandae. Dicta,
            maiores.</p>

        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores aspernatur, assumenda
            cupiditate distinctio dolor ducimus eaque, enim, fugiat impedit ipsa iste iusto placeat quaerat quasi
            ratione
            totam voluptatibus? Amet dolorem eos eum excepturi impedit iste perspiciatis quisquam, repudiandae. Dicta,
            maiores.</p>

        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores aspernatur, assumenda
            cupiditate distinctio dolor ducimus eaque, enim, fugiat impedit ipsa iste iusto placeat quaerat quasi
            ratione
            totam voluptatibus? Amet dolorem eos eum excepturi impedit iste perspiciatis quisquam, repudiandae. Dicta,
            maiores.</p>

    </div>

    <?php include ('footer.php') ?>

</html>