<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pakets = DB::table('pakets')->get();

        return view('paket.index', compact('pakets'));

        // dd($pakets);
    }

    public function detail($id)
    {
        $paket = Paket::where('id', $id)->first();

        return view('paket.detail', compact('paket'));

        // dd($paket);
    }

    public function add()
    {
        return view('admin.paket.add');
    }

    public function addprocess(Request $request)
    {

        $request->validate([
            'nama_paket' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:255'],
            'jenis' => ['required'],
            'harga' => ['required', 'integer']
        ]);


        $post = new Paket;
        $post->nama_paket = $request->nama_paket;
        $post->deskripsi = $request->deskripsi;
        $post->jenis = $request->jenis;
        $post->harga = $request->harga;

        // Input Gambar
        if($request->file('gambar')){
            $gambar = $request->file('gambar');
            $name = $gambar->getClientOriginalName();
            $gambar->move('images/post', $name);
            $post->gambar = $name;
        }

        $post->save();

        return redirect('paket')->with('status', 'Paket Bertambah!');
        // dd($request->all());
    }

    public function editview()
    {
        $pakets = DB::table('pakets')->get();

        return view('admin.paket.edit', compact('pakets'));

        // dd($pakets);
    }

    public function edit($id)
    {
        $pakets = DB::table('pakets')->where('id', $id)->first();

        return view('admin.paket.editdetail', compact('pakets'));
        // dd($pakets);
    }
    public function editprocess(Request $request, $id)
    {
        $request->validate([
            'nama_paket' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:255'],
            'jenis' => ['required'],
            'harga' => ['required', 'integer']
        ]);

        $post = Paket::findorfail($id);
        $post->nama_paket = $request->nama_paket;
        $post->deskripsi = $request->deskripsi;
        $post->jenis = $request->jenis;
        $post->harga = $request->harga;

        // Input Gambar
        if($request->file('gambar')){
            $gambar = $request->file('gambar');
            $name = $gambar->getClientOriginalName();
            $gambar->move('images/post', $name);
            $post->gambar = $name;
        }

        $post->update();

        return redirect('paket/edit')->with('status', 'Paket Diubah!');
        // dd($request->all());

    }

    public function destroy()
    {
        $pakets = DB::table('pakets')->get();

        return view('admin.paket.delete', compact('pakets'));

        // dd($pakets);
    }

    public function destroyprocess($id)
    {
        DB::table('pakets')->where('id', $id)->delete();
        return redirect('paket/delete')->with('status', 'Paket Dihapus!');
    }
}
