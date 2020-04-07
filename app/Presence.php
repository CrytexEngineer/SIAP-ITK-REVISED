<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class presence extends Model{

protected $primaryKey='PR_ID';
protected $fillable=['PR_KU_ID','PR_PT_ID','PR_IsLAte','PR_Keterangan','PR_Type'];


}
