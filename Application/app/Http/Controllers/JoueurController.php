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
        $couleur = $joueur->getColorPlayer();
        foreach ($tournois as $tournoi) {
            $resultatsTournoi[] = $tournoi->getResultatsByColor($couleur);
        }
        $message = null;
        return view('vueJoueur', compact('joueur', 'age', 'tournois', 'resultatsTournoi', 'message'));
    }


    // Fonction qui met à jour les informations d'un joueur
    public function updateProfil(Request $request)
 {
        $joueur = Joueur::find($request->input('id'));
        $joueur->timestamps = false;
        $joueur->update([
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'adresse' => $request->input('adresse'),
            'cp' => $request->input('cp'),
            'ville' => $request->input('ville'),
            'telephone' => $request->input('telephone'),
            'Niveau' => $request->input('niveau')
        ]);
        $tournois = $joueur->tournois;
        $age = date('Y') -  date('Y', strtotime($joueur->dateNaissance));
        $couleur = $joueur->getColorPlayer();

        foreach ($tournois as $tournoi) {
            $resultatsTournoi[] = $tournoi->getResultatsByColor($couleur);
        }
        $message = 'Le Profil a bien été mis à jour !';
        return view('vueJoueur', compact('joueur', 'age', 'tournois', 'resultatsTournoi', 'message'));
    }
}
