<?php

namespace App\Http\Controllers;

use App\Models\TimeOpen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiTimeOpenController extends Controller
{
    //
    public function timeOpen(Request $request)
    {
        // $time = new TimeOpen();
        // $time->code = $request->code;
        // $time->open = $request->open;
        // $time->close = $request->close;
        // $time->save();
        // return response()->json($time);
        $check = DB::table('time_opens')->where('code', $request->code)->first();

        $request->validate(
            [
                'open' => 'required',
                'close' => 'required|after:open',
            ],
            [
                'open.required' => 'Ngày bắt đầu khai báo không được để trống !',
                'close.required' => 'Ngày đóng khai báo không được để trống !',
                'close.after' => 'Ngày đóng khai báo phải lớn hơn hoặc bằng ngày bắt đầu !'
            ]
        );
        if (empty($check)) {
            $time = new TimeOpen(); 
            $time->code = $request->code;
            $time->open = $request->open;
            $time->close = $request->close;
            $time->save();
            return 'them moi thanh cong'; 
        } else {
            DB::table('time_opens')->where('code', $request->code)
                ->update(
                    [
                        'open' => $request->open,
                        'close' => $request->close
                    ]
                );
            return 'cap nhat thanh cong'; 
        }
    }
    public function checkTime($code)
    {
        $check = DB::table('time_opens')->where('code', $code)->get();
        return response()->json($check);
    }
    public function deleteOpen($code)
    {
        // kiem tra xem da co thoi diem khai bao chua
        $check = DB::table('time_opens')->where('code', $code)->first();
        if (empty($check)) {
            return 'no';
        } else {
            // neu co thi xoa cai cu va update lock trong users
            DB::table('time_opens')->where('code','like', $code.'%')->delete();
            DB::table('users')->where('city_code','like', $code.'%')->update([
                'active_status' => 'lock',
            ]);
            return 'delete all in time_opens like '.$code.'%'; 
        }
    }
}
