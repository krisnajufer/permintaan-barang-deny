@extends('admin.layouts.app')

@section('title')
    Tambah Gudang
@endsection

@section('content')
    <div class="card shadow mb-12 col-md-8 p-0">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Gudang nonProduksi</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('gudang.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Gudang</label>
                    <input type="text" name="nama" id="nama" class="form-control">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat Gudang</label>
                    <input type="text" name="alamat" id="alamat" class="form-control">
                </div>
                <div class="form-group">
                    <label for="role">Tipe Gudang</label>
                    <input type="text" name="role" id="role" class="form-control" value="nonproduksi" readonly>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('gudang') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
