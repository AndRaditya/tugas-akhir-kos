<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KosBuktiTransfer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];

    public function kos_booking()
    {
        return $this->belongsTo(KosBooking::class);
    }
    
    public function transaksi_masuk()
    {
        return $this->belongsTo(TransaksiMasuk::class);
    }
}