@extends('admin.layouts.app')

@section('title')
    Barang
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
                    table.destroy();
                    $('#dataTable').empty();
                    $('#dataTable').DataTable({
                        columns: [{
                                title: "ID Barang"
                            },
                            {
                                title: "Nama Barang"
                            },
                            {
                                title: "Nama Gudang"
                            },
                            {
                                title: "Action"
                            }
                        ]
                    });
                    table = $('#dataTable').DataTable();
                    fetch("{{ route('barang.get') }}", {
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
                            len = data.barangs.length;
                            $("#tambahBarang").removeAttr("hidden");
                            if (len > 0) {
                                for (let index = 0; index < len; index++) {
                                    const id = data.barangs[index].barang_gudang_id;
                                    const nama_barang = data.barangs[index].nama_barang;
                                    const nama_gudang = data.barangs[index].nama_gudang;
                                    const slug_barang = data.barangs[index].slug_barang;
                                    const aksi =
                                        '<?php if($user->role == "produksi") { ?> <a class="btn btn-info" href="<?php echo url("/barang/edit/'+slug_barang+'"); ?>"><i class="fas fa-edit"></i><span>Edit</span></a><a class="btn btn-danger mx-1" href="<?php echo url("/barang/destroy/'+slug_barang+'"); ?>"><i class="fas fa-trash-alt"></i> <span>Hapus</span></a> <?php } ?>'
                                    table.row.add([
                                        id,
                                        nama_barang,
                                        nama_gudang,
                                        aksi
                                    ]).draw(false);
                                }
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                } else {
                    table.destroy();
                    $('#dataTable').empty();
                    $('#dataTable').DataTable({
                        columns: [{
                                title: "ID Barang"
                            },
                            {
                                title: "Nama Barang"
                            },
                            {
                                title: "Nama Gudang"
                            }
                        ]
                    });
                    table = $('#dataTable').DataTable();
                    fetch("{{ route('barang.get') }}", {
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
                            $("#tambahBarang").attr("hidden", true);
                            len = data.barangs.length;
                            if (len > 0) {
                                for (let index = 0; index < len; index++) {
                                    const id = data.barangs[index].barang_gudang_id;
                                    const nama_barang = data.barangs[index].nama_barang;
                                    const nama_gudang = data.barangs[index].nama_gudang;
                                    table.row.add([
                                        id,
                                        nama_barang,
                                        nama_gudang
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
            <h6 class="m-0 font-weight-bold text-primary">Data Barang Gudang
                {{ $user->role == 'produksi' ? 'Produksi & nonProduksi' : 'nonProduksi' }}</h6>
        </div>
        <div class="card-body">

            <div class="row my-4">
                @if ($user->role == 'produksi')
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
                @endif
                <div class="{{ $user->role == 'produksi' ? 'col-md-5 ' : 'col-md-12 ' }}d-flex justify-content-end">
                    <a href="{{ route('barang.create') }}" class="btn btn-success" id="tambahBarang"
                        {{ $user->role == 'produksi' ? 'hidden' : '' }}><i class="fas fa-plus"></i>
                        <span>Tambah</span></a>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 15%;">ID Barang</th>
                            <th style="width: 25%;">Nama Barang</th>
                            <th style="width: 20%;">Nama Gudang</th>
                            <th style="width: 13%;">Stok Barang</th>
                            <th>Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($barangs))
                            @foreach ($barangs as $barang)
                                <tr>
                                    <td>{{ $barang->barang_gudang_id }}</td>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>{{ $barang->nama_gudang }}</td>
                                    <td>{{ $barang->quantity }}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{ url('/barang/edit/' . $barang->slug_barang) }}"><i
                                                class="fas fa-edit"></i>
                                            <span>Edit</span></a>
                                        <a class="btn btn-danger"
                                            href="{{ url('/barang/destroy/' . $barang->slug_barang) }}"><i
                                                class="fas fa-trash-alt"></i> <span>Hapus</span>
                                        </a>
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
