<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\models\Barang;
use Carbon\Carbon;
use DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barangs = DB::table('barang')->get();
        return view('barang',compact('barangs'));
        // return response()->json(['data'=>$barangs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('barang-tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'       => 'required',
            // 'gambar'            => 'required',
            'harga_awal'        => 'required',
            'deskripsi_barang'  => 'required',
        ]);

        // dd($request);

        // if ($request->fails()) {
        //     error_log;
        // }

        $save = new Barang;
        $save->nama_barang = $request->nama_barang;
        $save->gambar = $request->gambar;
        $save->tgl_daftar = Carbon::now();
        $save->harga_awal = $request->harga_awal;
        $save->deskripsi_barang = $request->deskripsi_barang;

        if($request->file('gambar')){
            $gambar = $request->file('gambar');
            $name = $gambar->getClientOriginalName();
            $gambar->move('images/post', $name);
            $save->gambar = $name;
        }

        $save->save();

        if ($save) {
            return redirect('/barang');
        }
        
        return redirect()->back()->with('pesan', 'Gagal menambahkan barang');
        
        // $barangs=Barang::all();
        // return redirect('/barang');
        

        // $save=Barang::create($request->all());

        // if ($save) {
        //     return response()->json(['status'=>'berhasil']);
        // } else {
        //     return response()->json(['status'=>'gagal']);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $barangs=Barang::find($id);
        // return view('barang-edit', compact('barangs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $barangs=Barang::find($id);
        return view('barang-edit', compact('barangs'));
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
        $validator=Validator::make($request->all(), [
            'nama_barang'       => 'required',
            'harga_awal'        => 'required',
            'deskripsi_barang'  => 'required',
        ]);
        if ($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $update = Barang::find($id);

        $update->nama_barang        = $request->nama_barang;
        $update->gambar             = $request->gambar != null ? $request->gambar:$update->gambar;
        $update->harga_awal         = $request->harga_awal;
        $update->deskripsi_barang   = $request->deskripsi_barang;

        if($request->file('gambar')){
            $gambar = $request->file('gambar');
            $name = $gambar->getClientOriginalName();
            $gambar->move('images/post', $name);
            $update->gambar = $name;
        }

        $update->update();
        return redirect('/barang');
        // return redirect()->back()
        // $barangs=Barang::all();
        // return view('barang', compact('barangs'));
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Barang::find($id)->delete();
        // $status = $data->delete();
        return redirect('/barang');


        // if ($status) {
        //     return response()->json(['status'=>'Data berhasil dihapus']);
        // } else {
        //     return response()->json(['status'=>'Data gagal dihapus']);
        // }
    }
}
