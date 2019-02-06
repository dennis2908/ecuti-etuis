<?php

use Illuminate\Database\Seeder;

class MasterMeetingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('master_meeting_type')->insert([
            'name' => 'Mesyuarat Jawatankuasa Kerja',
        ]);
        
        DB::table('master_meeting_type')->insert([
            'name' => 'Mesyuarat Agung',
        ]);

        DB::table('master_meeting_type')->insert([
            'name' => 'Persidangan Perwakilan',
        ]);

        DB::table('master_meeting_type')->insert([
            'name' => 'Undi Sulit',
        ]);

        DB::table('master_meeting_type')->insert([
            'name' => 'Mesyuarat Jawatankuasa Eksekutif',
        ]);

        DB::table('master_meeting_type')->insert([
            'name' => 'Mesyuarat Agung Luar Biasa',
        ]);
    }
}
