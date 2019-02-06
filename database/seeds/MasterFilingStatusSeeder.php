<?php

use Illuminate\Database\Seeder;

class MasterFilingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_filing_status')->insert([
            'name' => 'Draf'
        ]);

        DB::table('master_filing_status')->insert([
            'name' => 'Telah Dihantar'
        ]);

        DB::table('master_filing_status')->insert([
            'name' => 'Perlu Diproses'
        ]);

        DB::table('master_filing_status')->insert([
            'name' => 'Dalam Proses'
        ]);

        DB::table('master_filing_status')->insert([
            'name' => 'Kuiri'
        ]);

        DB::table('master_filing_status')->insert([
            'name' => 'Disyorkan'
        ]);

        DB::table('master_filing_status')->insert([
            'name' => 'Tangguh'
        ]);

        DB::table('master_filing_status')->insert([
            'name' => 'Tidak Lulus'
        ]);

        DB::table('master_filing_status')->insert([
            'name' => 'Lulus'
        ]);

        DB::table('master_filing_status')->insert([
            'name' => 'Selesai'
        ]);

        DB::table('master_filing_status')->insert([
            'name' => 'Lulus + Tidak Lulus'
        ]);

        DB::table('master_filing_status')->insert([
            'name' => 'Diperakukan'
        ]);
    }
}
