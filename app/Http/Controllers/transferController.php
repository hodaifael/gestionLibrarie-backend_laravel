<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transfer;
use Illuminate\Support\Facades\DB;
class transferController extends Controller
{
    public function AddProdIntransfer(Request $request) {
        $codep = $request[0][0]['id'];
        $name = $request[0][0]['name'];
        $pu = $request[0][0]['pu'];
        $img = $request[0][0]['img'];
        $date=$request[1];
        $user=$request[3];

        $results = DB::select('select id,qt from transfers where date=:n and codep=:c', ['n'=>$date,'c'=>$codep]);

        if($results){
            $qt = $request[2]+$results[0]->qt; 
            $totalligne = $pu*$qt;
            DB::update('update transfers set qt =:q ,user=:u,totalligne=:t,time=:time ,date=:d where id=:i', ['u'=>$user,'q'=>$qt,'t'=>$totalligne,'i'=>$results[0]->id,'d'=>$date,'time'=>date('H:i:s')]);
        }else{
            $qt=$request[2];
            $totalligne = $pu*$qt;
            $data=array('name'=>$name,"codep"=>$codep,"pu"=>$pu,"qt"=>$qt,'user'=>$user,"totalligne"=>$totalligne,'img'=>$img,"date"=>$date,"time"=>date('H:i:s'));
            DB::table('transfers')->insert($data);
        }
        DB::update('update stocksglobals set qt =qt-:q  where id=:i', ['q'=>$request[2],'i'=>$request[0][0]['id']]);
        DB::update('update stocks set qt =qt+:q  where id=:i', ['q'=>$request[2],'i'=>$request[0][0]['id']]);
        return response($results, 201);
    }

    public function updateProductTransfer(Request $request){
        $id = $request[0];
        $qt = $request[1];
        $user = $request[2];
        $results = DB::select('select codep,qt,pu from transfers where id=:c', ['c'=>$id]);
        if($results){
            $qt = $request[1]+$results[0]->qt;
            $totalligne = $results[0]->pu*$qt;
            $codep=$results[0]->codep;
            DB::update('update transfers set qt =:q ,totalligne=:t,user=:u ,date=:d,time=:h where id=:i', ['u'=>$user,'q'=>$qt,'t'=>$totalligne,'i'=>$id,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
            DB::update('update stocksglobals set qt =qt-:q  where id=:i', ['q'=>$request[1],'i'=>$codep]);
            DB::update('update stocks set qt =qt+:q  where id=:i', ['q'=>$request[1],'i'=>$codep]);
        }
        return response()->json($id, 200);
    }

     //get all Products
    public function gettransfer($date) {
        $results = DB::select('select * from transfers where date= (?) order by date DESC, time desc', [$date]);
        $prod = array();
        $path="http://localhost:8000/image/";
        $prod []=$results;
        $prod []=$path;
        return response()->json($prod, 200);
    }

    public function deleteProductOfTransfer(Request $request,$id){

        $Caisse= Transfer::find($id);
        $qt=$Caisse->qt;
        $codep=$Caisse->codep;
        if(is_null($Caisse)) {
            return response()->json($request, 404);
        }
        $Caisse->delete();
        DB::update('update stocksglobals set qt =qt+:q  where id=:i', ['q'=>$qt,'i'=>$codep]);
        DB::update('update stocks set qt =qt-:q  where id=:i', ['q'=>$qt,'i'=>$codep]);
        return response()->json(null, 204);
    }    



}
