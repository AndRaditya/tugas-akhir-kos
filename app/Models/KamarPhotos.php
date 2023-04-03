<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KamarPhotos extends Model
{
    use HasFactory;

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
}
