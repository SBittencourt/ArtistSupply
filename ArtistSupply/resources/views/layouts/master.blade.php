<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;700&display=swap" rel="stylesheet">



        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Theme style -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">

        {{-- DataTables CSS --}}
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css">

        {{-- Master CSS --}}
        <link rel="stylesheet" href="https://your-cdn.com/path/to/master.css">

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

        {{-- Select2 --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-4-theme/0.1.0/select2-bootstrap4.min.css">

        <!-- JS -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- SweetAlert2 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

        <!-- Hint CSS -->
        <link rel="stylesheet" href="https://your-cdn.com/path/to/hint.css">

        <link rel="stylesheet" href="/css/master.css">
        
        @yield('styles')

        @livewireStyles
    </head>
    <body class="font-sans antialiased">

        <div class="wrapper">
            {{-- Nav bar --}}
            @include('layouts.navbar')

            <!-- Main Sidebar Container -->
            @include('layouts.sidebar')

            <div class="content-wrapper">
                <section class="content">
                    @include('layouts.message')
                    @yield('content')
                </section>
            </div>        
        </div>

        


    @stack('scripts')
    @yield('script')




    </body>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('dist/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.min.js') }}"></script>

    <!-- Scripts do AdminLTE -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>    

    {{-- DataTables JS --}}
    <script src="{{ asset('dist/plugins/datatables/js/dataTables.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables/js/dataTables.bootstrap5.js') }}"></script>

    <script src="{{ asset('dist/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-jszip/js/jszip.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/pdfmake/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/pdfmake/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>


    <script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
    {{-- Select2 --}}
    <script src="{{ asset('dist/plugins/select2/js/select2.full.min.js') }}"></script>
    
</html>
