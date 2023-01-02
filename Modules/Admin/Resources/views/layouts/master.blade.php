<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>
        @section('title') @show
    </title>
    <meta content="@yield('description')" name="description">
    <meta content="@yield('keywords')" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('admin/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('admin/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    {{--    <link href="https://fonts.gstatic.com" rel="preconnect">--}}
    {{--    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"--}}
    {{--        rel="stylesheet">--}}

    <!-- Vendor CSS Files -->
    <link href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />--}}
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap-select.min.css') }}">
    <link href="{{ asset('admin/css/mds.bs.datetimepicker.style.css') }}" rel="stylesheet"/>
    @yield('style')
    <!-- =======================================================
    * Template Name: NiceAdmin - v2.2.2
    * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/Modules/Admin/admin.js') }}"></script>
    <link href="{{ asset('css/Modules/Admin/slider.css') }}" rel="stylesheet">
</head>

<body>

@include('admin::sections.header')

@include('admin::sections.sidebar')

@yield('content')

@include('admin::sections.footer')


<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{ asset('admin/js/jquery.3.6.1.min.js') }}"></script>
<script src="{{ asset('admin/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/vendor/chart.js/chart.min.js') }}"></script>
<script src="{{ asset('admin/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('admin/vendor/quill/quill.min.js') }}"></script>
<script src="{{ asset('admin/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('admin/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('admin/vendor/php-email-form/validate.js') }}"></script>
{{--    //ckEditor--}}
<script src="{{ asset('admin/fullCKEditor/ckeditor/ckeditor.js') }}"></script>
<!-- Template Main JS File -->
<script src="{{ asset('admin/js/main.js') }}"></script>
<script src="{{ asset('admin/js/my.js') }}"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="{{ asset('admin/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('admin/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('admin/js/mds.bs.datetimepicker.js') }}"></script>
@yield('script')
@include('sweet::alert')
</body>

</html>
