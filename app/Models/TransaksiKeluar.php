<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKeluar extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $dates = ['tanggal'];

    public function transaksi_keluar_kategori()
    {
        return $this->hasOne(TransaksiKeluarKategori::class,'id','transaksi_keluar_kategori_id');
    }
}