<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Retour;
use Illuminate\Support\Facades\DB;



class retourController extends Controller
{
    public function AddProdInRetour(Request $request) {
        $codep = $request[0][0]['id'];
        $name = $request[0][0]['name'];
        $pu = $request[0][0]['pu'];
        $img = $request[0][0]['img'];
        $user=$request[2];
        $qt=$request[1];
        $totalligne = $pu*$qt;

        $data=array('name'=>$name,"codep"=>$codep,"pu"=>$pu,"qt"=>$qt,"totalligne"=>$totalligne,'img'=>$img,'user'=>$user,"date"=>date('Y-m-d'),"heure"=>date('H:i:s'));
        DB::table('retours')->insert($data);

        DB::update('update stocks set qt =qt+:q  where id=:i', ['q'=>$request[1],'i'=>$request[0][0]['id']]);
        return response(['message' => 'Product inserted'], 201);
    }

    
   
    public function getretour() {
        $results = DB::select('select * from retours where date= (?) order by date DESC, heure DESC', [date('Y-m-d')]);
        $path="http://localhost:8000/image/";
        $prod []=$results;
        $prod []=$path;
        return response()->json($prod, 200);
    }

  
    public function deleteProductOfRetour(Request $request,$id){

        $Retour= Retour::find($id);
        $qt=$Retour->qt;
        $codep=$Retour->codep;
        if(is_null($Retour)) {
            return response()->json($request, 404);
        }
        $Retour->delete();
        DB::update('update stocks set qt =qt-:q  where id=:i', ['q'=>$qt,'i'=>$codep]);
        return response()->json(null, 204);
    }  



    public function addNumFacture(Request $request){
        $numcommande=$request[0];
        $id=$request[1];
        $totalligne=$request[2];
        $user=$request[3];
        $lastnumcommande=$request[4];
        
        DB::update('update retours set numfacture=:u  where id=:i', ['u'=>$numcommande,'i'=>$id]);
        $res = DB::select('select * from benefcommandes where numcommande=:n ', ['n'=>$numcommande]);
            if($res){  
                $numbenef=$res[0]->numbenef;
                $result = DB::select('select * from beneficiaries where id=:n ', ['n'=>$numbenef]);
                $newMontant=$result[0]->montant-$totalligne;
                $newpoint=$newMontant*0.5;
                $newbenefice=0;
                if($newpoint >= 250 ){
                    if($newpoint >= 500 ){
                        $newbenefice=$newpoint*0.1;
                    }else {
                        $newbenefice=$point*0.04;
                    }
                }  
                $subbenef=$result[0]->benefice-$newbenefice; 
                $return=$totalligne-$subbenef;
                if($lastnumcommande != 0){
                    DB::update('delete from retourbenefs where id=:i', ['i'=>$lastnumcommande]);
                }
                $data=array("numcommande"=>$result[0]->numcommande,"num"=>$result[0]->num,"point"=>$result[0]->point,"montant"=>$result[0]->montant,'benefice'=>$result[0]->benefice,"newpoint"=>$newpoint,"newmontant"=>$newMontant,'newbenefice'=>$newbenefice,'return'=>$return,'user'=>$user,"date"=>date('Y-m-d'),"heure"=>date('H:i:s'));
                DB::table('retourbenefs')->insert($data);

                $resulttt = DB::select('select * from retourbenefs order by id desc  limit 1 ');
                DB::update('update retours set numretourbenef=:u  where id=:i', ['u'=>$resulttt[0]->id,'i'=>$id]);
                
                return response()->json($resulttt, 201);
            }    
        return response()->json(null, 201);
    
    }  
    

}
