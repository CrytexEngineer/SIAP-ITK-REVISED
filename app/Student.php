<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    protected $fillable = ['MA_Nrp', 'MA_NRP_Baru', 'MA_NamaLengkap', 'MA_Email'];

    public function user()
    {
        return $this->hasOne(User::Class, 'email', 'MA_Email');
    }
}
