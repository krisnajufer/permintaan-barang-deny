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

<body>
    <div class="container-scroller">

        {{-- Start of including Navbar --}}
        @include('admin.includes.navbar')
        {{-- End of including Navbar --}}

        <div class="container-fluid page-body-wrapper">

            {{-- Start of including Sidebar --}}
            @include('admin.includes.sidebar')
            {{-- End of including Sidebar --}}

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>

                {{-- Start of including Footer --}}
                @include('admin.includes.footer')
                {{-- End of including Footer --}}

            </div>
        </div>
    </div>

    {{-- Start of Including Script / Javascript --}}
    @stack('before-script')
    @include('admin.includes.script')
    @stack('after-script')
    {{-- End of Including Script / Javascript --}}

</body>

</html>
