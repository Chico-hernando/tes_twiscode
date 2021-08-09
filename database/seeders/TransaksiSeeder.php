<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transaksi')->delete();

        DB::table('transaksi')->insert([
            'tanggal_order' => now(),
            'status' => 'lunas',
            'tanggal_pembayaran' => now(),
        ]);
    }
}
