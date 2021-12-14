<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiCommuneController extends Controller
{
    // 

    public function createCommune(Request $req)
    {
        $req->validate(
            [
                'commune' => 'required'
            ],
            [
                'commune.required' => 'Tên Xã/Phường không được để trống !',
            ]
        ); 
        $check = Commune::where('district', $req->district)->where('commune', $req->commune)->first();
        if (empty($check)) {
            $commune = new Commune();
            $commune->district = $req->district;
            $commune->d_code = $req->d_code;
            $commune->commune = $req->commune;
            $commune->save();
            return 'success';
        }
        else {
            return 'no';
        }
    }
    public function getAllCommunes()
    {
        $com = DB::table('communes')->join('district', 'communes.district', '=', 'district.district')->get();
        return $com;
    }
    public function deleteCommune(Request $req){
       Commune::where('district', $req->d_code)->where('commune', $req->commune)->delete();
       return 'success';
    }
    public function getComOfDis($id){
        $data = DB::table('district')->join('users', 'users.city_code', 'district.d_code')
        ->join('communes', 'district.district', 'communes.district')->where('users.id', $id)->get();
        return $data; 
    }
    public function getComOfCity($code){
        $data = DB::table('communes')->where('com_code','like',$code.'%')->get() ;
        return $data;
    }
    public function comOfDis($dis){
       $data = DB::table('communes')->where('district', $dis)->get('commune');
       return $data;
    }
    public function getCodeOfCom($com){
        $data = DB::table('communes')->where('commune', $com)->get('com_code');
        return $data;
    } 
    public function getComAct($code){
        $data = DB::table('users')->join('communes', 'users.city_code', 'communes.com_code')
        ->where('communes.d_code',$code)->get();
        return $data;
    }
    public function getAllComAct(){
        $data = DB::table('communes')->whereNotNull('com_code')->get();
        return $data;
    }
}
