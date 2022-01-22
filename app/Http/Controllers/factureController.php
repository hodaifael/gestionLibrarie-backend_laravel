<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facture;
use App\Stock;
use Illuminate\Support\Facades\DB;

class factureController extends Controller
{
    public function updateFourAndFacture(Request $request) {
        $numFinterne=$request[0];
        $numfour=$request[1];
        $numfacture=$request[2];
        DB::update('update factures set numfour =:q ,numfacture =:n  where numFinterne=:i', ['q'=>$numfour,'i'=>$numFinterne,'n'=>$numfacture]);

    }    
    public function AddProdInFacture(Request $request) {
        $numFinterne=$request[1];
        $numfour=$request[3];
        $numfacture=$request[4];
        $codep = $request[0][0]['id'];
        $name = $request[0][0]['name'];
        $pu = $request[0][0]['pu'];
        $pht=$request[0][0]['pht'];
        $type=$request[0][0]['type'];
        $img = $request[0][0]['img'];
        $user=$request[5];
        $date=date('Y-m-d');


        $results = DB::select('select id,qt from factures where numFinterne=:n and codep=:c', ['n'=>$numFinterne,'c'=>$codep]);
        if($results){
            $qt = $request[2]+$results[0]->qt;
            $totalligne = $pu*$qt;
            DB::update('update factures set qt =:q ,user=:u,date=:date,heure=:time where id=:i', ['u'=>$user,'q'=>$qt,'i'=>$results[0]->id,"date"=>$date,"time"=>date('H:i:s')]);
        }else{
            $qt=$request[2]; 
            $totalligne = $pu*$qt;
            $data=array('name'=>$name,"codep"=>$codep,"pu"=>$pu,'user'=>$user,"pht"=>$pht,"type"=>$type,"qt"=>$qt,'img'=>$img,"numFinterne"=>$numFinterne,"numfacture"=>$numfacture,"numfour"=>$numfour,"date"=>$date,"heure"=>date('H:i:s'));
            DB::table('factures')->insert($data);
        }
        DB::update('update stocksglobals set qt =qt+:q  where id=:i', ['q'=>$request[2],'i'=>$request[0][0]['id']]);
        return response($pu, 200);
    }


    public function UpdateProductFacture(Request $request){
        $id = $request[0];
        $qt = $request[1];
        $user = $request[2];
        $results = DB::select('select codep,qt,pu from factures where id=:c', ['c'=>$id]);
        if($results){
            $qt = $request[1]+$results[0]->qt;
            $codep=$results[0]->codep;
            DB::update('update factures set qt =:q ,user=:u ,date=:d,heure=:h where id=:i', ['u'=>$user,'q'=>$qt,'i'=>$id,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
            DB::update('update stocksglobals set qt =qt+:q  where id=:i', ['q'=>$request[1],'i'=>$codep]);
        }
        return response()->json($qt, 200);
    }   
    
    
    public function transfer(Request $request){
        $numFinterne = $request[0];
        $user = $request[1];
        $results = DB::select('select * from factures where numFinterne=:c', ['c'=>$numFinterne]);
        if($results){
            for ($i = 0; $i < count($results); $i++){
                  
                    $totalligne=$results[$i]->qt*$results[$i]->pu;
                    $data=array('name'=>$results[$i]->name,"codep"=>$results[$i]->codep,"pu"=>$results[$i]->pu,"qt"=>$results[$i]->qt,'user'=>$user,"totalligne"=>$totalligne,'img'=>$results[$i]->img,"date"=>$results[$i]->date,"time"=>date('H:i:s'));
                    DB::table('transfers')->insert($data);
                    DB::update('update stocks set qt =qt+:q  where id=:i', ['q'=>$results[$i]->qt,'i'=>$results[$i]->codep]);
                    DB::update('update stocksglobals set qt =qt-:q  where id=:i', ['q'=>$results[$i]->qt,'i'=>$results[$i]->codep]);
                
            }  
        }
        return response()->json(null, 200);
    }    


    public function selectLastf(){
        $results = DB::select('select numfacture from sessions ');
        $res = DB::select('select * from factures where numFinterne= (?)  order by date DESC, heure DESC', [$results[0]->numfacture]);
        $value1=(int)$results[0]->numfacture;
        if($res){
            $value1++;
            DB::update('update sessions set numfacture = ?', [$value1]);
        }else{
            $value1=1;
            DB::insert('insert into sessions (numfacture) values (?)', [$value1]); 
        }

        return response($value1, 200);
    } 
   

    
     //get all Products
    public function getFacture($id) {
        $results = DB::select('select * from factures where numFinterne= (?) order by date DESC, heure DESC', [$id]);
        $resultsNum = DB::select('select numfacture,numfour from factures where numFinterne= (?) LIMIT 1', [$id]);
        if($results){
            $path="http://localhost:8000/image/";
            $prod []=$results;
            $prod []=$path;
            $prod []=$resultsNum[0]->numfacture;
            $prod []=$resultsNum[0]->numfour;
            return response()->json($prod, 200);
        }
    return response(null, 200);
       
    }


    public function deleteProductOfFacture(Request $request,$id){
        
        $Facture= Facture::find($id);
        $qt=$Facture->qt;
        $codep=$Facture->codep;
        if(is_null($Facture)) {
            return response()->json($request, 404);
        }
        $Facture->delete();
        DB::update('update stocksglobals set qt =qt-:q  where id=:i', ['q'=>$qt,'i'=>$codep]);
        return response()->json(null, 204);
    }    

}

