<?php

    //connessione al db
    include('db_connect.php');

    if (!isset($_SESSION)) {
        session_start();
    }

    $commento = $utenteSession = $idPost = $idBlog = '';

    if (isset($_SESSION['nomeUtente'])) {
        $utenteSession = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);
        echo "utente:" . $utenteSession;
    }

    if (isset($_GET['idBlog'])) {
        $idBlog = $_GET['idBlog'];
    }

    if (isset($_GET['idPost'])) {

        if ($utenteSession) {

            // id del post in cui inserire il commento
            $idPost = mysqli_real_escape_string($conn, $_GET['idPost']);
            echo "post:" . $idPost;

            // data commento
            $timestamp = date("Y-m-d H:i:s");
            $dataCommento = $timestamp;
            echo "$dataCommento";

            // testo commento
            $commento = mysqli_real_escape_string($conn, $_POST['nuovoCommentoTextarea']);
            echo $commento;

            // query creazione commento
            $sqlNewComment =
                "INSERT INTO `commenti` (`idCommento`, `data`, `nota`, `idPost`, `autore`) VALUES (NULL, '$dataCommento', '$commento', '$idPost', '$utenteSession')";

            //controlla e salva sul db
            if (mysqli_query($conn, $sqlNewComment)) {
                // successo: passo id blog appena creato all'url della pagina visual_blog tornando di fatto alla pagina prec
                header("Location: visual_blog.php?idBlog=$idBlog");
            } else {
                //errore
                echo 'errore query: ' . mysqli_error($conn);
            }

            //chiudi connessione
            $conn->close();
        } else {
            echo "<div class='col-12 text-center'>Solo gli utenti loggati possono commentare. <a href='login.php'>Fai login qui<a></div>";
        }
    }
?>
