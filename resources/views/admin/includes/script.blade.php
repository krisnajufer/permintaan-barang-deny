<script src="{{ asset('StarAdmin2/assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('StarAdmin2/assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('StarAdmin2/assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('StarAdmin2/assets/js/template.js') }}"></script>
<script src="{{ asset('StarAdmin2/assets/js/settings.js') }}"></script>
<script src="{{ asset('StarAdmin2/assets/js/todolist.js') }}"></script>
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
