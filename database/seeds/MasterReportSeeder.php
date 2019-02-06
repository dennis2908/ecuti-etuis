<?php

use Illuminate\Database\Seeder;

class MasterReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Dan Keanggotaan',
            'report_type_id' => 1,
            'code' => 1
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Mengikut Jantina',
            'report_type_id' => 1,
            'code' => 2
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Mengikut Sektor',
            'report_type_id' => 1,
            'code' => 3
        ]);

        DB::table('master_report')->insert([
            'name' => 'Keanggotaan Kesatuan Sekerja Mengikut Jantina Dan Sektor ',
            'report_type_id' => 1,
            'code' => 4
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Mengikut Jenis',
            'report_type_id' => 1,
            'code' => 5
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Keanggotaan Mengikut Jenis Dan Jantina',
            'report_type_id' => 1,
            'code' => 6
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Mengikut Kategori',
            'report_type_id' => 1,
            'code' => 7
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Dan Keanggotaan Mengikut Negeri',
            'report_type_id' => 1,
            'code' => 8
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Mengikut Industri',
            'report_type_id' => 1,
            'code' => 9
        ]);

        DB::table('master_report')->insert([
            'name' => 'Keanggotaan Kesatuan Sekerja Mengikut Industri',
            'report_type_id' => 1,
            'code' => 10
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Dan Keanggotaan Kesatuan Sekerja Pekerja Dan Majikan',
            'report_type_id' => 1,
            'code' => 11
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Yang Bergabung Dengan CUEPACS',
            'report_type_id' => 1,
            'code' => 12
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Yang Bergabung Dengan MTUC',
            'report_type_id' => 1,
            'code' => 13
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Yang Bergabung Dengan Badan Perunding Antarabangsa',
            'report_type_id' => 1,
            'code' => 14
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Dan Keanggotaan CUEPACS',
            'report_type_id' => 1,
            'code' => 15
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Yang Mempunyai Keanggotaan Pekerja Asing',
            'report_type_id' => 1,
            'code' => 16
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Yang Mempunyai Keanggotaan Pekerja Asing Mengikut Industri',
            'report_type_id' => 1,
            'code' => 17
        ]);

        DB::table('master_report')->insert([
            'name' => 'Keanggotaan Pekerja Asing Mengikut Industri',
            'report_type_id' => 1,
            'code' => 18
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Yang Mempunyai Pekerja Asing Mengikut Kategori',
            'report_type_id' => 1,
            'code' => 19
        ]);

        DB::table('master_report')->insert([
            'name' => 'Keanggotaan Pekerja Asing Mengikut Negeri',
            'report_type_id' => 1,
            'code' => 20
        ]);

        DB::table('master_report')->insert([
            'name' => 'Keanggotaan Pekerja Asing Mengikut Negara Sumber',
            'report_type_id' => 1,
            'code' => 21
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Dan Keanggotaan Kesatuan Sekerja',
            'report_type_id' => 2,
            'code' => 1
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Keanggotaan Kesatuan Sekerja Berdasarkan Jantina',
            'report_type_id' => 2,
            'code' => 2
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Dan Keanggotaan Kesatuan Sekerja Berdasarkan Sektor',
            'report_type_id' => 2,
            'code' => 3
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Keanggotaan Kesatuan Sekerja Berdasarkan Sektor Dan Jantina',
            'report_type_id' => 2,
            'code' => 4
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Berdasarkan Jenis',
            'report_type_id' => 2,
            'code' => 5
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Keanggotaan Kesatuan Sekerja Berdasarkan Jenis Dan Jantina',
            'report_type_id' => 2,
            'code' => 6
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Dan Keanggotaan Kesatuan Sekerja Berdasarkan Etoi',
            'report_type_id' => 2,
            'code' => 7
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Pekerja Dan Majikan',
            'report_type_id' => 2,
            'code' => 8
        ]);

        DB::table('master_report')->insert([
            'name' => 'Senarai Dan Keanggotaan Kesatuan Sekerja Kerja Majikan',
            'report_type_id' => 2,
            'code' => 9
        ]);

        DB::table('master_report')->insert([
            'name' => ' Bilangan Dan Keanggotaan Kesatuan Sekerja Berdasarkan Negeri',
            'report_type_id' => 2,
            'code' => 10
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Keanggotaan Kesatuan Sekerja Tertinggi',
            'report_type_id' => 2,
            'code' => 11
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Pendaftaran Dan Kesatuan Sekerja Aktif Berdasarkan Lokasi',
            'report_type_id' => 2,
            'code' => 12
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Aktif',
            'report_type_id' => 2,
            'code' => 13
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja Yang Bergabung Dengan Cuepacs, Mtuc Dan Badan Perunding Antarabangsa',
            'report_type_id' => 2,
            'code' => 14
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Dan Keanggotaan Kesatuan Sekerja Yang Bergabung Dengan Cuepacs',
            'report_type_id' => 2,
            'code' => 15
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Dan Keanggotaan Kesatuan Sekerja Yang Bergabung Dengan Mtuc',
            'report_type_id' => 2,
            'code' => 16
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Dan Keanggotaan Kesatuan Sekerja Berdasarkan Industri',
            'report_type_id' => 2,
            'code' => 17
        ]);

        DB::table('master_report')->insert([
            'name' => 'Senarai Persekutuan Kesatuan Sekerja',
            'report_type_id' => 2,
            'code' => 18
        ]);

        DB::table('master_report')->insert([
            'name' => 'Percantum Kesatuan Sekerja',
            'report_type_id' => 2,
            'code' => 19
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Dan Keanggotaan Kesatuan Sekerja Yang Mempunyai Keanggotaan Pekerja Asing',
            'report_type_id' => 2,
            'code' => 20
        ]);

        DB::table('master_report')->insert([
            'name' => 'Bilangan Kesatuan Sekerja (Daftar, Batal, Bubar)',
            'report_type_id' => 2,
            'code' => 21
        ]);

        DB::table('master_report')->insert([
            'name' => 'Senarai Kesatuan Dan Keanggotaan Pekerja Asing Mengikut Negeri',
            'report_type_id' => 2,
            'code' => 22
        ]);

    }
}
