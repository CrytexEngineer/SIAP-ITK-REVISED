<div class="form-group row">
    <label class="col-md-2 col-form-label text-md-right">Nama matakuliah</label>
    <div class="col-md-8">
        {{ Form::text('MK_Mata_Kuliah',null,['class'=>'form-control','placeholder'=>'Nama matakuliah'])}}
    </div>
</div>

<div class="form-group row">
    <label class="col-md-2 col-form-label text-md-right">Jumlah SKS</label>
    <div class="col-md-2">
        {{ Form::text('MK_KreditKuliah',null,['class'=>'form-control','placeholder'=>'Jumlah SKS'])}}
    </div>
</div>

<div class="form-group row">
    <label class="col-md-2 col-form-label text-md-right">Tahun Kurikulum</label>
    <div class="col-md-2">
        {{ Form::text('MK_ThnKurikulum',null,['class'=>'form-control','placeholder'=>'Tahun Kurikulum'])}}
    </div>

</div>
