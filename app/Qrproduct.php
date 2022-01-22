<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qrproduct extends Model
{
    public $timestamps = false;
    protected $fillable = ['codep','img','name','color','type','user','date','heure'];
}
