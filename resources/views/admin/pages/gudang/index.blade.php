@extends('admin.layouts.app')

@section('title')
    Gudang
@endsection

@push('after-style')
    <link href="{{ asset('SBadmin2/assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('after-script')
    <script src="{{ asset('SBadmin2/assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('SBadmin2/assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
        $(`input[name="options"]`).each((i, el) => {
            $(el).on('change', (e) => {
                const role = $(e.target).val();
                var table = $('#dataTable').DataTable();
                table.clear().draw();
                if (role == 'produksi') {
                    fetch("{{ route('gudang.get') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                role: role
                            }),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            len = data.gudangs.length;
                            $("#tambahGudang").attr("hidden", true);
                            if (len > 0) {
                                for (let index = 0; index < len; index++) {
                                    const id = data.gudangs[index].gudang_id;
                                    const nama = data.gudangs[index].nama;
                                    const alamat = data.gudangs[index].alamat;
                                    const slug_gudang = data.gudangs[index].slug_gudang;
                                    const role_gudang = data.gudangs[index].role;
                                    const slug_user = data.gudangs[index].slug_user;
                                    const aksi =
                                        '<?php if($user->role == "produksi") { ?> <a class="btn btn-info" href="<?php echo url("/gudang/edit/' +slug_gudang +'/'+role_gudang+'"); ?>"><i class="fas fa-edit"></i><span>Edit</span></a> <?php } ?>'
                                    table.row.add([
                                        id,
                                        nama,
                                        alamat,
                                        aksi
                                    ]).draw(false);
                                }
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                } else {
                    fetch("{{ route('gudang.get') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                role: role
                            }),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            len = data.gudangs.length;
                            $("#tambahGudang").removeAttr("hidden");
                            if (len > 0) {
                                for (let index = 0; index < len; index++) {
                                    const id = data.gudangs[index].gudang_id;
                                    const nama = data.gudangs[index].nama;
                                    const alamat = data.gudangs[index].alamat;
                                    const slug_gudang = data.gudangs[index].slug_gudang;
                                    const role_gudang = data.gudangs[index].role;
                                    const slug_user = data.gudangs[index].slug_user;
                                    const aksi =
                                        '<?php if($user->role == "produksi") { ?> <a class="btn btn-info" href="<?php echo url("/gudang/edit/' +slug_gudang +'/'+role_gudang+'"); ?>"><i class="fas fa-edit"></i> <span>Edit</span></a> <a class="btn btn-danger" href="<?php echo url("/gudang/destroy/' +slug_gudang +'/'+slug_user+'/'+role_gudang+'"); ?>"><i class="fas fa-trash-alt"></i> <span>Hapus</span></a><?php } ?>'
                                    table.row.add([
                                        id,
                                        nama,
                                        alamat,
                                        aksi
                                    ]).draw(false);
                                }
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                }
            })
        });
    </script>
@endpush

@section('content')
    <div class="card shadow mb-12">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Gudang
                {{ $user->role == 'produksi' ? 'Produksi & nonProduksi' : 'nonProduksi' }}</h6>
        </div>
        <div class="card-body">
            @if ($user->role == 'produksi')
                <div class="row my-4">
                    <div class="col-md-7 d-flex justify-content-end">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-outline-primary">
                                <input type="radio" name="options" id="options" value="produksi"
                                    autocomplete="off">Produksi
                            </label>
                            <label class="btn btn-outline-primary">
                                <input type="radio" name="options" id="options" value="nonproduksi" autocomplete="off">
                                nonProduksi
                            </label>
                        </div>
                    </div>
                    <div class="col-md-5 d-flex justify-content-end">
                        <a href="{{ route('gudang.create') }}" class="btn btn-success" id="tambahGudang" hidden><i
                                class="fas fa-plus"></i>
                            <span>Tambah</span></a>
                    </div>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 13%;">ID Gudang</th>
                            <th style="width: 25%;">Nama Gudang</th>
                            <th style="width: 40%;">Alamat Gudang</th>
                            @if ($user->role == 'produksi')
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($gudangs))
                            @foreach ($gudangs as $gudang)
                                <tr>
                                    <td>{{ $gudang->gudang_id }}</td>
                                    <td>{{ $gudang->nama }}</td>
                                    <td>{{ $gudang->alamat }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
