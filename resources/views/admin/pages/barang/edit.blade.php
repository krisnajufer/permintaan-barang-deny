@extends('admin.layouts.app')

@section('title')
    Edit Barang
@endsection

@section('content')
    <div class="card shadow mb-12 col-md-8 p-0">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data Barang Gudang
                {{ $user->role == 'produksi' ? 'Produksi' : 'nonProduksi' }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('barang.update', ['slug' => $data->slug_barang]) }}" method="POST">
                @csrf
                @if ($user->role == 'produksi')
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control"
                            value="{{ $data->nama_barang }}">
                    </div>
                @elseif ($user->role == 'nonproduksi')
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <select id="id_barang" class="form-control" disabled>
                            <option value="{{ $data->barang_gudang_id }}">{{ $data->nama_barang }}</option>
                        </select>
                        <input type="hidden" name="id_barang" value="{{ $data->barang_gudang_id }}">
                    </div>
                    <div class="form-group">
                        <label for="nama">Stok Barang</label>
                        <input type="text" name="quantity" id="quantity" class="form-control"
                            value="{{ $data->quantity }}">
                    </div>
                @endif
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('barang') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
