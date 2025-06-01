<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SquadController;
use App\Http\Controllers\TrainingController;
use Illuminate\Support\Facades\Route;

/*
Route::get('/', function () {
    return view('welcome');
})->name('home');
*/
Route::get('/', [HomeController::class, "view"])->name('home');
Route::get('/entrainements/menu/{levelUps}/{powerUps}', [TrainingController::class, "view"])->name('training');
Route::get('/entrainements/creerProg', [TrainingController::class, "creerProgramme"])->name('creerProgramme');
Route::post('/entrainements/doCreerProg', [TrainingController::class, "doCreerProgramme"])->name('doCreerProgramme');
Route::get('/entrainements/creerExo', [TrainingController::class, "creerExercice"])->name('creerExercice');
Route::post('/entrainements/doCreerExo', [TrainingController::class, "doCreerExercice"])->name('doCreerExercice');
Route::get('/entrainements/modifierProg/{idProg}/{nouvelExo}/{exos}', [TrainingController::class, "modifierProgramme"])->name('modifierProgramme');
Route::post('/entrainements/doModifierProg/{idProg}', [TrainingController::class, "doModifierProgramme"])->name('doModifierProgramme');
Route::get('/entrainements/creerEntrainement/{idProg}/{nouvelExo}/{exos}', [TrainingController::class, "creerEntrainement"])->name('creerEntrainement');
Route::post('/entrainements/doCreerEntrainement/{idProg}', [TrainingController::class, "doCreerEntrainement"])->name('doCreerEntrainement');
Route::get('/entrainements/historique/{idProg}', [TrainingController::class, "historique"])->name('historique');
Route::get('/entrainements/supprimerProg/{idProg}', [TrainingController::class, "supprimerProgramme"])->name('supprimerProgramme');


Route::get('/login',[AuthController::class, 'login' ])->name('auth.login');
Route::get('/signup',[AuthController::class, 'signup' ])->name('auth.signup');
Route::delete('/logout',[AuthController::class, 'logout' ])->name('auth.logout');
Route::post('/login',[AuthController::class, 'doLogin' ])->name('auth.login');
Route::post('/signup',[AuthController::class, 'doSignup' ])->name('auth.signup');

Route::get('/image', function () {
    return view('image.imageForm');
})->name('imageForm');
Route::post('/addImage',[ImageController::class, 'addImage' ])->name('addImage');
Route::get('/image/view', [ImageController::class, "view"])->name('image.view');

Route::get('/squad', [SquadController::class, "view"])->name('squad');
Route::get('/squad/addBro/{idBro}', [SquadController::class, "addBro"])->name('addBro');
Route::get('/squad/doAddBro/{idBro}', [SquadController::class, "doAddBro"])->name('doAddBro');
Route::get('/squad/createSquad', [SquadController::class, "createSquad"])->name('createSquad');
Route::get('/squad/setSquad/{idSquad}/{nouveauBro}/{bros}', [SquadController::class, "setSquad"])->name('setSquad');
Route::post('/squad/doSetSquad/{idSquad}', [SquadController::class, "doSetSquad"])->name('doSetSquad');
Route::get('/squad/deleteSquad/{idSquad}', [SquadController::class, "deleteSquad"])->name('deleteSquad');
Route::get('/squad/leaveSquad/{idSquad}', [SquadController::class, "leaveSquad"])->name('leaveSquad');

Route::post('/squad/doCreateSquad', [SquadController::class, "doCreateSquad"])->name('doCreateSquad');
Route::get('/squad/acceptBro/{idBro}', [SquadController::class, "acceptBro"])->name('acceptBro');
Route::get('/squad/refuseBro/{idBro}', [SquadController::class, "refuseBro"])->name('refuseBro');
Route::get('/squad/deleteGymbro/{idGymbro}', [SquadController::class, "deleteGymbro"])->name('deleteGymbro');

Route::get('/exercices', [TrainingController::class, 'exercices'])->name('exercices');
Route::post('/exercices/enregistrer', [TrainingController::class, 'enregistrerExercice'])->name('enregistrerExercice');
Route::get('/exercices/modifier/{id}', [TrainingController::class, 'modifierExercice'])->name('modifierExercice');
Route::post('/exercices/mettre-a-jour/{id}', [TrainingController::class, 'mettreAJourExercice'])->name('mettreAJourExercice');
Route::delete('/exercices/supprimer/{id}', [TrainingController::class, 'supprimerExercice'])->name('supprimerExercice');

Route::get('/exercices/consulter/{id}', [TrainingController::class, 'consulterExercice'])->name('consulterExercice');

Route::get('/muscles', function () {
    return view('musclesapi');
})->name('muscles');

Route::get('/exercices/list/{muscle}', [TrainingController::class, 'exosListApi'])->name('exercices.list');
Route::get('/exercices/creer-api/{exo}', [TrainingController::class, 'creerApi'])->name('creerExerciceApi');
//Route::post('/exercices/doCreerExercice', [TrainingController::class, 'doCreerExercice'])->name('doCreerExercice');
Route::get('/entrainements/addExoToProg/{idProg}/{idExo}', [TrainingController::class, "addExoToProg"])->name('addExoToProg');
Route::get('/entrainements/deleteExoFromProg/{idProg}/{idExo}/{ordre}', [TrainingController::class, "deleteExoFromProg"])->name('deleteExoFromProg');
Route::get('/entrainements/modifierEntrainement/{idEntrainement}', [TrainingController::class, "modifierEntrainement"])->name('modifierEntrainement');
Route::post('/entrainements/doModifierEntrainement/{idEntrainement}', [TrainingController::class, "doModifierEntrainement"])->name('doModifierEntrainement');
Route::post('/entrainements/ajouterExoEntrainement/{idEntrainement}/{idExo}', [TrainingController::class, "ajouterExoEntrainement"])->name('ajouterExoEntrainement');
Route::post('/entrainements/supprimerExoEntrainement/{idEntrainement}/{idSerie}', [TrainingController::class, "supprimerExoEntrainement"])->name('supprimerExoEntrainement');

Route::get('/searchexo', function () {
    return view('searchexo');
})->name('searchexo');
