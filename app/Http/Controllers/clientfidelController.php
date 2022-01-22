<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\clientfidel;
use Illuminate\Support\Facades\DB;

class clientfidelController extends Controller
{
     //get all Users
     public function getclients() {
        $results = DB::select('select * from clientfidels   order by date DESC, heure DESC');
        return response()->json($results, 200);
    }
   

    //insert User
    public function insertClient(Request $request) {
        $data=array('name'=>$request[0]['name'],"num"=>$request[0]['num'],"cin"=>$request[0]['cin'],"point"=>$request[0]['point'],'user'=>$request[1],"date"=>date('Y-m-d'),"heure"=>date('H:i:s'));
        DB::table('clientfidels')->insert($data);
        return response($data, 201);
    }

    //delete User
    public function deleteclients(Request $request, $id) {
        $clientfidel = clientfidel::find($id);
        if(is_null($clientfidel)) {
            return response()->json(['message' => 'Product Not Found'], 404);
        }
        $clientfidel->delete();
        return response()->json(null, 204);
    }

}
