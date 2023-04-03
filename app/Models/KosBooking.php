<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KosBooking extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class,'users_id','id');
    }

    public function kamar()
    {
        return $this->hasMany(Kamar::class,'kamar_id','id');
    }

    public function bukti_transfer()
    {
        return $this->hasOne(KosBuktiTransfer::class,'kos_bukti_transfer_id','id');
    }


}
