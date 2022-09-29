<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.includes.meta')
    <title>DENY - Login</title>
    @include('admin.includes.style')
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            @if (session()->has('incorrect'))
                                <div class="alert alert-danger text-center">
                                    <p class="h5">{{ session('incorrect') }}</p>
                                </div>
                            @endif
                            <h4>Selamat Datang!</h4>
                            <h6 class="fw-light">Silahkan masuk untuk melanjutkan</h6>
                            <form class="pt-3" action="{{ route('auth.login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="username" name="username"
                                        class="form-control form-control-lg @error('username') is-invalid @enderror"
                                        id="username" placeholder="Username">
                                    @error('username')
                                        <div class="invalid-feedback">
                                            Username tidak boleh kosong!!
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        id="password" placeholder="Password">
                                    @error('username')
                                        <div class="invalid-feedback">
                                            Password tidak boleh kosong!!
                                        </div>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">MASUK
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    @include('admin.includes.script')
    <script>
        $(".alert").fadeTo(3000, 500).slideUp(500, function() {
            $(".alert").slideUp(500);
        });
    </script>
</body>

</html>
