<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saison extends Model
{
    use HasFactory;

    protected $primaryKey = 'idSaison';

    public function tournois(){

        return $this->hasMany(Tournoi::class, 'saisonId');
    }
}
