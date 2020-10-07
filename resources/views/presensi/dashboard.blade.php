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

                        <table class="display compact"  >
                            <tr><td width="270">Kode Matakuliah</td><td>{{ $jadwal->MK_ID}}</td></tr>
                            <tr><td>Nama Matakuliah</td><td>{{ $jadwal->MK_Mata_Kuliah}}</td></tr>
                            <tr><td>Kelas</td><td>{{ $jadwal->KE_Kelas}}</td></tr>
                            <tr><td>Nama Dosen</td><td>{{ $jadwal->PE_NamaLengkap}}</td></tr>
                            <tr><td>Tim Pengajar</td><td>{{ implode(" ,",$timPengajar)}}</td></tr>
                        </table>

                        <a href="/jadwal_mengajar" class="btn btn-danger"><i class="fas fa-backward"></i> Kembali</a>
                        <a href="/kehadiran/{{ Request::segment(2)}}/create" class="btn btn-success"><i class="far fa-calendar-alt"></i> Input Pertemuan</a>
                        <a href="/kehadiran/{{ Request::segment(2)}}/history" class="btn btn-info"><i class="fas fa-history"></i> Riwayat Pertemuan</a>

                        <hr>
                        <table class="table table-bordered">
                            <tr>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Aksi</th>
                                <?php for($pertemuan=1;$pertemuan<=$jadwal->KE_RencanaTatapMuka;$pertemuan++)
                                {
                                    echo "<th>$pertemuan</th>";
                                }
                                ?>

                            </tr>
                            @foreach($mahasiswa as $row)
                                <tr>
                                    <td>{{ $row->MA_NRP_Baru}}</td>



                                    <td>{{ $row->MA_NamaLengkap}}</td>
                                    <td><a href='/presensi/{{$row->KU_ID}}/manage' class="btn btn-success"><i
                                                class="fas fa-history"></i> </a></td>
                                    <?php for($pertemuan=1;$pertemuan<=$jadwal->KE_RencanaTatapMuka;$pertemuan++)
                                    {
                                        echo "<td>".getKehadiran($row->MA_Nrp,Request::segment(2),$pertemuan)."</td>";
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

@push('scripts')
    <script>

        function simpan_nilai(id_khs)
        {
            var nilai_uas = $("#uas-"+id_khs).val();
            var nilai_uts = $("#uts-"+id_khs).val();
            var nilai_tugas = $("#tugas-"+id_khs).val();
            var nilai_kehadiran = $("#kehadiran-"+id_khs).val();


            console.log(nilai_uas);
            console.log(nilai_uts);
            console.log(nilai_tugas);
            console.log(nilai_kehadiran);


            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.post("/nilai/update_nilai/update",
                {
                    id_khs : id_khs,
                    nilai_uas : nilai_uas,
                    nilai_uts:nilai_uts,
                    nilai_tugas:nilai_tugas,
                    nilai_kehadiran:nilai_kehadiran,
                    _token: CSRF_TOKEN
                },
                function(data, status){
                    //alert('sukses')
                });
        }
    </script>
@endpush
