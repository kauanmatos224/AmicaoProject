<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetsController;
use App\Http\Controllers\ContatoController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\StaffController;
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

Route::get('/institucional/requisicoes', [PetsController::class, 'getView_requisicoes']);

Route::get('/institucional/pets/alterar/{id}', [PetsController::class, 'inspectPet']);

Route::get('/institucional/pets/excluir/{csrf_token}/{pet_id}',[PetsController::class, 'deletePet']);

Route::post('/institucional/pets/alterar/do', [PetsController::class, 'updatePet']);

Route::get('/institucional/pets/cadastrar', [PetsController::class, 'getView_cadastra_pet']);

Route::post('/institucional/pets/cadastrar/add', [PetsController::class, 'insertPet']);

Route::get('/contato', function(){
    return view('contato');
});

Route::get('/empresa', function(){
    return view('empresa');
});

Route::post('/contato/send', [ContatoController::class, 'sendMessage']);

Route::post('/contato/send-account-activation-request', [ContatoController::class, 'getViewContato_account_activation']);

Route::get('/institucional/cadastrar', [UserAuthController::class, 'getView_cadastrar_inst']);

Route::post('/institucional/cadastrar/send', [UserAuthController::class, 'registerInst']);

Route::get('/institucional/recuperar-senha', function(){
    return view('recuperar_senha');
});

Route::post('/institucional/recuperar-senha/send', [UserAuthController::class, 'reoveryPassword']);
Route::get('/institucional/rec-password/reset/{token}', [UserAuthController::class, 'getView_set_restet_password']);
Route::post('/institucional/rec-password/set-new', [UserAuthController::class, 'setNewPassword']);
Route::get('/account/mail_check/{token}', [UserAuthController::class, 'verifyLinkEmailConfirmation']);
Route::post('/account/resend_mail_check', [UserAuthController::class, 'resendMailVerification']);

//STAFF ROUTES

Route::get('/staff/mensagens', [PetsController::class, 'listMessages']);

Route::get('/staff/inst-analise', [StaffController::class, 'getView_RegistrationAnalisys']);

Route::get('/staff/inst-analise/more/{id}', [StaffController::class, 'getView_inspectInst']);



Route::post('/staff/inst-analise/delete', [StaffController::class, 'getView_justifyDeleteInst']);

Route::post('/staff/inst-analise/approve', [StaffController::class, 'getView_justifyApproveInst']);

Route::post('/staff/inst-analise/restore', [StaffController::class, 'getView_justifyRestoreInst']);

Route::post('/staff/inst-analise/deny', [StaffController::class, 'getView_justifyDenyInst']);


Route::post('/staff/inst-analise/delete/do', [StaffController::class, 'deleteInst']);

Route::post('/staff/inst-analise/approve/do', [StaffController::class, 'approveInst']);

Route::post('/staff/inst-analise/restore/do', [StaffController::class, 'restoreInst']);

Route::post('/staff/inst-analise/deny/do', [StaffController::class, 'denyInst']);


Route::get('/system/clear-database/complete-account-deletion/{key}', [AutomatedTasks::class, 'completeAccountDeletion']);





//END STAFF ROUTES


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

//Dump returns
Route::get('/application_retrieve/pets/dump', [PetsController::class, 'listPets_app_dump']);
Route::get('/application_retrieve/pets/inspect/dump/{id}', [PetsController::class, 'inspectPet_app_dump']);






//END APP ROUTES---------------------------------------------------------------------


