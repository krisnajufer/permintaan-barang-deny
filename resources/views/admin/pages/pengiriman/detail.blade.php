@extends('admin.layouts.app')

@section('title')
    Detail Pengiriman
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
            <h6 class="m-0 font-weight-bold text-primary">Detail Pengiriman {{ $pengiriman_id }}</h6>
            <a href="{{ route('pengiriman') }}" class="btn btn-secondary">Kembali</a>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Pengiriman</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($detail))
                            @foreach ($detail as $data)
                                <tr>
                                    <td>{{ $data->barang_gudang_produksi_id }}</td>
                                    <td>{{ $data->nama_barang }}</td>
                                    <td>{{ $data->jumlah_pengiriman }}</td>
                                    <td>{{ $data->catatan }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
