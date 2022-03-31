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
    
    public function seasonRanking()
    {
        $saisons = Saison::all();
        foreach ($saisons as $saison) {
            $tournois[] = $saison->tournois;
        }
        $saison = new Saison();
        $niveauxMessieurs = $saison->levelMessieurs();
        $niveauxDames = $saison->levelDames();
        $categories = $saison->categoriesTournament();

        foreach ($saisons as $saison) {
            $resultatTournoi[] = $saison->getResultatsSaison();
        }
        
        return view('classementSaison', compact('saisons', 'resultatTournoi', 'niveauxMessieurs', 'niveauxDames', 'categories'));
    }
}
