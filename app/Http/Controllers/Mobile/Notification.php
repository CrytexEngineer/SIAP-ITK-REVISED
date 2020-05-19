<?php


namespace App\Http\Controllers\Mobile;


use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable=['date','time','msg','count'];

}
