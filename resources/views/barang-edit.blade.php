@extends('layouts.navbar')
@section('link')
<div class="container-fluid py-4">
    <div class="row my-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Tambah Barang</h6>
                </div>
              </div>
            </div>
            <div class="card-body">
            <form role="form" action="{{ url('editbarang', $barangs->id_barang) }}" method="post" enctype="multipart/x-www-form-urlencoded">
                @csrf
                <label>Nama Barang</label>
                <div class="mb-3">
                    <input type="text" class="form-control" name="nama_barang" placeholder="Nama Barang" value="{{ $barangs->nama_barang }}">
                </div>
                <label>Gambar</label>
                <div class="mb-3">
                    <input type="file" class="form-control" name="gambar" placeholder="Gambar" value="{{ $barangs->gambar }}">
                </div>
                <label>Harga Awal</label>
                <div class="mb-3">
                    <input type="text" class="form-control" name="harga_awal" placeholder="Harga Awal" value="{{ $barangs->harga_awal }}">
                </div>
                <label>Deskripsi</label>
                <div class="mb-3">
                    <input type="text" class="form-control" name="deskripsi_barang" placeholder="Deskripsi" value="{{ $barangs->deskripsi_barang }}">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Simpan</button>
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
    