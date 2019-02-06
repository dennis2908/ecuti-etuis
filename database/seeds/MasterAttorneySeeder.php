<?php

use Illuminate\Database\Seeder;

class MasterAttorneySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $address = App\OtherModel\Address::create([
            'address1' => 'Tingkat 5 dan 7',
            'address2' => 'Wisma Chase Perdana Off Jalan Semantan, Damansara Heights',
            'postcode' => '50512',
            'district_id' => 14,
            'state_id' => 2,
        ]);

        DB::table('master_attorney')->insert([
            'name' => 'Jabatan Peguam Negara Malaysia',
            'address_id' => $address->id,
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Tingkat 4 Podium Utara',
            'address2' => ' Bangunan Sultan Salahuddin Abdul Aziz Shah',
            'postcode' => '41000',
            'district_id' => 72,
            'state_id' => 10,
        ]);

        DB::table('master_attorney')->insert([
            'name' => 'Pejabat Penasihat Undang-undang Negeri Selangor',
            'address_id' => $address->id,
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Aras 1, Blok Laksamana',
            'address2' => 'Seri Negeri Ayer Keroh',
            'address3' => 'Peti Surat 280, Hang Tuah Jaya',
            'postcode' => '75450',
            'district_id' => 34,
            'state_id' => 4,
        ]);

        DB::table('master_attorney')->insert([
            'name' => 'Pejabat Penasihat Undang-undang Negeri Melaka',
            'address_id' => $address->id,
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Aras 4, Blok C Wisma Darul Aman',
            'postcode' => '05250',
            'district_id' => 11,
            'state_id' => 2,
        ]);

        DB::table('master_attorney')->insert([
            'name' => 'Pejabat Penasihat Undang-undang Negeri Kedah',
            'address_id' => $address->id,
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Tingkat 3 Wisma Sri',
            'postcode' => '25512',
            'district_id' => 47,
            'state_id' => 6,
        ]);

        DB::table('master_attorney')->insert([
            'name' => 'Pejabat Penasihat Undang-undang Negeri Pahang',
            'address_id' => $address->id,
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Tingkat 1, Bangunan Perak Darul Ridzuan',
            'address2' => 'Jalan Panglima Bukit Gantang Wahab',
            'postcode' => '30000',
            'district_id' => 62,
            'state_id' => 8,
        ]);

        DB::table('master_attorney')->insert([
            'name' => 'Pejabat Penasihat Undang-undang Negeri Perak',
            'address_id' => $address->id,
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Jalan Campbell',
            'postcode' => '70000',
            'district_id' => 41,
            'state_id' => 5,
        ]);

        DB::table('master_attorney')->insert([
            'name' => 'Pejabat Penasihat Undang-undang Negeri Sembilan',
            'address_id' => $address->id,
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Aras 10, Bangunan Persekutuan',
            'address2' => 'Jalan Anson',
            'postcode' => '10400',
            'district_id' => 58,
            'state_id' => 7,
        ]);

        DB::table('master_attorney')->insert([
            'name' => 'Pejabat Penasihat Undang-undang Negeri Pulau Pinang',
            'address_id' => $address->id,
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Aras 2, Bangunan Dato’ Jaafar Muhammad',
            'address2' => 'Kota Iskandar',
            'postcode' => '79100',
            'district_id' => 2,
            'state_id' => 1,
        ]);

        DB::table('master_attorney')->insert([
            'name' => 'Pejabat Penasihat Undang-undang Negeri Johor',
            'address_id' => $address->id,
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Tingkat 14, Wisma Darul Iman',
            'postcode' => '20200',
            'district_id' => 84,
            'state_id' => 11,
        ]);

        DB::table('master_attorney')->insert([
            'name' => 'Pejabat Penasihat Undang-undang Negeri Terengganu',
            'address_id' => $address->id,
        ]);
    }
}
