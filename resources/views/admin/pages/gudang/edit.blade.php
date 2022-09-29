@extends('admin.layouts.app')

@section('title')
    Edit Gudang
@endsection

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Data Gudang</h4>
                <form class="forms-sample" method="POST"
                    action="{{ route('gudang.update', ['slug' => $gudangs->slug_gudang, 'role' => $gudangs->role]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="Nama">Nama</label>
                        <input type="text" class="form-control" id="Nama" placeholder="Nama" name="nama"
                            value="{{ $gudangs->nama }}">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label>Role</label>
                            <div class="col-sm-4">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="role" id=role1"
                                            {{ $gudangs->role == 'produksi' ? 'checked' : '' }} value="produksi">
                                        Produksi
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="role" id=role2"
                                            {{ $gudangs->role == 'nonproduksi' ? 'checked' : '' }} value="nonproduksi">
                                        nonProduksi
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Alamat">Alamat</label>
                        <input type="text" class="form-control" id="Alamat" placeholder="Alamat" name="alamat"
                            value="{{ $gudangs->alamat }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
                            name="password" value="{{ $gudangs->password }}">
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <a href="{{ route('gudang') }}" class="btn btn-light">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
