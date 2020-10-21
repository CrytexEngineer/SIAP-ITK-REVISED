@extends('layouts.app')
@section('title','Manajemen FRS')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">


                <div class="card">
                    <div class="card-header"> Manajemen FRS
                        <div class="float-md-right">
                            @include('frs.import')</div>
                        <br><br>
                        {{Form::select('PS_ID',$major,null,['class'=>'form-control','selected'=>''.$major->first().'','id' => 'PS_ID'])}}
                    </div>
                    <div class="card-body">

                        @include('alert')


                        <table class="display compact" id="table">
                            <thead>
                            <tr>
                                <th width="100">Kode Matakuliah</th>
                                <th width="100">Matakuliah</th>
                                <th width="200">Dosen</th>
                                <th width="50">Kelas</th>
                                <th width="50">Hari</th>
                                <th width="50">Jam Mulai</th>
                                <th width="50">Jam Berakhir</th>
                                <th width="70">Ruang</th>
                                <th width="100">Jurusan</th>
                                <th width="100">Action</th>
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
      var table= $('table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
    "url": '/frs/json',
    "data": function ( d ) {
    d.PS_ID = $('#PS_ID').val();
    },

    },
                   columns: [
                    { data: 'MK_ID', name: 'MK_ID' },
                    { data: 'MK_Mata_Kuliah', name: 'MK_Mata_Kuliah' },
                    { data:  'PE_NamaLengkap', name:'PE_NamaLengkap'},
                    { data: 'KE_Kelas', name: 'KE_Kelas' },
                    { data: 'nama_hari', name: 'nama_hari' },
                    { data: 'KE_Jadwal_JamMulai', name: 'KE_Jadwal_JamMulai' },
                    { data: 'KE_Jadwal_JamUsai', name: 'KE_Jadwal_JamUsai' },
                    { data: 'KE_Jadwal_Ruangan', name: 'KE_Jadwal_Ruangan' },
                    { data: 'PS_Nama', name: 'PS_Nama' },
                    { data: 'action', name: 'action' }
                ]
            });

          $(document).ready(function () {
                $('#PS_ID').on('change',function(e) {
               table.ajax.reload();
                });

        });





    </script>
@endpush
