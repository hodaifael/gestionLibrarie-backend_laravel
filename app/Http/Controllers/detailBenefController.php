<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caisse;
use Illuminate\Support\Facades\DB;


class detailBenefController extends Controller
{
    public function detailcaisses($numclient) {
        $results = DB::select('select * from caisses where numclient= (?) order by date DESC, time desc', [$numclient]);
        $prod = array();
        $path="http://localhost:8000/image/";
        $prod []=$results;
        $prod []=$path;
        return response()->json($prod, 200);
    }

    public function detailcommandes($numclient) {
        $prod = array();
        $path="http://localhost:8000/image/";
        $results = DB::select('select * from beneficiaries where num=:c  order by date DESC, heure DESC',[':c'=>$numclient]);
        $res = DB::select('select  distinct numc from commandes where numclient=:c and benef =0 order by date DESC, heure desc', [':c'=>$numclient]);
        $prod []=$results;
        $prod []=$res;
        return response()->json($prod, 200);
    }
}
