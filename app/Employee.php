<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{

    protected $fillable = ['PE_Nip', 'PE_Nama', 'PE_NamaLengkap', 'PE_Email'];

    protected $primaryKey = 'PE_Nip';
    public $incrementing = false;
    public function user()
    {
        return $this->hasOne(User::Class, 'email', 'PE_Email');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'classes', 'KE_PE_NIPPengajar', 'KE_KR_MK_ID');
    }

    //Multi-user Management
    public function roles(){
        return $this->belongsToMany('App\Role');
    }

    public function hasAnyRoles($roles){
        if($this->roles()->whereIn('role_name', $roles)->first()){
            return true;
        }
        return false;
    }

    public function hasRole($role){
        if($this->roles()->where('role_name', $role)->first()){
            return true;
        }
        return false;
    }
}
