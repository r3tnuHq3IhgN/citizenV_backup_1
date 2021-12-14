@extends('layouts.app')
@section('body')
@if(Auth::check())
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
              <div class="sidebar-sticky">
                <ul class="nav flex-column">
                  <li class="nav-item m-3">
                    <a href="/">Home</a>
                  </li> 
                  @if (Auth::user()->role =='admin')
                  <li class="nav-item m-3">
                    <a href="{{route('admin')}}">ADMIN</a>
                  </li>
                  <li class="nav-item m-3"> 
                    <router-link 
                    to="/createa1"
                    exact
                    >Tạo tài khoản cho A1</router-link>
                  </li> 
                  <li class="nav-item m-3">
                    <router-link to="/createcode">Tạo mã Tỉnh/Thành phố</router-link>
                  </li>
                  <li class="nav-item m-3">
                    <router-link to="/createcity">Tạo Tỉnh/Thành phố</router-link>
                  </li>
                  <li class="nav-item m-3">
                    <router-link to="/createdistrict">Tạo Quận/Huyện</router-link>
                  </li> 
                  <li class="nav-item m-3">
                    <router-link to="/createcommune">Tạo Xã/Phường</router-link>
                  </li> 
                  <li class="nav-item m-3">
                    <router-link to="/createhamlet">Tạo Thôn/Bản/Tổ dân phố</router-link>
                  </li>  
                  <li class="nav-item m-3">
                    <router-link to="/statsa1">Thống kê user</router-link>
                  </li> 
                  @endif 
                  
                  {{-- <li class="nav-item">
                    <a class="nav-link" href="#">
                      <span data-feather="shopping-cart"></span>
                      Products
                    </a>
                  </li> 
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <span data-feather="users"></span>
                      Customers
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <span data-feather="bar-chart-2"></span>
                      Reports
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <span data-feather="layers"></span>
                      Integrations
                    </a>
                  </li> --}}
                </ul> 
      
                {{-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                  <span>Saved reports</span>
                  <a class="d-flex align-items-center text-muted" href="#">
                    <span data-feather="plus-circle"></span>
                  </a>
                </h6>
                <ul class="nav flex-column mb-2">
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <span data-feather="file-text"></span>
                      Current month
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <span data-feather="file-text"></span>
                      Last quarter
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <span data-feather="file-text"></span>
                      Social engagement
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <span data-feather="file-text"></span>
                      Year-end sale
                    </a>
                  </li>
                </ul> --}}
              </div>
            </nav>  
      
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
              <div class="alert alert-primary">Đây là trang ADMIN kiểm soát hoạt động của hệ thống</div>
              <div id="app">
                <router-view></router-view> 
              </div>
            </main>
            @endif
    
@endsection  