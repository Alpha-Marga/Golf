@php ($titre = "Joueur")
@include('layouts.entete')

<body class="antialiased">
    <div class="container h-100">
        <br><br>
        <div class="div3">
            <div id="child1">
                <img src="{{ $joueur->photo }}" />
            </div>

<!-- Affichage de la carte de présentation du golfeur(se) -->
            <div id="child2">
                <h3>{{ $joueur->nom.' '.$joueur->prenom }}</h3>
                <h5> <b>Niveau:</b> {{ $joueur->Niveau }} </h5><br>
                <h5> <b>Adresse:</b> {{ $joueur->adresse }} </h5><br>
                <h5> <b>Code Postal:</b> {{ $joueur->cp }} </h5><br>
                <h5> <b>Ville:</b> {{ $joueur->ville }}</h5><br>
                <h5> <b>Téléphone:</b> {{ $joueur->telephone }}</h5><br>
                <h5> <b>Age:</b> {{ $age }} ans</h5>
            </div>
        </div><br><br><br>

<!-- Affichage des tournois auxquels le joueur a participés -->

        <div class="div1">
        <h3 class="title">Tournois</h3>
            @foreach($tournois as $tournoi)
            <div class="tournoi" id="child1">
                <div id="tournoi1" style="background-image: url('../image/tournoi.jpg');">
                    <h1> {{ $tournoi->nomTournoi.' '.$tournoi->saisonId }}</h1>
                </div>
                <div class="div7">
                    <div>
                        <h5> <b>Saison:</b> {{ $tournoi->saisonId }} </h5><br>
                        <h5> <b>Début du tournoi:</b> {{ $tournoi->debut }} </h5><br>
                        <h5> <b>Fin du tournoi:</b> {{ $tournoi->fin }} </h5><br>
                    </div>
                    <div>
                        <h5> <b>Catégorie:</b> {{ $tournoi->categorie }}</h5><br>
                        <h5> <b>Parcours:</b> {{ $tournoi->parcours->nomParcours }}</h5><br>
                       
                        <!-- Classement du golfeur(se) -->
                        @foreach($resultatsTournoi as $resultats)
                        @for($i=0; $i<count($resultats); $i++)
                        @if($resultats[$i]->tournoiId == $tournoi->idTournoi && $resultats[$i]->joueurId == $joueur->id)
                        @if($joueur->genre == 'Homme' && $i+1 == 1)
                        <h5><b>Classement du golfeur:</b> </h5>
                        {{$i+1}}er
                        @elseif($joueur->genre == 'Homme')
                        <h5><b>Classement du golfeur:</b> </h5>
                        {{$i+1}}ème
                        @elseif($joueur->genre == 'Femme' && $i+1 == 1)
                        <h5><b>Classement de la golfeuse:</b> </h5>
                        {{$i+1}}ère
                        @elseif($joueur->genre == 'Femme')
                        <h5><b>Classement de la golfeuse:</b> </h5>
                        {{$i+1}}ème
                        @endif
                        @endif
                        @endfor
                        @endforeach

                    </div>
                </div><br>
                <div class="center-c">
                    <a class="btn link" href="{{ route('vueTournoi', [$tournoi->idTournoi]) }}">Détails</a>
                </div>
            </div>
            @endforeach
        </div>
    <br><br>


    </div>
</body>

</html>