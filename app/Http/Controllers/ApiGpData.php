<?php

namespace App\Http\Controllers;

use App\Models\GpData;
use Illuminate\Http\Request;

class ApiGpData extends Controller
{
    //
    public function getCitizen($code){
        $data = GpData::where('code', $code)->get();
        return $data;
    }
}
