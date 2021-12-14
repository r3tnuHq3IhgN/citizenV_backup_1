<?php

namespace App\Http\Controllers;

use App\Models\CityCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiCityController extends Controller
{
    //
    public function getAllCity(){ 
        $cities = CityCode::all();
        return response()->json($cities);
    }
    public function getCity($name){ 
        //  $city = CityCode::where('city', $name)->get();
        $city = DB::table('city_codes')->where('city', $name)->leftJoin('users', 'city_codes.code', '=','users.city_code')->get();
         return response()->json($city);
    }
    public function getCityAct(){
        $city = DB::table('city_codes')->whereNotNull('code')->get();
        return $city;
    }
    public function getCodeOfCity($city){
        $data = DB::table('city_codes')->where('city',$city)->get();
        return $data;
    }
    public function createCity(Request $req){
        $req->validate([
            'city' => 'required|unique:city_codes',
        ],
        [
            'city.required' => 'Tên thành phố không được để trống !',
            'city.unique' => 'Thành phố đã được tạo trước đó !',
        ]
    );
         $check = DB::table('city_codes')->where('city',$req->city)->first();
         if(empty($check)){
             DB::table('city_codes')->insert([
                 'city' => $req->city,
             ]);
             return 'success';  
         }
         else{
             return 'error'; 
         }
    }
    public function removeCity($city){
        DB::table('city_codes')->where('city', $city)->delete();
        return 'xoa thanh cong';
    }
} 
