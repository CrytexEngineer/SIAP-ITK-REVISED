<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    public $incrementing='false';
    protected $primaryKey = 'PS_Kode_Prodi';
    protected $fillable = ['PS_Kode_Prodi', 'PS_Nama', 'PS_ID'];

}
