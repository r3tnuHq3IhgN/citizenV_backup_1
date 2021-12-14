<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiChartController extends Controller
{
    //
    public function chartGender(){
        $male = DB::table('gp_data')
        ->where('gender','male')->count();
        $female = DB::table('gp_data')
        ->where('gender','female')->count();
        return [$male,$female];
    }
    public function chartAge(){
        $first = DB::table('gp_data')
        ->where('age', '<', 18)->count();
        $second = DB::table('gp_data')
        ->where('age', '>=', 18)->where('age','<=', 60)->count();
        $third = DB::table('gp_data')
        ->where('age', '>', 60)->count();
        return [$first,$second,$third];
    }


    public function chartGenderMain($code){ 
        $male = DB::table('gp_data')
        ->where('code','like',$code.'%')->where('gender','male')->count();
        $female = DB::table('gp_data')
        ->where('code','like',$code.'%')->where('gender','female')->count();
        return [$male,$female];
    }
    public function chartAgeMain($code){
        $first = DB::table('gp_data')
        ->where('code','like',$code.'%')->where('age', '<', 18)->count();
        $second = DB::table('gp_data')
        ->where('code','like',$code.'%')->where('age', '>=', 18)->where('age','<=', 60)->count();
        $third = DB::table('gp_data')
        ->where('code','like',$code.'%')->where('age', '>', 60)->count();
        return [$first,$second,$third];
    }
}
