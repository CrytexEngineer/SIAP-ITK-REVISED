@extends('layouts.app')
@section('title','program_studi')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul Program Studi</div>

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

                        <a href="/program_studi/create" class="btn btn-success">Input Data Baru</a>
                            <form action="{{ route('import_program_studi') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file" class="form-control">
                                <br>
                                {{ Form::submit('Import',['class'=>'btn btn-primary'])}}
                            </form>
                        <hr>
                        <table class="table table-bordered" id="users-table">
                            <thead>
                            <tr>
                                <th>Kode Program Studi</th>
                                <th>Nama Program Studi</th>
                                <th width="85">Action</th>
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
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: '/program_studi/json', //DIGANTI SESUAI CONTROLLER
                columns: [
                    { data: 'PS_Kode_Prodi', name: 'PS_Kode_Prodi' }, //SESUAIKAN DB
                    { data: 'PS_Nama', name: 'PS_Nama' }, //SESUAIKAN DB
                    { data: 'action', name: 'action' }
                ]
            });
        });
    </script>
@endpush
