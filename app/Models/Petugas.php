<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    public $timestamps=false;

    protected $table="petugas";
    protected $primaryKey="id_petugas";
    protected $fillable=[
        'username',
        'password',
        'nama_petugas',
        'nomor_hp',
    ];
}
