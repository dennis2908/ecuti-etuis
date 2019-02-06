<?php

use Illuminate\Database\Seeder;

class MasterAnnouncementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_announcement_type')->insert([
            'name' => 'Penting',
            'label' => 'warning'
        ]);

        DB::table('master_announcement_type')->insert([
            'name' => 'Segera',
            'label' => 'danger'
        ]);

        DB::table('master_announcement_type')->insert([
            'name' => 'Maklumat',
            'label' => 'info'
        ]);
    }
}
