

<!DOCTYPE html>
<html lang="it">

<!--includo file header-->
<?php include('header.php'); ?>


<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
<!--<script>-->
<!--    $(document).ready(function(){-->
<!--        $("button").click(function(){-->
<!--            $("input + div").addClass("invalid-feedback");-->
<!--        });-->
<!--    });-->
<!--</script>-->

<body>

<div class="container" style="padding-top: 18vh">

    <div class="row justify-content-center">

        <div class="col-8">

            <div class="card bg-light shadow">
                <div class="card-body">
                    <h4 class="card-title text-center">Crea un Post</h4>

                    <form method="POST" action="addblog.php">

                        <div class="row">

                            <!-- titolo -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Titolo:</label>
                                    <input type="text" required
                                           class="form-control"
                                           value="<?php ?>"
                                           name="titolo">
                                    <!--                                        sopra ho "echo" le variabili vuote nei campi // htmlspecialchars() aggiunto per evitare script maligni-->
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


                            <!-- media(immagine o video) -->
                            <div class="col-12">
                                <div class="custom-file">
                                    <label for="">Carica immagine/video:</label>
                                    <input type="file" class="custom-file-input" id="validatedCustomFile" required>
                                    <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                </div>
                            </div>

                    <!--   oltre a queste cose dovrei salvare anche il nome del blog di cui fa parte il post-->

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