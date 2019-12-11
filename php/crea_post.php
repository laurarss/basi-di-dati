<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');

//verifica la richiesta GET del parametro idBlog
if (isset($_GET['idBlog'])) {

    $idBlog = mysqli_real_escape_string($conn, $_GET['idBlog']);

    // sql codice
    $sqlBlog = "SELECT idBlog, titolo, autore, categoria FROM blog WHERE idBlog = $idBlog";

    //fetch risultato in un array
    $blog = mysqli_fetch_assoc($risBlog); // si usa assoc e non all perchè prendiamo solo una riga della tab risultato

}

?>
<!DOCTYPE html>
<html lang="it">
<body>

<div class="container" style="padding-top: 18vh">

    <div class="row justify-content-center">

        <div class="col-8">

            <div class="card bg-light shadow">
                <div class="card-body">
                    <h4 class="card-title text-center">Stai creando un post in <?php echo htmlspecialchars($blog['titolo']); ?></h4>

                    <form method="POST" action="crea_blog.php">

                        <div class="row">

                            <!-- titolo -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Titolo:</label>
                                    <input type="text" required
                                           class="form-control"
                                           value="<?php ?>"
                                           name="titolo">
                                    <!-- sopra ho "echo" le variabili vuote nei campi // htmlspecialchars() aggiunto per evitare script maligni -->
                                </div>
                            </div>

                            <!-- data -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Data:</label>
                                    <input type="date"
                                           class="form-control"
                                           value="<?php  ?>"
                                           name="data">
                                    <div class="form-text invalid-feedback">
                                        <?php  ?>
                                    </div>

                                </div>
                            </div>

                            <!-- testo -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Testo:</label>
                                    <input type="text"
                                           class="form-control"
                                           value="<?php ?>"
                                           name="descrizione">
                                    <div class="invalid-feedback">
                                        <?php  ?>
                                    </div>
                                </div>
                            </div>


                            <!-- media (immagine o video) -->
                            <div class="col-12">
                                <div class="custom-file">
                                    <label for="">Carica immagine/video:</label>
                                    <input type="file" class="custom-file-input" id="validatedCustomFile" required>
                                    <label class="custom-file-label" for="validatedCustomFile">Scegli file...</label>
                                    <div class="invalid-feedback">Esempio file non accettato</div>
                                </div>
                            </div>

                    <!-- oltre a queste cose dovrei salvare anche il nome del blog di cui fa parte il post -->

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