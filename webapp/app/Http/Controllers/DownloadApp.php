<?php

//Controller responsável por executar operações relacionadas ao fluxo de Download do app

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadApp extends Controller
{
    public function getView_download(){
        return view('download_app')->with('app_path', url('/app_apk/amicao_app.apk'));
    }
}
