<nav class="navbar fixed-top navbar-expand-lg navbar-light shadow p-3 mb-5 bg-white rounded">

    <a class="navbar-brand" href="index.php">BDD</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav mr-auto">

            <li class="nav-item">
                <a class="nav-link" href="gestione_blog.php?nomeUtente=<?php echo $_SESSION['nomeUtente'] ?>">Gestisci
                    blog</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="gestione_blog.php">Gestisci commenti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="blog_seguiti.php">Blog che segui</a>
            </li>

        </ul>

        <ul class="nav navbar-nav ml-auto">
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2 search-item" type="search" placeholder="Cerca per titolo.." aria-label="">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cerca</button>
            </form>

            <li class="nav-item">
                <a class="nav-link" href="user.php"><i class="fa fa-user"></i> Profilo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>

    </div>
</nav>