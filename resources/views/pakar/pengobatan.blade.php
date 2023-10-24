@extends('pakar.layoutUser')
@section('content')
@include('sweetalert::alert')
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="/pakar_dashboard">Dashboard Pakar</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Halaman Pengobatan</li>
      </ol>
      <h6 class="font-weight-bolder text-white mb-0">Halaman Pengobatan</h6>
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
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mt-6 mb-4">
          <div class="card-header pb-0">
            <div class="row">
                <div class="col-6 d-flex align-items-center"><h6>Pengobatan Penyakit Hypertiroid</h6></div>
            <div class="col-6 text-end">
                <a type="button" class="btn bg-gradient-dark mb-0" href="javascript:;" data-bs-toggle="modal" data-bs-target="#modalTambahPengobatan"><i class="fas fa-plus"></i>&nbsp;&nbspTambah Pengobatan</a>
              </div>
            </div>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Penyakit</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Level Penyakit</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pengobatan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($drug as $item)
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">Hypertiroid</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{$item->level->level_penyakit}}</p>
                    </td>
                    <td>
                        <p class="text-xs font-weight-bold mb-0">{{ $item->pengobatan }}</p>
                      </td>
                      <td>
                        <button type="button" class="btn btn-xs btn-success edit" data-id="{{$item->id}}"><i class="fa fa-pencil"></i></button>
                      </td>
                      <td>
                        <form method="POST" action="{{ route('destroy.pengobatan', $item->id) }}">
                          @csrf
                          <input name="_method" type="hidden" value="DELETE">
                        <button type="submit" class="btn btn-xs btn-danger hapus" data-bs-toggle="tooltip" title="delete"><i class="fa fa-trash"></i></button>
                        </form>
                      </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="modalTambahPengobatan" tabindex="-1" aria-labelledby="modalTambahPengobatan" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Cara Pengobatan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!--FORM TAMBAH BARANG-->
              <form action="{{ route('store.pengobatan') }}" method="POST">
                @csrf
              <div class="form-group">
                <label for="">Cara Pengobatan</label>
                <input type="text" class="form-control" id="pengobatan" name="pengobatan">
              </div> 
              <div class="form-group">
                <select class="form-select" id="level" name="level" aria-label="Example select with button addon">
                  <option selected>Pilih Level...</option>
                  @foreach ($level as $item)
                  <option value="{{$item->id}}">{{$item->level_penyakit}}</option>
                  @endforeach
                </select>
              </div>   
              <button type="submit" class="btn btn-primary">Simpan Data</button>
              </form>
              <!--END FORM TAMBAH BARANG-->
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modalEditPengobatan" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <form  name="frm_edit" id="frm_edit" action="{{ route('update.pengobatan') }}" method="POST" enctype="multipart/form-data">
          @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Pengobatan Penyakit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">            
            <div class="form-group">
              <label for="">Pengobatan Penyakit Hypertiroid</label>
              <input type="text" class="form-control" name="pengobatan" id="pengobatan" placeholder="Pengobatan" value="">
            </div> 
            <div class="form-group">
              <select class="form-select" id="level" name="level" aria-label="Example select with button addon">
                <option selected>Pilih Level...</option>
                @foreach ($level as $item)
                <option value="{{$item->id}}">{{$item->level_penyakit}}</option>
                @endforeach
              </select>
            </div>   
            <input type="hidden" name="id" id="id"> 
            <button type="submit" class="btn btn-primary">Simpan Data</button>
          </div>
        </div>
      </form>
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
        $(document).ready(function(){
          //edit data
          $('.edit').on("click", function(){
          var id= $(this).attr('data-id');
          $.ajax({
            url:"{{route('edit.pengobatan')}}?id="+ id,
            type:"GET",
            dataType:"JSON",
            success:function(data){
              $('#id').val(data.id);
              $('#pengobatan').val(data.pengobatan);
              $('#level').val(data.level);
              $('#modalEditPengobatan').modal('show');
            },
          }); 
        });
      });
      </script>
        
      <script type="text/javascript">
      //hapus data
          $('.hapus').click(function(event){
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
          title: 'Yakin Menghapus Data Ini',
          icon: "warning",
          button: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete){
            form.submit();
          }
        });
      });
      </script>
@endsection