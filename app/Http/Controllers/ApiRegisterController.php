<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiRegisterController extends Controller
{
    //
    public function addUser(Request $req)
    {
        $req->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'pass' => 'required',
                'role' => 'required',
            ],
            [
                'name.required' => 'Tên không được để trống !',
                'email.required' => 'Email không được để trống !',
                'pass.required' => 'Mật khẩu không được để trống !',
                'email.email' => 'Không đúng định dạng email !',
                'email.unique' => 'Email đã được sử dụng !',
            ]
        );
        $user = new User();
        $user->fill($req->all());
        $user->password = Hash::make($req->pass);
        $user->role = $req->role;
        $user->save();
        return response()->json($user);
    }
    public function addUserA2(Request $req)
    {
        $req->validate(
            [
                'name' => 'required',
                'pass' => 'required',
                'role' => 'required',
            ],
            [
                'name.required' => 'Tên không được để trống !',
                'pass.required' => 'Mật khẩu không được để trống !',
            ]
        );
        $user = new User();
        $user->fill($req->all());
        $user->password = Hash::make($req->pass);
        $user->role = $req->role;
        $user->save();
        DB::table('city_codes')->where('city', $req->city)->update([
            'code' => $req->city_code,
        ]);

        DB::table('code')->where('code', $req->city_code)->update([
            'active_status' => 'active',
        ]);
        DB::table('city_codes')->join('district', 'city_codes.city', '=', 'district.city')
            ->where('district.city', $req->city)->update([
                'c_code' => $req->city_code,
            ]);

        return response()->json($user);
    }
    public function addUserA3(Request $req)
    {
        $req->validate(
            [
                'name' => 'required',
                'pass' => 'required',
                'role' => 'required',
            ],
            [
                'name.required' => 'Tên không được để trống !',
                'pass.required' => 'Mật khẩu không được để trống !',
            ]
        );
        $user = new User();
        $user->fill($req->all());
        $user->password = Hash::make($req->pass);
        $user->role = $req->role;
        $user->save();
        DB::table('district')->where('district', $req->dis)
            ->update([
                'd_code' => $req->d_code,
            ]);
        DB::table('communes')->where('district', $req->dis)
            ->update([
                'd_code' => $req->d_code,
            ]);
        return $req->dis;
    }
    public function addUserB1(Request $req)
    {
        $req->validate(
            [
                'name' => 'required',
                'pass' => 'required',
                'role' => 'required',
            ],
            [
                'name.required' => 'Tên không được để trống !',
                'pass.required' => 'Mật khẩu không được để trống !',
            ]
        );
        $user = new User();
        $user->fill($req->all());
        $user->password = Hash::make($req->pass);
        $user->role = $req->role;
        $user->save();
        DB::table('communes')->where('commune', $req->com)
            ->update([
                'com_code' => $req->city_code,
            ]);
        DB::table('hamlets')->where('commune', $req->com)
            ->update([
                'com_code' => $req->city_code,
            ]);
        return 'success';
    }
    public function addUserB2(Request $req)
    {
        $req->validate(
            [
                'name' => 'required',
                'pass' => 'required',
                'role' => 'required',
            ],
            [
                'name.required' => 'Tên không được để trống !',
                'pass.required' => 'Mật khẩu không được để trống !',
            ]
        );
        $user = new User();
        $user->fill($req->all());
        $user->password = Hash::make($req->pass);
        $user->role = $req->role;
        $user->save();
        DB::table('hamlets')->where('hamlet', $req->ham)
            ->update([
                'ham_code' => $req->city_code,
            ]);
        return 'success';
    }
}
