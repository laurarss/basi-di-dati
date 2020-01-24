<?php

    //includo file connessione al db
    include('db_connect.php');

    //includo file header
    include('header.php');

    $datiUtente = $risUtente = $risBlog = $numBlog = '';

    if (isset($_SESSION['nomeUtente'])) {

        $nomeUtente = $_SESSION['nomeUtente'];

        // sql codice
        $sqlUtente = "SELECT * FROM `utenti` WHERE nomeUtente = '$nomeUtente'"; //dati utente
        $sqlBlog = "SELECT COUNT(*) as contBlog FROM `blog` WHERE autore = '$nomeUtente'"; //conteggio blog per autore

        if (!$sqlUtente) {
            echo "Errore nell'sql inerente all'utente";
            return;
        }
        if (!$sqlBlog) {
            echo "Errore nell'sql inerente al conteggio blog";
            return;
        }

        // risultato righe query
        $risUtente = mysqli_query($conn, $sqlUtente);
        $risBlog = mysqli_query($conn, $sqlBlog);

        // fetch righe risultato in un array
        $datiUtente = mysqli_fetch_assoc($risUtente); // si usa assoc e non all perchè prendiamo solo una riga della tab risultato
        $numBlog = mysqli_fetch_assoc($risBlog); // si usa assoc e non all perchè prendiamo solo una riga della tab risultato

        // chiudi connessione
        mysqli_close($conn);
    } else {
        header("Location: ops.php");
    }

?>

<!DOCTYPE html>
<html lang="it">
<body>

<?php include 'head.php'; ?>
<div class="container py-5">

    <div class="row py-2 justify-content-center">
        <div class="col-8">

            <div class="card bg-light shadow">
                <div class="card-body">

                    <div class="row py-3 px-4">

                        <div class="col-6 text-left">
                            <h4 class="card-title">Il tuo profilo</h4>
                        </div>

                        <div class="col-6 text-right">
                            <i class="far fa-user fa-3x"></i>
                        </div>

                    </div>

                    <hr class="m-0">

                    <div class="row py-2 px-4">

                        <!-- titoli riga a sx -->
                        <div class="col-6 text-left">

                            <p class="lead font-weight-bold">Nome utente:</p>

                            <?php
                                //non echo nomi degli elem non obbligatori, se vuoti(nome e cognome)
                                $nome = $datiUtente['nome'];
                                $cognome = $datiUtente['cognome'];
                                if ($nome != NULL) {
                                    echo ' <p class="lead font-weight-bold">Nome:</p>';
                                }
                                if ($cognome != NULL) {
                                    echo '<p class="lead font-weight-bold">Cognome:</p>';
                                }
                            ?>

                            <p class="lead font-weight-bold">email:</p>
                            <p class="lead font-weight-bold">Tipo utente:</p>
                            <p class="lead font-weight-bold">Blog creati:</p>
                        </div>

                        <!-- valori dal db nella riga a dx -->
                        <div class="col-6 text-right">
                            <p class="lead"><?php echo $datiUtente['nomeUtente']; ?></p>
                            <?php
                                //non echo gli elem non obbligatori, se vuoti(nome e cognome)
                                $nome = $datiUtente['nome'];
                                $cognome = $datiUtente['cognome'];
                                if ($nome != NULL) {
                                    echo '<p class="lead">' . ucfirst($datiUtente['nome']) . '</p>';
                                }
                                if ($cognome != NULL) {
                                    echo '<p class="lead">' . ucfirst($datiUtente['cognome']) . '</p>';
                                }
                            ?>
                            <p class="lead"><?php echo $datiUtente['email']; ?></p>
                            <p class="lead"><?php echo $datiUtente['tipoUtente']; ?></p>
                            <p class="lead"><?php echo $numBlog['contBlog']; ?></p>
                        </div>
                    </div>

                    <div class="row py-2 px-4">

                        <div class="col-6 text-left">
                            <a id="cancProfilo" class="btn btn-danger btn-sm" href="#" data-href="cancella_profilo.php"
                               data-toggle="modal" data-target="#confirm-delete">
                                Cancella profilo
                            </a>
                        </div>

                        <?php if ($datiUtente['tipoUtente'] == 'Normale') : ?>
                            <div class="col-6 text-right">
                                <a id="utPremium" class="btn btn-success btn-sm" href="premium.php">
                                    Passa a premium
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="col-12 text-right">
                                <span id="utPremium" class="text-secondary">
                                    Sei premium<br>
                                    <small>Crea tutti i blog che vuoi</small>
                                </span>
                            </div>
                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- popup conferma cancellaz profilo -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <strong>Sei sicuro?</strong>
                </div>
                <div class="modal-body">
                    La cancellazione del tuo profilo comporterà anche la cancellazione di tutti i tuoi blog e post,
                    insieme ai commenti e mi piace inseriti.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                    <a class="btn btn-danger btn-ok">Cancella</a>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include('footer.php'); ?>

<script>
    $('#confirm-delete').on('show.bs.modal', function (e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>

</body>
</html>


