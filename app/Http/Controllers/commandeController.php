<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commande;
use App\Stock;
use Illuminate\Support\Facades\DB;
use App\Beneficiarie;


class commandeController extends Controller
{


   
    public function AddProdInCommande(Request $request) {
        $numc=$request[1];
        $codep = $request[0][0]['id'];
        $name = $request[0][0]['name'];
        $pu = $request[0][0]['pu'];
        $img = $request[0][0]['img'];
        $user=$request[3];
        $numclient=$request[4];
        $time=date('H:i:s');
        $dat=date('Y-m-d');
        $this->deletebenificeofcommande($numclient,$numc,$user);
        $results = DB::select('select id,qt from commandes where numc=:n and codep=:c', ['n'=>$numc,'c'=>$codep]);
        if($results){
            $qt = $request[2]+$results[0]->qt;
            $totalligne = $pu*$qt;
            DB::update('update commandes set qt =:q ,totalligne=:t,user=:u ,date=:d,heure=:h where id=:i', ['u'=>$user,'q'=>$qt,'t'=>$totalligne,'i'=>$results[0]->id,'d'=>$dat,'h'=>$time]);
            if($numclient != 0){
                $point = $pu*$request[2]*0.5;
                DB::update('update clientfidels set point =point+:q ,user=:u ,date=:d,heure=:h where num=:i', ['u'=>$user,'q'=>$point,'i'=>$numclient,'d'=>$dat,'h'=>$time]);
            }   
        }else{
            $qt=$request[2];
            $totalligne = $pu*$qt;
            $data=array('numclient'=>$numclient,'name'=>$name,"codep"=>$codep,"pu"=>$pu,"qt"=>$qt,"totalligne"=>$totalligne,'user'=>$user,'img'=>$img,"numc"=>$numc,"date"=>date('Y-m-d'),"heure"=>date('H:i:s'));
            DB::table('commandes')->insert($data);
            if($numclient != 0){
                $point = $pu*$request[2]*0.5;
                DB::update('update clientfidels set point =point+:q ,user=:u ,date=:d,heure=:h where num=:i', ['u'=>$user,'q'=>$point,'i'=>$numclient,'d'=>$dat,'h'=>$time]);
            }   
        }
        DB::update('update stocks set qt =qt-:q  where id=:i', ['q'=>$request[2],'i'=>$request[0][0]['id']]);
        return response(['message' => 'Product inserted'], 201);
    }




    public function deletebenificeofcommande($numclient,$numcommande,$user){
        if($numclient != 0){
            $res = DB::select('select * from benefcommandes where numcommande=:n ', ['n'=>$numcommande]);
            if($res){  
                $numbenef=$res[0]->numbenef;
                $result = DB::select('select * from beneficiaries where id=:n ', ['n'=>$numbenef]);
                DB::update('update clientfidels set point =point+:q ,user=:u ,date=:d,heure=:h where num=:i', ['u'=>$user,'q'=>$result[0]->point,'i'=>$numclient,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
                DB::update('update commandes set benef =0 where benef=:n', ['n'=>$numbenef]);
                DB::update('update caisses set benef =0 where benef=:n', ['n'=>$numbenef]);
                DB::update('delete from beneficiaries where id=:i', ['i'=>$numbenef]);   
                DB::update('delete from benefcommandes where numbenef=:i', ['i'=>$numbenef]);  
            }      
        }
    }



    public function AddProdInNiveauCommande(Request $request) {
        $numNiveau=$request[0];
        $numCommand=$request[1];
        $user=$request[2];
        $numclient=$request[3];
        $time=date('H:i:s');
        $dat=date('Y-m-d');
        if($numclient != 0){
            $res = DB::select('select * from beneficiaries where numcommande=:n ', ['n'=>$numCommand]);
            if($res){  
                DB::update('update clientfidels set point =point+:q ,user=:u ,date=:d,heure=:h where num=:i', ['u'=>$user,'q'=>$res[0]->point,'i'=>$res[0]->num,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
                DB::update('delete from beneficiaries where numcommande=:i', ['i'=>$numCommand]);
            }    
        }
        $result = DB::select('select * from commandeNiveaus where numNiveau=:n ', ['n'=>$numNiveau]);
        for ($i = 0; $i < count($result); $i++){
            $results = DB::select('select id,qt from commandes where numc=:n and codep=:c', ['n'=>$numCommand,'c'=>$result[$i]->codep]);
            if($results){
                $qt = $result[$i]->qt+$results[0]->qt;
                $totalligne = $result[$i]->pu*$qt;
                DB::update('update commandes set qt =:q ,totalligne=:t,user=:u ,date=:d,heure=:h where id=:i', ['u'=>$user,'q'=>$qt,'t'=>$totalligne,'i'=>$results[0]->id,'d'=>$dat,'h'=>$time]);
                if($numclient != 0){
                    $point = $result[$i]->pu*$result[$i]->qt*0.5;
                    DB::update('update clientfidels set point =point+:q ,user=:u ,date=:d,heure=:h where num=:i', ['u'=>$user,'q'=>$point,'i'=>$numclient,'d'=>$dat,'h'=>$time]);
                }  
            }else{
                $data=array('name'=>$result[$i]->name,"codep"=>$result[$i]->codep,"pu"=>$result[$i]->pu,"qt"=>$result[$i]->qt,"totalligne"=>$result[$i]->totalligne,'user'=>$user,'img'=>$result[$i]->img,"numc"=>$numCommand,"date"=>date('Y-m-d'),"heure"=>date('H:i:s'));
                DB::table('commandes')->insert($data);
                if($numclient != 0){
                    $point = $result[$i]->pu*$result[$i]->qt*0.5;
                    DB::update('update clientfidels set point =point+:q ,user=:u ,date=:d,heure=:h where num=:i', ['u'=>$user,'q'=>$point,'i'=>$numclient,'d'=>$dat,'h'=>$time]);
                } 
            }
            DB::update('update stocks set qt =qt-:q  where id=:i', ['q'=>$result[$i]->qt,'i'=>$result[$i]->codep]);
            
          
        }
        return response($result, 201);
    }

    



    public function UpdateProduct(Request $request){
        $id = $request[0];
        $qt = $request[1];
        $user = $request[2];
        $numclient = $request[3];
        $numc = $request[4];
        $this->deletebenificeofcommande($numclient,$numc,$user);
       
        $results = DB::select('select codep,qt,pu from commandes where id=:c', ['c'=>$id]);
        if($results){
            $qt = $request[1]+$results[0]->qt;
            $totalligne = $results[0]->pu*$qt;
            $codep=$results[0]->codep;
            DB::update('update commandes set qt =:q ,totalligne=:t,user=:u ,date=:d,heure=:h where id=:i', ['u'=>$user,'q'=>$qt,'t'=>$totalligne,'i'=>$id,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
            DB::update('update stocks set qt =qt-:q  where id=:i', ['q'=>$request[1],'i'=>$codep]);
            if($numclient != 0){
                $point = $results[0]->pu*$request[1]*0.5;
                DB::update('update clientfidels set point =point+:q ,user=:u ,date=:d,heure=:h where num=:i', ['u'=>$user,'q'=>$point,'i'=>$numclient,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
            } 
        }
        return response()->json($id, 200);
    }    






    public function UpdateNumclient(Request $request){
        $numcommande = $request[0];
        $numclient = $request[1];
        $user = $request[2];
        $num = $request[3];
        $this->deletebenificeofcommande($num,$numcommande,$user);
        if($numclient != 0){
            $result = DB::select('select numclient,codep,qt,pu from commandes where numc=:c and numclient=:n', ['c'=>$numcommande,'n'=>$num]);
                for ($i = 0; $i < count($result); $i++){
                    $point = $result[$i]->pu*$result[$i]->qt*0.5;
                    DB::update('update clientfidels set point =point-:q ,user=:u ,date=:d,heure=:h where num=:i', ['u'=>$user,'q'=>$point,'i'=>$num,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
                    DB::update('update clientfidels set point =point+:q ,user=:u ,date=:d,heure=:h where num=:i', ['u'=>$user,'q'=>$point,'i'=>$numclient,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
                } 
                DB::update('update commandes set numclient=:t,user=:u ,date=:d,heure=:h where  numc=:q ', ['u'=>$user,'q'=>$numcommande,'t'=>$numclient,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
                          
        }else{
            $result = DB::select('select numclient,codep,qt,pu from commandes where numc=:c and numclient=:n', ['c'=>$numcommande,'n'=>$num]);
            for ($i = 0; $i < count($result); $i++){
                $point = $result[$i]->pu*$result[$i]->qt*0.5;
                DB::update('update clientfidels set point =point-:q ,user=:u ,date=:d,heure=:h where num=:i', ['u'=>$user,'q'=>$point,'i'=>$num,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
            } 
            DB::update('update commandes set numclient=0,user=:u ,date=:d,heure=:h where  numc=:q ', ['u'=>$user,'q'=>$numcommande,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
                     
        }  
        return response()->json($result, 200);
    }    





    public function selectLastClient(){
        $value1=0;
        $results = DB::select('select numcommande from sessions ');
        $res = DB::select('select * from commandes where numc= (?)  order by date DESC, heure DESC', [$results[0]->numcommande]);
        $value1=(int)$results[0]->numcommande;
        if($res){
            $value1++;
            if($results!=NULL){ 
                DB::update('update sessions set numcommande = ?', [$value1]);
            }else{
                $value1=1;
                DB::insert('insert into sessions (numcommande) values (?)', [$value1]); 
            }
        }

        return response($value1, 200);
    } 
   




    public function getCommande(Request $request){
        $numcommande = $request[0];
        $numclient = $request[1];
        $resultssession = DB::select('select numcommande from sessions ');
        if($numcommande <= $resultssession[0]->numcommande){
            $results = DB::select('select * from commandes where numc= (?)  order by date DESC, heure DESC', [$numcommande]);
            $client=0;
            if($results){
                $client = DB::select('select * from clientfidels where num= (?) ', [$results[0]->numclient]);
            }else{
                $client = DB::select('select * from clientfidels where num= (?) ', [$numclient]);
                
            }
            $prod = array();
            $path="http://localhost:8000/image/";
            $prod []=$results;
            $prod []=$path;
            if($client){
                $prod []=$client;
            }else{
                $prod[]=null;
            }
            $res = DB::select('select * from benefcommandes where numcommande=:n ', ['n'=>$numcommande]);
            if($res){
                $prod[]=false;
            }else{
                $prod[]=true;
            }
            return response()->json($prod, 200);
        }
        return response(null, 200);
    }


    public function getCommandeinvoice($id){
        $numcommande = $id;
      
            $results = DB::select('select * from commandes where numc= (?)  order by date DESC, heure DESC', [$numcommande]);

            return response()->json($results, 200);
    }



  
    public function deleteProductOfCommand(Request $request){
        $id = $request[0];
        $numclient = $request[1];
        $user = $request[2];
        $Commande= Commande::find($id);
        $qt=$Commande->qt;
        $pu=$Commande->pu;
        $codep=$Commande->codep;
        if(is_null($Commande)) {
            return response()->json($request, 404);
        }
        $this->deletebenificeofcommande($numclient,$Commande->numc,$user);
        if($numclient != 0){
            $point = $pu*$qt*0.5;
            DB::update('update clientfidels set point =point-:q ,user=:u ,date=:d,heure=:h where num=:i', ['u'=>$user,'q'=>$point,'i'=>$numclient,'d'=>date('Y-m-d'),'h'=>date('H:i:s')]);
        } 
        $Commande->delete();
        DB::update('update stocks set qt =qt+:q  where id=:i', ['q'=>$qt,'i'=>$codep]);
        return response()->json(null, 204);
    }    






    public function videCommande(Request $request){
        $id = $request[0];
        $numclient = $request[1];
        $user = $request[2];
            $result = DB::select('select * from caisses ');
            for ($i = 0; $i < count($result); $i++){
                DB::update('update stocks set qt =qt-:q  where id=:i', ['q'=>$result[$i]->qt,'i'=>$result[$i]->codep]);
            }               
        
        
        return response()->json($result, 200);
    }    

}
