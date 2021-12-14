@extends('layouts.app')
@section('body')
@if(Auth::check())
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
              <div class="sidebar-sticky">
                <ul class="nav flex-column">
                  <li class="nav-item m-3">
                    <a href="/">Home</a>
                  </li> 
                  @if(Auth::user()->role =='b1')
                  <li class="nav-item m-3"> 
                    <a href="{{route('b1')}}">B1</a> 
                  </li> 
                  <li class="nav-item m-3"> 
                    <router-link to="/createcodeb2" extract>Tạo mã thôn/bản/tổ dân phố</router-link>
                  </li>
                  <li class="nav-item m-3">  
                    <router-link to="/accountb2">Kiểm soát tài khoản thôn/bản/tổ dân phố</router-link>
                  </li>
                  <div class="dropdown show nav-item m-3">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Biểu đồ
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <li class="nav-item m-3"> 
                        <router-link to="/chartofcom">Biểu đồ thống kê trên toàn xã</router-link>
                      </li> 
                      <li class="nav-item m-3">  
                        <router-link to="/chartb2">Biểu đồ thống kê các thôn/bản/tổ dân phố</router-link>
                      </li>
                    </div>
                  </div>
                  <div class="dropdown show nav-item m-3">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Danh sách dân số
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <li class="nav-item m-3"> 
                        <router-link to="/citizenofcom">Danh sách dân số của xã/phường</router-link>
                      </li> 
                      <li class="nav-item m-3">  
                        <router-link to="/chartb2">Biểu đồ thống kê các thôn/bản/tổ dân phố</router-link>
                      </li>
                    </div>
                  </div> 
                  @endif  
                </ul>
              </div>
            </nav>    
      
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                @php
                    $commune = DB::table('users')->join('communes', 'users.city_code', '=', 'communes.com_code')->where('communes.com_code', '=', Auth::user()->city_code)->get('commune');
                    $user = Auth::user()->id;
                    //print_r($city['0']->city); 
                @endphp
                <div class="alert alert-primary">Viên chức dân số thuộc Trạm Y tế xã/phường: <span style="font-weight: bold">{{$commune['0']->commune}}</span></div>
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