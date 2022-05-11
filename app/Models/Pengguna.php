<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;

    public $timestamps=false;

    protected $table="pengguna";
    protected $primaryKey="id_pengguna";
    protected $fillable=[
        'username',
        'password',
        'nama_pengguna',
        'nomor_hp',
        'alamat',
    ];
    

}
