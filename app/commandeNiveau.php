<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class commandeNiveau extends Model
{
    public $timestamps = false;
    protected $fillable = ['numNiveau','codep','name', 'pu','totalligne','qt','img','user','date','heure'];
}

