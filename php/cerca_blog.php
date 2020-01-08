<?php
//includo file connessione al db
include('db_connect.php');


//la query funziona ma va sistemata l'integrazione con la pagina di origine, se campo ricerca vuoto dovrebbe tornare allo stato iniziale
//inoltre trovare il modo di mostrare tutto del blog, oltre al titolo

$risBlogPerTitolo = '';

$sqlBlogPerTitolo = "SELECT * FROM `blog` WHERE `titolo` LIKE '%".$_POST["search"]."%'";
$risBlogPerTitolo = mysqli_query($conn, $sqlBlogPerTitolo);
if(mysqli_num_rows($risBlogPerTitolo) > 0){
    $blogs = mysqli_fetch_array($risBlogPerTitolo, MYSQLI_ASSOC);
    echo "<li>$blogs[titolo]</br></li>";
} else{
    'Nessun blog trovato';
}

?>
