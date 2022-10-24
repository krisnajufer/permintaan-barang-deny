@extends('admin.layouts.app')

@section('title')
    Edit Gudang
@endsection

@section('content')
    <div class="card shadow mb-12 col-md-8 p-0">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Gudang nonProduksi</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('gudang.update', ['slug' => $gudangs->slug_gudang, 'role' => $gudangs->role]) }}"
                method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Gudang</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $gudangs->nama }}">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat Gudang</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" value="{{ $gudangs->alamat }}">
                </div>
                <div class="form-group">
                    <label for="role">Tipe Gudang</label>
                    <input type="text" name="role" id="role" class="form-control" value="{{ $gudangs->role }}"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                        value="{{ $gudangs->password }}">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('gudang') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
