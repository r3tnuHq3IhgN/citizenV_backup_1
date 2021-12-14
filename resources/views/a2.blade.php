@extends('layouts.app')
@section('body')
@if(Auth::check())
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
              <div class="sidebar-sticky">
                <ul class="nav flex-column">
                  <li class="nav-item m-3">
                    <a href="/">Home</a>
                  </li> 
                  @if(Auth::user()->role =='a2')
                  <li class="nav-item m-3"> 
                    <a href="{{route('a2')}}">A2</a> 
                  </li>
                  <li class="nav-item m-3"> 
                    <router-link to="/createcodea3">Tạo mã quận huyện</router-link>
                  </li>
                  <li class="nav-item m-3">  
                    <router-link to="/accounta3">Kiểm soát tài khoản quận huyện</router-link>
                  </li> 
                  <div class="dropdown show nav-item m-3">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Biểu đồ
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <li class="nav-item m-3"> 
                        <router-link to="/chartofcity">Biểu đồ thống kê trên toàn thành phố</router-link>
                      </li>
                      <li class="nav-item m-3">  
                        <router-link to="/charta2">Biểu đồ thống kê của quận/huyện</router-link>
                      </li>
                      <li class="nav-item m-3">  
                        <router-link to="/chartcom">Biểu đồ thống kê của xã/phường</router-link>
                      </li>
                    </div>
                  </div>
                  @endif 
                </ul>
              </div>
            </nav>    
      
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                @php
                    $city = DB::table('users')->join('city_codes', 'users.city_code', '=', 'city_codes.code')->where('city_codes.code', '=', Auth::user()->city_code)->get('city');
                    $user = Auth::user()->id;
                    //print_r($city['0']->city);
                @endphp
                <div class="alert alert-primary">Chi cục dân số thuộc Sở Y tế các tỉnh/thành phố : <span style="font-weight: bold">{{$city['0']->city}}</span></div>
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