<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class chiffre extends Model
{
    public $timestamps = false;
    protected $fillable = ['date','caisse', 'commande','retour','totalligne','solde'];
}
