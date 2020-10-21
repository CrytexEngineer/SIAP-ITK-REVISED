@extends('layouts.app')
@section('title','Daftar  Mahasiswa')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Daftar Mahasiswa</div>

                    <div class="card-body">
                        @include('alert')
                        <input type="hidden" id="ke_id" name="ke_id" value={{ Request::segment(2)}}>


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


                        @can('admin')

                            {{ Form::open(array('url' => '/frs/create', 'method'=>'GET')) }}

                            <input type="hidden" id="ke_id" name="ke_id" value={{ Request::segment(2)}}>
                            <button type='submit'class='btn btn-primary'><i
                                    class="fas fa-plus"></i> Input Data Baru</button>

                            {{ Form::close() }}


                                @endcan


                                <hr>
                                <table id="table_student" class="table table-bordered display compact">
                                    <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        @can('admin')
                                            <th>Aksi</th>
                                    @endcan</thead>

                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
        $(function() {
            var ke_id = $('#ke_id').val();
                 $('#table_student').DataTable({
                dom: 'Blfrtip',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "scrollX": true,
                processing: true,
                serverSide: false,
                ajax: '/frs/'+ke_id+'/dashboard/json',
                   columns: [
                       { data: 'MA_NRP_Baru', name: 'MA_Nrp_Baru' },
                    { data: 'MA_NamaLengkap', name: 'MA_NamaLengkap' },


                        @can('admin')
                { data: 'action', name: 'action' }
@endcan

            ],

        });
    });




        </script>
    @endpush


@endsection


