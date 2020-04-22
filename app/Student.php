<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;
    protected $primaryKey='MA_Nrp';
    protected $fillable = ['MA_Nrp', 'MA_NRP_Baru', 'MA_NamaLengkap', 'email','MA_IMEI','MA_PASSWORD'];

    public function user()
    {
        return $this->hasOne(User::Class, 'email', 'email');
    }


}
