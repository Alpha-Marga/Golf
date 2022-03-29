<html>

<head>
    <!-- <title><?php echo ($titre) ?></title> -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $titre }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/corps.css') }}">
    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark nav">
        <div class="container-fluid">

            <a href="{{ route('accueil') }}"><img class="bar" src="../image/logo.png" width="80" height="35" align="right" /></a>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">

                    <!-- Element "Accueil" -->
                    <li class="nav-item"><a class="nav-link" href="{{ route('accueil') }}">Accueil </a></li>

                    <!-- Element Classement Saison-->
                    <li class="nav-item"><a class="nav-link " href="{{ route('classementSaison') }}">Classement saison</a></li>

                    @if (Route::has('login'))
                    @auth
                    <!-- Element Creation tournoi -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Créer un tournoi
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" style="background-color:white" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('creationTournoi' , ['Homme']) }}">Masculin</a></li>
                            <li><a class="dropdown-item" href="{{ route('creationTournoi' , ['Femme']) }}">Féminin</a></li>
                        </ul>
                    </li>
                    <!-- Connexion -->
                    <li class="nav-item"><a class="nav-link " href="{{ route('logout') }}">Deconnexion</a></li>
                    @else
                    <!-- Deconnexion -->
                    <li class="nav-item"><a class="nav-link " href="{{ route('login') }}">Connexion</a></li>
                    @endauth
                    @endif

                </ul>
            </div>
        </div>
    </nav>

</header>


</html>