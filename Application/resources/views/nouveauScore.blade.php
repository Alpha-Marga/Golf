@php ($titre = "Saisie Score")
@include('layouts.entete')

<head>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="antialiased">
    <div class="container h-75 parent">

<!-- Affichage du formulaire de saisie de scores -->

        <div class="enfant">
            <div class="main-agileinfo2">
                <div class="agileits-top2">
                    <form action="{{ route('vueResultat') }}" method="POST">
                        @csrf
                        <fieldset align="center" class="field">
                            <h2>Saisie score</h2>
                        </fieldset>
                        <input type="hidden" name="saisonId" value="{{ $saison }}">
                        <input type="hidden" name="idTournoi" value=" {{ $id }} ">
                        <input type="hidden" name="parcoursId" value=" {{ $parcours->idParcours }} ">
                        <input type="hidden" name="jour" value=" {{ $jour }} ">

                        <div class="div7">
                            <div>
                                Jour: {{ $jour }}
                            </div>
                            <div id="child1">
                                Niveau : {{ $niveau }}
                                <input type="hidden" name="couleur" value="{{ $niveau }}" required>

                            </div>
                            <div id="child1">
                                @if($niveau == 'Rouge' || $niveau == 'Bleu')
                                Sélectionnez la golfeuse
                                @else
                                Sélectionnez le golfeur
                                @endif
                                <select name="joueurId" required="">
                                    @foreach($joueursNiveau as $joueur)
                                    <option value="{{ $joueur->id }}">{{ $joueur->nom.' '.$joueur->prenom }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="div7">
                            @foreach($trous as $trou)
                            <br>
                            <div>
                                Trou {{ $trou->idTrou }}
                                <input type="hidden" name="trouId[]" value="{{ $trou->idTrou }}"><br>

                                <input type="number" name="nombreCoups[]" placeholder="Nombre coups"><br>
                            </div>
                            @endforeach
                        </div>
                        <br><br>
                        <div class="center-c">
                            <button class="btn-success2 btn-lg3" type="submit" value="Envoyer">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </div>
</body>

</html>