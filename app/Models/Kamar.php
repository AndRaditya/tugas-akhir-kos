<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function kamar_photos()
    {
        return $this->hasMany(KamarPhotos::class);
    }

    public function kamar_fasilitas()
    {
        return $this->hasMany(KamarFasilitas::class);
    }

    public function kos_booking()
    {
        return $this->belongsTo(KosBooking::class);
    }


}