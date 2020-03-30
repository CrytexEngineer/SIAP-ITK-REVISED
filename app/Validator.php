<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Validator extends Model
{
    protected $table='validators';
    protected $primaryKey='VD_ID';
    protected $fillable=['VD_PT_ID','VD_Token','VD_Expired'];
}
