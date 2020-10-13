<!DOCTYPE html>


<html>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Collapsible sidebar using Bootstrap 4</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->

    <link href="{{ asset('css/wrapper.css') }}" rel="stylesheet">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
            integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ"
            crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
            integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY"
            crossorigin="anonymous"></script>
</head>

<body>


<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>

</body>

<div class="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>Bootstrap Sidebar</h3>
        </div>

        <ul class="list-unstyled components">
            <p>Dummy Heading</p>
            <li class="active">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">  <i class="fas fa-table"></i> Presensi</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li>
                        <a  href="/pertemuan">Manajemen Presensi</a>
                    </li>
                    <li>
                        <a href="/rekapitulasi/mahasiswa">Rekapitulasi Mahasiswa</a>
                    </li>
                    <li>
                        <a  href="/rekapitulasi/dosen">Rekapitulasi Dosen</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fas fa-database"></i> Manajemen Data</a>
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li>
                        <a href="/akunmahasiswa">Akun Mahasiswa</a>
                    </li>
                    <li>
                        <a  href="/akunpegawai">Akun Pegawai</a>
                    </li>
                    <li>
                        <a href="/kelas">Kelas</a>
                    </li>
                    <li>
                        <a  href="/khs">KHS</a>
                    </li>
                    <li>
                        <a  href="/kurikulum">Kurikulum</a>
                    </li>
                    <li>
                        <a href="/matakuliah">Mata Kuliah</a>
                    </li>
                    <li>
                        <a href="/program_studi">Program Studi</a>
                    </li>
                    <li>
                        <a href="/riwayat_data">Riwayat Pengolahan Data</a>

                    </li>
                    <li>
                        <a class=" delete-confirm" href="/delete_all">Hapus Semua
                            Data</a>
                    </li>


                </ul>
            </li>

        </ul>
    </nav>


    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i>
                    <span>Toggle Sidebar</span>
                </button>

            </div>
        </nav>
    </div>
</div>


</html>

<script>
    $(document).ready(function () {

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

});


</script>
