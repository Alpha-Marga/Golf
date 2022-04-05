@php ($titre = "Accueil")
@include('layouts.entete')


<body>

  <div class="container-lg h-50">
<br>
    <h2>Le Site Officiel De La Féderation Française De Golf</h2>

    <div id="demo" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
          <!-- Affichage des tournois du moment -->
          @if(count($tournoiJour) > 0)
        <div class="carousel-item active">
          <div class="d-block">
            <div class="div1">
              <h3 class="title">Tournois Du Moment</h3>
              @foreach($tournoiJour as $tournoi)
              <div class="tournoi" id="child1">
                <div id="tournoi1" style="background-image: url('../image/tournoi.jpg');">
                  <h1> {{ $tournoi->nomTournoi.' '.$tournoi->saisonId }}</h1>
                </div>
                <div id="tournoi2">
                  <p>Le {{ $tournoi->nomTournoi }} de l'édition {{ $tournoi->saisonId }} est un tournoi de golf de catégorie {{ $tournoi->categorie }}" qui se déroule du {{ \Carbon\Carbon::parse($tournoi->debut)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($tournoi->fin)->format('d/m/Y') }} sur le parcours {{ $tournoi->parcours->nomParcours }} à {{ $tournoi->parcours->villeParcours }}.</p>
                  <div class="center-c">
                    <a class="btn link" href="{{ route('vueTournoi', [$tournoi->idTournoi]) }}">Détails</a>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        @endif

        <!-- Affichage des tournois à venir -->
        @if(count($tournoisFuturs) > 0)

        <div class="carousel-item">
          <div class="d-block">
            <div class="div1">
              <h3 class="title">Tournois A Venir</h3>
              @foreach($tournoisFuturs as $tournoi)
              <div class="tournoi" id="child1">
                <div id="tournoi1" style="background-image: url('../image/tournoi3.jpg');">
                  <h1> {{ $tournoi->nomTournoi.' '.$tournoi->saisonId }}</h1>
                </div>
                <div id="tournoi2">
                  <p>Le {{ $tournoi->nomTournoi }} de l'édition {{ $tournoi->saisonId }} est un tournoi de golf de catégorie {{ $tournoi->categorie }}" qui va se dérouler du {{ \Carbon\Carbon::parse($tournoi->debut)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($tournoi->fin)->format('d/m/Y') }} sur le parcours {{ $tournoi->parcours->nomParcours }} à {{ $tournoi->parcours->villeParcours }}.</p>
                  <div class="center-c">
                    <a class="btn link" href="{{ route('vueTournoi', [$tournoi->idTournoi]) }}">Détails</a>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>

        @endif



        <!-- Affichage des tournois passés -->
        <div class="carousel-item">
          <div class="d-block">
            <div class="div1">
              <h3 class="title">Tournois Passés</h3>
              @foreach($tournoisPasses as $tournoi)
              <div class="tournoi" id="child1">
                <div id="tournoi1" style="background-image: url('../image/tournoi2.jpg');">
                  <h1> {{ $tournoi->nomTournoi.' '.$tournoi->saisonId }}</h1>
                </div>
                <div id="tournoi2">
                  <p>Le {{ $tournoi->nomTournoi }} de l'édition {{ $tournoi->saisonId }} est un tournoi de golf de catégorie {{ $tournoi->categorie }}" qui s'est déroulé du {{ \Carbon\Carbon::parse($tournoi->debut)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($tournoi->fin)->format('d/m/Y') }} sur le parcours {{ $tournoi->parcours->nomParcours }} à {{ $tournoi->parcours->villeParcours }}.</p>
                  <div class="center-c">
                    <a class="btn link" href="{{ route('vueTournoi', [$tournoi->idTournoi]) }}">Détails</a>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
            </button>
      </div>
    </div>
    <br><br><br>
    @include('layouts.pied')
  </div>

</body>


</html>