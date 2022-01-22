<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class entree extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'montant','user','time'];
}