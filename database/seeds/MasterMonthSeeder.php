<?php

use Illuminate\Database\Seeder;

class MasterMonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_month')->insert([
            'name' => 'Januari',
            'code' => 'Jan',
        ]);

        DB::table('master_month')->insert([
            'name' => 'Februari',
            'code' => 'Feb',
        ]);

        DB::table('master_month')->insert([
            'name' => 'Mac',
            'code' => 'Mac',
        ]);

        DB::table('master_month')->insert([
            'name' => 'April',
            'code' => 'Apr',
        ]);

        DB::table('master_month')->insert([
            'name' => 'Mei',
            'code' => 'Mei',
        ]);

        DB::table('master_month')->insert([
            'name' => 'Jun',
            'code' => 'Jun',
        ]);

        DB::table('master_month')->insert([
            'name' => 'Julai',
            'code' => 'Jul',
        ]);

        DB::table('master_month')->insert([
            'name' => 'Ogos',
            'code' => 'Ogo',
        ]);

        DB::table('master_month')->insert([
            'name' => 'September',
            'code' => 'Sep',
        ]);

        DB::table('master_month')->insert([
            'name' => 'Oktober',
            'code' => 'Okt',
        ]);

        DB::table('master_month')->insert([
            'name' => 'November',
            'code' => 'Nov',
        ]);

        DB::table('master_month')->insert([
            'name' => 'Disember',
            'code' => 'Dis',
        ]);
    }
}
