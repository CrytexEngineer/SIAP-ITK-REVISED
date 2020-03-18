{{--@extends('layouts.app')--}}
{{--@section('title','Modul Kelas')--}}
{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">Modul Kelas</div>--}}

{{--                    <div class="card-body">--}}

{{--                        @include('alert')--}}

{{--                        <div class="row">--}}
{{--                            <div class="col-md-4">--}}
{{--                                <table class="table table-bordered">--}}
{{--                                    <tr>--}}
{{--                                        <td>Program Studi</td>--}}
{{--                                        <td>{{Form::select('major',$major,null,['class'=>'form-control'])}}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>Semester</td>--}}
{{--                                        <td>{{Form::select('semester',['1'=>'Semester 1','2'=>'Semester 2','3'=>'Semester 3','4'=>'Semester 4','5'=>'Semester 5','6'=>'Semester 6','7'=>'Semester 7','8'=>'Semester 8'],null,['class'=>'form-control'])}}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td colspan="2">--}}
{{--                                            <button type="submit" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Refresh Data</button>--}}
{{--                                            <a href="/kelas/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data</a>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td colspan="2">--}}
{{--                                            @include('kelas.import')--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-8" style="overflow-x:auto;">--}}
{{--                                <table class="table table-bordered">--}}
{{--                                    <tr>--}}
{{--                                        <th width="40">Kode Kelas</th>--}}
{{--                                        <th>Nama Kelas</th>--}}
{{--                                        <th>Program Studi</th>--}}
{{--                                        <th width="100">Kode kelas</th>--}}
{{--                                        <th width="40">Tahun</th>--}}
{{--                                        <th width="40">Semester</th>--}}
{{--                                        <th>Daya Tampung</th>--}}
{{--                                        <th>Jumlah Kelas Terisi</th>--}}
{{--                                        <th>NIP Pengajar</th>--}}
{{--                                        <th>Hari</th>--}}
{{--                                        <th>Jam Mulai</th>--}}
{{--                                        <th>Jam Usai</th>--}}
{{--                                        <th>Ruangan</th>--}}
{{--                                    </tr>--}}
{{--                                    --}}{{--                                        @foreach($kelas as $row)--}}
{{--                                    <tr>--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                    </tr>--}}
{{--                                    --}}{{--                                        @endforeach--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}

@extends('layouts.app')
@section('title','Modul Kelas')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul Kelas</div>

                    <div class="card-body">

                        @include('alert')

                        <a href="/kelas/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data Baru</a>

                        @include('kelas.import')
                        <hr>

                        <table class="table table-bordered" id="users-table" style="overflow-x:auto;">
                            <thead>
                            <tr>
                                <th width="40">Kode Kelas</th>
                                <th>Nama Kelas</th>
                                <th>Program Studi</th>
                                <th>Kode kelas</th>
                                <th>Tahun</th>
                                <th>Semester</th>
                                <th>Daya Tampung</th>
                                <th>Jumlah Kelas Terisi</th>
                                <th>NIP Pengajar</th>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Usai</th>
                                <th>Ruangan</th>
                                <th width="85">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>S
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(function () {
            $('#users-table').DataTable({
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: '/kelas/json',
                columns: [
                    {data: 'KE_ID', name: 'KE_ID'},
                    {data: 'KE_Kelas', name: 'KE_Kelas'},
                    {data: 'KE_KodeJurusan', name: 'KE_KodeJurusan'},
                    {data: 'KE_KR_MK_ID', name: 'KE_KR_MK_ID'},
                    {data: 'KE_Tahun', name: 'KE_Tahun'},
                    {data: 'KE_IDSemester', name: 'KE_IDSemester'},
                    {data: 'KE_DayaTampung', name: 'KE_IDSemester'},
                    {data: 'KE_Terisi', name: 'KE_Terisi'},
                    {data: 'KE_PE_NIPPengajar', name: 'KE_PE_NIPPengajar'},
                    {data: 'KE_Jadwal_IDHari', name: 'KE_Jadwal_IDHari'},
                    {data: 'KE_Jadwal_JamMulai', name: 'KE_Jadwal_JamMulai'},
                    {data: 'KE_Jadwal_JamUsai', name: 'KE_Jadwal_JamUsai'},
                    {data: 'KE_Jadwal_Ruangan', name: 'KE_Jadwal_Ruangan'},
                    {data: 'action', name: 'action'}
                ]
            });
        });
    </script>
@endpush
