<?php

use Illuminate\Database\Seeder;

class MasterReportTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_report_type')->insert([
            'name' => 'public',
        ]);

        DB::table('master_report_type')->insert([
            'name' => 'internal',
        ]);
    }
}
