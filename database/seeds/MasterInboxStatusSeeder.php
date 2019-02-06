<?php

use Illuminate\Database\Seeder;

class MasterInboxStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_inbox_status')->insert([
            'name' => 'Draf',
        ]);

        DB::table('master_inbox_status')->insert([
            'name' => 'Telah Dihantar',
        ]);

        DB::table('master_inbox_status')->insert([
            'name' => 'Telah Dibaca',
        ]);
    }
}
