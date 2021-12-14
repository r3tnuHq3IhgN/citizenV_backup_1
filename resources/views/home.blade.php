@extends('layouts.app')
@section('body')
    <div class="container">
        <br>
        {{-- <h2>Trang chủ giới thiệu về Citizen V</h2> --}}
        <div>
          <h2>CitizenV - Hệ thống điều tra dân số</h2>
          <br>
          <p style="font-size: 1rem">CitizenV là một ứng dụng web được phát triển nhằm phục vụ công tác điều tra dân số trên toàn quốc. Với giao diện thân thiện, đơn giản, dễ sử dụng, hệ thống sẽ giúp việc khai báo, nhập liệu, tổng hợp và phân tích dữ liệu về dân số một cách thuận tiện. 
            Hệ thống được phát triển bởi nhóm sinh viên trường Đại học Công Nghệ - Đại học Quốc gia Hà Nội gồm:</p>
<h5>Võ Hồng Nghiệp – 19020384 – Trưởng nhóm</h5>
<h5>Phạm Văn Quý – 19020409</h5> 
<h5>Bùi Đức Thắng – 19020419</h5>
<p>Thông tin liên hệ: abc@gmail.com</p>
<p>Số điện thoại liên hệ : 0123456789</p>
        </div>
        @if (Auth::check())
            @if(Auth::user()->role=='admin')
            <a href="/admin#/createa1"><div class="btn btn-primary" href="">Trang Admin</div></a>
            @elseif(Auth::user()->role=='a1')
            <a href="/a1#/createcodea2/"><div class="btn btn-primary" href="">Trang A1</div></a>
            @elseif(Auth::user()->role=='a2')
            <a href="/a2#/createcodea3/"><div class="btn btn-primary" href="">Trang A2</div></a>
            @elseif(Auth::user()->role=='a3')
            <a href="/a3#/createcodeb1/"><div class="btn btn-primary" href="">Trang A3</div></a>
            @elseif(Auth::user()->role=='b1')
            <a href="{{route('b1')}}"><div class="btn btn-primary" href="">Trang B1</div></a>
            @elseif(Auth::user()->role=='b2')
            <a href="{{route('b2')}}"><div class="btn btn-primary" href="">Trang B2</div></a>
            @endif
        @endif
    </div>
@endsection        