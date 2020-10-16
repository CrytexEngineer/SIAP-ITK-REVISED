@extends('layouts.app')
@section('title', 'Manajemen Akun Mahasiswa')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@yield('title')
                        <div class="float-md-right">
                            <a href="/akunmahasiswa/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input
                                Data Baru</a>
                            @include('mahasiswa.import')

                        </div>
                        <div class="mt-4">
                            {{Form::select('PS_ID',$major,null,['class'=>'form-control','selected'=>''.$major->first().'','id' => 'PS_ID'])}}
                        </div>
                    </div>

                    <div class="card-body">

                        @include('alert')


                        <table class="display compact" id="users-table">
                            <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama Lengkap</th>
                                <th>E-mail</th>
                                <th>ID Perangkat</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                @can('admin')
                                    <th width="50">Action</th>
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

 var table= $('#users-table').DataTable({
                dom: 'Blfrtip',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "scrollX": true,
                processing: true,
                serverSide: false,
             ajax: {
                "url": '/akunmahasiswa/json',
                "data": function ( d ) {
                    d.PS_ID = $('#PS_ID').val();
                    console.log(d.PS_ID)
                }},
                columns: [
                    { data: 'MA_NRP_Baru', name: 'MA_NRP_Baru' },
                    { data: 'MA_NamaLengkap', name: 'MA_NamaLengkap' },
                    { data: 'email', name: 'email' },
                     { data: 'MA_IMEI', name: 'MA_IMEI' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                        @can('admin')
            { data: 'action', name: 'action' }
@endcan
        ],


    });

       $(document).ready(function () {
                $('#PS_ID').on('change',function(e) {

               table.ajax.reload();

                });
});

    </script>
@endpush
