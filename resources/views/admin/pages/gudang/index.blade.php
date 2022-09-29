@extends('admin.layouts.app')

@section('title')
    Gudang
@endsection

@push('after-script')
    <script>
        $(`input[name=options]`).each((i, el) => {
            $(el).on('change', (e) => {
                const role = $(e.target).val();
                fetch("{{ route('gudang.get') }}", {
                        method: 'POST', // or 'PUT'
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
                        $("#gudangTable tbody").empty();
                        if (len > 0) {
                            for (var i = 0; i < len; i++) {
                                var rows = "";
                                var id = data.gudangs[i].gudang_id;
                                var nama = data.gudangs[i].nama;
                                var alamat = data.gudangs[i].alamat;
                                var slug_gudang = data.gudangs[i].slug_gudang;
                                var role_gudang = data.gudangs[i].role;
                                var slug_user = data.gudangs[i].slug_user;
                                var aksi =
                                    "<a href='<?php echo url('/gudang/edit/" +slug_gudang +"/"+role_gudang+"'); ?>' class='btn btn-inverse-primary btn-icon-text fw-bold'>" +
                                    "<i class='ti-pencil-alt btn-icon-prepend'></i>" +
                                    'Edit' +
                                    "</a>" +
                                    "<a href='<?php echo url('/gudang/destroy/" +slug_gudang +"/"+slug_user+"/"+role_gudang+"'); ?>' class='btn btn-inverse-danger btn-icon-text fw-bold'>" +
                                    "<i class='ti-trash btn-icon-prepend'></i>" +
                                    "Delete" +
                                    "</a>";
                                rows = "<tr><td>" + id + "</td><td>" + nama + "</td><td>" + alamat +
                                    "</td><?php if($user_role == 'admin') { ?><td><div class='d-flex gap-2'>" +
                                    aksi +
                                    "</div></td><?php } ?></tr>"
                                $(rows).appendTo("#gudangTable tbody");
                            }
                        } else {
                            var rows = "";
                            rows =
                                "<tr><td colspan='4' class='text-center'>Nothing data to display</td></tr>"
                            $(rows).appendTo("#gudangTable tbody");
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
                <h4 class="card-title">Gudang
                    {{ $user_role == 'admin' || $user_role == 'produksi' ? 'Produksi & nonProduksi' : 'nonProduksi' }}</h4>
                <p class="card-description">
                    Informasi Gudang
                    {{ $user_role == 'admin' || $user_role == 'produksi' ? 'Produksi & nonProduksi' : 'nonProduksi' }}

                </p>
                @if ($user_role == 'admin' || $user_role == 'produksi')
                    <div
                        class="d-flex {{ $user_role == 'produksi' ? 'justify-content-center' : 'justify-content-between' }}">
                        <div></div>
                        <div class="btn-group">
                            <input type="radio" class="btn-check" name="options" id="radio1" autocomplete="off"
                                value="produksi">
                            <label class="btn btn-outline-primary" for="radio1">Produksi</label>

                            <input type="radio" class="btn-check" name="options" id="radio2" autocomplete="off"
                                value="nonproduksi">
                            <label class="btn btn-outline-primary" for="radio2">nonProduksi</label>
                        </div>
                        @if ($user_role == 'admin')
                            <a href="{{ route('gudang.create') }}" class="btn btn-inverse-success btn-icon-text fw-bold">
                                <i class="ti-plus btn-icon-prepend"></i>
                                Tambah
                            </a>
                        @endif

                    </div>
                @endif
                <div class="table-responsive mt-5">
                    <table class="table table-hover" id="gudangTable">
                        <thead>
                            <tr>
                                <th>
                                    ID Gudang
                                </th>
                                <th>
                                    Nama Gudang
                                </th>
                                <th>
                                    Alamat Gudang
                                </th>
                                @if ($user_role == 'admin')
                                    <th>
                                        Aksi
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($gudangs))
                                @foreach ($gudangs as $gudang)
                                    <tr>
                                        <td class="py-1">
                                            {{ $gudang->gudang_id }}
                                        </td>
                                        <td>
                                            {{ $gudang->nama }}
                                        </td>
                                        <td>
                                            {{ $gudang->alamat }}
                                        </td>
                                        <td>
                                            @if ($user_role == 'admin')
                                                <a href="#" class="btn btn-inverse-primary btn-icon-text fw-bold">
                                                    <i class="ti-pencil-alt btn-icon-prepend"></i>
                                                    Edit
                                                </a>
                                                <a href="#" class="btn btn-inverse-danger btn-icon-text fw-bold">
                                                    <i class="ti-trash btn-icon-prepend"></i>
                                                    Delete
                                                </a>
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
    </div>
@endsection
