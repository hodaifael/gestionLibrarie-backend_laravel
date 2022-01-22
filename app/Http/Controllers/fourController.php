<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fournisseur;
use Illuminate\Support\Facades\DB;



class fourController extends Controller
{
  
    //get all Fournisseur
    public function getfournisseur() {
        $results = DB::select('select * from fournisseurs order by numfour ');
        return response()->json($results, 200);
    }



    //insert Fournisseur
    public function addfournisseur(Request $request) {
        $Fournisseur = Fournisseur::create($request->all());
        return response($Fournisseur, 201);
    }

    //delete Fournisseur
    public function deletefournisseur(Request $request, $id) {
        $Fournisseur = Fournisseur::find($id);
        if(is_null($Fournisseur)) {
            return response()->json(['message' => 'Product Not Found'], 404);
        }
        $Fournisseur->delete();
        return response()->json(null, 204);
    }


}
