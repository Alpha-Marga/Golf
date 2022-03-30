<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class Saison extends Model
{
    use HasFactory;

    protected $primaryKey = 'idSaison';

    public function tournois(){

        return $this->hasMany(Tournoi::class, 'saisonId');
    }

    // Fonction qui retourne la saison actuelle
    public function saisonCurrent()
    {
        $date = Carbon::now()->format('Y-m-d');
        $saison = Saison::where('debutSaison', '<=', $date)->where('finSaison', '>=', $date)->get();
        return $saison;
    }

    // Fonction qui retourne les niveaux des Hommes
    public function levelMessieurs()
    {
        $niveaux = DB::table('trous')->distinct()->where('genreJoueur', '=', 'Messieurs')->get(['couleur']);
        return $niveaux;
    }

    // Fonction qui retourne les niveaux des Femmes
    public function levelDames()
    {
        $niveaux = DB::table('trous')->distinct()->where('genreJoueur', '=', 'Dames')->get(['couleur']);

        return $niveaux;
    }

    // Fonction qui retourne les categories des tournois
    public function categoriesTournament()
    {
        $categories = DB::table('tournois')->distinct()->get(['categorie']);

        return $categories;
    }

    // Fonction qui retourne les resultats d'une saison
    public function getResultatsSaison()
    {
        $resultatsSaison = DB::table('resultats')
        ->join('joueurs', 'joueurs.id', '=', 'resultats.joueurId')
        ->join('tournois', 'tournois.idTournoi', '=', 'resultats.tournoiId')
        ->select('nom', 'prenom', 'couleur', 'categorie', 'resultats.saisonId', DB::raw('SUM(resultat) as resultat_saison'))
        ->where('resultats.saisonId', '=', $this->idSaison)
        ->whereNotNull('resultat')
        ->groupBy('joueurId', 'couleur', 'categorie', 'resultats.saisonId')
        ->orderBy('resultat_saison')
        ->get();

        return $resultatsSaison;
    }
}
