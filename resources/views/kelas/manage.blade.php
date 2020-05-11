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
                        {{Form::open(['url'=>'kelas'])}}

                        <a href="/kelas" class="btn btn-danger"><i class="fas fa-backward"></i> Kembali</a>
                        <hr>
                        <table class="table table-bordered">
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
                                <td>Tim Pengajar</td><td>{{ implode(" ,",$timPengajar)}}</td>
                            </tr>
                            <tr>
                                <td>Input Tim Pengajar
                                <td><input type="text" name="PE_Nama" id="PE_Nama" class="form-control input" placeholder="Masukan Nama Pengajar" />
                                <div id="pengajarList">
                                </div>
                                </td>
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

@endsection
