@extends('admin.layouts.app')

@section('title')
    Barang
@endsection

@push('after-script')
    <script>
        $(`input[name=options]`).each((i, el) => {
            $(el).on('change', (e) => {
                const role = $(e.target).val();
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
                        if (role == 'produksi') {
                            $("#wrapperButton").removeClass("justify-content-center").addClass(
                                "justify-content-between");
                            $("#tambahBarang").show();
                            $("#barangTable").empty();
                            field =
                                "<thead><tr><th class='col-md-3'>ID Barang Gudang Produksi</th><th>Gudang</th><th>Nama Barang</th><?php if($users->role == 'produksi') { ?><th>Aksi</th><?php } ?></tr></thead><tbody></tbody>";
                            $(field).appendTo("#barangTable");
                            if (len > 0) {
                                for (var i = 0; i < len; i++) {
                                    var rows = "";
                                    var id = data.barangs[i].barang_gudang_id;
                                    var nama_gudang = data.barangs[i].nama_gudang;
                                    var nama_barang = data.barangs[i].nama_barang;
                                    var slug_barang = data.barangs[i].slug_barang;
                                    var aksi =
                                        "<a href='<?php echo url('/gudang/edit/" +slug_barang +"'); ?>' class='btn btn-inverse-primary btn-icon-text fw-bold'>" +
                                        "<i class='ti-pencil-alt btn-icon-prepend'></i>" +
                                        'Edit' +
                                        "</a>" +
                                        "<a href='<?php echo url('/gudang/destroy/" +slug_barang +"'); ?>' class='btn btn-inverse-danger btn-icon-text fw-bold'>" +
                                        "<i class='ti-trash btn-icon-prepend'></i>" +
                                        "Delete" +
                                        "</a>";
                                    rows = "<tr><td>" + id + "</td><td>" + nama_gudang +
                                        "</td><td>" +
                                        nama_barang +
                                        "</td><?php if($users->role == 'produksi') { ?><td><div class='d-flex gap-2'>" +
                                        aksi +
                                        "</div></td><?php } ?></tr>"
                                    $(rows).appendTo("#barangTable tbody");
                                }
                            } else {
                                var rows = "";
                                rows =
                                    "<tr><td colspan='4' class='text-center'>Nothing data to display</td></tr>"
                                $(rows).appendTo("#gudangTable tbody");
                            }
                        } else {
                            $("#wrapperButton").removeClass("justify-content-between").addClass(
                                "justify-content-center");
                            $("#tambahBarang").hide();
                            $("#barangTable").empty();
                            field =
                                "<thead><tr><th class='col-md-3'>ID Barang Gudang</th><th>Gudang</th><th>Nama Barang</th><th>Quantity</th><?php if($users->role == 'nonproduksi') { ?><th>Aksi</th><?php } ?></tr></thead><tbody></tbody>";
                            $(field).appendTo("#barangTable");
                            if (len > 0) {
                                for (var i = 0; i < len; i++) {
                                    var rows = "";
                                    var id = data.barangs[i].barang_gudang_id;
                                    var nama_gudang = data.barangs[i].nama_gudang;
                                    var nama_barang = data.barangs[i].nama_barang;
                                    var slug_barang = data.barangs[i].slug_barang;
                                    var quantity = data.barangs[i].quantity;
                                    var aksi =
                                        "<a href='<?php echo url('/gudang/edit/" +slug_barang +"'); ?>' class='btn btn-inverse-primary btn-icon-text fw-bold'>" +
                                        "<i class='ti-pencil-alt btn-icon-prepend'></i>" +
                                        'Edit' +
                                        "</a>" +
                                        "<a href='<?php echo url('/gudang/destroy/" +slug_barang +"'); ?>' class='btn btn-inverse-danger btn-icon-text fw-bold'>" +
                                        "<i class='ti-trash btn-icon-prepend'></i>" +
                                        "Delete" +
                                        "</a>";
                                    rows = "<tr><td>" + id + "</td><td>" + nama_gudang +
                                        "</td><td>" +
                                        nama_barang +
                                        "</td><td>" + quantity +
                                        "</td><?php if($users->role == 'nonproduksi') { ?><td><div class='d-flex gap-2'>" +
                                        aksi +
                                        "</div></td><?php } ?></tr>"
                                    $(rows).appendTo("#barangTable tbody");
                                }
                            } else {
                                var rows = "";
                                rows =
                                    "<tr><td colspan='4' class='text-center'>Nothing data to display</td></tr>"
                                $(rows).appendTo("#gudangTable tbody");
                            }
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
@endpush

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Barang
                    {{ $users->role == 'produksi' ? 'Produksi & nonProduksi' : 'nonProduksi' }}
                </h4>
                <p class="card-description">
                    Informasi Gudang
                    {{ $users->role == 'produksi' ? 'Produksi & nonProduksi' : 'nonProduksi' }}
                </p>
                @if ($users->role == 'produksi')
                    <div class="d-flex justify-content-between" id="wrapperButton">
                        <div></div>
                        <div class="btn-group">
                            <input type="radio" class="btn-check" name="options" id="radio1" autocomplete="off"
                                value="produksi">
                            <label class="btn btn-outline-primary" for="radio1">Produksi</label>

                            <input type="radio" class="btn-check" name="options" id="radio2" autocomplete="off"
                                value="nonproduksi">
                            <label class="btn btn-outline-primary" for="radio2">nonProduksi</label>
                        </div>
                        @if ($users->role == 'produksi')
                            <a href="{{ route('gudang.create') }}" class="btn btn-inverse-success btn-icon-text fw-bold"
                                id="tambahBarang">
                                <i class="ti-plus btn-icon-prepend"></i>
                                Tambah
                            </a>
                        @endif
                    </div>
                @endif
                <div class="table-responsive mt-5">
                    <table class="table table-hover" id="barangTable">
                        @if ($users->role == 'nonproduksi')
                            <thead>
                                <tr>
                                    <th>
                                        ID Barang Gudang
                                    </th>
                                    <th>
                                        Nama Gudang
                                    </th>
                                    <th>
                                        Nama Barang
                                    </th>
                                    <th>
                                        Quantity
                                    </th>
                                    <th>
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($barangs) && count($barangs) != 0)
                                    @foreach ($barangs as $barang)
                                        <tr>
                                            <td class="py-1">
                                                {{ $barang->barang_gudang_id }}
                                            </td>
                                            <td>
                                                {{ $barang->nama_gudang }}
                                            </td>
                                            <td>
                                                {{ $barang->nama_barang }}
                                            </td>
                                            <td>
                                                {{ $barang->quantity }}
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-inverse-primary btn-icon-text fw-bold">
                                                    <i class="ti-pencil-alt btn-icon-prepend"></i>
                                                    Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">Nothing data to display.</td>
                                    </tr>
                                @endif
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
