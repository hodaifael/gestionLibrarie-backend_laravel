<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class caisse extends Model
{
    public $timestamps = false;
    protected $fillable = ['codep','numclient','name', 'pu','totalligne','qt','img','user','date','time','benef'];
}
