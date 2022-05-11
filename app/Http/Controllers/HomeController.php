<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\History;
use App\models\User;
use App\models\Barang;
use App\models\Lelang;
use DB;
use PDF;

class HomeController extends Controller
{
    public function getAll()
    {
        $lelangs11=Lelang::all();
        return compact('lelangs11');
    }

    public function getId(Request $req, $id)
    {
        $detaild=Lelang::join('users', 'lelang.id_petugas', 'users.id')
                         ->select('*')
                         ->get();

        $historyd=DB::table('history')->where('history.id_lelang', '=', $id)
                                      ->join('lelang', 'history.id_lelang', 'lelang.id_lelang')
                                      ->join('barang', 'lelang.id_barang', 'barang.id_barang')
                                      ->join('users', 'history.id_pengguna', 'users.id')
                                      ->select('*')
                                      ->get();

        return view('report', compact('detaild', 'historyd'));
    }

    public function download($id)
    {
        $historyd=History::all();
        $pdf=PDF::loadView('report', compact('historyd'))->setOptions(['defaultFont' => 'sans-serif']);;
        return $pdf->download('history.pdf');
    }

    public function jmlh()
    {
        $count1=DB::table('users')->where('role', 'admin')->count();
        $count2=DB::table('users')->where('role', 'petugas')->count();
        $count3=DB::table('users')->where('role', 'pengguna')->count();
        $lelang=DB::table('lelang')->count();
        $lelang1=Lelang::all();
        
        return view('index', compact('count1', 'count2', 'count3', 'lelang', 'lelang1'));
        // dd($lelang1);
    }

    // public function datalelang()
    // {
    //     $lelang=Lelang::all();
    //     return view('index-1', compact('lelang'));
    // }
}
