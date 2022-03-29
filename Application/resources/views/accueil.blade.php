@php ($titre = "Accueil")
@include('layouts.entete')



<body class="antialiased">

  <div class="container h-100">
    
    <h2>Le Site Officiel De La Féderation Française De Golf</h2>
  <!-- Affichage des tournois du moment -->

    
      <div class="div1">
      <h3 class="title">Tournois du moment</h3>
        @foreach($tournoiJour as $tournoi)
        <div class="tournoi" id="child1">
          <div id="tournoi1" style="background-image: url('../image/tournoi.jpg');">
            <h1> {{ $tournoi->nomTournoi.' '.$tournoi->saisonId }}</h1>
          </div>
          <div id="tournoi2">
            <p>Le <b>{{ $tournoi->nomTournoi }}</b> de l'édition <b>{{ $tournoi->saisonId }}</b> est un tournoi de golf de catégorie "<b>{{ $tournoi->categorie }}</b>" qui se déroule du <b>{{ \Carbon\Carbon::parse($tournoi->debut)->format('d/m/Y') }}</b> au <b>{{ \Carbon\Carbon::parse($tournoi->fin)->format('d/m/Y') }}</b> sur le parcours <b>{{ $tournoi->parcours->nomParcours }}</b> à {{ $tournoi->parcours->villeParcours }}.</p>
            <div class="center-c">
              <a class="btn link" href="{{ route('vueTournoi', [$tournoi->idTournoi]) }}">Détails</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>

  <!-- Affichage des tournois à venir -->
      @if(count($tournoisFuturs) > 0)
      <br><br><br>
      
      <div class="div1">
      <h3 class="title">Tournois à venir</h3>
        @foreach($tournoisFuturs as $tournoi)
        <div class="tournoi" id="child1">
          <div id="tournoi1" style="background-image: url('../image/tournoi3.jpg');">
            <h1> {{ $tournoi->nomTournoi.' '.$tournoi->saisonId }}</h1>
          </div>
          <div id="tournoi2">
            <p>Le <b>{{ $tournoi->nomTournoi }}</b> de l'édition <b>{{ $tournoi->saisonId }}</b> est un tournoi de golf de catégorie "<b>{{ $tournoi->categorie }}</b>" qui s'est déroulé du <b>{{ \Carbon\Carbon::parse($tournoi->debut)->format('d/m/Y') }}</b> au <b>{{ \Carbon\Carbon::parse($tournoi->fin)->format('d/m/Y') }}</b> sur le parcours <b>{{ $tournoi->parcours->nomParcours }}</b> à {{ $tournoi->parcours->villeParcours }}.</p>
            <div class="center-c">
              <a class="btn link" href="{{ route('vueTournoi', [$tournoi->idTournoi]) }}">Détails</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @endif

      <br><br><br>

  <!-- Affichage des tournois passés -->
      
      <div class="div1">
      <h3 class="title">Tournois passés</h3>
        @foreach($tournoisPasses as $tournoi)
        <div class="tournoi" id="child1">
          <div id="tournoi1" style="background-image: url('../image/tournoi2.jpg');">
            <h1> {{ $tournoi->nomTournoi.' '.$tournoi->saisonId }}</h1>
          </div>
          <div id="tournoi2">
            <p>Le <b>{{ $tournoi->nomTournoi }}</b> de l'édition <b>{{ $tournoi->saisonId }}</b> est un tournoi de golf de catégorie "<b>{{ $tournoi->categorie }}</b>" qui s'est déroulé du <b>{{ \Carbon\Carbon::parse($tournoi->debut)->format('d/m/Y') }}</b> au <b>{{ \Carbon\Carbon::parse($tournoi->fin)->format('d/m/Y') }}</b> sur le parcours <b>{{ $tournoi->parcours->nomParcours }}</b> à {{ $tournoi->parcours->villeParcours }}.</p>
            <div class="center-c">
              <a class="btn link" href="{{ route('vueTournoi', [$tournoi->idTournoi]) }}">Détails</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <br><br>
  </div>

</body>

</html>