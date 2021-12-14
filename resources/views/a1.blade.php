@extends('layouts.app')
@section('body')
@if(Auth::check())
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
              <div class="sidebar-sticky">
                <ul class="nav flex-column">
                  <li class="nav-item m-3">
                    <a href="/">Home</a>
                  </li> 
                  @if(Auth::user()->role =='a1')
                  <li class="nav-item m-3"> 
                    <a href="{{route('a1')}}">A1</a> 
                  </li>
                  <li class="nav-item m-3"> 
                    <router-link to="/createcodea2">Tạo mã tỉnh thành</router-link>
                  </li>
                  <li class="nav-item m-3"> 
                    <router-link to="/accounta2">Kiểm soát tài khoản cấp thành phố</router-link>
                  </li>
                  <div class="dropdown show nav-item m-3">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Biểu đồ
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <li class="nav-item m-3"> 
                        <router-link to="/chartall">Biểu đồ thống kê trên cả nước</router-link>
                      </li>
                      <li class="nav-item m-3"> 
                        <router-link to="/chartcity">Biểu đồ thống kê các tỉnh TP</router-link>
                      </li>
                      <li class="nav-item m-3"> 
                        <router-link to="/chartdisa1">Biểu đồ thống kê các quận/huyện</router-link>
                      </li>
                      <li class="nav-item m-3"> 
                        <router-link to="/chartcoma1">Biểu đồ thống kê các xã/phường</router-link>
                      </li>
                    </div>
                  </div>

                  {{-- <li class="nav-item m-3"> 
                    <router-link to="/chartall">Biểu đồ thống kê trên cả nước</router-link>
                  </li>
                  <li class="nav-item m-3"> 
                    <router-link to="/chartcity">Biểu đồ thống kê các tỉnh TP</router-link>
                  </li>
                  <li class="nav-item m-3"> 
                    <router-link to="/chartdisa1">Biểu đồ thống kê các quận/huyện</router-link>
                  </li>
                  <li class="nav-item m-3"> 
                    <router-link to="/chartcoma1">Biểu đồ thống kê các xã/phường</router-link>
                  </li>
                  <li class="nav-item m-3"> 
                    <router-link to="/chartcoma1">Biểu đồ thống kê các xã/phường</router-link>
                  </li>  --}}
                  @endif 
                </ul>
              </div>
            </nav>   
      
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                <div class="alert alert-primary">Đây là trang quản lý của Tổng cục Dân số thuộc Bộ Y tế</div>
                <div style="margin-bottom: 100px">
                  <div id="app">
                    <router-view></router-view>
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