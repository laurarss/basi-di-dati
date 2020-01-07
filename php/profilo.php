<!DOCTYPE html>
<html lang="it">
<?php
//includo file header
include 'head.php';
?>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">

            <div class="card bg-light shadow">
                <div class="card-body">

                    <h4 class="card-title text-center">Modifica profilo</h4>
                    <!-- div che fa comparire errori trovati dal js con l'id e dal php -->
                    <div id="errore">
                        <?php foreach ($errors as $value) {
                            echo "$value\r\n";
                        } ?>
                    </div>

                    <form method="POST"
                          name="creaBlog"
                          action="*"
                          enctype="multipart/form-data"
                          novalidate>
                        <div class="form-row">
                            <!-- titolo -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="titoloCreaBlog">Nome utente:</label>
                                    <input type="text" required
                                           class="form-control"
                                           id="titoloCreaBlog"
                                           placeholder="Dai un titolo"
                                           value="<?php echo htmlspecialchars($titolo) ?>"
                                           name="titolo">
                                    <!--  sopra ho "echo" le variabili vuote nei campi // htmlspecialchars() aggiunto per evitare script maligni-->
                                    <div class="invalid-feedback">
                                        Titolo non corretto
                                    </div>
                                </div>
                            </div>

                            <!-- categoria -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="categoriaCreaBlog">Categoria:</label>
                                    <input type="text"
                                           class="form-control"
                                           id="categoriaCreaBlog"
                                           placeholder="Dai un nome alla categoria"
                                           value="<?php echo htmlspecialchars($id_categoria) ?>"
                                           name="categoria">
                                    <div class="form-text invalid-feedback">
                                        Categoria non corretta
                                    </div>
                                </div>
                            </div>

                            <!-- descrizione -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="descrizioneCreaBlog">Descrizione:</label>
                                    <input type="text"
                                           class="form-control"
                                           id="descrizioneCreaBlog"
                                           placeholder="Aggiungi una descrizione"
                                           value="<?php echo htmlspecialchars($descrizione); ?>"
                                           name="descrizione">
                                    <div class="invalid-feedback">
                                        Descrizione non corretta
                                    </div>
                                </div>
                            </div>

                            <!-- media(immagine o video) -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="fileInput">Carica immagine blog:</label>
                                    <div class="custom-file">
                                        <input type="file"
                                               class="custom-file-input"
                                               id="fileInput"
                                               required
                                               placeholder="Carica uno sfondo per il blog"
                                               value="<?php echo htmlspecialchars($banner) ?>"
                                               accept="image/png/jpg"
                                               name="blog_banner">
                                        <label class="custom-file-label" for="validatedCustomFile">
                                            Scegli file...
                                        </label>
                                        <div class="invalid-feedback">Esempio file non accettato</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group p-3">
                                <button type="submit"
                                        value="Crea"
                                        class="btn btn-secondary float-left"
                                        name="crea_blog_submit">
                                    Crea
                                </button>
                            </div>

                        </div>

                    </form>

                    <script type="text/javascript">
                        $("form").submit(function (event) {
                            let errore = "";
                            if ($("#titoloCreaBlog").val() === "") { //se il campo è vuoto
                                errore += "Il titolo è obbligatorio.<br>";
                            }
                            if ($("#categoriaCreaBlog").val() === "") { //se il campo è vuoto
                                errore += "La categoria è obbligatoria.<br>";
                            }
                            if ($("#descrizioneCreaBlog").val() === "") { //se il campo è vuoto
                                errore += "Non hai inserito una descrizione.<br>";
                            }
                            if (errore !== "") {
                                event.preventDefault();//fa in modo che il form non si refreshi al "submit" ma mi permetta di validare i dati prima di mandarli al server
                                $("#errore").html('<div class="alert alert-danger" role="alert"><p><strong>Nel form sono stati trovati i seguenti errori:</strong></p>' + errore + '</div>');
                            }
                        });
                    </script>


                </div>
            </div>

        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<!--
     Script per far apparire il nome del file nel relativo input.
     L'input file di bootstrap 4 di default non permetteva di far vedere il nome quindi, come spiegato nella documentazione
     si usa il javascript per ovviare al problema.
-->
<script>
    $('#fileInput').on('change', function () {

        // estraggo il nome del file facendo una substring sul percorso completo del file caricato
        const filePath = $(this).val();
        const fileName = filePath.substr(filePath.lastIndexOf('\\') + 1);

        // rimpiazzo la scritta di default con il nome del file
        $(this).next('.custom-file-label').html(fileName);
    })
</script>

</body>
</html>


