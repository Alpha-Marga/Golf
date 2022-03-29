@php ($titre = "Creation Tournoi")
@include('layouts.entete')

<head>
    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="antialiased" style="background-image: url('../image/create.png');">


<!-- Formulaire de création d'un tournoi -->

    <div class="main-agileinfo">
        <div class="agileits-top">
            <form action="{{ route('nouveauTournoi') }}" method="POST">
                @csrf
                <section>
                    <fieldset class="field">
                        <h2>Création d'un tournoi</h2>
                    </fieldset>

                    <input type="hidden" name="saisonId" value=" {{ $saisons[0]->idSaison }} "><br>
                    <input type="hidden" name="idTournoi" value=" {{ $id }} ">
                    <input type="hidden" name="categorie" value=" {{ $categorie }} ">


                    <input class="ajout" type="text" name="nomTournoi" placeholder="Nom du tournoi" required>

                    <label>Sélectionnez un Parcours</label>
                    <select class="form-select2 ajout" name="parcoursId" required>
                        @foreach($parcours as $unParcours)
                        <option value="{{ $unParcours->idParcours }}">{{ $unParcours->nomParcours }}</option>
                        @endforeach
                    </select><br>

                    <input id="zone_text" class="ajout" type="text" name="debut" placeholder="Date debut" onfocus="(this.type='date')" required><br>

                    <input id="zone_text" class="ajout" type="text" name="fin" placeholder="Date fin" onfocus="(this.type='date')" required><br>

                    <label class="col-sm-3 col-form-label">Participants</label><br>
                    <div class="div2">
                        @foreach($joueurs as $joueur)
                        <div id="child1">
                            <input class="form-check-input" type="checkbox" name="joueurs[]" value="{{ $joueur   ->id }}" id="flexCheckIndeterminate">
                           {{ $joueur->nom.' '.$joueur->prenom}}
                        </div>
                        @endforeach
                    </div>
                    <br>
                    <button class="btn-success2 btn-lg3" type="submit" value="Envoyer">Enregistrer</button>
            </form>
        </div>
    </div>

</body>

</html>