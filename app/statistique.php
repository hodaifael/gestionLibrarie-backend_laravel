<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class statistique extends Model
{
    public $timestamps = false;
    protected $fillable = ['codep','name', 'retour', 'commande','caisse','facture','totalligne','img'];
}
