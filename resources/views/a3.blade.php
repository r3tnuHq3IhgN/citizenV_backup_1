@extends('layouts.app')
@section('body')
@if(Auth::check())
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
              <div class="sidebar-sticky">
                <ul class="nav flex-column">
                  <li class="nav-item m-3">
                    <a href="/">Home</a>
                  </li> 
                  @if(Auth::user()->role =='a3')
                  <li class="nav-item m-3"> 
                    <a href="{{route('a3')}}">A3</a> 
                  </li> 
                  <li class="nav-item m-3"> 
                    <router-link to="/createcodeb1" extract>Tạo mã xã/phường</router-link>
                  </li>
                  <li class="nav-item m-3">  
                    <router-link to="/accountb1">Kiểm soát tài khoản xã/phường</router-link>
                  </li>
                  <div class="dropdown show nav-item m-3">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Biểu đồ
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <li class="nav-item m-3">  
                        <router-link to="/chartofdis">Biểu đồ thống kê trên toàn quận/huyện</router-link>
                      </li>
                      <li class="nav-item m-3">  
                        <router-link to="/charta3">Biểu đồ thống kê các xã/phường</router-link>
                      </li> 
                    </div>
                  </div>
                  @endif  
                </ul>
              </div>
            </nav>    
      
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                @php
                    $city = DB::table('users')->join('district', 'users.city_code', '=', 'district.d_code')->where('district.d_code', '=', Auth::user()->city_code)->get('district');
                    $user = Auth::user()->id;
                    //print_r($city['0']->city);
                @endphp
                <div class="alert alert-primary">Công chức thực hiện công tác dân số tại Phòng Y tế các quận/huyện: <span style="font-weight: bold">{{$city['0']->district}}</span></div>
                <div style="margin-bottom: 100px">
                  <div id="app">
                    <router-view :user="{{Auth::user()}}"></router-view> 
                  </div>
                </div>
            </main> 
            
            @else
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
              <div id="app">
                <router-view></router-view>  
              </div>
            </main>
            @endif
    
@endsection 