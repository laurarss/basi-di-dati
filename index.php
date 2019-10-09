
<?php
//session_start();
//if (! empty($_SESSION['logged_in'])){
//    ?>
<!---->
<!--    <p>here is my super-secret content</p>-->
<!--    <a href='logout.php'>Click here to log out</a>-->
<!---->
<!--    --><?php
//}
//else{
//    header("Location: main.php");
//}
//?>

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


    <!-- connessione al db e caricamento blog -->
    <?php
    /* specifichiamo il nome della nostra tabella */
    $blogtable = "blog";

    /* Connettiamoci al database */
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "progettodb1";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    /* impostiamo la query*/
    $sqlquery = "SELECT * FROM $blogtable";
    $result = $conn->query($sqlquery);
    ?>

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