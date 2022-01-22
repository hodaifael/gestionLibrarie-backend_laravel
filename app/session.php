<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class session extends Model
{
    public $timestamps = false;
    protected $fillable = ['numcommande','numfacture','codep','numNiveau','cmdFourniss'];
}
