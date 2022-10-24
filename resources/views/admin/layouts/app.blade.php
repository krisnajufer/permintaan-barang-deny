<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Start of including Meta --}}
    @include('admin.includes.meta')
    {{-- End of including Meta --}}

    <title>DENY - @yield('title')</title>

    {{-- Start of including Style --}}
    @stack('before-style')
    @include('admin.includes.style')
    @stack('after-style')
    {{-- End of including Style --}}

</head>

<body id="page-top">

    <div id="wrapper">
        @include('admin.includes.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('admin.includes.navbar')
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('admin.includes.footer')
        </div>
    </div>

    {{-- Start of Including Script / Javascript --}}
    @stack('before-script')
    @include('admin.includes.script')
    @stack('after-script')
    {{-- End of Including Script / Javascript --}}

</body>

</html>
