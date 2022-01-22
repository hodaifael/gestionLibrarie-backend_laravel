<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class retourbenef extends Model
{
    public $timestamps = false;
    protected $fillable = ['num','numcommande','point','montant','benefice','newpoint','newmontant','newbenefice','return','user','date','heure'];
}
