<?php

use Illuminate\Database\Seeder;

class MasterCourtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $address = App\OtherModel\Address::create([
            'address1' => 'Jalan Hospital',
            'postcode' => '01000',
            'district_id' => 71,
            'state_id' => 9,
        ]);

        DB::table('master_court')->insert([
            'name' => 'Mahkamah Tinggi Kangar',
            'address_id' => $address->id,
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Kompleks Mahkamah Alor Star',
            'address2' => 'Jalan Suka Menanti',
            'postcode' => '05700',
            'district_id' => 11,
            'state_id' => 9,
        ]);

        DB::table('master_court')->insert([
            'name' => 'Mahkamah Tinggi Alor Star',
            'address_id' => $address->id,
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'No. 57, Northam Tower',
            'address2' => 'Jalan Sultan Ahmad Shah',
            'postcode' => '10050',
            'district_id' => 58,
            'state_id' => 7,
        ]);

        DB::table('master_court')->insert([
            'name' => 'Mahkamah Tinggi Pulau Pinang',
            'address_id' => $address->id,
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Jalan Panglima Bukit Gantang Wahab',
            'postcode' => '30507',
            'district_id' => 62,
            'state_id' => 8,
        ]);

        DB::table('master_court')->insert([
            'name' => 'Mahkamah Tinggi Ipoh',
            'address_id' => $address->id,
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Jalan Kota',
            'postcode' => '34009',
            'district_id' => 65,
            'state_id' => 8,
        ]);

        DB::table('master_court')->insert([
            'name' => 'Mahkamah Tinggi Taiping',
            'address_id' => $address->id,
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Bangunan Mahkamah Sultan Salahuddin Abdul Aziz Shah',
            'address2' => 'Persiaran Pegawai, Seksyen 5',
            'postcode' => '40000',
            'district_id' => 78,
            'state_id' => 10,
        ]);

        DB::table('master_court')->insert([
            'name' => 'Mahkamah Tinggi Shah Alam',
            'address_id' => $address->id,
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Kompleks Mahkamah Kuala Lumpur',
            'address2' => 'Jalan Sultan Abdul Halim Shah (Jalan Duta)',
            'postcode' => '50592',
            'district_id' => 14,
            'state_id' => 2,
        ]);

        DB::table('master_court')->insert([
            'name' => 'Mahkamah Tinggi Kuala Lumpur',
            'address_id' => $address->id,
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Kompleks Mahkamah Seremban',
            'postcode' => '70300',
            'district_id' => 41,
            'state_id' => 5,
        ]);

        DB::table('master_court')->insert([
            'name' => 'Mahkamah Tinggi Seremban',
            'address_id' => $address->id,
        ]);
    }
}
