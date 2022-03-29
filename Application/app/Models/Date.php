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

    public function getDays($saisonId, $tournoiId){
        $jours = Date::where('saisonId', $saisonId)->where('tournoiId', $tournoiId)->get();
        return $jours;
    }
}
