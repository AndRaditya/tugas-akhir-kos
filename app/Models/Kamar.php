<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $guarded = ["id"];

    public function kamar_photos()
    {
        return $this->hasMany(KamarPhotos::class);
    }

    public function kamar_fasilitas()
    {
        return $this->hasMany(KamarFasilitas::class, 'kamar_id', 'id');
    }

    public function kos_booking()
    {
        return $this->belongsTo(KosBooking::class);
    }

    public function kos(){
        return $this->hasOne(Kos::class);
    }


}