<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use App\Qrproduct;

class SimpleQRcodeController extends Controller
{
    public function generate () {
       
        $numbers = array();
        for ($i = 0; $i < 40; $i++){
            $x=(string)rand(1, 99999);
            $result = DB::select('select * from clientfidels where num=:c', ['c'=>$x]);
            if($result){
                $i--;
            }else{
                $numbers []=$x;
            }
        }    
        return response()->json($numbers, 200);
    	
    }

    
    public function AddProdInProductQR(Request $request) {
        $codep = $request[0][0]['codep'];
        $name = $request[0][0]['name'];
        $img = $request[0][0]['img'];
        $type=$request[1];
        $color=$request[2];
        $user=$request[3];
        $date=date('Y-m-d');

            $data=array('name'=>$name,'img'=>$img,"codep"=>$codep,"type"=>$type,'user'=>$user,"color"=>$color,"date"=>$date,"heure"=>date('H:i:s'));
            DB::table('QRproducts')->insert($data);
        
        return response($data, 200);
    }


  
    
        //get all Products
    public function getProductQR(Request $request) {
       $type=$request[0];
        $results = DB::select('select * from QRproducts where type= (?) order by date DESC, heure DESC', [$type]);
        $path="http://localhost:8000/image/";
        $prod []=$results;
        $prod []=$path;
        return response()->json($prod, 200);
    }


    public function getProductTypes() {
         $results = DB::select('select distinct(type) from QRproducts  order by date DESC, heure DESC');
        
         return response()->json($results, 200);
    }


    public function deleteProductQR(Request $request,$id){
        
        $Facture= Qrproduct::find($id);
        if(is_null($Facture)) {
            return response()->json($request, 404);
        }
        $Facture->delete();
        return response()->json(null, 204);
    }    

}
