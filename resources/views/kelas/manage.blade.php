@extends('layouts.app')
@section('title','Manage Data Kelas')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Daftar Hadir Mahasiswa</div>

                    <div class="card-body">
                        @include('alert')
                        {{Form::open(['url'=>'/kelas/'.$jadwal->KE_ID.'/manage/store'])}}

                        <a href="/kelas" class="btn btn-danger"><i class="fas fa-backward"></i> Kembali</a>
                        <hr>
                        <table class="display compact"  >
                            <tr>
                                <td width="270">Kode Matakuliah</td><td>{{ $jadwal->MK_ID}}</td>
                            </tr>
                            <tr>
                                <td>Nama Matakuliah</td><td>{{ $jadwal->MK_Mata_Kuliah}}</td>
                            </tr>
                            <tr>
                                <td>Kelas</td><td>{{ $jadwal->KE_Kelas}}</td>
                            </tr>
                            <tr>
                                <td>Nama Pengajar</td><td>{{ $jadwal->PE_Nama}}</td>
                            </tr>
                            <tr>
                                <td>Tim Pengajar</td><td> <table class="table table-bordered" id="users-table" style="overflow-x:auto;">
                                        <thead>
                                        <tr>
                                            <th>NIP</th>
                                            <th>Nama Pengajar</th>
                                            @can('change')
                                                <th width="50">Action</th>
                                            @endcan

                                        </tr>
                                        </thead>
                                    </table></td>
                            </tr>
                            <tr>
                                <td>Input Tim Pengajar
                                <td><input type="text" name="PE_Nama" id="PE_Nama" class="form-control input" placeholder="Masukan Nama Pengajar" />
                                <div id="pengajarList">
                                </div>
                                </td>

                                <td><input type="hidden" name="KE_ID" id="KE_ID"  class="form-control input" value={{$jadwal->KE_ID}}></td>
                            </tr>
                            <tr>
                                <td></td><td>{{ Form::submit('Simpan Data',['class'=>'btn btn-primary'])}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--//SCRIPT UNTUK AUTOCOMPLETE//--}}
<script>
    $(document).ready(function(){

        $('#PE_Nama').keyup(function(){
            var query = $(this).val();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('kelas.fetch_pengajar') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        $('#pengajarList').fadeIn();
                        $('#pengajarList').html(data);
                    }
                });
            }
        });

        $(document).on('click', 'li', function(){
            $('#PE_Nama').val($(this).text());
            $('#pengajarList').fadeOut();
        });

    });
</script>

    @push('scripts')
        <script>
        $(function() {
            $('#users-table').DataTable({

                "scrollX": true,
                processing: true,
                 dom: 'Blfrtip',
                serverSide: true,
                ajax: '/kelas/'+$('#KE_ID').val()+'/manage/json',
                columns: [
                    { data: 'PE_Nip', name: 'PE_Nip' },
                    { data: 'PE_NamaLengkap', name: 'PE_NamaLengkap' },


                        @can('change')
                { data: 'action', name: 'action' }
@endcan
            ],

        });
    });
</script>
    @endpush
@endsection
