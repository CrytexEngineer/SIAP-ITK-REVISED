@extends('layouts.app')
@section('title', 'Manajemen Akun Pegawai')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@yield('title')
                        <div class="float-md-right">
                            <a href="/akunpegawai/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data
                                Baru</a>
                            @include('employee.import')
                        </div>
{{--                        <div class="mt-4">--}}
{{--                            {{Form::select('PS_ID',$major,null,['class'=>'form-control','selected'=>''.$major->first().'','id' => 'PS_ID'])}}--}}
{{--                        </div>--}}
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('status_failed'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('status_failed') }}
                            </div>
                        @endif

                        <table class="display compact" id="users-table"
                               class="table table-striped table-bordered display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama Lengkap</th>
{{--                                <th>E-mail</th>--}}
                                <th>Jurusan</th>
                                <th>Roles</th>
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
        $(function() {
            $('#users-table').DataTable({
                dom: 'Blfrtip',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "scrollX": true,
                processing: true,
                serverSide: false,
                ajax: '/akunpegawai/json',
                columns: [
                    { data: 'PE_Nip', name: 'PE_Nip' },
                    { data: 'PE_NamaLengkap', name: 'PE_NamaLengkap' },
{{--                    { data: 'email', name: 'email' },--}}
                    { data: 'PS_Nama', name: 'PS_Nama' },
                    { data: 'roles', name: 'role_name',
                        render: "[, ].role_name"},
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                        @can('admin')
            { data: 'action', name: 'action' }
@endcan

        ],

    });
});


    </script>
@endpush
