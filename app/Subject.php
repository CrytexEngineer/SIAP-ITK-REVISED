<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

    protected $fillable = ['MK_ID', 'MK_Mata_Kuliah', 'MK_ThnKurikulum', 'MK_KreditKuliah'];


    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'classes', 'KE_KR_MK_ID', 'KE_PE_NIPPengajar');
    }
}
