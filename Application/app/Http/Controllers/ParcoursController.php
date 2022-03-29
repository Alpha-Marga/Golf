<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Parcours;

class ParcoursController extends Controller
{
    public function getParcours($id){
        $parcours = Parcours::find($id);
        $trous = Parcours::find($id)->trous->sortByDesc('distanceMetre')->sortBy('idTrou');
        return view('vueParcours', compact('parcours', 'trous'));
    }
}
