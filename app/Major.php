<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
protected $primaryKey = 'PS_Kode_Prodi';
    protected $fillable = ['PS_Kode_Prodi', 'PS_Nama'];

}
