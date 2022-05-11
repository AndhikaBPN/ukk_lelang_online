<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Lelang;
use App\Models\Barang;
use DB;

class LelangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lelangs=Lelang::all();
        // return response()->json(['data'=>$lelang]);
        return view('lelang', compact('lelangs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $databarang = DB::table('barang')
                          ->select('*')
                          ->get();
        
        
        return view('/lelang-tambah', compact('databarang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $cek = DB::table('lelang')
                 ->where('lelang.id_barang',$request->id_barang)
                 ->where('status','dibuka')
                 ->join('barang','lelang.id_barang','=','barang.id_barang')
                 ->get();
        $cek2=count($cek);
        
        if($cek2 == 1){
        return response()->json(['status'=>'gagal']);

        }else{
            $save = new Lelang;

            $save->id_barang = $request->id_barang;
            $save->tgl_lelang = Carbon::now();
            $save->id_petugas = auth()->user()->id;
            $save->id_pengguna = $request->id_pengguna;
            $save->harga_akhir = $request->harga_akhir;
    
            $save->save();
        
            // return response()->json(['status'=>'Berhasil']);
            return redirect('/lelang');
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
        $lelang = Lelang::find($id);
        return response()->json(['data'=>$lelang]);
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
        // 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Lelang::find($id);
        $data->delete();

        if ($data) {
            return response()->json(['status'=>'Data berhasil dihapus']);
        } else {
            return response()->json(['status'=>'Data gagal dihapus']);
        }
    }
}
