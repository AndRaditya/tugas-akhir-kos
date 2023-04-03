<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiMasuk extends Model
{
    use HasFactory;

    public function transaksi_masuk_kategori()
    {
        return $this->hasOne(TransaksiMasukKategori::class,'transaksi_masuk_kategori_id','id');
    }

    public function biaya_tambahan()
    {
        return $this->hasMany(BiayaTambahan::class);
    }

    public function bukti_transfer()
    {
        return $this->hasOne(KosBuktiTransfer::class,'kos_bukti_transfer_id','id');
    }

    public function kos_booking()
    {
        return $this->hasOne(KosBooking::class,'kos_booking_id','id');
    }

    public function kamar()
    {
        return $this->hasOne(Kamar::class,'kamar_id','id');
    }

}
