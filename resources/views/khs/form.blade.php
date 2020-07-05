<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Mahasiswa</label>
    <div class="col-md-5">
        {{Form::select('KU_MA_Nrp',$students,null,['class'=>'form-control','placeholder'=>'Pilih Mahasiswa'])}}
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Program Studi</label>
    <div class="col-md-5">
        {{Form::select('KU_KE_KodeJurusan',$major,null,['class'=>'form-control','placeholder'=>'Pilih Program Studi'])}}
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Kelas</label>
    <div class="col-md-4">
        {{Form::select('KU_KE_KR_MK_ID',$subjects,null,['class'=>'form-control','placeholder'=>'Pilih Mata Kuliah'])}}
    </div>
    <div class="col-md-2">
        {{Form::select('KU_KE_Kelas',$classes,null,['class'=>'form-control','placeholder'=>'Pilih Kelas'])}}
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Tahun Akademik</label>
    <div class="col-md-3">
        {{ Form::text('KU_KE_Tahun',null,['class'=>'form-control','placeholder'=>'Masukan Tahun Akademik'])}}
    </div>
</div>
