<?php
session_start();

// initializing variables
$nome_utente = "";
$email = "";
$errors = array();

// connect to the database (modificare con un account admin, non root però)
$db = mysqli_connect('localhost', 'root', '', 'progettodb1');

// REGISTRAZIONE UTENTE
if (isset($_POST['reg_btn'])) {
    // receive all input values from the form
    $nome_utente = mysqli_real_escape_string($db, $_POST['nome_utente']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    $nome = mysqli_real_escape_string($db, $_POST['nome']);
    $cognome = mysqli_real_escape_string($db, $_POST['cognome']);
    $email = mysqli_real_escape_string($db, $_POST['email']);


    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($nome_utente)) {
        array_push($errors, "E' richiesto il nome utente");
    }
    if (empty($email)) {
        array_push($errors, "Email richiesta");
    }
    if (empty($password_1)) {
        array_push($errors, "Password richiesta");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "Le due password non combaciano");
    }

    // first check the database to make sure
    // a user does not already exist with the same nome_utente and/or email
    $user_check_query = "SELECT * FROM utenti WHERE nome_utente='$nome_utente' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['nome_utente'] === $nome_utente) {
            array_push($errors, "nome_utente already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "email already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database

        $query = "INSERT INTO utenti(nome_utente, password, nome, cognome, email) 
                  VALUES('$nome_utente', '$password', '$nome', '$cognome', '$email')";
        mysqli_query($db, $query);
        $_SESSION['nome_utente'] = $nome_utente;
        $_SESSION['success'] = "Ora sei loggato";
        header('location: index.php');
    }
}

// LOGIN UTENTE
if (isset($_POST['login_user'])) {
    $nome_utente = mysqli_real_escape_string($db, $_POST['nome_utente']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($nome_utente)) {
        array_push($errors, "nome_utente richiesto");
    }
    if (empty($password)) {
        array_push($errors, "Password richiesto");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM utenti WHERE nome_utente='$nome_utente' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            $_SESSION['nome_utente'] = $nome_utente;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        } else {
            array_push($errors, "Wrong nome_utente/password combination");
        }
    }
}

?>