<?php

use Illuminate\Database\Seeder;

class MasterLetterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus',
            'module_id' => 7,
            'template_name' => 'formb.approve',
        ]);

        DB::table('master_letter_type')->insert([
            'name' => 'Perakuan Permohonan (Borang D)',
            'module_id' => 7,
            'template_name' => 'formb.formd',
        ]);

        DB::table('master_letter_type')->insert([
            'name' => 'Surat PNMB',
            'module_id' => 7,
            'template_name' => 'formb.pnmb',
        ]);

        DB::table('master_letter_type')->insert([
            'name' => 'Surat JPPM',
            'module_id' => 7,
            'template_name' => 'formb.jppm',
        ]);

        DB::table('master_letter_type')->insert([
            'name' => 'Surat Tidak Lulus',
            'module_id' => 7,
            'template_name' => 'formb.disapprove',
        ]);

        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus',
            'module_id' => 9,
            'template_name' => 'formbb.approve',
        ]);

        DB::table('master_letter_type')->insert([
            'name' => 'Perakuan Permohonan (Borang DD)',
            'module_id' => 9,
            'template_name' => 'formbb.formdd',
        ]);

        DB::table('master_letter_type')->insert([
            'name' => 'Surat PNMB',
            'module_id' => 9,
            'template_name' => 'formbb.pnmb',
        ]);

        DB::table('master_letter_type')->insert([
            'name' => 'Surat JPPM',
            'module_id' => 9,
            'template_name' => 'formbb.jppm',
        ]);

        DB::table('master_letter_type')->insert([
            'name' => 'Surat Tidak Lulus',
            'module_id' => 9,
            'template_name' => 'formbb.disapprove',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus',
            'module_id' => 11,
            'template_name' => 'formpq.approve',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Pemberitahuan Penggabungan',
            'module_id' => 13,
            'template_name' => 'formww.letter',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Pemberitahuan Penggabungan',
            'module_id' => 14,
            'template_name' => 'formw.letter',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Dibatalkan - Kerajaan / Swasta',
            'module_id' => 15,
            'template_name' => 'ectr4u.cancelled',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Perakuan - Kerajaan',
            'module_id' => 15,
            'template_name' => 'ectr4u.gov_acknowledge',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Perakuan - Kerajaan (Kursus Luar Negara)',
            'module_id' => 15,
            'template_name' => 'ectr4u.gov_acknowledge_oversea',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Perakuan - Sektor Swasta',
            'module_id' => 15,
            'template_name' => 'ectr4u.private_acknowledge',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Tidak Diperakukan - Kerajaan',
            'module_id' => 15,
            'template_name' => 'ectr4u.gov_non_acknowledge',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Tidak Diperakukan - Kerajaan (Kursus Luar Negara)',
            'module_id' => 15,
            'template_name' => 'ectr4u.gov_non_acknowledge_oversea',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Tidak Diperakukan - Swasta',
            'module_id' => 15,
            'template_name' => 'ectr4u.private_non_acknowledge',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Tidak Lulus',
            'module_id' => 16,
            'template_name' => 'formg.disapprove',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus',
            'module_id' => 16,
            'template_name' => 'formg.approve',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Kepada PNMB',
            'module_id' => 16,
            'template_name' => 'formg.pnmb',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Sijil Kesatuan',
            'module_id' => 16,
            'template_name' => 'formg.certificate',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus',
            'module_id' => 17,
            'template_name' => 'formj.approve',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Tidak Lulus',
            'module_id' => 17,
            'template_name' => 'formj.disapprove',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Kepada PNMB',
            'module_id' => 17,
            'template_name' => 'formj.pnmb',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus',
            'module_id' => 18,
            'template_name' => 'formk.approve',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus - Tidak Lulus',
            'module_id' => 18,
            'template_name' => 'formk.approve_disapprove',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Tidak Lulus',
            'module_id' => 18,
            'template_name' => 'formk.disapprove',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Senarai Pindaan Peraturan-Peraturan',
            'module_id' => 18,
            'template_name' => 'formk.constitution_list',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Buku Peraturan Lengkap',
            'module_id' => 18,
            'template_name' => 'formk.constitution_complete',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Buku Peraturan Tidak Lengkap',
            'module_id' => 18,
            'template_name' => 'formk.constitution_incomplete',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus',
            'module_id' => 19,
            'template_name' => 'formlu.approve',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus',
            'module_id' => 20,
            'template_name' => 'forml.approve',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus',
            'module_id' => 21,
            'template_name' => 'forml1.approve',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus',
            'module_id' => 22,
            'template_name' => 'fund.approve',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Tidak Lulus',
            'module_id' => 22,
            'template_name' => 'fund.disapprove',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus',
            'module_id' => 23,
            'template_name' => 'insurance.approve',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Tidak Lulus',
            'module_id' => 23,
            'template_name' => 'insurance.disapprove',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus',
            'module_id' => 24,
            'template_name' => 'levy.approve',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Tidak Lulus',
            'module_id' => 24,
            'template_name' => 'levy.disapprove',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus JL Bertauliah',
            'module_id' => 25,
            'template_name' => 'formjl.approve',
        ]);        
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Tidak Lulus JL Bertauliah',
            'module_id' => 25,
            'template_name' => 'formjl.disapprove',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus JL Tidak Bertauliah',
            'module_id' => 25,
            'template_name' => 'formjl.external_approve',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Tidak Lulus JL Tidak Bertauliah',
            'module_id' => 25,
            'template_name' => 'formjl.external_disapprove',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Memo Pembubaran',
            'module_id' => 27,
            'template_name' => 'formieu.notice',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus',
            'module_id' => 27,
            'template_name' => 'formieu.approve',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Pemeriksaan',
            'module_id' => 29,
            'template_name' => 'enforcement.letter',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Notis Pematuhan',
            'module_id' => 29,
            'template_name' => 'enforcement.notice',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Arahan KPKS',
            'module_id' => 29,
            'template_name' => 'enforcement.memo',
        ]);

        DB::table('master_letter_type')->insert([
            'name' => 'Surat Pelantikan IO',
            'module_id' => 30,
            'template_name' => 'investigation.appoint_io',
        ]);

        DB::table('master_letter_type')->insert([
            'name' => 'Permohonan Waran Geledah',
            'module_id' => 30,
            'template_name' => 'investigation.warrant_application',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Waran Geledah',
            'module_id' => 30,
            'template_name' => 'investigation.warrant',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Memo PUU',
            'module_id' => 30,
            'template_name' => 'investigation.memo_puu',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Cadangan Lawan Kes',
            'module_id' => 30,
            'template_name' => 'investigation.memo_case',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Pelantikan PO',
            'module_id' => 30,
            'template_name' => 'investigation.appoint_po',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Memo Aduan',
            'module_id' => 31,
            'template_name' => 'complaint.memo',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Ketidakpatuhan',
            'module_id' => 32,
            'template_name' => 'strike.disobey',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Ketidakpatuhan',
            'module_id' => 53,
            'template_name' => 'lockout.disobey',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Iringan',
            'module_id' => 33,
            'template_name' => 'affidavit.letter',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Keputusan (Termasuk)',
            'module_id' => 34,
            'template_name' => 'eligibility.include',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Keputusan (Tidak Termasuk)',
            'module_id' => 34,
            'template_name' => 'eligibility.exclude',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Memo Siasatan',
            'module_id' => 34,
            'template_name' => 'eligibility.memo_investigation',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Memo Peringatan',
            'module_id' => 34,
            'template_name' => 'eligibility.memo_reminder',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Memo Keputusan',
            'module_id' => 34,
            'template_name' => 'eligibility.memo_result',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Memo Tarik Balik',
            'module_id' => 34,
            'template_name' => 'eligibility.memo_retract',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Pemeriksaan',
            'module_id' => 34,
            'template_name' => 'eligibility.letter_investigation',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Memo Pengecualian (PP-30-02)',
            'module_id' => 35,
            'template_name' => 'pp30.memo',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Perintah Pengecualian (BM) (PP-30-03)',
            'module_id' => 35,
            'template_name' => 'pp30.command',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Kelulusan (PP-30-05)',
            'module_id' => 35,
            'template_name' => 'pp30.approve',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Kelulusan AP.3 (PP-68-02)',
            'module_id' => 36,
            'template_name' => 'pp68.ap3',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Kelulusan AP.5 (PP-68-03)',
            'module_id' => 36,
            'template_name' => 'pp68.ap5',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Kelulusan AP.1 (PP-68-04)',
            'module_id' => 36,
            'template_name' => 'pp68.ap1',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Lulus + Tidak Lulus (PP-68-05)',
            'module_id' => 36,
            'template_name' => 'pp68.approve_disapprove',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Surat Tidak Lulus (PP-68-06)',
            'module_id' => 36,
            'template_name' => 'pp68.disapprove',
        ]);
        DB::table('master_letter_type')->insert([
            'name' => 'Keputusan Pengiktirafan JPPM',
            'module_id' => 34,
            'template_name' => 'eligibility.jppm_result',
        ]);
    }
}
