@extends('admin.layoutAdmin')
@section('content')
<style>
    .button-float{
        float: right;
    }
</style>
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>Tabel Hasil Pelatihan Backpropagation</h6>
              <form action="{{ route('trainMethod') }}" method="GET">
                    @csrf
                    <span >Silahkan klik button disamping untuk melakukan pelatihan</span>
                    <button type="submit" class="btn button-float btn-primary text-end">Mulai Training</button>
              </form>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bobot Input Hidden Layer Terakhir</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Bobot Output Hidden Layer Terakhir</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bias Hidden Layer Terakhir</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bias Output Hidden Layer</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <ul>
                        @foreach ($weightsInputHidden as $item)
                        @if (is_array($item))
                        <li>
                          {{json_encode($item, JSON_PRETTY_PRINT)}}
                        </li>
                        @else
                        <div class="d-flex px-2 py-1">
                            {{$item}}
                        </div>
                        @endif
                        @endforeach
                      </ul>
                    </td>
                    <td>
                      <ul>
                        @foreach ($weightsHiddenOutput as $who)
                        @if (is_array($who))
                          <li>
                            {{json_encode($who, JSON_PRETTY_PRINT)}}
                          </li>
                        @else
                        <div class="d-flex px-2 py-1">
                            {{$who}}
                        </div>
                        @endif
                        @endforeach
                      </ul>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <ul>
                        @foreach ($biasHidden as $biH)
                        @if (is_array($biH))
                        <li>
                          {{json_encode($biH, JSON_PRETTY_PRINT)}}
                          </li>
                        @else
                        <li>
                            {{$biH}}
                        </li>
                        @endif
                        @endforeach
                      </ul>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <ul>
                        @foreach ($biasOutput as $biO)
                        @if (is_array($biO))
                          <li>
                              {{json_encode($biO, JSON_PRETTY_PRINT)}}
                          </li>
                        @else
                        <li>
                            {{$biO}}
                        </li>
                        @endif
                        @endforeach
                      </ul>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!----------------------------------------------------------------------------->
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>Tabel Proses Pelatihan Backpropagation</h6>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              @if (session()->has('trainingResults'))
              @php
              $trainingResults = session()->get('trainingResults');
              @endphp
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Epoch ke -</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Error</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">MSE</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bobot Hidden Layer</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bias Hidden Layer</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bobot Output Layer</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bias Output Layer</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($trainingResults as $item)
                      <tr>
                        <td>{{ $item['epoch'] }}</td>
                        <td>{{ $item['averageError'] }}</td>
                        <td>{{ $item['averageMSE'] }}</td>
                        <td>
                          <ul>
                            @foreach ($item['hiddenWeights'] as $weights)
                                <li>
                                  @foreach ($weights as $w)
                                      {{ $w }}
                                  @endforeach
                                </li>
                            @endforeach
                          </ul>
                        </td>
                        <td>
                          <ul>
                                <li>
                                  {{json_encode($item['hiddenBias'] , JSON_PRETTY_PRINT)}}
                                </li>
                          </ul>
                        </td>
                        <td>
                          <ul>
                                <li>
                                  {{json_encode($item['ouputWeights'] , JSON_PRETTY_PRINT)}}
                                </li>
                          </ul>
                        </td>
                        <td>
                          <ul>
                                <li>
                                  {{json_encode($item['ouputBias'] , JSON_PRETTY_PRINT)}}
                                </li>
                          </ul>
                        </td>
                      </tr>      
                    @endforeach
                  </tbody>
                </table>
              @endif
            </div>
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
@endsection