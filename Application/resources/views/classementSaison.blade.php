@php ($titre = "Classement saison")
@include('layouts.entete')

<body class="antialiased">
  <div class="container h-75">
    <br><br>
    @foreach($saisons as $saison)
    @if(count($saison->tournois) > 0)

    <h3 class="title">Classement Saison {{ $saison->idSaison }} </h3>
    <!-- <h2> Messieurs </h2> -->

    <div class="div6">
      @foreach($niveauxMessieurs as $niveau)

      @if($niveau->couleur == 'Noir')
      @php ($leNiveau = 'Messieurs Professionnels')

      @elseif($niveau->couleur == 'Blanc')
      @php ($leNiveau = 'Messieurs Bon Index')

      @else
      @php ($leNiveau = 'Messieurs')
      @endif

      <div>
        <table class="classement">

          <h5> {{ $leNiveau }} </h5>

          <th>Rang</th>
          <th>Joueurs</th>
          <th>Resultats</th>

          @php ($comp = 0)
          @foreach($resultatTournoi as $resultat)
          @foreach ($resultat as $resultat1)
          @if($resultat1->couleur == $niveau->couleur)
          @php ($comp = $comp + 1)

          <tr>
            <td>{{ $comp }}</td>
            <td>{{ $resultat1->nom.' '.$resultat1->prenom }}</td>
            <td>{{ $resultat1->resultat_saison }}</td>
          </tr>

          @endif
          @endforeach
          @endforeach
        </table>
      </div>
      @endforeach
    </div>

    <br><br>
    <!-- <h2> Dames </h2> -->

    <div class="div8">
      @foreach($niveauxDames as $niveau)

      @if($niveau->couleur == 'Bleu')
      @php ($leNiveau = 'Dames Bon Index')

      @else
      @php ($leNiveau = 'Dames')
      @endif


      <div>
        <table class="classement2">
          
          <h5> {{ $leNiveau }} </h5>

          <th>Rang</th>
          <th>Joueurs</th>
          <th>Resultats</th>

          @php ($comp = 0)
          @foreach($resultatTournoi as $resultat)
          @foreach ($resultat as $resultat1)
          @if($resultat1->couleur == $niveau->couleur)
          @php ($comp = $comp + 1)
          <tr>
            <td>{{ $comp }}</td>
            <td>{{ $resultat1->nom.' '.$resultat1->prenom }}</td>
            <td>{{ $resultat1->resultat_saison }}</td>
          </tr>
          @endif
          @endforeach
          @endforeach
        </table>
      </div>
      @endforeach
    </div>


    @endif
    @endforeach
<br><br>
  </div>
</body>

</html>