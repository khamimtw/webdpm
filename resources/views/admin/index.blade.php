@extends('admin.layoutAdmin')
@section('content')
@include('sweetalert::alert')
<div class="container-fluid py-4">
    <div class="row">
      <div class="mb-lg-0 mb-4">
        <div class="card z-index-2 h-100 ">
          <div class="card-header pb-0 pt-3 bg-transparent">
            <h5 class="text-capitalize text-center">Web Diagnosa Penyakit Hipertyroid</h5>
          </div>
          <div class="card-body p-3">
           <p class="card-text text-center">
              Web diagnosa penyakit hypertiroid merupakan website yang dapat melakukan diagnosa penyakit hypertiroid dengan cara mengidentifikasi kadar TSH, T3 dan T4 yang telah diinputkan user ke dalam database. Hasil yang dikeluarkan nantinya berapa persen user tersebut terkena penyakit hypertiroid dan juga saran untuk pengobatan awal sebelum nantinya user datang ke rumah sakit terdekat untuk melakukan pemeriksaan secara meyeluruh dan mendapatkan pengobatan yang lebih maksimal.
           </p>
          </div>
        </div>
      </div>
     
 <div class="row mt-4">
      <div class="col-lg-7 mb-lg-0 mb-4">
        <div class="card ">
          <div class="card-header pb-0 p-3">
            <div class="d-flex justify-content-between">
              <h6 class="mb-2">Gejala yang dianalisis</h6>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table align-items-center ">
              <tbody>
                <tr>
                  <td class="w-30">
                    <div class="d-flex px-2 py-1 align-items-center">
                      <div>
                        <i class="fa fa-database"></i>
                      </div>
                      <div class="ms-4">
                        Usia
                      </div>
                    </div>
                  </td>
                </tr>
                  <tr>
                  <td class="w-30">
                    <div class="d-flex px-2 py-1 align-items-center">
                      <div>
                        <i class="fa fa-database"></i>
                      </div>
                      <div class="ms-4">
                        Jenis Kelamin
                      </div>
                    </div>
                  </td>
                </tr>
                 <tr>
                  <td class="w-30">
                    <div class="d-flex px-2 py-1 align-items-center">
                      <div>
                        <i class="fa fa-database"></i>
                      </div>
                      <div class="ms-4">
                        Dalam kondisi hamil atau tidak (Untuk Perempuan)
                      </div>
                    </div>
                  </td>
                </tr>
                  <tr>
                  <td class="w-30">
                    <div class="d-flex px-2 py-1 align-items-center">
                      <div>
                        <i class="fa fa-database"></i>
                      </div>
                      <div class="ms-4">
                        TSH
                      </div>
                    </div>
                  </td>
                </tr>
                   <tr>
                  <td class="w-30">
                    <div class="d-flex px-2 py-1 align-items-center">
                      <div>
                        <i class="fa fa-database"></i>
                      </div>
                      <div class="ms-4">
                        T3
                      </div>
                    </div>
                  </td>
                </tr>
                  <tr>
                  <td class="w-30">
                    <div class="d-flex px-2 py-1 align-items-center">
                      <div>
                        <i class="fa fa-database"></i>
                      </div>
                      <div class="ms-4">
                        TT4
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="card">
          <div class="card-header pb-0 p-3">
            <h6 class="mb-0">Level penyakit hypertiroid</h6>
          </div>
          <div class="card-body p-3">
            <ul class="list-group">
              <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                <div class="d-flex align-items-center">
                  <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                    <i class="fa fa-circle-o text-white opacity-10"></i>
                  </div>
                  <div class="d-flex flex-column">
                    <h6 class="mb-1 text-dark text-sm">Ringan</h6>
                </div>
              </li>
              <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                <div class="d-flex align-items-center">
                  <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                    <i class="fa fa-circle-o text-white opacity-10"></i>
                  </div>
                  <div class="d-flex flex-column">
                    <h6 class="mb-1 text-dark text-sm">Sedang</h6>
                </div>
              </li>
              <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                <div class="d-flex align-items-center">
                  <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                    <i class="fa fa-circle-o text-white opacity-10"></i>
                  </div>
                  <div class="d-flex flex-column">
                    <h6 class="mb-1 text-dark text-sm">Berat</h6>
                </div>
              </li>
            </ul>
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
  </div>
</main>
@endsection