<?php
//includo file connessione al db
include('db_connect.php');

if (!isset($_SESSION)) {
    session_start();
}

$miPiace = $utenteSession = '';

if (isset($_GET['idPost'])) {
    $idPost = $_GET['idPost'];
}

if (isset($_SESSION['nomeUtente'])) {
    $utenteSession = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);
}

// sql creazione nuovo mi piace
$sqlNewFollow = "INSERT INTO `mipiace` (`idLike`, `idPost`, `idUtente`) VALUES (NULL, '$idPost', '$utenteSession')";

if ($conn->query($sqlNewFollow) === TRUE) {
    $miPiace = '<a class="miPiace btn btn-md btn-primary" id="tiPiace" value="tiPiace"><i class="far fa-thumbs-up"></i>' . "Ti piace" . '</a>';
} else {
    $miPiace = '<a class="miPiace btn btn-md btn-outline-primary" id="mettiMiPiace" value="miPiace"><i class="far fa-thumbs-up"></i>' . "Mi piace" . '</a>';
}

echo $miPiace;

// close connection
$conn->close();

?>

