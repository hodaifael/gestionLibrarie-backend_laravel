<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sortie extends Model
{
    public $timestamps = false;
    protected $fillable = ['name','type', 'montant','user','time'];
}