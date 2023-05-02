<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KosBooking extends Model
{
    protected $guarded = ["id"];

    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class,'id', 'users_id');
    }

    public function kamar()
    {
        return $this->hasMany(Kamar::class,'id', 'kamar_id');
    }

    public function bukti_transfer()
    {
        return $this->hasOne(KosBuktiTransfer::class);
    }


}