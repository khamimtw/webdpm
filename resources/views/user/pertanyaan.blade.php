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
    <div class="container-fluid py-4">
        <div class="row">
        <div class="col-mb-3">
            @if ($errors->any())
                <div class="alert alert-danger" id="alert">
                    <h6 style="color: aliceblue">Data yang Anda masukkan salah. Mohon periksa kembali.
                    <i class="fa fa-close" style="float: right" onclick="hideAlert()"></i></h6>
                </div>
                @endif
            <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                <p class="mb-0">Pertanyaan Ke Dokter</p>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('pertanyaan.input') }}" method="POST">
                @csrf
                <p class="text-uppercase text-sm">Silahkan Masukkan Pertanyaan</p>
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="nama" class="form-control-label">Nama</label>
                    <input class="form-control" type="text" placeholder="Nama Anda"  name="nama" id="nama">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="jenis_kelamin" class="form-control-label">Jenis Kelamin</label>
                        <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                        <option value="" disabled selected>Silahkan Pilih Jenis Kelamin </option>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>
                <hr class="horizontal dark">
                <p class="text-uppercase text-sm">Masukkan Pertanyaan anda</p>
                <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                    <label for="pertanyaan" class="form-control-label">Pertanyaan</label>
                    <input class="form-control" type="text" placeholder="Masukkan Pertanyaan anda" name="pertanyaan" id="pertanyaan">
                    </div>
                </div>
                <div class="row">
                <div class="col-md-4">
                    <div class="btnn">
                    <button type="submit" class=" bttn btn1">Kirim</button>
                    </div>
                </div>
                </div>
            </div>
            </form>
            </div>
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
<script src="js/jquery/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script> 
<script>
function hideAlert() {
    document.getElementById('alert').style.display = 'none';
}
</script>
@endsection