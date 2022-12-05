@extends('admin.layouts.app')

@section('title')
    Detail Permintaan
@endsection

@push('after-style')
    <link href="{{ asset('SBadmin2/assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('after-script')
    <script src="{{ asset('SBadmin2/assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('SBadmin2/assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $('#dataTable').DataTable();
    </script>
@endpush

@section('content')
    <div class="card shadow mb-12">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Detail Permintaan {{ $permintaan->permintaan_id }}</h6>
            <div>
                <a href="{{ route('permintaan') }}" class="btn btn-secondary">Kembali</a>
                @if ($user->role == 'nonproduksi')
                    @if ($count_temporary == $count_detail)
                        <a href="{{ route('pengiriman.store', ['permintaan_id' => $permintaan->permintaan_id]) }}"
                            class="btn btn-primary">Simpan</a>
                    @endif
                @endif
            </div>
        </div>
        <div class="card-body">
            {{-- @if ($user->role == 'produksi')
                <div class="row my-4">
                    <div class="col d-flex justify-content-end">
                        <a href="{{ route('permintaan.create') }}" class="btn btn-success"><i class="fas fa-plus"></i>
                            <span>Tambah</span></a>
                    </div>
                </div>
            @endif --}}

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            @if ($user->role == 'nonproduksi')
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($detail_permintaan))
                            @foreach ($detail_permintaan as $data)
                                <tr>
                                    <td>{{ $data->nama_barang }}</td>
                                    <td>{{ $data->jumlah_permintaan }}</td>
                                    @if ($user->role == 'nonproduksi')
                                        <td>
                                            @if (!empty($temporary_pengiriman))
                                                @if (array_key_exists($permintaan->permintaan_id . $data->barang_gudang_produksi_id, $temporary_pengiriman) or
                                                    $data->status_permintaan == 'Dikirim')
                                                    <h5>
                                                        <span class="badge badge-success">Selesai</span>
                                                    </h5>
                                                @else
                                                    <a href="{{ route('pengiriman.create', ['pengiriman_id' => $permintaan->permintaan_id, 'barang_gudang_produksi_id' => $data->barang_gudang_produksi_id]) }}"
                                                        class="btn btn-success">
                                                        Proses Kirim
                                                    </a>
                                                @endif
                                            @else
                                                @if ($data->status_permintaan == 'Dikirim' or $data->status_permintaan == 'Diterima')
                                                    <h5>
                                                        <span class="badge badge-success">Selesai</span>
                                                    </h5>
                                                @else
                                                    <a href="{{ route('pengiriman.create', ['pengiriman_id' => $permintaan->permintaan_id, 'barang_gudang_produksi_id' => $data->barang_gudang_produksi_id]) }}"
                                                        class="btn btn-success">
                                                        Proses Kirim
                                                    </a>
                                                @endif
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
