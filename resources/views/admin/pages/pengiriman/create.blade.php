@extends('admin.layouts.app')

@section('title')
    Proses Pengiriman
@endsection

@section('content')
    <div class="card shadow mb-12 col-md-8 p-0">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Proses Pengiriman</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('pengiriman.temporary') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">ID Permintaan</label>
                    <input type="text" name="id_permintaan" id="id_permintaan" class="form-control"
                        value="{{ $detail_permintaan->permintaan_id }}" readonly>
                </div>
                <div class="form-group">
                    <label for="nama">ID Barang</label>
                    <input type="text" name="id_barang" id="id_barang" class="form-control"
                        value="{{ $detail_permintaan->barang_gudang_produksi_id }}" readonly>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama" class="form-control"
                        value="{{ $detail_permintaan->nama_barang }}" readonly>
                </div>
                <div class="form-group">
                    <label for="alamat">Jumlah Permintaan</label>
                    <input type="text" name="jumlah_permintaan" id="permintaan" class="form-control"
                        value="{{ $detail_permintaan->jumlah_permintaan }}" readonly>
                </div>
                <div class="form-group">
                    <label for="role">Jumlah Dikirim</label>
                    <input type="text" name="jumlah_dikirim" id="jumlah_dikirim" class="form-control">
                </div>
                <div class="form-group">
                    <label for="catatan">Catatan</label>
                    <input type="text" name="catatan" id="catatan" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
