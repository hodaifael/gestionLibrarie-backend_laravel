<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CmdFourniss;
use Illuminate\Support\Facades\DB;

class CmdFournissController extends Controller
{
   
    public function AddProdInCmd(Request $request) {
        $numCmdFourniss=$request[1];
        $codep = $request[0][0]['id'];
        $name = $request[0][0]['name'];
        $pu = $request[0][0]['pu'];
        $pht=$request[0][0]['pht'];
        $type=$request[0][0]['type'];
        $img = $request[0][0]['img'];
        $user=$request[3];
        $date=date('Y-m-d');


        $results = DB::select('select id,qt from cmdFourniss where numCmdFourniss=:n and codep=:c', ['n'=>$numCmdFourniss,'c'=>$codep]);
        if($results){
            $qt = $request[2]+$results[0]->qt;
            $totalligne = $pu*$qt;
            DB::update('update cmdFourniss set qt =:q ,user=:u,date=:date,heure=:time where id=:i', ['u'=>$user,'q'=>$qt,'i'=>$results[0]->id,"date"=>$date,"time"=>date('H:i:s')]);
        }else{
            $qt=$request[2]; 
            $totalligne = $pu*$qt;
            $data=array('name'=>$name,"codep"=>$codep,"pu"=>$pu,'user'=>$user,"pht"=>$pht,"type"=>$type,"qt"=>$qt,'img'=>$img,"numCmdFourniss"=>$numCmdFourniss,"date"=>$date,"heure"=>date('H:i:s'));
            DB::table('cmdFourniss')->insert($data);
        }
        return response($pu, 200);
    }


    public function UpdateProductCmd(Request $request){
        $id = $request[0];
        $qt = $request[1];
        $user = $request[2];
        $results = DB::select('select codep,qt,pu from cmdFourniss where id=:c', ['c'=>$id]);
        if($results){
            $qt = $request[1]+$results[0]->qt;
            $codep=$results[0]->codep;
            DB::update('update cmdFourniss set qt =:q ,user=:u ,date=:d,heure=:h where id=:i', ['u'=>$user,'q'=>$qt,'i'=>$id,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
        }
        return response()->json($qt, 200);
    } 
    
    
    public function selectLastCmd(){
        $results = DB::select('select cmdFourniss from sessions ');
        if($results!=NULL){
            $value1=(int)$results[0]->cmdFourniss;
            $value1++;
            DB::update('update sessions set cmdFourniss = ?', [$value1]);
        }else{
            $value1=1;
            DB::insert('insert into sessions (cmdFourniss) values (?)', [$value1]); 
        }

        return response($value1, 200);
    } 
   
     //get all Products
    public function getCmd($id) {
       
        $results = DB::select('select * from cmdFourniss where numCmdFourniss= (?) order by date DESC, heure DESC', [$id]);
        $path="http://localhost:8000/image/";
        $prod []=$results;
        $prod []=$path;
        return response()->json($prod, 200);
    }

    public function deleteProductOfCmd(Request $request,$id){
        
        $Facture= CmdFourniss::find($id);
        $qt=$Facture->qt;
        $codep=$Facture->codep;
        if(is_null($Facture)) {
            return response()->json($request, 404);
        }
        $Facture->delete();
        return response()->json(null, 204);
    }    

}
