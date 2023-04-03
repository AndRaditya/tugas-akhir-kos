<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kos extends Model
{
    protected $guarded = ["id"];

    public function kos_fasilitas()
    {
        return $this->hasMany(KosFasilitas::class);
    }

    public function kamar_spesifikasi()
    {
        return $this->hasMany(KamarSpesifikasi::class);
    }

    public function kos_photos()
    {
        return $this->hasMany(KosPhotos::class);
    }
}