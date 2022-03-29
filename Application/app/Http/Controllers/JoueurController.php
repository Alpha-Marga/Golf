<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Joueur;
use App\Models\Date;
use App\Models\JoueursTournoi;
use Illuminate\Support\Facades\DB;

class JoueurController extends Controller
{
 
    // Fonction qui recupère et affiche les informations concernant un joueur
    
    public function getPlayer($id)
    {
        $joueur = Joueur::find($id);
        $tournois = $joueur->tournois;
        $age = date('Y') -  date('Y', strtotime($joueur->dateNaissance));

        if ($joueur->Niveau == 'Messieurs Professionnels')
            $couleur = 'Noir';
        elseif ($joueur->Niveau == 'Messieurs Bon Index')
            $couleur = 'Blanc';
        elseif ($joueur->Niveau == 'Messieurs')
            $couleur = 'Jaune';
        elseif ($joueur->Niveau == 'Dames Bon Index')
            $couleur = 'Bleu';
        else
            $couleur = 'Rouge';

        foreach ($tournois as $tournoi) {
            $resultatsTournoi[] = DB::table('resultats')
                ->join('joueurs', 'joueurs.id', '=', 'resultats.joueurId')
                ->select('joueurId', 'tournoiId', 'couleur', DB::raw('SUM(resultat) as resultat_tournoi'))
                ->where('tournoiId', '=', $tournoi->idTournoi)
                ->where('couleur', '=', $couleur)
                ->whereNotNull('resultat')
                ->groupBy('joueurId', 'couleur', 'tournoiId')
                ->orderBy('resultat_tournoi')
                ->get();
        }

        return view('vueJoueur', compact('joueur', 'age', 'tournois', 'resultatsTournoi'));
    }
}
