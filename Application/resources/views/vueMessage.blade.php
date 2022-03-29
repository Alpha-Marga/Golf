@php ($titre = "Message")
@include('layouts.entete')

<body class="antialiased">
    <div class="container h-75 parent">

        <div class="enfant center-c">

<!-- Affichage des messages d'erreurs -->

            <div class="div6">
            <div class="message">
            {{$message}}
            </div>
            </div><br><br>
           
            <a class="btn link2" href="{{ route('nouveauScore', [$leCoup['tournoiId'], $leCoup['couleur']]) }}">Retour</a>
        </div>

    </div>
</body>

</html>