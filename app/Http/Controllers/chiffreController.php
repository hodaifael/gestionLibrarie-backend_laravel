<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commande;
use App\Chiffre;
use App\Retour;
use Illuminate\Support\Facades\DB;


class chiffreController extends Controller
{
    public function getchiffreCommande($id){
        $chiffres = array();
        $date="";
        $solde=0;
        for($i = 31;$i>=1;$i--)
        {
            if($i<10){
                $date=date('Y').'-'.$id.'-'.'0'.$i;
            }else{
                $date=date('Y').'-'.$id.'-'.$i;
            }
            $results = DB::select('select * from commandes where date= (?) ', [$date]);
            $commande=0;
            for($j = 0;$j<count($results);$j++)
            {   
                $commande+=$results[$j]->totalligne;
            } 
            $results1 = DB::select('select * from caisses where date= (?) ', [$date]);
            $caisse=0;
            for($j = 0;$j<count($results1);$j++)
            {   
                $caisse+=$results1[$j]->totalligne;
            } 
            $results2 = DB::select('select * from retours where date= (?) ', [$date]);
            $retour=0;
            for($j = 0;$j<count($results2);$j++)
            {   if($results2[$j]->numretourbenef !=0){
                $results2 = DB::select('select * from retours where date= (?) ', [$date]);
                }
                $retour+=$results2[$j]->totalligne;
            } 
            if($commande!=0 || $caisse!=0 || $retour!=0){
                $object = new Chiffre();
                $object->commande = $commande;
                $object->caisse = $caisse;
                $object->retour = $retour;
                $totalligne = $caisse+$commande-$retour;
                $solde+=$totalligne;
                $object->totalligne = $totalligne;
                $object->solde = $solde;
                $object->date = $date;
                $chiffres []= $object;
            }       
        }

        return response()->json($chiffres, 200);//i must add time in commandes table
    }

}
