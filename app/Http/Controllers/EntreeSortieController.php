<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entree;
use App\Sortie;
use Illuminate\Support\Facades\DB;


class EntreeSortieController extends Controller
{
   
    //get all Fournisseur
    public function getEntree($date) {
        $results = DB::select('select * from entrees where date= (?) order by date DESC, time DESC', [$date]);

        return response()->json($results, 200);
    }



    //insert Fournisseur
    public function addEntree(Request $request) {
        $user=$request[1];
        $name = $request[0]['name'];
        $montant = $request[0]['montant'];
        $date=date('Y-m-d');
        $data=array("name"=>$name,"montant"=>$montant,"date"=>$date,'user'=>$user,"time"=>date('H:i:s'));
        DB::table('entrees')->insert($data);
        return response($request, 201);
    }

    //delete Fournisseur
    public function deleteEntree(Request $request, $id) {
        $Entree = Entree::find($id);
        if(is_null($Entree)) {
            return response()->json(['message' => 'Entree Not Found'], 404);
        }
        $Entree->delete();
        return response()->json(null, 204);
    }



      //get all Fournisseur
      public function getSortie($date) {
        $results = DB::select('select * from sorties where date= (?) order by date DESC, time DESC', [$date]);

        return response()->json($results, 200);
    }



    //insert Fournisseur
    public function addSortie(Request $request) {
        $user=$request[1];
        $name = $request[0]['name'];
        $montant = $request[0]['montant'];
        $type = $request[0]['type'];
        $date=date('Y-m-d');
        $data=array('type'=>$type,"name"=>$name,"montant"=>$montant,"date"=>$date,'user'=>$user,"time"=>date('H:i:s'));
        DB::table('sorties')->insert($data);
        return response($request, 201);
    }

    //delete Fournisseur
    public function deleteSortie(Request $request, $id) {
        $Sortie = Sortie::find($id);
        if(is_null($Sortie)) {
            return response()->json(['message' => 'Sortie Not Found'], 404);
        }
        $Sortie->delete();
        return response()->json(null, 204);
    }


}
