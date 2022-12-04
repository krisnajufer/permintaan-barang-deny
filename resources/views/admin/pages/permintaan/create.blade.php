@extends('admin.layouts.app')

@section('title')
    Tambah Permintaan
@endsection

@push('after-style')
    <link href="{{ asset('SBadmin2/assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('after-script')
    <script src="{{ asset('SBadmin2/assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('SBadmin2/assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        table = $("#dataTable").DataTable();
        dataPermintaan = [];
        $("#tambah-permintaan").submit(function(e) {
            e.preventDefault();
            if ($("#id_barang").val() == "null" || $("#quantity").val() == "") {
                Swal.fire({
                    icon: 'info',
                    title: 'Oops...',
                    text: "Tidak boleh ada field yang kosong",
                    customClass: 'swal-height'
                })
            } else {
                dataPermintaan.push({
                    "bgp_id": $("#id_barang").val(),
                    "nama_barang": $("#id_barang option:selected").text(),
                    "quantity": $("#quantity").val()
                })
                $("#dataTable").DataTable().destroy();
                i = 1;
                $("#dataTable").DataTable({
                    data: dataPermintaan,
                    columns: [{
                            render: function() {
                                return i++;
                            }
                        }, {
                            data: "nama_barang"
                        },
                        {
                            data: "quantity"
                        },
                        {
                            data: "bgp_id",
                            render: function(data) {
                                return "<button class='btn btn-warning' id='hapus-permintaan' data-barang-delete=" +
                                    data + " onclick='deleteListPermintaan(event)'>Hapus</button>"
                            }
                        }
                    ]
                })
            }
        })

        function deleteListPermintaan(e) {
            e.preventDefault();
            index = dataPermintaan.findIndex(x => x.bgp_id == e.target.getAttribute('data-barang-delete'));
            dataPermintaan.splice(index, 1);
            $("#dataTable").DataTable().destroy();
            i = 1;
            $("#dataTable").DataTable({
                data: dataPermintaan,
                columns: [{
                        render: function() {
                            return i++;
                        }
                    }, {
                        data: "nama_barang"
                    },
                    {
                        data: "quantity"
                    },
                    {
                        data: "bgp_id",
                        render: function(data) {
                            return "<button class='btn btn-warning' id='hapus-permintaan' data-barang-delete=" +
                                data + " onclick='deleteListPermintaan(event)'>Hapus</button>"
                        }
                    }
                ]
            })
        }

        function storeListPermintaan(e) {
            e.preventDefault();
            if (dataPermintaan.length == 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'Oops...',
                    text: "List permintaan tidak boleh kosong",
                    customClass: 'swal-height'
                })
            } else {
                permintaan_id = "{{ $permintaan_id }}";
                data_permintaan = JSON.stringify(dataPermintaan);
                fetch("{{ route('permintaan.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            permintaan: data_permintaan,
                            id_permintaan: permintaan_id
                        }),
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        console.log("oke" + data);
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: "Permintaan berhasil di tambahkan",
                            customClass: 'swal-height'
                        })
                        window.location.href = "{{ route('permintaan') }}";
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            }
        }
    </script>
@endpush

@section('content')
    <div class="card shadow mb-12 col-md-8 p-0">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Permintaan</h6>
        </div>
        <div class="card-body">
            <form id="tambah-permintaan">
                <div class="form-group">
                    <label for="nama">Nama Barang</label>
                    <select name="id_barang" id="id_barang" class="form-control">
                        <option value="null">--Pilih Barang--</option>
                        @foreach ($barangs as $barang)
                            <option value="{{ $barang->barang_gudang_produksi_id }}">{{ $barang->nama_barang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="nama">Jumlah Barang</label>
                    <input type="text" name="quantity" id="quantity" class="form-control">
                </div>
                <a href="{{ route('permintaan') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div>
    </div>

    <div class="card shadow mb-12 col-md-8 p-0 my-3">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">List Permintaan {{ $permintaan_id }}</h6>
            <button class="btn btn-success" onclick="storeListPermintaan(event)">Simpan</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Barang</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
