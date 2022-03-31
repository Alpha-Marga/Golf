<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Parcours extends Model
{
    use HasFactory;

    protected $primaryKey = 'idParcours';

    public function tournoi(){
        return $this->belongsTo(Tournoi::class);
    }

    public function trous(){
        return $this->hasMany(Trou::class, 'parcoursId');
    }

    // Fonction qui retourne les différents trous d'un parcours
    public function trousDistinct(){
         $trous = DB::table('trous')->distinct()->where('parcoursId', '=', $this->idParcours)->get(['idTrou']);
        return $trous;    
    }

    // Fonction qui retourne les niveaux d'un parcours selon le genre et la couleur
    public function levelByColorAndGender(){
        $niveau = DB::table('trous')->distinct()->where('parcoursId', '=', $this->idParcours)->get(['couleur', 'genreJoueur'])->sortByDesc('couleur')->sortByDesc('genreJoueur');
        return $niveau;    
    }

    // Fonction qui retourne les niveaux d'un parcours selon la couleur
    public function levelByColor($categorie){
        $niveau = DB::table('trous')->distinct()->where('genreJoueur', '=', $categorie)->get(['couleur']);
        return $niveau;    
    }

    // Fonction qui retourne les pars des trous d'un parcours
    public function pars(){
        $pars = DB::table('trous')->distinct()->where('parcoursId', '=', $this->idParcours)->get(['idtrou', 'par']);
        return $pars;    
    } 
    
    // Fonction qui retourne la distance total des trous d'un parcours
    public function distancesTotal($parcoursId, $couleur){
        $distanceTotal = DB::table('trous')
        ->select(DB::raw('SUM(distanceMetre) as distanceMetreTotal'), DB::raw('SUM(distanceYard) as distanceYardTotal'))
        ->where('parcoursId', '=', $parcoursId)
        ->where('couleur', '=', $couleur)
        ->groupBy('parcoursId', 'couleur')
        ->get();
        
        return $distanceTotal;
        
    }
}
