<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class facture extends Model
{
    public $timestamps = false;
    protected $fillable = ['numFinterne','numfacture','numfour','codep','name', 'pu', 'pht','type','qt','img','user','date','heure'];
}
