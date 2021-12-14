<?php

namespace App\Http\Controllers;

use App\Models\Hamlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiHamletController extends Controller
{
    //
    public function createHamlet(Request $req)
    {
        $req->validate(
            [
                'hamlet' => 'required'
            ],
            [
                'hamlet.required' => 'Tên Thôn/Bản/Tổ dân phố không được để trống !',
            ]
        );
        $check = Hamlet::where('commune', $req->commune)->where('hamlet', $req->hamlet)->first();
        if(empty($check)){
            $hamlet = new Hamlet();
            $hamlet->commune = $req->commune;
            $hamlet->com_code = $req->com_code;
            $hamlet->hamlet = $req->hamlet;
            $hamlet->save();
            return 'success';

        }
        else{
            return 'no';
        }
        return $req;
    }
    public function getAllHam(){
        $data = DB::table('hamlets')->join('communes', 'communes.commune', 'hamlets.commune')
        ->join('district', 'district.district', 'communes.district')
        ->join('city_codes', 'city_codes.city', 'district.city')->get();
        return $data;
    }
    public function deleteHamlet(Request $req){
        DB::table('hamlets')->where('commune', $req->com)->where('hamlet', $req->ham)->delete();
        return 'xoa thanh cong';
    }
    public function getHamOfCom($id){
        $data = DB::table('communes')->join('users', 'users.city_code', 'communes.com_code')
        ->join('hamlets', 'communes.commune', 'hamlets.commune')->where('users.id', $id)->get();
        return $data;
    }
    public function getHamAct($code){
        $data = DB::table('users')->join('hamlets', 'users.city_code', 'hamlets.ham_code')
        ->where('hamlets.com_code',$code)->get();
        return $data;
    }
    public function getCodeOfHam($ham){
        $data =DB::table('hamlets')->where('hamlet',$ham)->get('ham_code');
        return $data;
    }
}
