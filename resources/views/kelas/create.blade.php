@extends('layouts.app')
@section('title','Input Data Kelas')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Input Data Kelas</div>

                    <div class="card-body">
                        @include('validation_error')

                        {{ Form::open(['url'=>'kelas'])}}

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Matakuliah</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="MK_Mata_Kuliah" id="MK_Mata_Kuliah" class="form-control input" placeholder="Masukan Nama Matakuliah" />
                                    <div id="matakuliahList">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Kelas</label>
                            <div class="col-md-3">
                                {{ Form::text('KE_Kelas',null,['class'=>'form-control','placeholder'=>'Masukan Nama Kelas'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Ruangan</label>
                            <div class="col-md-3">
                                {{ Form::text('KE_Jadwal_Ruangan',null,['class'=>'form-control','placeholder'=>'Ruangan [Contoh B201]'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Program Studi</label>
                            <div class="col-md-4">
                                {{Form::select('PS_Kode_Prodi',$major ?? '',null,['class'=>'form-control'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Tahun Ajaran</label>
                            <div class="col-md-4">
                                {{ Form::text('KE_Tahun',null,['class'=>'form-control','placeholder'=>'Tahun Ajaran'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Semester</label>
                            <div class="col-md-4">
                                {{ Form::select('KE_IDSemester',['1'=>'Semester 1','2'=>'Semester 2','3'=>'Semester 3','4'=>'Semester 4','5'=>'Semester 5','6'=>'Semester 6','7'=>'Semester 7','8'=>'Semester 8'],null,['class'=>'form-control'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Daya Tampung</label>
                            <div class="col-md-2">
                                {{ Form::text('KE_DayaTampung',null,['class'=>'form-control','placeholder'=>'Daya Tampung'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Jumlah Kelas Terisi</label>
                            <div class="col-md-2">
                                {{ Form::text('KE_Terisi',null,['class'=>'form-control','placeholder'=>'Jumlah Kelas Terisi'])}}
                            </div>
                        </div>

                        {{--<div class="form-group row">--}}
                        {{--    <label class="col-md-2 col-form-label text-md-right">NIP Pengajar</label>--}}
                        {{--    <div class="col-md-4">--}}
                        {{--        {{Form::select('PE_Nip',$employees_nip,null,['class'=>'form-control'])}}--}}
                        {{--    </div>--}}
                        {{--</div>--}}

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Nama Pengajar</label>
                            <div class="col-md-4">
                                {{Form::select('KE_PE_NIPPengajar',$employees,null,['class'=>'form-control'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Rencana Tatap Muka</label>
                            <div class="col-md-2">
                                {{ Form::text('KE_RencanaTatapMuka',null,['class'=>'form-control','placeholder'=>'Rencana Tatap Muka'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Hari</label>
                            <div class="col-md-2">
                                {{ Form::select('KE_Jadwal_IDHari',['1'=>'Senin','2'=>'Selasa','3'=>'Rabu','4'=>'Kamis','5'=>'Jumat'],null,['class'=>'form-control'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Jam Mulai & Usai</label>
                            <div class="col-md-2">
                                {{ Form::select('KE_Jadwal_JamMulai',['07:30'=>'07:30','08:20'=>'08:20','09:10'=>'09:10','09:20'=>'09:20','10:10'=>'10:10','10:20'=>'10:20','11:10'=>'11:10','13:00'=>'13:00','13:50'=>'13:50','14:40'=>'14:40','15:50'=>'15:50','16:40'=>'16:40'],null,['class'=>'form-control'])}}
                            </div> -
                            <div class="col-md-2">
                                {{ Form::select('KE_Jadwal_JamUsai',['08:20'=>'08:20','09:10'=>'09:10','10:00'=>'10:00','10:10'=>'10:10','11:00'=>'11:00','11:10'=>'11:10','12:00'=>'12:00','13:50'=>'13:50','14:40'=>'14:40','15:30'=>'15:30','16:40'=>'16:40','17:30'=>'17:30'],null,['class'=>'form-control'])}}
                            </div>
                        </div>

                        {{--//SCRIPT UNTUK AUTOCOMPLETE//--}}
                        <script>
    $(document).ready(function(){

        $('#MK_Mata_Kuliah').keyup(function(){
            var query = $(this).val();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('kelas.fetch') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        $('#matakuliahList').fadeIn();
                        $('#matakuliahList').html(data);
                    }
                });
            }
        });

        $(document).on('click', 'li', function(){
            $('#MK_Mata_Kuliah').val($(this).text());
            $('#matakuliahList').fadeOut();
        });

    });
</script>





                        @csrf

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-2">

                                {{ Form::submit('Simpan Data',['class'=>'btn btn-primary'])}}
                                <a href="/kelas" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
