<?php

include('nav_unauth.php');

session_start();

// inizializzo variabili
$nomeUtente = $password_1 = $password_2 = $nome = $cognome = $email = '';
$errors = array();

include('db_connect.php');

// REGISTRAZIONE UTENTE
if (isset($_POST['reg_btn'])) {

    // receive all input values from the form
    $nomeUtente = mysqli_real_escape_string($conn, $_POST['nomeUtente']);
    $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($nomeUtente)) {
        array_push($errors, "E' richiesto il nome utente");
    } else {
        $nomeUtente = test_input($_POST["nomeUtente"]);
    }
    if (empty($password_1)) {
        array_push($errors, "Password richiesta");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "Le due password non combaciano");
    }
    if (empty($email)) {
        array_push($errors, "Email richiesta");
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address syntax is valid
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
            array_push($errors,"formato email non valido");
        }
    }
    if (!empty($nome)) {
        $nome = test_input($_POST["nome"]);
        //Checks if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
            array_push($errors, "Only letters and white space allowed");
        }
    }

    // first check the database to make sure
    // a user does not already exist with the same nomeUtente and/or email
    $user_check_query = "SELECT * FROM utenti WHERE nomeUtente='$nomeUtente' OR email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['nomeUtente'] === $nomeUtente) {
            array_push($errors, "nome utente already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "email already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database

        $query = "INSERT INTO utenti(nomeUtente, password, nome, cognome, email) 
                      VALUES('$nomeUtente', '$password', '$nome', '$cognome', '$email')";
        mysqli_query($conn, $query);
        $_SESSION['nomeUtente'] = $nomeUtente;
        header('Location: index.php');
    }
}

/*Each $_POST variable with be checked by the function*/
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// LOGIN UTENTE
if (isset($_POST['login_user'])) {

    //if login_user is set then do ..
    $nomeUtente = mysqli_real_escape_string($conn, $_POST['nomeUtente']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);


//    if (empty($nomeUtente)) {
//        array_push($errors, "nomeUtente richiesto");
//    }
//    if (empty($password)) {
//        array_push($errors, "password richiesta");
//    }
//
//    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM utenti WHERE nomeUtente='$nomeUtente' AND password='$password'";
        $results = mysqli_query($conn, $query);

        if (mysqli_num_rows($results) == 1) {
            $_SESSION['nomeUtente'] = $nomeUtente;
            header('Location: index.php');
        } else {
            // todo dare avvertimento quando la query non trova risultati
            echo "La query non ha prodotto risultati";
        }
    }
?>