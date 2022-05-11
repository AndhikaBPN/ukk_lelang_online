@extends('layouts.navbar')
@section('link')
  <div class="container-fluid py-4">
    <div class="card">
      <div class="card-header pb-0">
        <div class="row">
          <div class="col-lg-6 col-7">
            <h6>Detail Lelang 
              @if (auth()->user()->role=="admin")
                <a href=" {{ Route('report', $detail->id_lelang) }} "><i class="fa-solid fa-file-export"></i></a>
              @endif
              @if (auth()->user()->role=="petugas")
                <a href=" {{ Route('report', $detail->id_lelang) }} "><i class="fa-solid fa-file-export"></i></a>
              @endif
            </h6>
          </div>
        </div>
      </div>
      <div class="card-body p-3">
        <div class="row">
          <div class="col-lg-6">
            <div class="d-flex flex-column h-100">
              <h5 class="font-weight-bolder">Nama Barang: <p class="mb-5">{{ $detail->nama_barang }}</p></h5>
              <h5 class="font-weight-bolder">Harga Awal: <p class="mb-5">Rp.{{ number_format($detail->harga_awal) }}</p></h5>
              @if($detail->harga_akhir == null)
                <h5 class="font-weight-bolder">Harga Akhir: <p class="mb-5">-</p></h5>
              @else
                <h5 class="font-weight-bolder">Harga Akhir: <p class="mb-5">Rp.{{ number_format($detail->harga_akhir) }}</p></h5>
              @endif
              
              <h5 class="font-weight-bolder">Tanggal Lelang: <p class="mb-5">{{ date('d/m/Y', strtotime($detail->tgl_lelang)) }}</p></h5>
              @if($detail->id_pengguna == null)
                <h5 class="font-weight-bolder">Pemenang: <p class="mb-5">-</p></h5>
              @else
                <h5 class="font-weight-bolder">Pemenang: <p class="mb-5">{{ $detail->nama }} </p></h5>
              @endif
              <h5 class="font-weight-bolder">Deskripsi: <p class="mb-5">{{ $detail->deskripsi_barang }}</p></h5>
            </div>
          </div>
          <div class="col-lg-5 ms-auto text-center mt-5 mt-lg-0">
            <div class="position-relative d-flex align-items-center justify-content-center h-100 me-4">
              <img class="w-100 position-relative z-index-2 pt-1 border-radius-lg" src="{{ asset('images/post/'.$detail->gambar) }}" alt="rocket">
              </div>
            </div>
          </div>
        </div>
      </div>
      @if(auth()->user()->role=="pengguna")
      <div class="row my-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Penawaran Harga</h6>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
              <form role="form" action="{{ url('penawaran') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="text" class="form-control" name="id_lelang" placeholder="Penawaran Harga"  value=" {{ $detail->id_lelang }} " hidden>
                </div>
                <label>Penawaran Harga</label>
                <div class="mb-3">
                    <input type="text" class="form-control" name="penawaran_harga" placeholder="Penawaran Harga">
                </div>
                @if (session('warning'))
                  <div class="alert alert-warning">
                    {{ session('warning') }}
                  </div>
                @endif
                <div class="text-center">
                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0" onclick="return confirm('Apakah anda yakin?')">Tawar</button>
                </div>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif
      <div class="row my-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>List User</h6>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alamat</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor HP</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Penawaran</th>
                      @if(auth()->user()->role=="petugas")
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      @endif
                    </tr>
                  </thead>
                    <?php $no=1;?>
                    @foreach($historyd as $ud)
                  <tbody>
                    <tr>
                      <td>
                        <div class="d-flex px-3 py-5">
                          <div class="align-middle text-center text-sm">
                            <h6 class="mb-0 text-sm">  {{ $no++ }}</h6>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold"> {{ $ud->nama }} </span>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold"> {{ $ud->alamat }} </span>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold"> {{ $ud->no_hp }} </span>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold"> Rp.{{ number_format($ud->penawaran_harga) }} </span>
                      </td>
                      @if(auth()->user()->role=="petugas")
                      <td class="align-middle text-center text-sm">
                        <form action="{{ url('pemenang', $ud->id_history) }}" method="post">
                            @csrf
                            @if($detail->status=='dibuka')
                                <button type="submit" class="btn btn-icon btn-primary" onclick="return confirm('Are you sure?')">Pilih</button>
                            </td>
                            @else
                                @if($ud->status_pemenang=='kalah')
                                    <span class="btn btn-icon btn-danger">Kalah</span>
                                @else
                                    <span class="btn btn-icon btn-success">Menang</span>
                                @endif
                            @endif
                        </form>
                      </td>
                      @endif
                    </tr>
                  </tbody>
                  @endforeach
                </table>
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
                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                for a better web.
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
@endsection