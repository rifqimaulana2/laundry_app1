<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TrackingStatus;

class StatusMaster extends Model
{
    use HasFactory;

    protected $table = 'status_master';

    protected $fillable = [
        'nama_status',
    ];

    public function trackingStatuses()
    {
        return $this->hasMany(TrackingStatus::class);
    }
}