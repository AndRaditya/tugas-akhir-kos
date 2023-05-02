<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransaksiMasuk_KeluarKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('transaksi_masuk_kategoris')->delete();

        \DB::table('transaksi_masuk_kategoris')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Bayar 1 Bulan',
                'created_at' => '2023-05-02 16:04:00',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Bayar 2 Bulan',
                'created_at' => '2023-05-02 16:04:00',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Bayar 3 Bulan',
                'created_at' => '2023-05-02 16:04:00',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Bayar 6 Bulan',
                'created_at' => '2023-05-02 16:04:00',
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Bayar 12 Bulan',
                'created_at' => '2023-05-02 16:04:00',
                'updated_at' => NULL,
            ),
        ));

        \DB::table('transaksi_keluar_kategoris')->delete();

        \DB::table('transaksi_keluar_kategoris')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Gaji Bulanan',
                'created_at' => '2023-05-02 16:04:00',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Perbaikan',
                'created_at' => '2023-05-02 16:04:00',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Perawatan',
                'created_at' => '2023-05-02 16:04:00',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Lain-lain',
                'created_at' => '2023-05-02 16:04:00',
                'updated_at' => NULL,
            ),
        ));

    }
}