<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PelangganProfile extends Model
{
    protected $table = 'pelanggan_profiles';

    protected $fillable = [
        'user_id',
        'alamat',
        'no_telepon',
        'foto_profil',
        'latitude',
        'longitude',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
