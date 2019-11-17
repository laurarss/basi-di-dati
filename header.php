<?php include('server.php') ?>

<head>
    <meta charset="UTF-8">
    <title>BDD App</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/bbde602ffb.js" crossorigin="anonymous"></script>

    <!-- Link css generale -->
    <link rel="stylesheet" type="text/css" href="css/general.css">

    <!-- Link css custom -->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- Link css bootstrap -->
    <link href="css/bootstrap/bootstrap.css" rel="stylesheet"/>

    <!-- todo: scaricare jquery e popper per install locale   -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>

    <!-- collegamento javascript bootstrap -->
    <script src="js/bootstrap/bootstrap.min.js"></script>
</head>

<body>
<nav class="navbar fixed-top navbar-expand-lg navbar-light shadow p-3 mb-5 bg-white rounded">

    <a class="navbar-brand" href="index.php">BDD</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav mr-auto">

            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="addblog.php">Crea Blog</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">Blog Seguiti</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="elencoblog.php">Blog Creati</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Dropdown
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <!--                    <div class="dropdown-divider"></div>-->
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>

            <!--            <li class="nav-item">-->
            <!--                <a class="nav-link disabled" href="#">Disabled</a>-->
            <!--            </li>-->

        </ul>
        <ul class="nav navbar-nav ml-auto">

            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cerca</button>
            </form>

            <li class="nav-item">
                <a class="nav-link" href="user.php"><i class="fa fa-user"></i> Profilo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php?logout='1'"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>

    </div>
</nav>

