<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class commande extends Model
{
    public $timestamps = false;
    protected $fillable = ['numc','numclient','codep','name', 'pu','totalligne','qt','img','user','date','heure'];
}
