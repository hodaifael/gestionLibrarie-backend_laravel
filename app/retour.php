<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class retour extends Model
{
    public $timestamps = false;
    protected $fillable = ['numfacture','codep','name', 'pu','totalligne','qt','img','numretourbenef','user','date','heure'];

}
