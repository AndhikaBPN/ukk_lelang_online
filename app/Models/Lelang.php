<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lelang extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table="lelang";
    protected $primaryKey="id_lelang";
    protected $fillable=[
        'id_barang',
        'tgl_lelang',
        'harga_akhir',
        'id_pengguna',
        'id_petugas',
        'status',
    ];

    public function barang()
    {
        return $this->belongsto('App\Models\Barang', 'id_barang', 'id_barang');
    }

    public function user()
    {
        return $this->belongsto('App\Models\User', 'id_pengguna', 'id');
    }
}
