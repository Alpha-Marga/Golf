<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    use HasFactory;

    public function tournoi(){
        return $this->belongsTo(Tournoi::class);
    }

    // Fonction qui retourne les dates (jour) d'un tournoi
    public function getDays($saisonId, $tournoiId){
        $dates = Date::where('saisonId', $saisonId)->where('tournoiId', $tournoiId)->get();
        return $dates;
    }
}
