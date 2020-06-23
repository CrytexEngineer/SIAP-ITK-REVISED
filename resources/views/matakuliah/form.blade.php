<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Nama matakuliah</label>
    <div class="col-md-6">
        {{ Form::text('MK_Mata_Kuliah',null,['class'=>'form-control','placeholder'=>'Nama Mata Kuliah'])}}
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Jumlah SKS</label>
    <div class="col-md-4">
        {{ Form::text('MK_KreditKuliah',null,['class'=>'form-control','placeholder'=>'Jumlah SKS'])}}
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Tahun Kurikulum</label>
    <div class="col-md-4">
        {{ Form::text('MK_ThnKurikulum',null,['class'=>'form-control','placeholder'=>'Tahun Kurikulum'])}}
    </div>

</div>
