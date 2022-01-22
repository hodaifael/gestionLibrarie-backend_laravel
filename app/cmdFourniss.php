<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cmdFourniss extends Model
{
    public $timestamps = false;
    protected $fillable = ['numCmdFourniss','codep','name', 'pu', 'pht','type','qt','img','user','date','heure'];
}
