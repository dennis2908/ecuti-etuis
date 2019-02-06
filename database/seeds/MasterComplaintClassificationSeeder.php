<?php

use Illuminate\Database\Seeder;

class MasterComplaintClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_complaint_classification')->insert([
            'name' => 'Pertikaian Dalaman'
        ]);

        DB::table('master_complaint_classification')->insert([
            'name' => 'Kesalahan'
        ]);

        DB::table('master_complaint_classification')->insert([
            'name' => 'Mogok/Tutup Pintu'
        ]);

        DB::table('master_complaint_classification')->insert([
            'name' => 'Lain-lain'
        ]);
    }
}
