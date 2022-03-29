<?php

namespace App\Http\Controllers;

use App\Models\Joueur;
use App\Models\JoueursTournoi;
use App\Models\Tournoi;
use App\Models\Parcours;
use App\Models\Saison;
use App\Models\Date;
use App\Models\Resultat;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class SaisonController extends Controller
{

    // Fonction qui permet d'obtenir le classement géneral des saisons
    
    public function classementSaison()
    {
        $saisons = Saison::all();
        foreach ($saisons as $saison) {
            $tournois[] = $saison->tournois;
        }
        $niveauxMessieurs = DB::table('trous')->distinct()->where('genreJoueur', '=', 'Messieurs')->get(['couleur']);
        $niveauxDames = DB::table('trous')->distinct()->where('genreJoueur', '=', 'Dames')->get(['couleur']);
        $categories = DB::table('tournois')->distinct()->get(['categorie']);


        foreach ($saisons as $saison) {
            $resultatTournoi[] = DB::table('resultats')
                ->join('joueurs', 'joueurs.id', '=', 'resultats.joueurId')
                ->join('tournois', 'tournois.idTournoi', '=', 'resultats.tournoiId')
                ->select('nom', 'prenom', 'couleur', 'categorie', 'resultats.saisonId', DB::raw('SUM(resultat) as resultat_saison'))
                ->where('resultats.saisonId', '=', $saison->idSaison)
                ->whereNotNull('resultat')
                ->groupBy('joueurId', 'couleur', 'categorie', 'resultats.saisonId')
                ->orderBy('resultat_saison')
                ->get();
        }


        return view('classementSaison', compact('saisons', 'resultatTournoi', 'niveauxMessieurs', 'niveauxDames', 'categories'));
    }
}
