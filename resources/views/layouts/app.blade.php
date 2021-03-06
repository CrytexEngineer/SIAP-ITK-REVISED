<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <script src="{{asset('assets/dist/air-datepicker/dist/js/datepicker.js')}}"></script>
    <script src="{{asset('assets/dist/air-datepicker/dist/js/i18n/datepicker.en.js')}}"></script>
    <script src="{{asset('assets/dist/sweetalert2/sweetalert2.min.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Styles DataTables-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <link rel="icon" href="{{ URL::asset('/css/favicon.png') }}" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/app.css')  }}">
    <link rel="stylesheet" href="{{asset('assets/dist/air-datepicker/dist/css/datepicker.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css"
          integrity="sha384-v8BU367qNbs/aIZIxuivaU55N5GPF89WBerHoGA4QTcbUjYiLQtKdrfXnqAcXyTv" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('assets/dist/sweetalert2/sweetalert2.min.css')}}">


</head>
<body style="
    background: url('{{ asset('img/Background SIAP ITK - Skripsi.png')}}') no-repeat center fixed;
    background-size: cover;
    ">
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/img/siap-itk-54px.png" alt="logo siap itk" height="40" width="166">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        {{--                        <li class="nav-item">--}}
                        {{--                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>--}}
                        {{--                        </li>--}}
                        {{--                        @if (Route::has('register'))--}}
                        {{--                            <li class="nav-item">--}}
                        {{--                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
                        {{--                            </li>--}}
                        {{--                        @endif--}}
                    @else

                        @can('admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-table"></i> Presensi
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/pertemuan">Manajemen Presensi</a>
                                    <a class="dropdown-item" href="/rekapitulasi/mahasiswa">Rekapitulasi Mahasiswa</a>
                                    <a class="dropdown-item" href="/rekapitulasi/dosen">Rekapitulasi Dosen</a>
                                </div>
                            </li>
                        @endcan

                        @can('admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-database"></i> Manajemen Data
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @can('super-admin')
                                        <a class="dropdown-item" href="/kurikulum">Kurikulum</a>
                                    @endcan
                                    <a class="dropdown-item" href="/program_studi">Program Studi</a>
                                    <a class="dropdown-item" href="/matakuliah">Mata Kuliah</a>
                                    <a class="dropdown-item" href="/akunpegawai">Akun Pegawai</a>
                                    <a class="dropdown-item" href="/akunmahasiswa">Akun Mahasiswa</a>
                                    <a class="dropdown-item" href="/kelas">Kelas</a>
                                    <a class="dropdown-item" href="/frs">FRS</a>
                                    <a class="dropdown-item" href="/riwayat_data">Riwayat Pengolahan Data</a>
                                    @can('super-admin')
                                        <a class="dropdown-item delete-confirm" href="/delete_all">Hapus Semua
                                            Data</a>
                                    @endcan
                                </div>
                            </li>
                        @endcan


                        @can('dosen')
                            <li class="nav-item">
                                <a class="nav-link" href="/jadwal_mengajar"><i class="far fa-calendar-alt"></i>
                                    Jadwal
                                    Mengajar</a>
                            </li>
                        @endcan

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-user"></i> {{ Auth::user()->PE_NamaLengkap }} <span
                                    class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>

                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- jQuery DATATABLES DONT CHANGE! -->
    <!-- jQuery -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- DataTables -->
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <!-- App scripts -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        $('.delete-confirm').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            swal({
                title: 'Apakah Anda Yakin?',
                text: 'Data yang sudah dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                dangerMode: true,
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                    window.location.href = url;
                }
            });
        });



    </script>
    @stack('scripts')

</div>
@include('sweetalert::alert')
</body>
</html>
