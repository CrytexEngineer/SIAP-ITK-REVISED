<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable{

protected $fillable=['PE_Nip','PE_Nama','PE_NamaLengkap','PE_Email','PE_TipePegawai'];


  public function user(){
     return $this->hasOne(User::Class,'email','PE_Email');
  }

  public function subjects(){
      return $this->belongsToMany(Subject::class,'classes','KE_PE_NIPPengajar','KE_KR_MK_ID');
  }
}
