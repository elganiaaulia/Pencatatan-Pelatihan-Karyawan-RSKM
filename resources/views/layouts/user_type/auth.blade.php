@extends('layouts.app')

@section('head')
    <title>
        Pencatatan Pelatihan Karyawan RSKM | @yield('title', 'CMS')
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- CSS Files -->
    @yield('css')
    <style>
        /* Custom pagination style */
        .dataTables_paginate {
            margin-top: 10px; /* Adjust the top margin */
        }

        /* Customize the pagination buttons */
        .dataTables_paginate .paginate_button {
            background-color: var(--bs-indigo)
            color: #fff; /* Change the text color */
            border-radius: 5px; /* Add border radius */
            padding: 5px 10px; /* Adjust padding */
            margin: 0 5px; /* Adjust margin */
        }

        /* Style the active pagination button */
        .dataTables_paginate .paginate_button.current {
            background-color: #17c1e8; /* Change the active button background color */
            color: #fff; /* Change the active button text color */
        }

        /* Style the pagination button hover */
        .dataTables_paginate .paginate_button:hover {
            background-color: #17c1e8; /* Change the hover background color */
            color: #fff; /* Change the hover text color */
        }
    </style>
    <link id="pagestyle" href="{{asset('assets/css/soft-ui-dashboard.css?v=1.0.3')}}" rel="stylesheet" />
    <link href="{{asset('datatables/bootstrap-icons/font/bootstrap-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('datatables/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <link href="{{asset('datatables/datatables.net-select-bs5/css/select.bootstrap5.css')}}" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

@endsection

@auth
    @section('auth')
        <x-layouts.sidebar />
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        @include('layouts.navbars.auth.nav')

            <div class="container-fluid py-4">
                @yield('content')
                @include('layouts.footers.auth.footer')
            </div>
        </main>
    @endsection
@endauth

@if(\Request::routeIs('login'))
    @section('guest')
        <div class="container position-sticky z-index-sticky top-0">
            <div class="row">
                <div class="col-12">
                    @include('layouts.navbars.guest.nav')
                </div>
            </div>
        </div>
        @yield('content')
    @endsection
@endif

@section('script')
    @stack('js')
    <!--   Core JS Files   -->
    <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/fullcalendar.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/chartjs.min.js')}}"></script>
    <script src="{{asset('datatables/datatables.net/js/jquery.dataTables.js')}}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3')}}"></script>
@endsection