<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resultat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Tournoi extends Model
{
    use HasFactory;


    protected $primaryKey = 'idTournoi';

    public function parcours()
    {

        return $this->hasOne(Parcours::class, 'idParcours');
    }

    public function saison()
    {
        return $this->belongsTo(Saison::class);
    }

    public function joueurs()
    {
        return $this->belongsToMany(Joueur::class);
    }

    public function coups()
    {
        return $this->hasMany(Coup::class, 'tournoiId');
    }

    public function dates()
    {

        return $this->hasMany(Date::class, 'tournoiId');
    }


    public function tournamentCurrent()
    {
        $date = Carbon::now()->format('Y-m-d');
        $tournoiMoment = Tournoi::where('debut', '<=', $date)->where('fin', '>=', $date)->get();

        return $tournoiMoment;
    }

    public function tournamentComing()
    {
        $date = Carbon::now()->format('Y-m-d');
        $tournoisFuturs = Tournoi::where('debut', '>', $date)->get();

        return $tournoisFuturs;
    }

    public function tournamentPast()
    {
        $date = Carbon::now()->format('Y-m-d');
        $tournoisPasses = Tournoi::where('fin', '<', $date)->get();

        return $tournoisPasses;
    }


    public function saveResultat($idTournoi, $idSaison, $idJoueur, $idParcours, $couleur, $jour)
    {

        $coups = Coup::where('joueurId', $idJoueur)
            ->where('saisonId', $idSaison)
            ->where('tournoiId', $idTournoi)
            ->where('jour', $jour)
            ->where('couleur',  $couleur)
            ->where('parcoursId', $idParcours)
            ->get();

        if (count($coups) != 0) {
            $resultat = 0;
            for ($i = 0; $i < count($coups); $i++) {
                $idtrou = $coups[$i]->trouId;
                $trou = Trou::find($idtrou);
                $scores[] = $coups[$i]->nombreCoups - $trou->par;
                $resultat = $resultat + ($coups[$i]->nombreCoups - $trou->par);
            }
            return $resultat;
        }
    }

    public function getResultats($idSaison, $idParcours)
    {

        $resultats[] = Resultat::where('saisonId', $idSaison)
            ->where('tournoiId', $this->idTournoi)
            ->where('parcoursId', $idParcours)
            ->whereNotNull('resultat')
            ->get();

        return $resultats;
    }

    public function getResultatsFinaux()
    {

        $resultatsFinaux = DB::table('resultats')
            ->join('joueurs', 'joueurs.id', '=', 'resultats.joueurId')
            ->select('nom', 'prenom', 'couleur', DB::raw('SUM(resultat) as resultat_tournoi'))
            ->where('tournoiId', '=', $this->idTournoi)
            ->whereNotNull('resultat')
            ->groupBy('joueurId', 'couleur')
            ->orderBy('resultat_tournoi')
            ->get();

        return $resultatsFinaux;
    }
   
    public function getResultatsPlayers($couleur)
    {
        $resultatsJoueurs =  DB::table('resultats')
        ->join('joueurs', 'joueurs.id', '=', 'resultats.joueurId')
        ->select('joueurId', 'tournoiId', 'couleur', DB::raw('SUM(resultat) as resultat_tournoi'))
        ->where('tournoiId', '=', $this->idTournoi)
        ->where('couleur', '=', $couleur)
        ->whereNotNull('resultat')
        ->groupBy('joueurId', 'couleur', 'tournoiId')
        ->orderBy('resultat_tournoi')
        ->get();

        return $resultatsJoueurs;
    }
}
