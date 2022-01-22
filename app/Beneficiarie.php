<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficiarie extends Model
{
    public $timestamps = false;
    protected $fillable = ['num','numcommande','allcommande','name', 'cin','point','montant','benefice','user','date','heure'];
}
