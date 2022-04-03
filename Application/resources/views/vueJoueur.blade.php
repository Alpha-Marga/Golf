@php ($titre = "Joueur")
@include('layouts.entete')

<body class="antialiased">
    <div class="container h-100">
        <br><br>
        @if($message != null)
        <div class="div6">
            <div class="message2">
                {{$message}}
            </div>
        </div>
        @endif
        <br>
        <div class="div9">
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
                    @if (Route::has('login')) @auth
                    <div class="center-c">
                        <a href="#" type="submit" class="btn link btn-sm" onclick="showDiv()">Modifier</a>
                    </div>
                    @endauth
                    @endif
                </div>
            </div>

            <!-- Script permettant de masquer le contenu dans le buton "Modifier" -->
            <script>
                function showDiv() {
                    document.getElementById('sign-in').style.display = "block";
                }
            </script>

            <div id="sign-in" class="login" style="display: none;">
                <form class="form-profil" action="{{route('modifierProfil')}}" method="POST">
                    @csrf
                    <section><br>
                        <div class="form-group row">

                            <div class="col-sm-10">
                                <input type="hidden" name="id" value="{{ $joueur->id }}" />
                                <label class="col-sm-3 col-form-label">Nom:</label>
                                <input id="zone_text2" type="text" name="nom" value="{{$joueur->nom}}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <label class="col-sm-3 col-form-label">Prénom:</label>
                                <input id="zone_text2" type="text" name="prenom" value="{{$joueur->prenom}}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <label class="col-sm-3 col-form-label">Adresse:</label>
                                <input id="zone_text2" type="text" name="adresse" value="{{$joueur->adresse}}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <label class="col-sm-3 col-form-label">Code Postal:</label>
                                <input id="zone_text2" type="text" name="cp" value="{{$joueur->cp}}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <label class="col-sm-3 col-form-label">Ville:</label>
                                <input id="zone_text2" type="text" name="ville" value="{{$joueur->ville}}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <label class="col-sm-3 col-form-label">Télephone:</label>
                                <input id="zone_text2" type="text" name="telephone" value="{{$joueur->telephone}}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <label class="col-sm-3 col-form-label">Niveau:</label>
                                <input id="zone_text2" type="text" name="niveau" value="{{$joueur->Niveau}}" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-11"><br>
                                <button type="submit" class="btn-success2 btn-lg3" value="Envoyer">Confirmer</button>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>

        <!-- Affichage des tournois auxquels le joueur a participés -->
        <br><br><br>
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
                        @for($i=0; $i<count($resultats); $i++) @if($resultats[$i]->tournoiId == $tournoi->idTournoi && $resultats[$i]->joueurId == $joueur->id)
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