<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CommandeNiveau;
use App\Stock;
use Illuminate\Support\Facades\DB;


class commandeNiveauController extends Controller
{
    public function AddProdInNiveau(Request $request) {
        $numc=$request[1];
        $codep = $request[0][0]['id'];
        $name = $request[0][0]['name'];
        $pu = $request[0][0]['pu'];
        $img = $request[0][0]['img'];
        $user=$request[3];
        $time=date('H:i:s');
        $dat=date('Y-m-d');
        $results = DB::select('select id,qt from commandeNiveaus where numNiveau=:n and codep=:c', ['n'=>$numc,'c'=>$codep]);
        if($results){
            $qt = $request[2]+$results[0]->qt;
            $totalligne = $pu*$qt;
            DB::update('update commandeNiveaus set qt =:q ,totalligne=:t,user=:u ,date=:d,heure=:h where id=:i', ['u'=>$user,'q'=>$qt,'t'=>$totalligne,'i'=>$results[0]->id,'d'=>$dat,'h'=>$time]);
        }else{
            $qt=$request[2];
            $totalligne = $pu*$qt;
            $data=array('name'=>$name,"codep"=>$codep,"pu"=>$pu,"qt"=>$qt,"totalligne"=>$totalligne,'user'=>$user,'img'=>$img,"numNiveau"=>$numc,"date"=>date('Y-m-d'),"heure"=>date('H:i:s'));
            DB::table('commandeNiveaus')->insert($data);
        }
        return response(['message' => 'Product inserted'], 201);
    }

    public function updateNomNiveau(Request $request) {
        $numNiveau=$request[0];
        $nomNiveau=$request[1];
        $user=$request[2];
        $time=date('H:i:s');
        $dat=date('Y-m-d');
        $results = DB::select('select id from niveaus where numNiveau=:n ', ['n'=>$numNiveau]);
        if($results){
            DB::update('update niveaus set nomNiveau=:t,user=:u ,date=:d,heure=:h where id=:i', ['u'=>$user,'t'=>$nomNiveau,'i'=>$results[0]->id,'d'=>$dat,'h'=>$time]);
        }else{
            $data=array("nomNiveau"=>$nomNiveau,'user'=>$user,"numNiveau"=>$numNiveau,"date"=>$dat,"heure"=>$time);
            DB::table('niveaus')->insert($data);
        }
        return response(['message' => 'Product inserted'], 201);
    }

    
    public function UpdateProductNiveau(Request $request){
        $id = $request[0];
        $qt = $request[1];
        $user = $request[2];
        $results = DB::select('select codep,qt,pu from commandeNiveaus where id=:c', ['c'=>$id]);
        if($results){
            $qt = $request[1]+$results[0]->qt;
            $totalligne = $results[0]->pu*$qt;
            $codep=$results[0]->codep;
            DB::update('update commandeNiveaus set qt =:q ,totalligne=:t,user=:u ,date=:d,heure=:h where id=:i', ['u'=>$user,'q'=>$qt,'t'=>$totalligne,'i'=>$id,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
        }
        return response()->json($id, 200);
    }    
    public function selectLastcNiveau(){
        $results = DB::select('select numNiveau from sessions ');
        if($results!=NULL){
            $value1=(int)$results[0]->numNiveau;
            $value1++;
            DB::update('update sessions set numNiveau = ?', [$value1]);
        }else{
            $value1=1;
            DB::insert('insert into sessions (numNiveau) values (?)', [$value1]); 
        }

        return response($value1, 200);
    } 
    
     //get all Products
     public function getNomNiveau($id){
        $results = DB::select('select nomNiveau from niveaus where numNiveau= (?)  order by date DESC, heure DESC', [$id]);
        if($results!=NULL){
            return response($results, 200);
        }   
            return response()->json(null, 204);
     }    
    public function getCommandeNiveau($id){
        $results = DB::select('select * from commandeNiveaus where numNiveau= (?)  order by date DESC, heure DESC', [$id]);
            $prod = array();
            $path="http://localhost:8000/image/";
            $prod []=$results;
            $prod []=$path;
            return response($prod, 200);
    }
    public function getNiveaux(){
        $results = DB::select('select * from niveaus   order by date DESC, heure DESC');
        $niveaux = array();
        $niveaux = $results;
        return response($niveaux, 200);
    }

  
    public function deleteProductOfNiveau(Request $request,$id){
        
        $Commande= Commandeniveau::find($id);
        $qt=$Commande->qt;
        $codep=$Commande->codep;
        if(is_null($Commande)) {
            return response()->json($request, 404);
        }
        $Commande->delete();
        return response()->json(null, 204);
    }    

}
