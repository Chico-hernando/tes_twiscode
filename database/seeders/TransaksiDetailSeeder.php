<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class transaksiDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transaksi_detail')->delete();

        DB::table('transaksi_detail')->insert([
            'id_transaksi' => 1,
            'harga' => 5000,
            'jumlah' => 3,
            'subtotal' => 15000
        ]);
    }
}
