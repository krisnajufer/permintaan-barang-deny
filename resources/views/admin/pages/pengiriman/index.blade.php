@extends('admin.layouts.app')

@section('title')
    Pengiriman
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
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pengiriman Barang Gudang Produksi</h6>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Pengiriman</th>
                            <th>ID Permintaan</th>
                            <th>Tanggal Pengiriman</th>
                            <th>Status</th>
                            <th>Tanggal Penerimaan</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($pengiriman))
                            @foreach ($pengiriman as $data)
                                <tr>
                                    <td>{{ $data->pengiriman_id }}</td>
                                    <td>{{ $data->permintaan_id }}</td>
                                    <td>{{ $data->tanggal_pengiriman }}</td>
                                    <td>{{ $data->status_permintaan }}</td>
                                    <td>{{ empty($data->tanggal_penerimaan) ? '-' : $data->tanggal_penerimaan }}</td>
                                    <td>
                                        @if ($user->role == 'produksi')
                                            @if ($data->status_permintaan == 'Dikirim')
                                                <a href="{{ route('pengiriman.update', ['pengiriman_id' => $data->pengiriman_id]) }}"
                                                    class="btn btn-primary">Diterima</a>
                                            @endif
                                        @endif
                                        <a href="{{ route('pengiriman.show', ['pengiriman_id' => $data->pengiriman_id]) }}"
                                            class="btn btn-info">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
