<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caisse;
use Illuminate\Support\Facades\DB;

class caisseController extends Controller
{
    public function AddProdIncaisses(Request $request) {
        $codep = $request[0][0]['id'];
        $name = $request[0][0]['name'];
        $pu = $request[0][0]['pu'];
        $img = $request[0][0]['img'];
        $date=$request[1];
        $user=$request[3];
        
            $qt=$request[2];
            $totalligne = $pu*$qt;
            $data=array('name'=>$name,"codep"=>$codep,"pu"=>$pu,"qt"=>$qt,'user'=>$user,"totalligne"=>$totalligne,'img'=>$img,"date"=>$date,"time"=>date('H:i:s'));
            DB::table('caisses')->insert($data);
        
        DB::update('update stocks set qt =qt-:q  where id=:i', ['q'=>$request[2],'i'=>$request[0][0]['id']]);
        return response(null, 201);
    }

    public function UpdateProductcaisse(Request $request){
        $id = $request[0];
        $qt = $request[1];
        $user = $request[2];
        $results = DB::select('select codep,qt,pu from caisses where id=:c', ['c'=>$id]);
        if($results){
            $qt = $request[1]+$results[0]->qt;
            $totalligne = $results[0]->pu*$qt;
            $codep=$results[0]->codep;
            DB::update('update caisses set qt =:q ,totalligne=:t,user=:u ,date=:d,time=:h where id=:i', ['u'=>$user,'q'=>$qt,'t'=>$totalligne,'i'=>$id,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
            DB::update('update stocks set qt =qt-:q  where id=:i', ['q'=>$request[1],'i'=>$codep]);
        }
        return response()->json($id, 200);
    }
    public function changenumclient(Request $request){
        $numclient = $request[0];
        $id = $request[1];
        $user = $request[2];
        DB::update('update caisses set numclient =:q ,user=:u ,date=:d,time=:h where id=:i', ['u'=>$user,'q'=>$numclient,'i'=>$id,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
        $results = DB::select('select qt,pu from caisses where id=:c', ['c'=>$id]);
        if($results){
            $qt = $results[0]->qt;
            $totalligne = $results[0]->pu*$qt;
            
            if($numclient != 0){
                $point = $totalligne*0.5;
                DB::update('update clientfidels set point =point+:q ,user=:u ,date=:d,heure=:h where num=:i', ['u'=>$user,'q'=>$point,'i'=>$numclient,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
            } 
           }
        return response()->json($id, 200);
    }
     //get all Products
    public function getcaisses($date) {
        $results = DB::select('select * from caisses where date= (?) order by date DESC, time desc', [$date]);
        $prod = array();
        $path="http://localhost:8000/image/";
        $prod []=$results;
        $prod []=$path;
        return response()->json($prod, 200);
    }

    public function deleteProductOfcaisses(Request $request,$id){

        $Caisse= Caisse::find($id);
        $qt=$Caisse->qt;
        $codep=$Caisse->codep;
        if(is_null($Caisse)) {
            return response()->json($request, 404);
        }
        if($Caisse->numclient != 0){
            $point = $Caisse->totalligne*0.5;
            DB::update('update clientfidels set point =point-:q ,date=:d,heure=:h where num=:i', ['q'=>$point,'i'=>$Caisse->numclient,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
        }
        $Caisse->delete();
        DB::update('update stocks set qt =qt+:q  where id=:i', ['q'=>$qt,'i'=>$codep]);
        return response()->json(null, 204);
    }    
}
