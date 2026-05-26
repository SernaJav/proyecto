<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="{{ asset('logo.jpg') }}">

    <!-- =========================
         TOKEN CSRF
    ========================== -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- =========================
         FUENTES
    ========================== -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- =========================
         FONT AWESOME
    ========================== -->
    <link rel="stylesheet"
        href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- =========================
         IONICONS
    ========================== -->
    <link rel="stylesheet"
        href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- =========================
         TEMAS Y PLUGINS
    ========================== -->
    <link rel="stylesheet"
        href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('backend/plugins/jqvmap/jqvmap.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('backend/dist/css/adminlte.css') }}">

    <link rel="stylesheet"
        href="{{ asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('backend/plugins/daterangepicker/daterangepicker.css') }}">

    <link rel="stylesheet"
        href="{{ asset('backend/plugins/summernote/summernote-bs4.min.css') }}">

    <!-- =========================
         DATATABLES
    ========================== -->
    <link rel="stylesheet"
        href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">

    <link rel="stylesheet"
        href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- =========================
         SELECT2
    ========================== -->
    <link rel="stylesheet"
        href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <!-- =========================
         COLOR PICKER
    ========================== -->
    <link rel="stylesheet"
        href="{{ asset('backend/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">

    <!-- =========================
         DATE PICKER
    ========================== -->
    <link rel="stylesheet"
        href="{{ asset('backend/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

    <!-- =========================
         OTROS PLUGINS
    ========================== -->
    <link rel="stylesheet"
        href="{{ asset('backend/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('backend/plugins/bs-stepper/css/bs-stepper.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('backend/plugins/dropzone/min/dropzone.min.css') }}">

    <!-- =========================
         SWEET ALERT
    ========================== -->
    <link rel="stylesheet"
        href="{{ asset('backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <!-- =========================
         BOOTSTRAP TOGGLE
    ========================== -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.css">

    <!-- =========================
         CSS PERSONALIZADO
    ========================== -->
    <link rel="stylesheet"
        href="{{ asset('backend/dist/css/proveedores.css') }}">

    <link rel="stylesheet"
        href="{{ asset('backend/dist/css/custom.css') }}">

    <!-- =========================
         VITE
    ========================== -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @stack('css')

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        @include('layouts.partial.topbar')

        @include('layouts.partial.sidebar')

        @yield('content')

        @include('layouts.partial.footer')

    </div>

</body>

<!-- =========================
     JQUERY
========================= -->
<script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- =========================
     BOOTSTRAP
========================= -->
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- =========================
     CHARTS
========================= -->
<script src="{{ asset('backend/plugins/chart.js/Chart.min.js') }}"></script>

<script src="{{ asset('backend/plugins/sparklines/sparkline.js') }}"></script>

<script src="{{ asset('backend/plugins/jquery-knob/jquery.knob.min.js') }}"></script>

<!-- =========================
     FECHAS
========================= -->
<script src="{{ asset('backend/plugins/moment/moment.min.js') }}"></script>

<script src="{{ asset('backend/plugins/daterangepicker/daterangepicker.js') }}"></script>

<script src="{{ asset('backend/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('backend/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') }}"></script>

<!-- =========================
     TEMPUSDOMINUS
========================= -->
<script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

<!-- =========================
     SUMMERNOTE
========================= -->
<script src="{{ asset('backend/plugins/summernote/summernote-bs4.min.js') }}"></script>

<!-- =========================
     OVERLAY
========================= -->
<script src="{{ asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<!-- =========================
     ADMIN LTE
========================= -->
<script src="{{ asset('backend/dist/js/adminlte.js') }}"></script>

<!-- =========================
     DATATABLES
========================= -->
<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>

<script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script src="{{ asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>

<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

<!-- =========================
     SELECT2
========================= -->
<script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>

<!-- =========================
     SWEET ALERT
========================= -->
<script src="{{ asset('backend/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- =========================
     TOGGLE
========================= -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.js"></script>

<!-- =========================
     JS PERSONALIZADOS
========================= -->
<script src="{{ asset('backend/dist/js/table.js') }}"></script>

<script src="{{ asset('backend/dist/js/statuschange.js') }}"></script>

<script src="{{ asset('backend/dist/js/delete-confirm.js') }}"></script>

<script src="{{ asset('backend/dist/js/selectors.js') }}"></script>

<script src="{{ asset('backend/dist/js/menu-scroll.js') }}"></script>

<!-- =========================
     ALERTAS BONITAS
========================= -->

@if(session('success'))

<script>

Swal.fire({

    icon: 'success',

    title: 'Proceso completado',

    text: '{{ session('success') }}',

    showConfirmButton: false,

    timer: 2500

});

</script>

@endif


@if(session('error'))

<script>

Swal.fire({

    icon: 'error',

    title: 'Operación no permitida',

    text: '{{ session('error') }}',

    confirmButtonColor: '#d33'

});

</script>

@endif


@if ($errors->any())

<script>

Swal.fire({

    icon: 'warning',

    title: 'Advertencia',

    html: `
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    `

});

</script>

@endif

@stack('scripts')

</html>