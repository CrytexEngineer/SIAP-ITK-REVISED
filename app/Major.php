<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $table = 'majors';
    protected $fillable=['PS_Kode_Prodi','PS_Nama_Baru'];

}
