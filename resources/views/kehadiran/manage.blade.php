@extends('layouts.app')
@section('title','Manajemen Presensi Mahasiswa')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Manajemen Presensi Mahasiswa</div>
                    <div class="card-body">

                        @include('alert')
                        @include('validation_error')
                        <table class="display compact"  >
                            <tr><td width="270">Nama Mahasiswa</td><td> {{ $mahasiswa->pluck('MA_NamaLengkap')[0]}}</td></tr>
                            <tr><td>Nomor Induk Mahaiswa</td><td>{{ $mahasiswa->pluck('MA_Nrp_Baru')[0]}}</td></tr>
                            <tr><td>Matakuliah</td><td>{{$mahasiswa->pluck('MK_ID')[0]}} - {{ $mahasiswa->pluck('MK_Mata_Kuliah')[0]}}</td></tr>
                            <tr><td>Kelas</td><td>{{ $mahasiswa->pluck('KU_KE_Kelas')[0]}}</td></tr>

                            {{--                        <tr><td>Kelas</td><td>{{ $jadwal->KE_Kelas}}</td></tr>--}}
                            {{--                        <tr><td>Nama Dosen</td><td>{{ $jadwal->PE_NamaLengkap}}</td></tr>--}}
                            {{--                        <tr><td>Tim Pengajar</td><td>{{ implode(" ,",$timPengajar)}}</td></tr>--}}
                        </table>
                        <a href="/presensi/{{ $mahasiswa->pluck('KU_ID')[0]}}/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data Baru</a>
                        <input type="hidden" name="KU_ID" id="KU_ID"  class="form-control input" value={{$mahasiswa->pluck('KU_ID')[0]}}>

                        <hr>
                        <table class="display compact"  id="users-table">
                            <thead>
                            <tr>
                                <th>Pertemuan Ke</th>
                                <th>Nama Pertemuan</th>
                                <th>Status Kehadiran</th>
                                <th>Media Presensi</th>
                                @can('admin')
                                    <th width="50">Aksi</th>
                                @endcan
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(function() {

        var link='/presensi/'+$('#KU_ID').val()+'/manage/json';
        console.log(link);
                  $('#users-table').DataTable({
                dom: 'Blfrtip',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: '/presensi/'+$('#KU_ID').val()+'/manage/json',
                columns: [
                    { data: 'PT_Urutan', name: 'PT_Urutan' },
                    { data: 'PT_Name', name: 'PT_Name' },
                         { data: 'PR_Keterangan', name: 'PR_Keterangan' },
                         { data: 'PR_Type', name: 'PR_Type' },
                        @can('admin')
            { data: 'action', name: 'action' }
@endcan
        ]
    });
});
</script>
@endpush
