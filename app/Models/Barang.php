<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    public $timestamps=false;

    protected $table="barang";
    protected $primaryKey="id_barang";
    protected $fillable=[
        'nama_barang',
        'gambar',
        'tgl_daftar',
        'harga_awal',
        'deskripsi_barang',
    ];
}
