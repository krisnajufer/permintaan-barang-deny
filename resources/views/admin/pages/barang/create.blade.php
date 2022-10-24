@extends('admin.layouts.app')

@section('title')
    Tambah Barang
@endsection

@section('content')
    <div class="card shadow mb-12 col-md-8 p-0">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Barang Gudang
                {{ $user->role == 'produksi' ? 'Produksi' : 'nonProduksi' }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                @if ($user->role == 'produksi')
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control">
                    </div>
                @elseif ($user->role == 'nonproduksi')
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <select name="id_barang" id="id_barang" class="form-control">
                            <option value="">--Pilih Barang--</option>
                            @foreach ($barangs as $barang)
                                <option value="{{ $barang->barang_id }}">{{ $barang->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama">Stok Barang</label>
                        <input type="text" name="quantity" id="quantity" class="form-control">
                    </div>
                @endif
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('barang') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
