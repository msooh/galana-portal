<!DOCTYPE html>
    <html lang="en">
        <head>
            <base href="./">
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
            <meta name="description" content="Retail Quality Checklist">
            <meta name="author" content="Galana Energies">
            <meta name="keyword" content="">
            <title>@yield('title', 'Retail Module')</title>
        
            <!-- Favicon -->
            <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/favicon/apple-icon-57x57.png') }}">
            <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/favicon/apple-icon-60x60.png') }}">
            <!-- Add more favicon sizes as needed -->
        
            <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
            <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/favicon/favicon-96x96.png') }}">
            <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
            <link rel="manifest" href="{{ asset('assets/favicon/manifest.json') }}">
            <meta name="msapplication-TileColor" content="#ffffff">
            <meta name="msapplication-TileImage" content="{{ asset('assets/favicon/ms-icon-144x144.png') }}">
            <meta name="theme-color" content="#ffffff">
        
            <!-- Vendor styles -->
            <link href="{{ asset('vendors/simplebar/css/simplebar.css') }}" rel="stylesheet">
            <link href="{{ asset('css/vendors/simplebar.css') }}" rel="stylesheet">
            <link href="{{ asset('vendors/bootstrap/bootstrap5/css/bootstrap.min.css') }}" rel="stylesheet">
            <link href="{{ asset('vendors/bootstrap/css/bootstrap-toggle.min.css') }}" rel="stylesheet">
            <link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet">
            <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css" rel="stylesheet">
            <link href="{{ asset('vendors/datatables/dataTables.dateTime.min.css') }}" rel="stylesheet">
            <!-- Include SweetAlert CSS -->
        <link rel="stylesheet" href="{{ asset('vendors/sweetalerts/sweetalert2.min.css') }}">
            <!-- Main styles for this application -->
            <link href="{{ asset('css/style.css') }}" rel="stylesheet">
            <!-- Examples styles (you can remove this in your application) -->
            <link href="{{ asset('css/examples.css') }}" rel="stylesheet">
            <link href="{{ asset('vendors/@coreui/chartjs/css/coreui-chartjs.css') }}" rel="stylesheet">
            @stack('css')
            @yield('styles')
        </head>
      <body>     
        @include('retail::layouts.sidenav')

        <div class="wrapper d-flex flex-column min-vh-100 bg-light">
          <!-- resources/views/_header.blade.php -->
          @include('layouts.topnav')

          <div class="body flex-grow-1 px-3">
            @yield('content')
        </div>
          <!-- Footer -->
        @include('layouts.footer')
        </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('vendors/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/js/bootstrap-toggle.min.js') }}"></script>
    <!-- Plugins and scripts required by this view-->
    
    <script src="{{ asset('vendors/@coreui/utils/js/coreui-utils.js') }}"></script>
    
    
    
    <!-- DataTables -->
   
    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('vendors/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendors/datatables/dataTables.js') }}"></script>
    <script src="{{ asset('vendors/datatables/dataTables.bootstrap5.min.js') }}"></script>    
  
    <script src="{{ asset('vendors/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('vendors/datatables/moment.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/dataTables.dateTime.min.js') }}"></script>
    
    
    <!-- Signature Pad -->
    <script src="{{ asset('vendors/signature_pad.min.js') }}"></script>
    
    <!-- SweetAlert -->
    <script src="{{ asset('vendors/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendors/sweetalerts/custom-sweetalert.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    @yield('scripts')
</body>
</html>
