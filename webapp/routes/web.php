<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetsController;
use App\Http\Controllers\ContatoController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserAuthController;
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

//WEBSITE ROUTES:---------------------------------------------------------------------


//Dropbox test route
Route::get('/dropbox', function(){

    if(Storage::disk('dropbox')->makeDirectory('teste')){
        dd('Created sucessfully');
    }
    else{
        dd('Error during directory creation');
    }
});

Route::get('/dropbox-verify', function(){
    if(Storage::disk('dropbox')->exists('teste')){
        dd('The folder / file exists');
    }else{
        dd('The folder / file doesnt exists');
    }
});


Route::get('/', function(){
    return view('home');
});

Route::get('/home', function(){
    return view('home');
});

Route::get('/institucional', [PetsController::class, 'getView_institucional']);

Route::get('/institucional/pets', [PetsController::class, 'listPets']);

Route::get('/institucional/requisicoes', function(){
    return view('requisicoes');
});

Route::get('/institucional/pets/alterar/{id}', [PetsController::class, 'inspectPet']);

Route::post('/institucional/pets/excluir/',[PetsController::class, 'deletePet']);

Route::post('/institucional/pets/alterar/do', [PetsController::class, 'updatePet']);

Route::get('/institucional/pets/cadastrar', function(){
    return view('cadastrar_pet');
});

Route::post('/institucional/pets/cadastrar/add', [PetsController::class, 'insertPet']);

Route::get('/contato', function(){
    return view('contato');
});

Route::get('/empresa', function(){
    return view('empresa');
});

Route::post('/contato/send', [ContatoController::class, 'sendMessage']);


//AUTHENTICATION ROUTES--------------------------------------------------------------
Route::get('/login',  function(){
    return view('login');
});

Route::post('/login/do_auth', [UserAuthController::class, 'doLogin']);

Route::get('/logout', [UserAuthController::class, 'doLogout']);

//END OF AUTHENTICATION ROUTES-------------------------------------------------------
//END WEBSITE ROUTES-----------------------------------------------------------------


//APP ROUTES-------------------------------------------------------------------------

//This must to receive the parameter "return_type" that must be equals "json"

Route::get('/application_retrieve/pets', [PetsController::class, 'listPets_app']);
Route::get('/application_retrieve/pets/inspect/{id}', [PetsController::class, 'inspectPet_app']);






//END APP ROUTES---------------------------------------------------------------------


