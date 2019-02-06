<?php

use Illuminate\Database\Seeder;

class MasterActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_activity_type')->insert([
            'name' => 'Lihat Senarai'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Lihat Maklumat'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Papar Modal (Popup)'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Tambah Data'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Kemaskini Data'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Padam Data'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Log Masuk'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Log Keluar'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Buka Paparan'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'API'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Hantar Permohonan'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Terima Dokumen Fizikal'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Kuiri'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Ulasan / Syor'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Tangguh'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Buat Keputusan'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Laporan'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Cetak Surat'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Cetak Dokumen'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Kemaskini Status Permohonan'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Buat Keputusan (Menteri)'
        ]);

        DB::table('master_activity_type')->insert([
            'name' => 'Maklum Balas'
        ]);
    }
}
