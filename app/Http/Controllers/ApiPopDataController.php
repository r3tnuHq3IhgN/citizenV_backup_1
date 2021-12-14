<?php

namespace App\Http\Controllers;

use App\Models\GpData;
use Illuminate\Http\Request;

class ApiPopDataController extends Controller
{
    //
    public function insertData(Request $req)
    {
        $req->validate(
            [
                'full_name' =>  'required',
                'date_of_birth' => 'required',
                'gender' => 'required',
                'native_place' => 'required',
                'address' => 'required',
                'address1' => 'required',
                'religion' => 'required',
                'edu_level' => 'required',
                'career' => 'required',
            ], 
            [
                'full_name.required' => 'Họ và tên không được để trống !',
                'date_of_birth.required' => 'Ngày sinh không được để trống !',
                'gender.required' => 'Giới tính không được để trống !',
                'native_place.required' => 'Quê quán không được để trống !',
                'address.required' => 'Nơi thường trú không được để trống !',
                'address1.required' => 'Nơi tạm trú không được để trống !',
                'religion.required' => 'Tôn giáo không được để trống !',
                'edu_level.required' => 'Trình độ học vấn không được để trống !',
                'career.required' => 'Nghề nghiệp không được để trống !',
            ]
        );
        $yN = date('Y');
        $test = substr($req->date_of_birth, 0, 4);
        $tg = $yN - $test;
        $data = new GpData(); 
        $data->fill($req->all());
        $data->age = $tg;
        $data->save();
        return $tg;

    } 
}
