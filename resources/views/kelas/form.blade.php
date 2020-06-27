<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Mata Kuliah</label>
    <div class="col-md-5">
        {{Form::select('KE_KR_MK_ID',$subjects,null,['class'=>'form-control','placeholder'=>'Pilih Mata Kuliah'])}}
    </div>
</div>

{{--<div class="form-group row">--}}
{{--    <label class="col-md-2 col-form-label text-md-right">Nama Mata Kuliah</label>--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="form-group">--}}
{{--            <input type="text" name="MK_Mata_Kuliah" id="MK_Mata_Kuliah" class="form-control input" placeholder="Masukan Nama Mata Kuliah" autocomplete="off" />--}}
{{--            <div id="matakuliahList">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Kelas</label>
    <div class="col-md-3">
        {{ Form::text('KE_Kelas',null,['class'=>'form-control','placeholder'=>'Masukan Nama Kelas'])}}
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Ruangan</label>
    <div class="col-md-3">
        {{ Form::text('KE_Jadwal_Ruangan',null,['class'=>'form-control','placeholder'=>'Masukan Ruangan [Contoh B201]'])}}
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Program Studi</label>
    <div class="col-md-4">
        {{Form::select('KE_KodeJurusan',$major ?? '',null,['class'=>'form-control','placeholder'=>'Pilih Program Studi'])}}
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Tahun Ajaran</label>
    <div class="col-md-4">
        {{ Form::text('KE_Tahun',null,['class'=>'form-control','placeholder'=>'Masukan Tahun Ajaran'])}}
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Semester</label>
    <div class="col-md-4">
        {{ Form::select('KE_IDSemester',['1'=>'Semester 1','2'=>'Semester 2','3'=>'Semester 3','4'=>'Semester 4','5'=>'Semester 5','6'=>'Semester 6','7'=>'Semester 7','8'=>'Semester 8'],null,['class'=>'form-control','placeholder'=>'Pilih Semester'])}}
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Daya Tampung</label>
    <div class="col-md-4">
        {{ Form::text('KE_DayaTampung',null,['class'=>'form-control','placeholder'=>'Masukan Daya Tampung Kelas'])}}
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Jumlah Kelas Terisi</label>
    <div class="col-md-4">
        {{ Form::text('KE_Terisi',null,['class'=>'form-control','placeholder'=>'Masukan Jumlah Kelas Terisi'])}}
    </div>
</div>

{{--<div class="form-group row">--}}
{{--    <label class="col-md-2 col-form-label text-md-right">NIP Dosen Pengampu</label>--}}
{{--    <div class="col-md-4">--}}
{{--        {{Form::select('KE_PE_NIPPengajar',$employees_nip,null,['class'=>'form-control','placeholder'=>'Pilih NIP Dosen Pengampu'])}}--}}
{{--    </div>--}}
{{--</div>--}}

<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Dosen Pengampu</label>
    <div class="col-md-4">
        {{Form::select('KE_PE_NIPPengajar',$employees,null,['class'=>'form-control','placeholder'=>'Pilih Dosen Pengampu'])}}
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Rencana Pertemuan</label>
    <div class="col-md-4">
        {{Form::text('KE_RencanaTatapMuka',null,['class'=>'form-control','placeholder'=>'Masukan Rencana Pertemuan'])}}
    </div>

</div><div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Realisasi Pertemuan</label>
    <div class="col-md-4">
        {{Form::text('KE_RealisasiTatapMuka',null,['class'=>'form-control','placeholder'=>'Masukan Realisasi Pertemuan'])}}
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Hari</label>
    <div class="col-md-2">
        {{ Form::select('KE_Jadwal_IDHari',['1'=>'Senin','2'=>'Selasa','3'=>'Rabu','4'=>'Kamis','5'=>'Jumat','6'=>'Sabtu','7'=>'Minggu'],null,['class'=>'form-control'])}}
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Jam Mulai & Usai</label>
    <div class="col-md-2">
{{--        {{ Form::select('KE_Jadwal_JamMulai',['07:30'=>'07:30','08:20'=>'08:20','09:10'=>'09:10','09:20'=>'09:20','10:10'=>'10:10','10:20'=>'10:20','11:10'=>'11:10','13:00'=>'13:00','13:50'=>'13:50','14:40'=>'14:40','15:50'=>'15:50','16:40'=>'16:40'],null,['class'=>'form-control'])}}--}}
        <input type="text"
               class="only-time form-control"
               name="KE_Jadwal_JamMulai"
               id="KE_Jadwal_JamMulai"
               autocomplete="off"/>
    </div> -
    <div class="col-md-2">
{{--        {{ Form::select('KE_Jadwal_JamUsai',['08:20'=>'08:20','09:10'=>'09:10','10:00'=>'10:00','10:10'=>'10:10','11:00'=>'11:00','11:10'=>'11:10','12:00'=>'12:00','13:50'=>'13:50','14:40'=>'14:40','15:30'=>'15:30','16:40'=>'16:40','17:30'=>'17:30'],null,['class'=>'form-control'])}}--}}
        <input type="text"
               class="only-time form-control"
               name="KE_Jadwal_JamUsai"
               id="KE_Jadwal_JamUsai"
               autocomplete="off"/>
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

    $('.only-time').datepicker({
        dateFormat: ' ',
        timepicker: true,
        classes: 'only-timepicker'
    });
</script>



