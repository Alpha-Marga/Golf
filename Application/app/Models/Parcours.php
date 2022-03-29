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

    
    public function trousDistinct(){
         $trous = DB::table('trous')->distinct()->where('parcoursId', '=', $this->idParcours)->get(['idTrou']);
        return $trous;    
    }

    public function levelByColorAndGender(){
        $niveau = DB::table('trous')->distinct()->where('parcoursId', '=', $this->idParcours)->get(['couleur', 'genreJoueur'])->sortByDesc('couleur')->sortByDesc('genreJoueur');
        return $niveau;    
    }

    public function levelByColor($categorie){
        $niveau = DB::table('trous')->distinct()->where('genreJoueur', '=', $categorie)->get(['couleur']);
        return $niveau;    
    }

    public function pars(){
        $pars = DB::table('trous')->distinct()->where('parcoursId', '=', $this->idParcours)->get(['idtrou', 'par']);
        return $pars;    
    }    
    
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
