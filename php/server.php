<?php

include('nav_unauth.php');

session_start();

// inizializzo variabili
$nomeUtente = $password_1 = $password_2 = $nome = $cognome = $email = '';
//array associativo che immagazzina gli errori(vuoto all'inizio)
$errors = array();
$accessoF = '';

include('db_connect.php');

// REGISTRAZIONE UTENTE
if (isset($_POST['reg_btn'])) {

    // ricevo valori dal form
    $nomeUtente = mysqli_real_escape_string($conn, $_POST['nomeUtente']);
    $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // validazione form
    // con (array_push()) inserisco l'errore corrispondente nell'array errors
    if (empty($nomeUtente)) {
        array_push($errors, "E' richiesto il nome utente");
    }
    if (empty($password_1)) {
        array_push($errors, "Password richiesta");
    } else if (strlen(trim($password_2)) < 8) {
        array_push($errors, "La password deve essere almeno di 8 caratteri");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "Le due password non combaciano");
    }

    // controllo il db per essere sicura che lo stesso utente non esista già
    $user_check_query = "SELECT * FROM utenti WHERE nomeUtente='$nomeUtente' OR email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['nomeUtente'] === $nomeUtente) {
            array_push($errors, "Il nome utente esiste già");
        }

        if ($user['email'] === $email) {
            array_push($errors, "La mail esiste già");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database

        $query = "INSERT INTO utenti(nomeUtente, password, nome, cognome, email, tipoUtente) VALUES('$nomeUtente', '$password', '$nome', '$cognome', '$email', 'Normale')";
        mysqli_query($conn, $query);
        $_SESSION['nomeUtente'] = $nomeUtente;
        header('Location: index.php');
    }
}

// LOGIN UTENTE
if (isset($_POST['login_user'])) {

    //if login_user is set then do ..
    $nomeUtente = mysqli_real_escape_string($conn, $_POST['nomeUtente']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($nomeUtente)) {
        array_push($errors, "Nome utente richiesto");
    }
    if (empty($password)) {
        array_push($errors, "Password richiesta");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM utenti WHERE nomeUtente='$nomeUtente' AND password='$password'";
        $results = mysqli_query($conn, $query);

        if (mysqli_num_rows($results) == 1) {
            $_SESSION['nomeUtente'] = $nomeUtente;
            header('Location: index.php');
        } else if(mysqli_num_rows($results) == 0){
            //la query non trova risultati
            $accessoF = '<br><div class="alert alert-danger" role="alert"><p><strong>' . "Username o password errati" . '</strong></p></div>';

        } else {
            //la query produce più di una riga di risultato(difetto db)
            header('Location: ops.php');
        }
    }
}
?>