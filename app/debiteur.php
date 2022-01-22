<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class debiteur extends Model
{
    public $timestamps = false;
    protected $fillable = ['numcommande','name', 'tel','total','avance','user','date','heure'];
}