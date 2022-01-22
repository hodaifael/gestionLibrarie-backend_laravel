<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commande;
use App\Caisse;
use App\Retour;
use App\Statistique;
use Illuminate\Support\Facades\DB;


class statistiqueController extends Controller
{
     //get all Products
     public function getStatistique(Request $request) {    
        $statistique = array();
        $dateEntree=$request[0];
        $dateSortie=$request[1];
        $Stock = DB::select('select * from stocks');

        for($i = 0;$i<count($Stock);$i++)
        { 
            $id=$Stock[$i]->id;
            $results = DB::select('select * from commandes where codep=:id and ( date>=:e or date<=:s ) ', ["id"=>$id,"e"=>$dateEntree,"s"=>$dateSortie]);
            $commande=0;
                for($j = 0;$j<count($results);$j++)
                {   
                    $commande+=$results[$j]->qt;
                } 
            $results1 = DB::select('select * from caisses where codep=:id and ( date>=:e or date<=:s ) ', ["id"=>$id,"e"=>$dateEntree,"s"=>$dateSortie]);           
            $caisse=0;                         
                for($j = 0;$j<count($results1);$j++)
                {   
                    $caisse+=$results1[$j]->qt;
                }  
            $results2 = DB::select('select * from retours where codep=:id and ( date>=:e or date<=:s ) ', ["id"=>$id,"e"=>$dateEntree,"s"=>$dateSortie]);                
            $retour=0;
                for($j = 0;$j<count($results2);$j++)
                {   
                    $retour+=$results2[$j]->qt;
                }  
            $results3 = DB::select('select * from factures where codep=:id and ( date>=:e or date<=:s ) ', ["id"=>$id,"e"=>$dateEntree,"s"=>$dateSortie]);                
            $facture=0;
                for($j = 0;$j<count($results3);$j++)
                {   
                    $facture+=$results3[$j]->qt;
                }      
            $object = new statistique(); 
            $object->commande = $commande;
            $object->caisse = $caisse;
            $object->retour = $retour;
            $object->facture = $facture;
            $object->totalligne = $facture-$caisse-$commande;
            $object->codep=$Stock[$i]->id;
            $object->img=$Stock[$i]->img;
            $object->name=$Stock[$i]->name;
            $statistique []= $object;
        }      
        $path="http://localhost:8000/image/";
        $prod []=$statistique;
        $prod []=$path;

        return response()->json($prod, 200);//i must add time in commandes table
     }
}    