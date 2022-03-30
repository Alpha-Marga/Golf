<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coup extends Model
{
    use HasFactory;

// Fonction qui retourne le coup réalisé par un joueur sur un trou
    public function getCoup($joueurId, $saisonId, $idTournoi, $jour, $couleur, $parcoursId, $trouId)
    {
        $leCoup = Coup::where('joueurId', $joueurId)
        ->where('saisonId', $saisonId)
        ->where('tournoiId', $idTournoi)
        ->where('jour', $jour)
        ->where('couleur',  $couleur)
        ->where('parcoursId', $parcoursId)
        ->where('trouId',  $trouId)
        ->get();

        return $leCoup;
    }

// Fonction qui retourne les coups réalisés par un joueur 
    public function getAllCoups($joueurId, $saisonId, $idTournoi, $jour, $couleur, $parcoursId)
    {
        $leCoup = Coup::where('joueurId', $joueurId)
        ->where('saisonId', $saisonId)
        ->where('tournoiId', $idTournoi)
        ->where('jour', $jour)
        ->where('couleur',  $couleur)
        ->where('parcoursId', $parcoursId)
        ->get();

        return $leCoup;
    }
}
