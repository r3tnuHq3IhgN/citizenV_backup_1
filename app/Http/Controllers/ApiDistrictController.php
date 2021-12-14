<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ApiDistrictController extends Controller
{
    // 
    public function createDistrict(Request $req){   
        $req->validate([
            'district' => 'required',
        ],
        [
            'district.required' => 'Tên Quận/Huyện không được để trống !',
        ] 
    );
        $c_code = DB::table('city_codes')->where('city', $req->city)->first();
        DB::table('district')->insert([
            'city' => $req->city,
            'c_code' => $c_code->code,
            'district' => $req->district,
        ]);
        return 'success';  
    }
    public function getAllDistrict(){
        $district = DB::table('district')->orderBy('c_code')->get();
        return $district; 
    }
    public function removeDis(Request $req){
        DB::table('district')->where('city',$req->city)->where('district', $req->dis)->delete();
        return 'xoa thanh cong';
    }
    public function getDisOf($id){
        $data = DB::table('users')->join('district', 'users.city_code', '=', 'district.c_code')
        ->where('users.id',$id)
        ->get();
        return $data; 
    }
    public function getDisOfCity($city){
        $data = DB::table('district')->where('city','=',$city)->get();
        //return response()->json($data);
        return $data;
    }
    public function getDisAct($code){
        $data = DB::table('users')->join('district', 'users.city_code','=', 'district.d_code')
        ->where('district.c_code',$code)
        ->get();
        return $data; 
    }
    public function getAllDisAct(){
        $data = DB::table('district')->whereNotNull('d_code')->get();
        return $data;
    }
    public function getCodeOfDis($dis){
        $data = DB::table('district')->where('district',$dis)->get('d_code');
        return $data;
    }
    
} 
