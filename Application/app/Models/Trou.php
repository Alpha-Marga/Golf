<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trou extends Model
{
    use HasFactory;

    protected $primaryKey = 'idTrou';

    public function parcours(){

        return $this->belongsTo(Parcours::class);
    }
}
