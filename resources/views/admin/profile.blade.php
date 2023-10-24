@extends('admin.layoutAdmin')
@section('content')
@include('sweetalert::alert')
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="/pakar_dashboard">Dashboard Admin</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Halaman Profile</li>
      </ol>
      <h6 class="font-weight-bolder text-white mb-0">Halaman Profile</h6>
    </nav>
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        <div class="input-group">
          <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
          <input type="text" class="form-control" placeholder="Type here...">
        </div>
      </div>
      <ul class="navbar-nav  justify-content-end">
        <li class="nav-item d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
            <i class="fa fa-user me-sm-1"></i>
            <span class="d-sm-inline d-none"></span>
          </a>
        </li>
        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
            </div>
          </a>
        </li>
        <li class="nav-item px-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-white p-0">
            <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="main-content position-relative max-height-vh-100 h-100">
<div class="card shadow-lg mx-4 card-profile-top">
    <div class="card-body p-3">
      <div class="row gx-4">
        <div class="col-auto">
          <div class="avatar avatar-xl position-relative">
            <img src="img/team-3.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
          </div>
        </div>
        <div class="col-auto my-auto">
          <div class="h-100">
            <h5 class="mb-1">
              Admin {{$user->name}}            
            </h5>
            <p class="mb-0 font-weight-bold text-sm">
              Mahasiswa
            </p>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
    <div class="container-fluid py-4">
        <div class="row">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                <p class="mb-0">Profil Pakar</p>
                </div>
            </div>
            <div class="card-body">
                <p class="text-uppercase text-sm">User Information</p>
                <div class="row">
                <form method="POST" action="{{ route('update_profile_admin') }}">
                    @csrf
                    @method('PUT')
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="username" class="form-control-label">Username</label>
                    <input class="form-control" id="username" type="text" name="name" value="{{$user->name}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="email" class="form-control-label">Email address</label>
                    <input class="form-control" id="email" type="email" name="email" value="{{$user->email}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="password" class="form-control-label">Password Baru</label>
                    <input class="form-control" type="password" id="password" name="password">
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                </form>

                <?php /*
                <div class="col-md-12">
                    <div class="form-group">
                    <label class="form-control-label">Tempat praktek</label>
                    <input class="form-control" type="text" value="RS. Soegiri Lamongan">
                    </div>
                </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                    <label class="form-control-label">Jabatan</label>
                    <input class="form-control" type="text" value="Dokter spesialis penyakit dalam">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label class="form-control-label">City</label>
                    <input class="form-control" type="text" value="Lamongan">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label class="form-control-label">Country</label>
                    <input class="form-control" type="text" value="Indonesia">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label class="form-control-label">Postal code</label>
                    <input class="form-control" type="text" value="62211">
                    </div>
                </div>
                </div>
                */ ?>
                <hr class="horizontal dark">
            </div>
            </div>
        </div>
    <footer class="footer pt-3  ">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                    document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by
                <a class="font-weight-bold" target="_blank">PKM Tikung</a>
                for a better web.
                </div>
            </div>
            <div class="col-lg-6">
                <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted" target="_blank">Thank you for visit our website</a>
                </ul>
            </div>
            </div>
        </div>
        </footer>
    </div>
    </div>
<script src="js/jquery/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script> 
@endsection