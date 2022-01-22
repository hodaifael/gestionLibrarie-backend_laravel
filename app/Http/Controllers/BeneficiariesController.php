<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Beneficiarie;
use Illuminate\Support\Facades\DB;
use App\clientfidel;

class BeneficiariesController extends Controller
{
    //get all 
    public function getbeneficiaries() {
        $results = DB::select('select * from beneficiaries   order by date DESC, heure DESC');
        return response()->json($results, 200);
    }
   
    public function getbeneficiariesbyId($id) {
        $results = DB::select('select * from beneficiaries where num=:c  order by date DESC, heure DESC', ['c'=>$id]);
        return response()->json($results, 200);
    }
   

    //insert 
    public function insertbeneficiaries(Request $request) {
        $numclient=$request[0];
        $user=$request[1];
        $numcommande=$request[2];
       
        if($numclient != 0){
                $allcommande="";
                $results = DB::select('select distinct numc from commandes where numclient=:n and benef=0', ['n'=>$numclient]);
                if($results){
                    for ($i = 0; $i <= count($results)-1; $i++){
                        $allcommande=$allcommande.(string)$results[$i]->numc;
                        if($i<count($results)-1){
                            $allcommande=$allcommande."-";
                        }
                    }
                }
                
                $results = DB::select('select * from clientfidels where num=:n ', ['n'=>$numclient]);
                $point = $results[0]->point;
                if($point >= 250 ){
                    if($point >= 500 ){
                        $benefice=$point*0.1;
                    }else {
                        $benefice=$point*0.04;
                    }
                    $p=0;
                    $total=$point*2;
                    $data=array('name'=>$results[0]->name,"numcommande"=>$numcommande,"allcommande"=>$allcommande,"num"=>$results[0]->num,"cin"=>$results[0]->cin,"point"=>$point,"montant"=>$total,'benefice'=>$benefice,'user'=>$user,"date"=>date('Y-m-d'),"heure"=>date('H:i:s'));
                    DB::table('beneficiaries')->insert($data);
                    DB::update('update clientfidels set point =:q ,user=:u ,date=:d,heure=:h where num=:i', ['u'=>$user,'q'=>$p,'i'=>$numclient,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
                }
                
            }
            $res = DB::select('select  * from beneficiaries where num=:n and numcommande=:nu ', ['n'=>$numclient,'nu'=>$numcommande]);
            $results = DB::select('select distinct numc from commandes where numclient=:n and benef=0', ['n'=>$numclient]);
                if($results){
                    for ($i = 0; $i <= count($results)-1; $i++){
                        $data=array('numbenef'=>$res[0]->id,"numcommande"=>$results[$i]->numc);
                        DB::table('benefcommandes')->insert($data);
                    }
                }
            DB::update('update commandes set benef =:n where benef=0 and numclient=:nu', ['n'=>$res[0]->id,'nu'=>$numclient]);
            DB::update('update caisses set benef =:n where benef=0 and numclient=:nu', ['n'=>$res[0]->id,'nu'=>$numclient]);
            return response(null, 201);
    }

    //delete
    public function deletebeneficiaries(Request $request) {
        $id=$request[0];
        $numclient=$request[1];
        $user=$request[2];

        $Beneficiarie = Beneficiarie::find($id);

        DB::update('update commandes set benef =0 where benef=:n', ['n'=>$Beneficiarie->id]);
        DB::update('delete from benefcommandes where numbenef=:i', ['i'=>$Beneficiarie->id]);    
        DB::update('update clientfidels set point =point+:q ,user=:u ,date=:d,heure=:h where num=:i', ['u'=>$user,'q'=>$Beneficiarie->point,'i'=>$numclient,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
        if(is_null($Beneficiarie)) {
            return response()->json(['message' => 'Beneficiarie Not Found'], 404);
        }
        $Beneficiarie->delete();
        return response()->json(null, 201);
    }
}
