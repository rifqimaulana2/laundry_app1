<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisLayanan extends Model
{
    use HasFactory;

    protected $table = 'jenis_layanan';

    public $timestamps = false;

    protected $fillable = ['nama_layanan'];

    // Relasi-relasi lain bisa ditambahkan jika diperlukan
}
