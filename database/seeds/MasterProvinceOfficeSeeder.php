<?php

use Illuminate\Database\Seeder;

class MasterProvinceOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $address = App\OtherModel\Address::create([
            'address1' => 'Tingkat 2, Bangunan Ehsan',
            'address2' => 'No. 3, Jalan Indah, Seksyen 14',
            'postcode' => '40000',
            'district_id' => 78,
            'state_id' => 10,
        ]);

        DB::table('master_province_office')->insert([
            'name' => 'Jabatan Hal Ehwal Kesatuan Sekerja Selangor & Wilayah Persekutuan',
            'address_id' => $address->id,
            'phone' => '03-55193233/03-55193551',
            'fax' => '03-55199059',
            'email' => 'jhekssgor@mohr.gov.my',
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Aras 3, Menara Persekutuan, Bandar MITC',
            'address2' => 'Jalan Persekutuan, Hang Tuah Jaya',
            'postcode' => '75450',
            'district_id' => 34,
            'state_id' => 4,
        ]);

        DB::table('master_province_office')->insert([
            'name' => 'Jabatan Hal Ehwal Kesatuan Sekerja Melaka & Negeri Sembilan',
            'address_id' => $address->id,
            'phone' => '06-2345080/06-2345081',
            'fax' => '06-2345084',
            'email' => 'jheksmlk@mohr.gov.my',
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Suite 10.4 & 10.5',
            'address2' => 'Tingkat 10, Kompleks Teruntum',
            'address3' => 'Jalan Mahkota',
            'postcode' => '25000',
            'district_id' => 47,
            'state_id' => 6,
        ]);

        DB::table('master_province_office')->insert([
            'name' => 'Jabatan Hal Ehwal Kesatuan Sekerja Pahang',
            'address_id' => $address->id,
            'phone' => '09-5131321/09-5131304/09-5131305',
            'fax' => '09-5131306',
            'email' => 'jheksphg@mohr.gov.my',
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Tingkat 6, Wisma Persekutuan',
            'address2' => 'Jalan Sultan Ismail',
            'postcode' => '20200',
            'district_id' => 84,
            'state_id' => 11,
        ]);

        DB::table('master_province_office')->insert([
            'name' => 'Jabatan Hal Ehwal Kesatuan Sekerja Terengganu & Kelantan',
            'address_id' => $address->id,
            'phone' => '09-6315117/09-6221853/09-6312001',
            'fax' => '09-6231043',
            'email' => 'jhekstrg@mohr.gov.my',
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Tingkat 3, Blok A',
            'address2' => 'Wisma Persekutuan, Jalan Air Molek',
            'postcode' => '80000',
            'district_id' => 2,
            'state_id' => 1,
        ]);

        DB::table('master_province_office')->insert([
            'name' => 'Jabatan Hal Ehwal Kesatuan Sekerja Johor',
            'address_id' => $address->id,
            'phone' => '07-2231090/07-2219186',
            'fax' => '07-2240049',
            'email' => 'jheksjhr@mohr.gov.my',
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Tingkat 12, Bangunan Persekutuan P.Pinang',
            'address2' => 'Jalan Anson',
            'postcode' => '10400',
            'district_id' => 58,
            'state_id' => 7,
        ]);

        DB::table('master_province_office')->insert([
            'name' => 'Jabatan Hal Ehwal Kesatuan Sekerja Pulau Pinang, Kedah & Perlis',
            'address_id' => $address->id,
            'phone' => '04-2265008/04-2298925/04-2281991',
            'fax' => '04-2278824',
            'email' => 'jhekspp@mohr.gov.my',
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Tingkat 7, Blok E, Unit 7.6 B',
            'address2' => 'Bangunan KWSP',
            'address3' => 'Jalan Karamunsing',
            'postcode' => '88000',
            'district_id' => 89,
            'state_id' => 12,
        ]);

        DB::table('master_province_office')->insert([
            'name' => 'Jabatan Hal Ehwal Kesatuan Sekerja Sabah',
            'address_id' => $address->id,
            'phone' => '088-222131/088-222132',
            'fax' => '088-245404',
            'email' => 'jhekssbh@mohr.gov.my',
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Aras 10, #10-01 & 10-02',
            'address2' => 'No 9, Somerset, Gateway Kuching',
            'address3' => 'Jalan Bukit Mata, Peti Surat 2987',
            'postcode' => '93758',
            'district_id' => 114,
            'state_id' => 13,
        ]);

        DB::table('master_province_office')->insert([
            'name' => 'Jabatan Hal Ehwal Kesatuan Sekerja Sarawak',
            'address_id' => $address->id,
            'phone' => '082-258862/082-257600',
            'fax' => '082-230093',
            'email' => 'jheksswk@mohr.gov.my',
        ]);

        $address = App\OtherModel\Address::create([
            'address1' => 'Tingkat 4 , Blok C',
            'address2' => 'Bangunan Gunasama Persekutuan Ipoh',
            'address3' => 'Jalan Dato\' Seri Ahmad Said, Greentown',
            'postcode' => '30450',
            'district_id' => 62,
            'state_id' => 8,
        ]);

        DB::table('master_province_office')->insert([
            'name' => 'Jabatan Hal Ehwal Kesatuan Sekerja Perak',
            'address_id' => $address->id,
            'phone' => '05-2550967/05-2545381',
            'fax' => '05-2549004',
            'email' => 'jheksprk@mohr.gov.my',
        ]);
    }
}
