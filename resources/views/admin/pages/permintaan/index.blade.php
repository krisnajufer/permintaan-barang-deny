@extends('admin.layouts.app')

@section('title')
    Permintaan
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
            <h6 class="m-0 font-weight-bold text-primary">Permintaan Gudang Produksi</h6>
        </div>
        <div class="card-body">
            @if ($user->role == 'produksi')
                <div class="row my-4">
                    <div class="col d-flex justify-content-end">
                        <a href="{{ route('permintaan.create') }}" class="btn btn-success"><i class="fas fa-plus"></i>
                            <span>Tambah</span></a>
                    </div>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Permintaan</th>
                            <th>Nama Gudang</th>
                            <th>Tanggal Permintaan</th>
                            <th>Status Permintaan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($permintaans))
                            @foreach ($permintaans as $permintaan)
                                <tr>
                                    <td>{{ $permintaan->permintaan_id }}</td>
                                    <td>{{ $permintaan->nama }}</td>
                                    <td>{{ $permintaan->tanggal_permintaan }}</td>
                                    <td>{{ $permintaan->status_permintaan }}</td>
                                    <td>
                                        @if ($permintaan->status_permintaan == 'Pending' and $user->role == 'nonproduksi' or
                                            $permintaan->status_permintaan == 'Proses' and $user->role == 'nonproduksi')
                                            <a href="" class="btn btn-info">Proses</a>
                                        @elseif ($permintaan->status_permintaan == 'Dikirim' and $user->role == 'nonproduksi')
                                            <a href="" class="btn btn-info">Detail</a>
                                        @elseif ($user->role == 'produksi')
                                            <a href="{{ route('permintaan.show', ['slug' => $permintaan->slug]) }}"
                                                class="btn btn-info">Detail</a>
                                        @endif
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
