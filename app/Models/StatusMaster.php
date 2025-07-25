<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusMaster extends Model
{
    use HasFactory;

    protected $table = 'status_master';
    public $timestamps = false;

    protected $fillable = ['nama_status', 'urutan'];
}
