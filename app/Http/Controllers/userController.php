<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;


class userController extends Controller
{
     //get all Users
     public function getusers() {
        return response()->json(User::all(), 200);
    }


    //get single Product
    public function getuserById($id) {
        $User = User::find($id);
        if(is_null($User)) {
            return response()->json(['message' => 'Product Not Found'], 404);
        }
        return response()->json($User::find($id), 200);
    }

    //insert User
    public function adduser(Request $request) {
        $User = User::create($request->all());
        return response($User, 201);
    }

    //delete User
    public function deleteusers(Request $request, $id) {
        $User = User::find($id);
        if(is_null($User)) {
            return response()->json(['message' => 'Product Not Found'], 404);
        }
        $User->delete();
        return response()->json(null, 204);
    }

    public function auth(Request $request){
        $results = DB::select('select * from users where numuser=:n and password=:c', ['n'=>$request[0],'c'=>$request[1]]);
        if($results){
            return response()->json($results, 201);
        }else{
            return response()->json(null, 204);
        }

    }
    public function updatepass(Request $request){
        $results = DB::select('select * from users where email=:n ', ['n'=>$request[0]]);
        if($results){
            DB::update('update users set password =:q  where id=:i', ['q'=>$request[1],'i'=>$results[0]->id]);
            return response()->json($results, 201);
        }else{
            return response()->json($request, 201);
        }
    }
}
