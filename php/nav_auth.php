<nav class="navbar fixed-top navbar-expand-lg navbar-light shadow p-3 mb-5 bg-white rounded">

    <a class="navbar-brand" href="index.php">BDD</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="gestione_blog.php?nomeUtente=<?php echo $_SESSION['nomeUtente'] ?>">Gestisci blog</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="blog_seguiti.php">Blog che segui</a>
            </li>
        </ul>

        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="profilo.php"><i class="fa fa-user"></i> Profilo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>

    </div>
</nav>