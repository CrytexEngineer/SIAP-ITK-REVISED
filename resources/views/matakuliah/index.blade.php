@extends('layouts.app')
@section('title','matakuliah')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul matakuliah</div>

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

                        <a href="/matakuliah/create" class="btn btn-success">Input Data Baru</a>

                            <form action="{{ route('import_matakuliah') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file" class="form-control">
                                <br>
                                {{ Form::submit('Import',['class'=>'btn btn-primary'])}}
                            </form>
                        <hr>

                        <table class="table table-bordered" id="users-table">
                            <thead>
                            <tr>
                                <th>Kode Matakuliah</th>
                                <th>Nama Matakuliah</th>
                                <th>Tahun Kurikulum</th>
                                <th>Kredit Kuliah</th>
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
        $(function () {
            $('#users-table').DataTable({
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: '/matakuliah/json',
                columns: [
                    {data: 'MK_ID', name: 'MK_ID'},
                    {data: 'MK_Mata_Kuliah', name: 'MK_Mata_Kuliah'},
                    {data: 'MK_ThnKurikulum', name: 'MK_ThnKurikulum'},
                    {data: 'MK_KreditKuliah', name: 'MK_KreditKuliah'},
                    {data: 'action', name: 'action'}
                ]
            });
        });
    </script>
@endpush
