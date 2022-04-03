<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joueur extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prenom', 'adresse', 'cp', 'ville', 'telephone', 'Niveau'];

    public function tournois()
    {
        return $this->belongsToMany(Tournoi::class);
    }

    // Fonction qui retourne la couleur en fonction du niveau d'un joueur
    public function getColorPlayer()
    {
        if ($this->Niveau == 'Messieurs Professionnels')
            $couleur = 'Noir';
        elseif ($this->Niveau == 'Messieurs Bon Index')
            $couleur = 'Blanc';
        elseif ($this->Niveau == 'Messieurs')
            $couleur = 'Jaune';
        elseif ($this->Niveau == 'Dames Bon Index')
            $couleur = 'Bleu';
        else
            $couleur = 'Rouge';
        return $couleur;
    }
}
