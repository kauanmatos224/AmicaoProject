<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadApp extends Controller
{
    public function getView_download(){
        return view('download_app')->with('app_path', url('/app_apk/amicao_app.apk'));
    }
}
