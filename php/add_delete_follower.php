<?php

// sql cancellazione follower
$sqlDelFollow = "DELETE FROM `follower` WHERE `idBlog` = $idBlog AND idUtente = '$utenteSession'";
$delFollow = mysqli_query($conn, $sqlDelFollow);
// sql creazione nuovo follower
$sqlNewFollow = "INSERT INTO `follower` (`idUtente`, `idBlog`) VALUES ('$utenteSession', '$idBlog')";
$newFollow = mysqli_query($conn, $sqlNewFollow);

?>
