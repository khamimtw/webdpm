@extends('admin.layoutAdmin')
@section('content')
@include('sweetalert::alert')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>Tabel Hasil Pelatihan Backpropagation</h6>
            <form action="{{ url('/test') }}" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-primary">Mulai Testing</button>
                </form>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Umur</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jenis Kelamin</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kehamilan</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TSH</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">T3</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TT4</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hasil yang diharapkan</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Hasil</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Hasil Perhitungan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($results as $item)
                  <tr>
                    @foreach ($item['attributes'] as $attr)
                    <td>
                      <div class="d-flex px-2 py-1">
                        <p class="text-xs font-weight-bold mb-0">{{$attr}}</p>
                      </div>
                    </td>
                    @endforeach
                    <td>
                      <p class="text-xs font-weight-bold mb-0"> {{json_encode($item['hasil']) }}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0"> {{json_encode($item['result']) }}</p>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td><p class="text-xs font-weight-bold mb-0">Presentase Pengujian</p></td>
                    <td> <p class="text-xs font-weight-bold mb-0"> {{ $predict }}</p></td>
                  </tr>
                </tfoot>
              </table>
            </div>
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
@endsection