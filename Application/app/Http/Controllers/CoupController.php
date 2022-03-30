<?php

namespace App\Http\Controllers;

use App\Models\Joueur;
use Illuminate\Http\Request;
use App\Models\Tournoi;
use App\Models\Parcours;
use App\Models\Resultat;
use App\Models\Trou;
use App\Models\Coup;
use App\Models\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class CoupController extends Controller
{

    // Fonction qui récupère les informations nécessaires pour la saisie des scores et affiche la vue du formulaire

    public function newScore($id, $niveau)
    {

        $tournoi = Tournoi::find($id);
        $dateJour = Carbon::now()->format('Y-m-d');
        $date = new Date();
        $dates = $date->getDays($tournoi->saisonId, $tournoi->idTournoi);

        for ($i = 0; $i < count($dates); $i++) {
            if ($dates[$i]->date == $dateJour) {
                $laDate = $dates[$i];
            }
        }
        if ($niveau == 'Noir')
            $niveauJoueur = 'Messieurs Professionnels';
        elseif ($niveau == 'Blanc')
            $niveauJoueur = 'Messieurs Bon Index';
        elseif ($niveau == 'Jaune')
            $niveauJoueur = 'Messieurs';
        elseif ($niveau == 'Bleu')
            $niveauJoueur = 'Dames Bon Index';
        else
            $niveauJoueur = 'Dames';

        $jour = $laDate->jour;
        $parcours = Parcours::find($tournoi->parcoursId);
        $saison = $laDate->saisonId;
        $categorieTournoi = $tournoi->categorie;
        $trous = DB::table('trous')->distinct()->get(['idTrou']);
        $joueurs = Tournoi::find($id)->joueurs;

        foreach ($joueurs as $joueur) {
            if ($joueur->Niveau == $niveauJoueur) {
                $joueursNiveau[] = $joueur;
            }
        }
        if (isset($joueursNiveau)) {
            return view('nouveauScore', compact('id', 'jour', 'saison', 'parcours', 'trous', 'joueursNiveau', 'niveau'));
        }
    }




    // Fonction qui sauvegarde les nombres de coups réalisés par un golfeur(se), calcul les points obtenu et crée la vue qui affiche le resultat

    public function saveMatch(Request $request)
    {

        $trous = $request->input('trouId');
        $nbCoups = $request->input('nombreCoups');

        $compteur = 0;
        for ($i = 0; $i < count($trous); $i++) {
            if ($nbCoups[$i] != null) {
                $compteur = $compteur + 1;
            }
        }

        if ($compteur > 0) {
            for ($i = 0; $i < count($trous); $i++) {
                if ($nbCoups[$i] != null) {

                    $leCoup = Coup::where('joueurId', $request->input('joueurId'))
                        ->where('saisonId', $request->input('saisonId'))
                        ->where('tournoiId', $request->input('idTournoi'))
                        ->where('jour', $request->input('jour'))
                        ->where('couleur',  $request->input('couleur'))
                        ->where('parcoursId', $request->input('parcoursId'))
                        ->where('trouId',  $trous[$i])
                        ->get();

                    // Sauvegarde des coups réalisés

                    if (count($leCoup) == 0) {
                        $coup = new Coup;
                        $coup->timestamps = false;

                        $coup->saisonId = $request->input('saisonId');
                        $coup->tournoiId = $request->input('idTournoi');
                        $coup->parcoursId = $request->input('parcoursId');
                        $coup->jour = $request->input('jour');
                        $coup->trouId = $trous[$i];
                        $coup->couleur = $request->input('couleur');
                        $coup->joueurId = $request->input('joueurId');
                        $coup->nombreCoups = $nbCoups[$i];

                        $coup->save();
                    } else {

                        // Création du message d'erreur si le nombre de coups d'un trou a dejà été enregistré
                        $message = 'Vous avez dejà enregistré le nombre de coups pour le Trou' . ' ' . $leCoup[0]->trouId . ' !';
                        $leCoup['tournoiId'] = $request->input('idTournoi');
                        $leCoup['couleur'] = $request->input('couleur');

                        return view('vueMessage', compact('message', 'leCoup'));
                    }
                }
            }

            $tournoi = Tournoi::find($request->input('idTournoi'));
            $joueur = Joueur::find($request->input('joueurId'));
            $coups = Coup::where('joueurId', $coup->joueurId)
                ->where('saisonId', $coup->saisonId)
                ->where('tournoiId', $coup->tournoiId)
                ->where('jour', $coup->jour)
                ->where('couleur',  $coup->couleur)
                ->where('parcoursId', $coup->parcoursId)
                ->get();

            // Sauvegarde des resulats obtenus et création de la vue qui affiche les resultats

            if (count($coups) == 9) {
                $resultat = new Resultat;
                $resultat->timestamps = false;

                $resultat->saisonId = $request->input('saisonId');
                $resultat->tournoiId = $request->input('idTournoi');
                $resultat->parcoursId =  $request->input('parcoursId');
                $resultat->jour = $request->input('jour');
                $resultat->couleur = $request->input('couleur');
                $resultat->joueurId = $request->input('joueurId');

                $resultat->resultat = $tournoi->saveResultat($request->input('idTournoi'),  $request->input('saisonId'), $request->input('joueurId'), $request->input('parcoursId'), $request->input('couleur'), $request->input('jour'));

                $resultat->save();
            }

            $result = 0;
            for ($i = 0; $i < count($coups); $i++) {
                $idtrou = $coups[$i]->trouId;
                $trou = Trou::find($idtrou);
                $scores[] = $coups[$i]->nombreCoups - $trou->par;
                $result = $result + ($coups[$i]->nombreCoups - $trou->par);
            }

            return view('vueResultat', compact('joueur', 'coups', 'scores', 'result'));
        } else {

            // Création du message d'erreur si aucun score n'est saisi
            $message = 'Vous devez saisir au moins un score !';
            $leCoup['tournoiId'] = $request->input('idTournoi');
            $leCoup['couleur'] = $request->input('couleur');

            return view('vueMessage', compact('message', 'leCoup'));
        }
    }
}
