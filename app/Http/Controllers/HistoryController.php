<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illmunitae\Support\Facades\Validator;
use App\Models\History;
use App\Models\User;
use App\Models\Lelang;
use App\Models\Barang;
use DB;
use Auth;
use PDF;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $history = History::all();
        return view('history', compact('history'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $cek = Barang::all()->first();
        $cek2 = DB::table('history')
                    ->where('history.id_lelang', $request->id_lelang)
                    ->join('lelang', 'history.id_lelang', '=', 'lelang.id_lelang')
                    ->join('barang', 'lelang.id_barang', '=', 'barang.id_barang')
                    ->select('barang.harga_awal')
                    ->first();

        $cek = DB::table('lelang')
                   ->where('id_lelang',$request->id_lelang)
                   ->join('barang','lelang.id_barang','=','barang.id_barang')->first();
        
        if($request->penawaran_harga <= $cek->harga_awal) {
            // return redirect('/lelang')->alert('message','Penawaran harga tidak boleh kurang atau sama dengan harga awal!!!');
            return redirect()->back()->with('warning', 'Penawaran harga tidak boleh KURANG atau SAMA DENGAN harga awal!!!');

        }else{
        $save = new History;

        $save->id_lelang = $request->id_lelang; 
        // $save->id_pengguna = $request->id_pengguna;
        $save->id_pengguna = Auth::user()->id;
        $save->penawaran_harga = $request->penawaran_harga;

        $save->save();
        // return redirect('/lelang');
        return redirect()->back();

        // if($save){
        //     return response()->json(['message'=>'Data berhasil ditambah']);
        // }else{
        //     return response()->json(['message'=>'Data gagal ditambah']);
        // }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $lelangd=DB::table('lelang')->select('*')->where('id_lelang', $id)->first();
        // $barangd=DB::table('barang')->where('id_barang', $lelangd->id_barang)->get();
        // $userd=DB::table('users')->where('id', $lelangd->id_pengguna)->get();

        $detail=DB::table('lelang')->leftJoin('barang', 'lelang.id_barang', 'barang.id_barang')
                                   ->leftJoin('users', 'lelang.id_pengguna', 'users.id')
                                   ->where('lelang.id_lelang', '=', $id)
                                   ->select('*')
                                   ->first();

        $historyd=DB::table('history')->leftJoin('users', 'history.id_pengguna', 'users.id')
                                      ->select('users.*', 'history.*')
                                      ->where('history.id_lelang', '=', $id)
                                      ->orderBy('history.penawaran_harga', 'DESC')
                                      ->get();

        // return response()->json(['data'=>$detail, $barang]);
        // dd($detail);
        return view('lelang-detail', compact('detail', 'historyd'));
    }

    public function status($id)
    {
        DB::table('history')->where('id_history',$id)->update([
            'status_pemenang' =>'menang'
        ]);

        $cek = DB::table('history')->where('id_history',$id)->first();
        
        $id_lelang = $cek->id_lelang;

        DB::table('history')->where('id_lelang',$id_lelang)->where('status_pemenang','proses')->update([
            'status_pemenang' =>'kalah'
        ]);

        $ceklagi=DB::table('history')->where('id_history',$id)->first();

        DB::table('lelang')->where('id_lelang',$id_lelang)->update([
            'harga_akhir'=>$ceklagi->penawaran_harga,
            'id_pengguna'=>$ceklagi->id_pengguna,
            'status'=>'ditutup'
        ]);

        $detail=DB::table('lelang')->leftJoin('barang', 'lelang.id_barang', 'barang.id_barang')
                                   ->leftJoin('users', 'lelang.id_pengguna', 'users.id')
                                   ->where('lelang.id_lelang', '=', $id_lelang)
                                   ->select('*')
                                   ->first();

        $historyd=DB::table('history')->leftJoin('users', 'history.id_pengguna', 'users.id')
                                      ->select('users.*', 'history.*')
                                      ->where('history.id_lelang', '=', $id_lelang)
                                      ->orderBy('history.penawaran_harga', 'DESC')
                                      ->get();

        // dd($detail);
        return view('/lelang-detail', compact('detail', 'historyd'));

        // if($ceklagi){
        //     return response()->json(['message'=>'Berhasil']);
        // }else{
        //     return response()->json(['message'=>'Gagal']);
        // }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
