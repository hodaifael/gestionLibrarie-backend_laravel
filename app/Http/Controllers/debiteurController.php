<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Debiteur;
use Illuminate\Support\Facades\DB;


class debiteurController extends Controller
{
  
    //get all Fournisseur
    public function getdebiteurs() {
        $results = DB::select('select * from debiteurs order by date DESC, heure DESC');
        return response()->json($results, 200);
    }



    //insert Fournisseur
    public function insertdebiteurs(Request $request) {
        $data=array('numcommande'=>$request[0]['numcommande'],'name'=>$request[0]['name'],"tel"=>$request[0]['tel'],"total"=>$request[0]['total'],"avance"=>$request[0]['avance'],'user'=>$request[1],"date"=>date('Y-m-d'),"heure"=>date('H:i:s'));
        DB::table('debiteurs')->insert($data);
        return response(null, 201);
    }

    public function changeavance(Request $request) {
        $avance=$request[0];
        $id=$request[1];
        $user=$request[2];
        DB::update('update debiteurs set avance=avance+:q ,user=:u ,date=:d,heure=:h where id=:i', ['u'=>$user,'q'=>$avance,'i'=>$id,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);

        return response(null, 201);
    }

    //delete Fournisseur
    public function deletedebiteurs(Request $request, $id) {
        $Debiteur = Debiteur::find($id);
        if(is_null($Debiteur)) {
            return response()->json(['message' => 'Product Not Found'], 404);
        }
        $Debiteur->delete();
        return response()->json(null, 204);
    }


}
