@extends('layouts.app')
@section('title','Daftar Hadir Mahasiswa')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Daftar Hadir Mahasiswa</div>

                    <div class="card-body">
                        @include('alert')

                        <table class="display compact">
                            <tr>
                                <td width="270">Kode Matakuliah</td>
                                <td>{{ $jadwal->MK_ID}}</td>
                            </tr>
                            <tr>
                                <td>Nama Matakuliah</td>
                                <td>{{ $jadwal->MK_Mata_Kuliah}}</td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>{{ $jadwal->KE_Kelas}}</td>
                            </tr>
                            <tr>
                                <td>Nama Dosen</td>
                                <td>{{ $jadwal->PE_NamaLengkap}}</td>
                            </tr>
                            <tr>
                                <td>Tim Pengajar</td>
                                <td>{{ implode(" ,",$timPengajar)}}</td>
                            </tr>
                        </table>

                        @can('dosen')
                            <a href="/jadwal_mengajar" class="btn btn-danger"><i class="fas fa-backward"></i>
                                Kembali</a>
                        @endcan
                        @can('admin')
                            <a href="/pertemuan/" class="btn btn-primary"><i class="fas fa-backward"></i>
                                Kembali</a>
                        @endcan
                        <a href="/pertemuan/{{ Request::segment(2)}}/create" class="btn btn-primary"><i
                                class="far fa-calendar-alt"></i> Input Pertemuan</a>
                        <a href="/pertemuan/{{ Request::segment(2)}}/history" class="btn btn-primary"><i
                                class="fas fa-history"></i> Riwayat Pertemuan</a>

                        <hr>
                        <table class="table table-bordered">
                            <tr>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                @can('admin')
                                    <th>Aksi</th>
                                @endcan
                                    <?php for ($pertemuan = 1; $pertemuan <= $jadwal->KE_RencanaTatapMuka; $pertemuan++) {
                                        echo "<th>$pertemuan</th>";
                                    }
                                    ?>

                            </tr>
                            @foreach($mahasiswa as $row)
                                <tr>
                                    <td>{{ $row->MA_NRP_Baru}}</td>


                                    <td>{{ $row->MA_NamaLengkap}}</td>
                                    @can('admin')
                                    <td><a href='/presensi/{{$row->KU_ID}}/manage' class="btn btn-primary btn-sm"><i
                                                class="far fa-calendar-alt"></i> </a></td>
                                    @endcan
                                    <?php for ($pertemuan = 1; $pertemuan <= $jadwal->KE_RencanaTatapMuka; $pertemuan++) {
                                        echo "<td>" . getKehadiran($row->MA_Nrp, Request::segment(2), $pertemuan) . "</td>";
                                    }
                                    ?>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

