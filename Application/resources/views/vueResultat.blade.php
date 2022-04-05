@php ($titre = "Resultat")
@include('layouts.entete')

<body class="antialiased">
    <div class="container h-75 parent">

        <div class="enfant center-c">

<!-- Affichage du resultat obtenu par le joueur après la saisie des coups réalisés-->
            <div class="div6">
                <div>
                    <table class="score">
                        <h6>Scores de {{ $joueur->nom.' '.$joueur->prenom}}</h6>
                        <th>Trou</th>
                        @for($i=0; $i < count($scores); $i++) <th>
                            {{ $coups[$i]->trouId }}
                            </th>
                            @endfor
                            <th>Total</th>
                            <tr>
                                <td>Point</td>
                                @for($i=0; $i < count($scores); $i++) <td>
                                    {{ $scores[$i] }}
                                    </td>
                                    @endfor
                                    <td>{{ $result }}</td>
                            </tr>
                    </table>
                </div>
            </div><br><br>
            <a class="btn link2" href="{{ route('nouveauScore', [$coups[0]->tournoiId, $coups[0]->couleur]) }}">Retour</a>
        </div>
    </div>
</body>

</html>