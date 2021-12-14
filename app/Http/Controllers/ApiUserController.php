<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiUserController extends Controller  
{
    // 
    public function getUsers(){
        $user = User::where('role', '!=', 'admin')->orderby('role')->get();
        return response()->json($user);
    } 
    public function removeUser($id){ 
        DB::table('users')->where('id', '=', $id)->delete();
        $user = User::where('role', '!=', 'admin')->get();
        return response()->json($user);
    }
    public function removeUserA2($email){
        DB::table('users')->where('email', $email)->delete();
        $user = User::where('role', 'a2')
        ->join('city_codes', 'users.city_code','=', 'city_codes.code')->get();
        return response()->json($user);
    }
    public function getUsersA2(){  
        //$user = User::where('role', '=', 'a2')->get();
        $user = DB::table('users')->where('role','a2')
        ->join('city_codes', 'users.city_code','=', 'city_codes.code')->get();
        return response()->json($user);   
    } 
    public function getUserWithId($id){
        $user = DB::table('users')->where('id', $id)->get();
        return response()->json($user);
    }
    public function updateActive($code){
        DB::table('users')->where('city_code', $code)->update(['active_status' => 'active']);
        // DB::table('district')->where('c_code', $code)->update(['status' => 'active']);
        return 'active Success';
    }
    public function updateLock($code){
        DB::table('users')->where('city_code','like', $code.'%')->update(['active_status' => 'lock']);
        // DB::table('district')->where('c_code', $code)->update(['status' => 'active']);
        return 'lock Success'; 
    }
}  
