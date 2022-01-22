<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\stocksglobal;
use Illuminate\Support\Facades\DB;


class stockController extends Controller
{

    //get all Products
    public function getProduct() {
            $prod = array();
            $results = DB::select('select * from stocks ');
            $path="http://localhost:8000/image/";
            $prod []=$results;
            $prod []=$path;
        return response()->json($prod, 200);
    }
    public function getProductglobal() {
        $prod = array();
        $results = DB::select('select * from stocksglobals ');
        $path="http://localhost:8000/image/";
        $prod []=$results;
        $prod []=$path;
        return response()->json($prod, 200);
    }

    //get single Product
    public function getProductById($id) {
        $Stock = Stock::find($id);
        if(is_null($Stock)) {
            return response()->json(['message' => 'Product Not Found'], 404);
        }
        return response()->json($Stock::find($id), 200);
    }

    //insert Product
    public function addProduct(Request $request) {
        $array = json_decode($request->input('prod'), true);

        $codep = $array['codep'];
        $name = $array['name'];
        $pu = $array['pu'];
        $pht = $array['pht'];
        $type = $array['type'];


        $file=$request->file('file');
        $uploadPath="image/";
        $originalImage=$file->getClientOriginalName();
        $imagename=date("Y-m-d-H-i-s").$originalImage;
        $file->move($uploadPath,$imagename);
        $data=array('name'=>$name,"codep"=>$codep,"pu"=>$pu,"pht"=>$pht,'type'=>$type,'img'=>$imagename);
        DB::table('stocks')->insert($data);
        DB::table('stocksglobals')->insert($data);

        return response()->json($array, 201);
    }
    public function duplicate(Request $request) {
        
        $results = DB::select('select * from stocks where id=:n',['n'=>$request[1]]);
        $codep = $request[0]['codep'];
        $name = $request[0]['name'];
        $pu = $request[0]['pu'];
        $pht = $request[0]['pht'];
        $type = $request[0]['type'];
        $imagename=$results[0]->img;
        $data=array('name'=>$name,"codep"=>$codep,"pu"=>$pu,"pht"=>$pht,'type'=>$type,'img'=>$imagename);
        DB::table('stocks')->insert($data);
        DB::table('stocksglobals')->insert($data);

        return response()->json($results, 201);
    }
    //update Product
    public function updateProduct(Request $request) {
        $array = json_decode($request->input('prod'), true);

        $codep = $array['codep'];
        $name = $array['name'];
        $pu = $array['pu'];
        $pht = $array['pht'];
        $type = $array['type'];
        $id=$request->input('prodId');

        $file=$request->file('file');
        $uploadPath="image/";
        $originalImage=$file->getClientOriginalName();
        $imagename=date("Y-m-d-H-i-s").$originalImage;
        $file->move($uploadPath,$imagename);
        DB::update('update stocks set name=:n,codep=:c,pu=:pu,pht=:pht,type=:t,img=:img where id=:i', ['n'=>$name,'c'=>$codep,'pu'=>$pu,'pht'=>$pht,'t'=>$type,'img'=>$imagename,'i'=>$id]);
        DB::update('update stocksglobals set name=:n,codep=:c,pu=:pu,pht=:pht,type=:t,img=:img where id=:i', ['n'=>$name,'c'=>$codep,'pu'=>$pu,'pht'=>$pht,'t'=>$type,'img'=>$imagename,'i'=>$id]);

        return response($request, 200);
    }

    public function editProduct(Request $request) {
        $id=$request[0];
        DB::update('update stocks set name=:n,codep=:c,pu=:pu,pht=:pht,type=:t where id=:i', ['n'=>$request[1]['name'],'c'=>$request[1]['codep'],'pu'=>$request[1]['pu'],'pht'=>$request[1]['pht'],'t'=>$request[1]['type'],'i'=>$id]);
        DB::update('update stocksglobals set name=:n,codep=:c,pu=:pu,pht=:pht,type=:t where id=:i', ['n'=>$request[1]['name'],'c'=>$request[1]['codep'],'pu'=>$request[1]['pu'],'pht'=>$request[1]['pht'],'t'=>$request[1]['type'],'i'=>$id]);
        return response($request, 200);
    }



     //delete Product
     public function deleteProduct(Request $request, $id) {
        $Stock = Stock::find($id);
        $Stockglobal = stocksglobal::find($id);
        if(is_null($Stock)) {
            return response()->json(['message' => 'Product Not Found'], 404);
        }
        $Stock->delete();
        $Stockglobal->delete();
        return response()->json(null, 204);
    }

    //cree new code produit
    public function selectLastCodep(){
        $results = DB::select('select codep from sessions ');
        if($results!=NULL){
            $value1=(int)$results[0]->codep;
            $value1++;
            DB::update('update sessions set codep = ?', [$value1]);
        }else{
            $value1=1;
            DB::insert('insert into sessions (codep) values (?)', [$value1]); 
        }

        return response($value1, 200);
    } 
}
