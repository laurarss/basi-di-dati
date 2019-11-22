<?php
include('db_connect.php');

$titolo = $categoria = $descrizione = ''; //inizializzo le variabili vuote (altrimenti php dà errore quando le uso senza avere mai cliccato submit)
$errors = array('titolo' => '', 'categoria' => '', 'descrizione' => ''); //array associativo che immagazzina gli errori

if (isset($_POST['submit'])) {

    //check titolo
    if (empty($_POST['titolo'])) {
        $errors['titolo'] = 'Manca un titolo per il tuo blog!';
    } else {
        $titolo = $_POST['titolo'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $titolo)) {
            $errors['titolo'] = 'Il titolo deve contenere solo lettere e spazi';
        }
    }

    //check categoria
    if (empty($_POST['categoria'])) {
        $errors['categoria'] = 'Manca una categoria per il tuo blog!';
    } else {
        $categoria = $_POST['categoria'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $categoria)) {
            $errors['categoria'] = 'Categoria deve contenere solo lettere e spazi';
        }
    }

    //check descrizione
    if (empty($_POST['descrizione'])) {
        $errors['descrizione'] = 'Manca una descrizione per il tuo blog!';
    } else {
        $descrizione = $_POST['descrizione'];
        if (!preg_match('/^[a-zA-Z\s,]+$/', $descrizione)) { //sistemare espressione regolare per lettere, spazi e PUNTEGGIATURA
            $errors['descrizione'] = 'la descrizione deve contenere solo lettere, spazi e virgole';
        }
    }

    if (array_filter($errors)) {
        //echo 'errori nel form';
    } else {

        //escape sql chars
        $titolo = mysqli_real_escape_string($conn, $_POST['titolo']);
        $categoria = mysqli_real_escape_string($conn, $_POST['categoria']);
        $autore = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']); //autore, aggiunto da me (non so se è giusto, deve recuperare l'user della sessione)
        echo 'cane di dio: ' . $_SESSION;
        $descrizione = mysqli_real_escape_string($conn, $_POST['descrizione']);

        //tabella sql in cui inserire il dato
        $sql = "INSERT INTO blog(titolo,categoria,autore,descrizione) VALUES('$titolo', '$categoria', '$autore','$descrizione')";

        //controlla e salva sul db
        if (mysqli_query($conn, $sql)) {
            echo 'dio cane maiale';
            //successo
            header('Location: gestione_blog.php');
        } else {
            //errore
            echo 'errore query: ' . mysqli_error($conn);
        }
    }

} // fine blog check
?>

<!DOCTYPE html>
<html lang="it">

<!--includo file header-->
<?php include('header.php'); ?>

<body>

<div class="container" style="padding-top: 18vh">
    <div class="row justify-content-center">
        <div class="col-8">

            <div class="card bg-light shadow">
                <div class="card-body">

                    <h4 class="card-title text-center">Crea un Blog</h4>

                    <form method="POST" action="crea_blog.php">

                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Titolo</label>
                                    <input type="text" required
                                           class="form-control"
                                           value="<?php echo htmlspecialchars($titolo) ?>"
                                           name="titolo">
                                    <!--  sopra ho "echo" le variabili vuote nei campi // htmlspecialchars() aggiunto per evitare script maligni-->
                                    <div class="invalid-feedback">
                                        <?php echo $errors['titolo']; ?>
                                        Please enter a message in the textarea.
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Categoria:</label>
                                    <input type="text"
                                           class="form-control"
                                           value="<?php echo htmlspecialchars($categoria) ?>"
                                           name="categoria">
                                    <div class="form-text invalid-feedback">
                                        <?php echo $errors['categoria']; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Descrizione:</label>
                                    <input type="text"
                                           class="form-control"
                                           value="<?php echo htmlspecialchars($descrizione) ?>"
                                           name="descrizione">
                                    <div class="invalid-feedback">
                                        <?php echo $errors['descrizione']; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group p-3">
                                <button type="submit"
                                        value="Crea"
                                        class="btn btn-secondary float-right"
                                        name="submit">
                                    Crea
                                </button>
                            </div>

                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include('footer.php'); ?>

</body>
</html>
