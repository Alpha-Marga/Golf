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
