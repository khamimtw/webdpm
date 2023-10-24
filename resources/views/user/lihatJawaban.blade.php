@extends('user.layout')
@section('content')
@include('sweetalert::alert')
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="/">Dashboard</a></li>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page">Diagnosa Hypertiroid</li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">Halaman Utama</h6>
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
                <span class="d-sm-inline d-none">Contributor</span>
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
        <div class="container">
            <div class="card bg-dark mb-3 text-center">
                <div class="card-body">
                    <h5 class="card-title text-white">Pertanyaan belum dijawab</h5>
                </div>
            </div>  
            @foreach ($unansweredQuestions as $item)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Dari : {{ $item->nama}}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Pertanyaan : {{ $item->pertanyaan}}</p>
                </div>
            </div>         
            @endforeach
        </div>
        <div class="container">
            <div class="card bg-dark mb-3 text-center">
                <div class="card-body">
                    <h5 class="card-title text-white">Pertanyaan sudah dijawab</h5>
                </div>
            </div> 
            @foreach ($answeredQuestions as $item)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Dari : {{ $item->nama}}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Pertanyaan : {{ $item->pertanyaan}}</p>
                </div>
                <div class="card-footer">
                    <h6 class="card-subtitle mb-2 text-muted">Jawaban:</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">{{ $item->jawaban }}</li>
                    </ul>
                </div>
            </div>         
            @endforeach
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
<script src="js/jquery/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script> 
@endsection