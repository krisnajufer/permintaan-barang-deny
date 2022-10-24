<script src="{{ asset('SBadmin2/assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('SBadmin2/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('SBadmin2/assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('SBadmin2/assets/js/sb-admin-2.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session()->has('warning'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('warning') }}",
            customClass: 'swal-height'
        })
    </script>
@endif
@if (session()->has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            customClass: 'swal-height'
        })
    </script>
@endif
