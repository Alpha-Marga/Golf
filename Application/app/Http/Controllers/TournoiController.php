<?php

namespace App\Http\Controllers;

use App\Models\Joueur;
use App\Models\JoueursTournoi;
use Illuminate\Http\Request;
use App\Models\Tournoi;
use App\Models\Parcours;
use App\Models\Saison;
use App\Models\Date;
use App\Models\Resultat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TournoiController extends Controller
{

    // Fonction qui récupère les informations necessaires et dirige vers la page d'accueil

    public function getAllTournament()
    {
        $date = Carbon::now()->format('Y-m-d');

        $tournoi = new Tournoi();
        $tournoiJour = $tournoi->tournamentCurrent();
        $tournoisFuturs = $tournoi->tournamentComing();
        $tournoisPasses = $tournoi->tournamentPast();
        return view('accueil', compact('tournoisFuturs', 'tournoiJour', 'tournoisPasses'));
    }

    
    // Fonction qui récupère toutes les informations d'un tournoi et dirige vers la page concerné

    public function getTournament(int $id)
    {
        $tournoi = Tournoi::find($id);
        $joueurs = Tournoi::find($id)->joueurs->sortBy('nom');
        foreach ($joueurs as $joueur) {
            $dateN = $joueur->dateNaissance;
            $ages[] = date('Y') -  date('Y', strtotime($dateN));
        }

        $parcours = Parcours::find($tournoi->parcoursId);
        $trous = $parcours->trousDistinct();
        $niveauxParcours = $parcours->levelByColorAndGender();
        $pars = $parcours->pars();
        $dateJour = Carbon::now()->format('Y-m-d');

        $saison = $tournoi->saisonId;
        $idParcours = $tournoi->parcoursId;
        $categorieTournoi = $tournoi->categorie;
        $niveauxClassement = $parcours->levelByColor($categorieTournoi);
        $dates = Tournoi::find($id)->dates;
        foreach ($dates as $date) {
            $jours[] = $date->jour;
        }

        $resultats = $tournoi->getResultats($saison, $idParcours);

        foreach ($resultats as $info) {
            $infos[] = $info->sortBy('resultat');
        }

        $resultatsFinaux = $tournoi->getResultatsFinaux();

        return view('vueTournoi', compact('tournoi', 'joueurs', 'parcours', 'jours', 'resultatsFinaux', 'ages', 'infos', 'trous', 'pars', 'niveauxParcours', "niveauxClassement", 'dateJour'));
    }


    // Fonction du contrôleur qui récupère les informations necessaires et crée la vue de création d'un tournoi

    public function newTournament($genre)
    {
        $parcours = Parcours::all();
        $saison = new Saison();
        $saison = $saison->saisonCurrent();
        if ($genre == 'Femme') {
            $categorie = 'Dames';
        } else {
            $categorie = 'Messieurs';
        }
        $id = count(Tournoi::all()) + 1;
        $joueurs = Joueur::where('genre', '=', $genre)->get();

        return view('creationTournoi', compact('categorie', 'saison', 'parcours', 'id', 'joueurs'));
    }


    
    // Fonction qui sauvegarde toutes les données d'un nouveau tournoi

    public function saveTournament(Request $request)
    {

        // Sauvegarde Tournoi

        $tournoi = new Tournoi;
        $tournoi->timestamps = false;
        $tournoi->saisonId = $request->input('saisonId');
        $tournoi->idTournoi = $request->input('idTournoi');
        $tournoi->parcoursId = $request->input('parcoursId');
        $tournoi->nomTournoi = $request->input('nomTournoi');
        $tournoi->debut = $request->input('debut');
        $tournoi->fin = $request->input('fin');
        $tournoi->categorie = $request->input('categorie');

        $tournoi->save();

        $joueurs = $request->input('joueurs');

        // Sauvegarde des joueurs participants

        if ($joueurs > 0) {
            for ($i = 0; $i < count($joueurs); $i++) {

                $joueur_tournoi = new JoueursTournoi;
                $joueur_tournoi->timestamps = false;

                $joueur_tournoi->joueur_id = $joueurs[$i];
                $joueur_tournoi->saisonId =  $request->input('saisonId');
                $joueur_tournoi->tournoi_idTournoi =  $request->input('idTournoi');

                $joueur_tournoi->save();
            }
        }

        // Sauvegarde des dates de déroulement

        $finTournoi = $request->input('fin');
        $debutTournoi = $request->input('debut');
        $nbJour = Carbon::parse($debutTournoi)->floatDiffInDays($finTournoi);

        $dateJ = $request->input('debut');
        $dateN1 = date('Y-m-d', strtotime("$dateJ +1 day"));
        for ($i = 0; $i <= $nbJour; $i++) {
            $jour = $i;
            $date = new Date;
            $date->timestamps = false;
            $date->saisonId = $request->input('saisonId');
            $date->tournoiId = $request->input('idTournoi');
            $date->jour = $jour + 1;
            $date->date = date('Y-m-d', strtotime("$dateJ + $jour day"));

            $date->save();
        }

        // Récuperation des données necessaires pour l'affichage des infos du nouveau terrain

        $id = count(Tournoi::all());
        $tournoi = Tournoi::find($id);
        $parcours = Parcours::find($tournoi->parcoursId);
        $joueurs = Tournoi::find($id)->joueurs->sortBy('nom');

        foreach ($joueurs as $joueur) {
            $dateN = $joueur->dateNaissance;
            $ages[] = date('Y') -  date('Y', strtotime($dateN));
        }

        $dateJour = Carbon::now()->format('Y-m-d');
        $dates = $tournoi->dates;
        foreach ($dates as $date) {
            $jours[] = $date->jour;
        }

        $trous = $parcours->trousDistinct();
        $niveauxParcours = $parcours->levelByColorAndGender();
        $categorieTournoi = $tournoi->categorie;
     
        // Récuperation des niveaux(couleurs) des golfeurs(se) qui participent au tournoi

        $niveauxJoueurs = array();
        foreach ($joueurs as $joueur) {

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
    
            if (!in_array($couleur, $niveauxJoueurs)) {
                $niveauxJoueurs[] = $couleur;
            }
        }

        $pars = $parcours->pars();

        return view('nouveauTournoi', compact('tournoi', 'joueurs', 'parcours', 'ages', 'jours', 'dateJour', 'trous', 'pars', 'niveauxParcours', 'niveauxJoueurs'));
    }
}
