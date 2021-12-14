@extends('layouts.app')
@section('body')
@if(Auth::check())
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
              <div class="sidebar-sticky">
                <ul class="nav flex-column">
                  <li class="nav-item m-3">
                    <a href="/">Home</a>
                  </li> 
                  @if(Auth::user()->role =='b2')
                  <li class="nav-item m-3"> 
                    <a href="{{route('b2')}}">B2</a> 
                  </li> 
                  <li class="nav-item m-3"> 
                    <router-link to="/census" extract>Điều tra dân số</router-link>
                  </li>
                  <li class="nav-item m-3"> 
                    <router-link to="/citizen" extract>Thông tin người dân</router-link>
                  </li>
                  @endif  
                </ul>
              </div>
            </nav>    
      
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                @php
                    $hamlet = DB::table('users')->join('hamlets', 'users.city_code', '=', 'hamlets.ham_code')->where('hamlets.ham_code', '=', Auth::user()->city_code)->get('hamlet');
                    $user = Auth::user()->id;
                    //print_r($city['0']->city); 
                @endphp
                <div class="alert alert-primary">Cộng tác viên dân số tại các thôn, bản, tổ dân phố: <span style="font-weight: bold">{{$hamlet['0']->hamlet}}</span></div>
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