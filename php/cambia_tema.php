<?php
//includo file connessione al db
include('db_connect.php');
//includo php header
include('header.php');

$selectedOptionVal = $_POST['optionVal'];

// You are trying to "UPDATE" a table data based on some ID and not inserting. Included both operations

// If you are INSERTING A new table entry, use below code.
//INSERT INTO snagging (taskstatus, updated_at) VALUES ('$selectedOptionVal', 'Now()');

// If you are UPDATING an existing table entry, use below code.
//UPDATE snagging SET taskstatus = '$selectedOptionVal', updated_at = 'Now()' WHERE ID = 1234;
$sqlCambiaTema = "UPDATE `blog` SET `tema` = '$selectedOptionVal' WHERE `blog`.`idBlog` = $idBlog";
mysqli_query($conn, $sqlCambiaTema);



