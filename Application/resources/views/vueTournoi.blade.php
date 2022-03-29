@php ($titre = "Tournoi")
@include('layouts.entete')

<body class="antialiased">
    <div class="container h-100">
        <br><br>

<!-- Affichage de la carte de présentation du tournoi -->

        <div class="div3">
            <div id="child1">
                <img src="../image/tournoi.jpg" />
            </div>
            <div id="child2">
                <h3>{{ $tournoi->nomTournoi }}</h3>
                <h5> <b>Saison:</b> {{ $tournoi->saisonId }} </h5><br>
                <h5> <b>Début du tournoi:</b> {{ $tournoi->debut }} </h5><br>
                <h5> <b>Fin du tournoi:</b> {{ $tournoi->fin }} </h5><br>
                <h5> <b>Catégorie:</b> {{ $tournoi->categorie }}</h5><br>
                <h5> <b>Nombre de participants:</b> {{ count($tournoi->joueurs) }}</h5><br>
                <h5> <b>Parcours:</b> {{ $tournoi->parcours->nomParcours }}</h5><br>
            </div>
        </div><br>


<!-- Affichage du bouton qui permet de saisir les scores des joueurs si on est connecté-->

        @if (Route::has('login') && ($tournoi->fin >= $dateJour && $tournoi->debut <= $dateJour )) @auth <br>

            <div class="dropdown">
                <button class="btn link2 dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Saisie Score
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @foreach($niveaux2 as $niveau)
                    <li><a class="dropdown-item" href="{{ route('nouveauScore', [$tournoi->idTournoi, $niveau->couleur]) }}">{{$niveau->couleur}}</a></li>
                    @endforeach
                </ul>
            </div>

            @endauth
            @endif

            <br>

<!-- Affichage des golfeurs ou golfeuses qui participent aux tournois -->

            @if($tournoi->categorie == 'Messieurs')
            <h3 class="title">Golfeurs</h3>
            @else
            <h3 class="title">Golfeuses</h3>
            @endif
            <div class="div4">
                @for($i=0; $i<count($joueurs); $i++) <div class="divParticipants">
                    <a href="{{ route('vueJoueur', [ $joueurs[$i]->id]) }}">
                        <div id="child1">
                            <img src="{{ $joueurs[$i]->photo }}" />
                        </div>
                        <div id="child2">
                            {{ $joueurs[$i]->nom }}
                            {{ $joueurs[$i]->prenom }} -
                            {{ $ages[$i] }} ans
                        </div>
                    </a>
            </div>
            @endfor
    </div>
    <br>

<!-- Affichage des détails du parcours -->

    <h3 class="title">Parcours {{ $parcours->nomParcours }} </h3>
    <br>
    <div class="div5">
        <div>
            <table class="parcours">
                <th>Trou</th>
                <th></th>
                @foreach($trous as $value)
                <th>{{ $value->idTrou }}</th>
                @endforeach
                <th>Total</th>
                <tr>
                </tr>
                @foreach($niveaux1 as $niveau)
                @if($niveau->couleur == 'Noir')
                @php ($background = '#202020')
                @elseif($niveau->couleur == 'Blanc')
                @php ($background = 'white')
                @elseif($niveau->couleur == 'Rouge')
                @php ($background = 'red')
                @elseif($niveau->couleur == 'Jaune')
                @php ($background = '#beb423')
                @else
                @php ($background = '#5b8fff')
                @endif

                @if($niveau->couleur == 'Noir')
                @php ($color = 'white')
                @else
                @php ($color = 'black')
                @endif

                <tr style="background-color:<?php echo ($background) ?>">
                    <td style="color:<?php echo ($color) ?>">
                        {{ $niveau->couleur }}
                    </td>
                    <td style="color:<?php echo ($color) ?>">
                        @if($niveau->genreJoueur == 'Messieurs')
                        Homme
                        @else
                        Femme
                        @endif
                    </td>
                    @foreach($parcours->trous as $trou)
                    @if($trou->couleur == $niveau->couleur)
                    <td style="color:<?php echo ($color) ?>">
                        {{ $trou->distanceMetre  }}<br>
                        {{ $trou->distanceYard  }}
                    </td>
                    @endif
                    @endforeach
                    @php($distanceTotal = $parcours->distancesTotal($parcours->idParcours, $niveau->couleur) )
                    <td style="color:<?php echo ($color) ?>">
                        @foreach($distanceTotal as $total)
                        {{ $total->distanceMetreTotal }} m<br>
                        {{ $total->distanceYardTotal }} y
                        @endforeach
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td>Par</td>
                    <td></td>
                    @php($totalPar = 0)
                    @foreach($pars as $unPar)
                    <td>
                        {{ $unPar->par }}
                        @php ($totalPar = $totalPar + $unPar->par)
                    </td>
                    @endforeach
                    <td>{{ $totalPar }}</td>
                </tr>
            </table>
        </div>
        <div id="parcours">
            <img src="../image/parcours.png" />
        </div>
    </div>

    <br><br><br>


    <!-- Affichage des classements des golfeurs -->

    @if (count($infos) > 0)

    <h3 class="title">Classement Tournoi</h3>

    @foreach($niveaux2 as $niveau)

    @if($niveau->couleur == 'Noir')
    @php ($leNiveau = 'Messieurs Professionnels')

    @elseif($niveau->couleur == 'Blanc')
    @php ($leNiveau = 'Messieurs Bon Index')

    @elseif($niveau->couleur == 'Jaune')
    @php ($leNiveau = 'Messieurs')

    @elseif($niveau->couleur == 'Bleu')
    @php ($leNiveau = 'Dames Bon Index')

    @else
    @php ($leNiveau = 'Dames')
    @endif

    <h3 class="title2">{{ $leNiveau }}</h3>

    <div class="div6">
        @foreach($jours as $jour)
        <div>
            <table class="classement">

                <h5>Classement Jour {{ $jour }}</h5>

                <th>Rang</th>
                <th>Joueurs</th>
                <th>Resultats</th>

                @foreach($infos as $info)
                @php ($compt = 0)
                @foreach($info as $info1)
                @foreach($joueurs as $joueur)
                @if($info1->joueurId == $joueur->id && $info1->couleur == $niveau->couleur && $info1->jour == $jour)
                <tr>
                    <td>{{ $compt=$compt+1 }}</td>
                    <td>{{ $joueur->nom.' '.$joueur->prenom }}</td>
                    <td>{{ $info1->resultat }}</td>
                </tr>
                @endif
                @endforeach
                @endforeach
                @endforeach
            </table>
        </div>

        @endforeach

        <div>
            <table class="classement">
                <tr>
                    <h5> Classement final </h5>
                </tr>
                <th>Rang</th>
                <th>Joueurs</th>
                <th>Resultats</th>
                @php ($comp = 0)
                @foreach($resultatsFinaux as $resultat)
                @if($resultat->couleur == $niveau->couleur)
                @php ($comp = $comp + 1)
                <tr>
                    <td>{{ $comp }}</td>
                    <td>{{ $resultat->nom.' '.$resultat->prenom }}</td>
                    <td>{{ $resultat->resultat_tournoi }}</td>
                </tr>
                @endif
                @endforeach
            </table>
        </div>
    </div>

    <br><br>
    @endforeach
    @endif
</body>

</html>