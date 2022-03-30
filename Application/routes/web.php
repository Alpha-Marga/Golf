<?php

use App\Http\Controllers\CoupController;
use App\Http\Controllers\SaisonController;
use App\Http\Controllers\JoueurController;
use App\Http\Controllers\TournoiController;
use App\Http\Controllers\ParcoursController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [TournoiController::class, 'getAllTournament'])->name('accueil');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('joueur', [JoueurController::class, 'getAllJoueurs'])
->name('joueur');

Route::get('vueTournois', [TournoiController::class, 'getAllTournament'])
->name('vueTournois');

Route::get('vueTournoi/{id}', [TournoiController::class, 'getTournament'])
->name('vueTournoi');

Route::get('creationTournoi/{genre}', [TournoiController::class, 'newTournament'])
->name('creationTournoi');

Route::post('nouveauTournoi', [TournoiController::class, 'saveTournament'])
->name('nouveauTournoi');

Route::get('vueParcours/{id}', [ParcoursController::class, 'getParcours'])
->name('vueParcours');

Route::get('nouveauScore/{id}/{niveau}', [CoupController::class, 'newScore'])
->name('nouveauScore');

Route::get('vueJoueur/{id}', [JoueurController::class, 'getPlayer'])
->name('vueJoueur');

Route::post('vueResultat', [CoupController::class, 'saveScore'])
->name('vueResultat');

Route::get('classementTournoi/{id}', [TournoiController::class, 'classement'])
->name('classementTournoi');

Route::get('classementSaison', [SaisonController::class, 'classementSaison'])
->name('classementSaison');
// Route::get('vueTournoi/{id}', [

//     'as' => 'vueTournoi.getTournament',

//     'uses' => 'TournoiController@getTournament',

// ]);

require __DIR__.'/auth.php';
