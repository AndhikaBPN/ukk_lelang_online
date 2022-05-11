<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    public $timestamps=false;

    protected $table="admin";
    protected $primaryKey="id_admin";
    protected $fillable=[
        'username',
        'password',
        'nama_admin',
    ];
}
