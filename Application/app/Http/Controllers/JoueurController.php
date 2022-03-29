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
            $resultatsTournoi[] = $tournoi->getResultatsPlayers($couleur);
        }

        return view('vueJoueur', compact('joueur', 'age', 'tournois', 'resultatsTournoi'));
    }
}
