<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transfer extends Model
{
    public $timestamps = false;
    protected $fillable = ['codep','name', 'pu','totalligne','qt','img','user','date','time'];
}
