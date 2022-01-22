<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Khadamat;
use Illuminate\Support\Facades\DB;


class khadamatController extends Controller
{
  
    //get all Fournisseur
    public function getKhadamat($date) {
        $results = DB::select('select * from khadamats where date= (?) order by date DESC, time DESC', [$date]);

        return response()->json($results, 200);
    }



    //insert Fournisseur
    public function addKhadamat(Request $request) {
        $user=$request[1];
        $typerecharge = $request[0]['typerecharge'];
        $montant = $request[0]['montant'];
        $type = $request[0]['type'];
        $date=date('Y-m-d');
        $data=array('type'=>$type,"typerecharge"=>$typerecharge,"montant"=>$montant,"date"=>$date,'user'=>$user,"time"=>date('H:i:s'));
        DB::table('khadamats')->insert($data);
        return response($request, 201);
    }

    //delete Fournisseur
    public function deleteKhadamat(Request $request, $id) {
        $Khadamat = Khadamat::find($id);
        if(is_null($Khadamat)) {
            return response()->json(['message' => 'Khadamat Not Found'], 404);
        }
        $Khadamat->delete();
        return response()->json(null, 204);
    }


}
