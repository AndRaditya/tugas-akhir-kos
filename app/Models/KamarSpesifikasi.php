<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KamarSpesifikasi extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }
}