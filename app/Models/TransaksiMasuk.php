<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiMasuk extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function transaksi_masuk_kategori()
    {
        return $this->hasOne(TransaksiMasukKategori::class,'id', 'transaksi_masuk_kategori_id');
    }

    public function biaya_tambahan()
    {
        return $this->hasMany(BiayaTambahan::class);
    }

    public function bukti_transfer()
    {
        return $this->hasOne(KosBuktiTransfer::class,'id', 'kos_bukti_transfer_id');
    }

    public function kos_booking()
    {
        return $this->hasOne(KosBooking::class,'id', 'kos_booking_id');
    }

}