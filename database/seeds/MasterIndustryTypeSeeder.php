<?php

use Illuminate\Database\Seeder;

class MasterIndustryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_industry_type')->insert([
            'name' => 'Pertanian, Perhutanan dan Perikanan'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Perlombongan dan Pengkuarian'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Pembuatan'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Bekalan Elektrik, Gas, Wap dan Pendingin Udara'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Bekalan Air, Pembentungan, Pengurusan Sisa dan Aktiviti Pemulihan'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Pembinaan'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Perdagangan Jual Borong dan Jual Runcit, Pembaikan Kenderaan Bermotor dan Motosikal'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Pengangkutan dan Penyimpanan'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Penginapan dan Aktiviti Perkhidmatan Makanan Dan Minuman'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Maklumat dan Komunikasi'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Aktiviti Kewangan dan Insuran/Takaful'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Aktiviti Hartanah'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Aktiviti Profesional, Saintifik dan Teknikal'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Aktiviti Pentadbiran dan Khidmat Sokongan'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Pentadbiran Awam dan Pertahanan; Aktiviti Keselamatan Sosial Wajib'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Pendidikan'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Kesihatan dan Kerja Sosial'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Kesenian, Hiburan dan Rekreasi'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Aktiviti Perkhidmatan Lain'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Aktiviti Isi Rumah Sebagai Majikan; Aktiviti Mengeluarkan Barangan dan Perkhidmatan Yang Tidak Dapat Dibezakan Oleh Isi Rumah Untuk Kegunaan Sendiri'
        ]);

        DB::table('master_industry_type')->insert([
            'name' => 'Aktiviti Badan dan Pertubuhan Luar Wilayah'
        ]);

    }
}
