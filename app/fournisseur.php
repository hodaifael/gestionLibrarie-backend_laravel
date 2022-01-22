<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fournisseur extends Model
{
    public $timestamps = false;
    protected $fillable = ['numfour','name', 'tel'];
}