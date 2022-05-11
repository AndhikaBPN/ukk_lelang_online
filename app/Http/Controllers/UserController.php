<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lelang;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Auth;
use DB;
use Alert;

class UserController extends Controller
{
    public function login(Request $req)
    {
        // dd($req->all());
        $credentials = $req->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('/dashboard')->with('message', 'Berhasil Login');
        }

        return redirect()->back()->with('alert', 'Email atau password salah!');
        // Alert::warning('Warning Title', 'Warning Message');

        // try{
        //     if(! $token = JWTAuth::attempt($credentials)){
        //         return response()->json(['error'=>'invalid_credentials'], 400);
        //         return response()->json(['error'=>'Username atau Password anda salah']);
        //     }
        // }catch (JWTException $e){
        //     return response()->json(['error'=>'could_not_create_token'], 500);
        // }

        // return response()->json(compact('token'));
        
        // return view('index');
    }

    public function login1(Request $req)
    {
        $credentials = $req->only('username', 'password');

        try{
            if(! $token = JWTAuth::attempt($credentials)){
                return response()->json(['error'=>'invalid_credentials'], 400);
                return response()->json(['error'=>'Username atau Password anda salah']);
            }
        }catch (JWTException $e){
            return response()->json(['error'=>'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));

    }

    public function register(Request $req)
    {

        $req->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|min:11',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $user = new User;
        $user->nama = $req->nama;
        $user->alamat = $req->alamat;
        $user->no_hp = $req->no_hp;
        $user->username = $req->username;
        $user->password = Hash::make($req->get('password'));
        $user->role = 'admin';
        $user->save();

        $token = JWTAuth::fromUser($user);

        if ($user) {
            return redirect('/');
        } else {
            return redirect()->back()->with('message-simpan', 'Gagal membuat akun, masukkan data dengan lengkap!');
        }
        

        // return response()->json(compact('user', 'token'), 201);
        // return redirect('/')->with('message-simpan', 'Berhasil Membuat Akun');
    }

    public function register1(Request $req)
    {

        $req->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|min:11',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:4',
        ]);

        $user = new User;
        $user->nama = $req->nama;
        $user->alamat = $req->alamat;
        $user->no_hp = $req->no_hp;
        $user->username = $req->username;
        $user->password = Hash::make($req->get('password'));
        $user->role = 'petugas';
        $user->save();

        // $token = JWTAuth::fromUser($user);

        // return response()->json(compact('user', 'token'), 201);
        return redirect('/petugas')->with('message-simpan', 'Berhasil Membuat Akun');
    }

    public function register2(Request $req)
    {

        $req->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|min:11',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:4',
        ]);

        $user = new User;
        $user->nama = $req->nama;
        $user->alamat = $req->alamat;
        $user->no_hp = $req->no_hp;
        $user->username = $req->username;
        $user->password = Hash::make($req->password);
        $user->role = 'pengguna';

        $user->save();

        if ($user) {
            return redirect('/');
        } else {
            return redirect()->back()->with('message', 'Gagal membuat akun, masukkan data dengan lengkap!');
        }

        // $token = Auth::user($user);

        // return redirect('/')->with('message-simpan', 'Berhasil Membuat Akun');
    }    

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }

    public function getprofile()
    {
    	return response()->json(['data'=>JWTAuth::user()]);
    }
    
    public function getprofileadmin()
    {
        return response()->json(['data'=>JWTAuth::user()]);
    }

    public function logout(Request $req)
    {
        // if(JWTAuth::invalidate(JWTAuth::getToken())){
        //     return response()->json(['message'=>'Anda sudah log out']);
        //     return view('login');
        // }else{
        //     return response()>json(['message'=>'Anda gagal log out']);
        // }

        Auth::logout();
        return view('login');
    }

    // Admin
    public function showadmin()
    {
        $admins = User::all()->where('role', 'admin');
        return view('admin', compact('admins'));
    }

    public function showeditadmin($id)
    {
        $admins1 = User::find($id);

        return view('/admin-edit', compact('admins1'));
        // return view('/admin');
    }

    public function editadmin(Request $req, $id)
    {
        $req->validate([
            'nama'      => 'required',
            'no_hp'     => 'required',
            'alamat'    => 'required',
            'username'  => 'required',
        ]);

        $update=User::find($id);
        $update->nama       = $req->nama;
        $update->no_hp      = $req->no_hp;
        $update->alamat     = $req->alamat;
        $update->username   = $req->username;
        $update->update();

        $admins = User::all()->where('role', 'admin');
        
        return redirect('/admin');
    }

    public function hapusadmin($id)
    {
        $destroy=User::find($id)->delete();
        $admins = User::all()->where('role', 'admin');
        return view('admin', compact('admins'));
    }

    // Petugas
    public function showpetugas()
    {
        $petugas = User::all()->where('role', 'petugas');
        return view('petugas', compact('petugas'));
    }

    public function showeditpetugas($id)
    {
        $petugas1 = User::find($id);

        return view('/petugas-edit', compact('petugas1'));
        // return view('/admin');
    }

    public function editpetugas(Request $req, $id)
    {
        $req->validate([
            'nama'      => 'required',
            'no_hp'     => 'required',
            'alamat'    => 'required',
            'username'  => 'required',
        ]);

        $update=User::find($id);
        $update->nama       = $req->nama;
        $update->no_hp      = $req->no_hp;
        $update->alamat     = $req->alamat;
        $update->username   = $req->username;
        $update->update();

        $petugas = User::all()->where('role', 'petugas');
        return redirect('/petugas');
    }

    public function hapuspetugas($id)
    {
        $destroy=User::find($id)->delete();
        $petugas = User::all()->where('role', 'petugas');
        return view('petugas', compact('petugas'));
    }
    // Pengguna
    public function showpengguna()
    {
        $pengguna = User::all()->where('role', 'pengguna');
        return view('pengguna', compact('pengguna'));
    }

    public function showeditpengguna($id)
    {
        $pengguna1 = User::find($id);

        return view('/pengguna-edit', compact('pengguna1'));
        // return view('/admin');
    }

    public function editpengguna(Request $req, $id)
    {
        $req->validate([
            'nama'      => 'required',
            'no_hp'     => 'required',
            'alamat'    => 'required',
            'username'  => 'required',
        ]);

        $update=User::find($id);
        $update->nama       = $req->nama;
        $update->no_hp      = $req->no_hp;
        $update->alamat     = $req->alamat;
        $update->username   = $req->username;
        $update->update();

        $pengguna = User::all()->where('role', 'pengguna');
        return redirect('/pengguna');
    }

    public function hapuspengguna($id)
    {
        $destroy=User::find($id)->delete();
        $pengguna = User::all()->where('role', 'pengguna');
        return view('pengguna', compact('pengguna'));
    }

    // Halaman Login
    public function halamanlogin(){
        return view ('login');
    }
}
