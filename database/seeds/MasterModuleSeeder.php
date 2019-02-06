<?php

use Illuminate\Database\Seeder;

class MasterModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_module')->insert([
            'name' => 'Pendaftaran Sistem'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Profil Pengguna'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Paparan Utama'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Paparan Pemantauan'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Inbox Notifikasi'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Rayuan',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pendaftaran Kesatuan Sekerja (Borang B)',
            'code' => 'PB',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Notis Niat Menubuhkan Persekutuan Kesatuan Sekerja (Borang O)',
            'code' => 'PBB',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pendaftaran Persekutuan Kesatuan Sekerja (Borang BB)',
            'code' => 'PBB',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pendaftaran Cawangan'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Penggabungan Kesatuan Sekerja Dengan Persekutuan Kesatuan Sekerja (Borang P & Q)',
            'code' => 'PQR',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Borang R',
            'code' => 'PQR',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Penggabungan Kesatuan Sekerja Dengan Badan Perundingan Dalam Malaysia (Borang WW)',
            'code' => 'PPW',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Penggabungan Kesatuan Sekerja Dengan Badan Perundingan Luar Malaysia (Borang W)',
            'code' => 'PPW',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Perakuan Cuti Tanpa Rekod Kesatuan Sekerja (eCTR4U)',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pindaan Nama Kesatuan Sekerja (Borang G)',
            'code' => 'PPG',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Perubahan Alamat Kesatuan Sekerja (Borang J)',
            'code' => 'PPJ',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pindaan Peraturan / Pendaftaran Peraturan Baru (Borang K)',
            'code' => 'PPK',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pendaftaran Perubahan Pegawai Kesatuan Sekerja (Borang LU)',
            'code' => 'PPL',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Notis Perubahan Pegawai-Pegawai / Jawatan Pegawai-Pegawai Kesatuan Sekerja (Borang L)',
            'code' => 'PPL',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Notis Perubahan Pekerja-Pekerja Kesatuan Sekerja (Borang L1)',
            'code' => 'PPL',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Kutipan Dana Dan Wang Kesatuan Sekerja',
            'code' => 'PID',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pembayaran Premium Insuran Kesatuan Sekerja',
            'code' => 'INS',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pengenaan Levi',
            'code' => 'PLV',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Penyata Kewangan (Juru Audit Luar)',
            'code' => 'PBN',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Penyata Tahunan Kesatuan',
            'code' => 'PBN',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pembubaran Kesatuan Sekerja (Borang IEU)',
            'code' => 'PPI',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pembatalan Kesatuan Sekerja (Borang F)',
            'code' => 'PPF',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pemeriksaan Berkanun',
            'code' => 'PBP',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Kertas Siasatan (Pendakwaan)',
            'code' => 'PDW',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pengendalian Aduan',
            'code' => 'PAD',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pengendalian Mogok',
            'code' => 'PAD',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Penyediaan Laporan Permohonan Semakan Kehakiman / Affidavit Jawapan',
            'code' => 'AFF',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Siasatan Isu Kelayakan Tuntutan Pengiktirafan',
            'code' => 'PIK',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pengecualian Seksyen 30(b), AKS 1959',
            'code' => 'PPC',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pengecualian Peraturan 68, AKS 1959',
            'code' => 'PPC',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Carian'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Laporan',
            'code' => 'PLM',
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pengurusan Agihan'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pengurusan Pengumuman'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Admin - Konfigurasi Sistem'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Admin - Pengurusan Pengguna'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Admin - Pengurusan Peranan'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Admin - Pengurusan Keizinan'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Admin - Pengurusan Simpanan'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Admin - Pengurusan Notifikasi'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Admin - Pengurusan Paparan Surat'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Admin - Pengurusan Cuti'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Admin - Jejak Audit / Log Sistem'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Admin - Data Induk'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pengurusan Surat'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pendaftaran Penggal'
        ]);

        DB::table('master_module')->insert([
            'name' => 'Pengendalian Tutup Pintu',
            'code' => 'PAD',
        ]);

        //...
    }
}
