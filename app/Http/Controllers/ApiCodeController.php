<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiCodeController extends Controller
{
    //
    public function getCodeInactive(){
       $code = DB::table('code')->where('active_status', 'inactive')->get();
       return response()->json($code);
    }
    public function createCode(Request $req){ 
        $req->validate([
            'code' => 'required|unique:code|min:1|max:63',
        ],
        [
            'code.required' => 'Không được để trống !',
            'code.unique' => 'Đã tồn tại code này !',
            'code.min' => 'Phải lớn hơn 0!',
            'code.max' => 'Phải nhỏ hơn 64!',
            //'code.integer' => 'Chỉ được nhập số !'

        ]);
        DB::table('code')->insert([
            'code' => $req->code,
        ]);
        return 'thanh cong';  
    }
}
