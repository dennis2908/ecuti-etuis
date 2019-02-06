<?php

use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notification')->insert([
            'name' => 'Pengesahan Pendaftaran',
            'code' => 'PB_KS_1.1_A',
            'message' => 'Pengesahan pendaftaran akan disahkan melalui emel tuan/puan.<br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Pendaftaran Berjaya',
            'code' => 'PB_KS_1.1',
            'message' => 'Salam sejahtera [name],<br><br>Anda telah berjaya mendaftar sebagai [type_full]. Berikut adalah maklumat anda:<br><br>ID Pengguna: [username]<br>Kata Laluan: [password]<br>Nama [type]: [entity_name]<br>Tarikh Penubuhan: [registered_at]<br><br>Sila klik pada pautan dibawah untuk pengesahan emel anda.<br>[button]<br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Pendaftaran Ditolak',
            'code' => 'PB_KS_1.2',
            'message' => 'Salam sejahtera,<br><br>Permohonan pendaftaran [type_full] tidak dapat diproses kerana telah melebihi tempoh [limit] hari daripada tarikh penubuhan (Seksyen 8(1) AKS).<br><br>Sekiranya masih berminat untuk meneruskan permohonan, sila klik pautan rayuan di bawah.<br>[button]<br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Rayuan Diterima',
            'code' => 'PB_KS_1.3',
            'message' => 'Salam negaraku Malaysia,<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan rayuan tuan/puan di bawah peruntukan Seksyen 8(2) Akta Kesatuan Sekerja 1959 untuk mengemukakan permohonan pendaftaran [type_full] telah diterima. Suhubungan itu, tuan/puan boleh meneruskan permohonan pendaftaran [type_full] melalui Borang B.<br>[button]<br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Rayuan Ditolak',
            'code' => 'PB_KS_1.4',
            'message' => 'Salam negaraku Malaysia,<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan rayuan tuan/puan di bawah peruntukan Seksyen 8(2) Akta Kesatuan Sekerja 1959 untuk mengemukakan permohonan pendaftaran [type_full] tidak dapat dipertimbangkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Serahan Tugas Kesatuan',
            'code' => 'profile.handed_over',
            'message' => 'Salam Sejahtera,<br><br>Tuan/Puan<br><br>Adalah dimaklumkan tugas Setiausaha bagi Kesatuan [entity_name] telah diserahkan kepada tuan/puan.<br><br>Sila klik pada pautan dibawah untuk mendaftar dan menerima tugasan tersebut.<br>[button]<br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Kuiri Permohonan',
            'code' => 'filing.queried',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan semakan ke atas permohonan ini mendapati terdapat perkara-perkara yang tidak lengkap seperti berikut:<br>[queries]<br>Mohon tuan/puan mengemukakan dokumen/maklumat yang telah lengkap dalam masa 14 hari dari tarikh emel ini.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Agihan Permohonan',
            'code' => 'filing.distributed',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan [module_name] ([reference_no]) telah diserahkan untuk tindakan tuan/puan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Serahan Kepada HQ',
            'code' => 'filing.send-to-hq',
            'message' => 'Tuan/Puan,<br><br>Sila kemukakan dokumen [module_name] ([reference_no]) oleh [entity_name] kepada Ibu Pejabat untuk tindakan lanjut.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Pengesahan Penerimaan Permohonan',
            'code' => 'filing.received',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan [module_name] ([reference_no]) telah diterima dan akan diproses.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Pengesahan Penerimaan Permohonan',
            'code' => 'filing.received-hq',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Dokumen [module_name] ([reference_no]) telah diterima oleh Ibu Pejabat.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Keputusan Permohonan',
            'code' => 'ectr4u.approved',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan bahawa [module_name] ([reference_no]) telah diperakukan. Sila semak status.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Keputusan Permohonan',
            'code' => 'ectr4u.rejected',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan bahawa [module_name] ([reference_no]) adalah tidak diperakukan. Sila semak status.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Perakuan eCTR4U',
            'code' => 'ectr4u.tobeprocessed',
            'message' => 'Tuan/Puan,<br><br>Mohon perhatian Tuan/ Puan,<br><br>Terdapat satu permohonan eCTR4U yang memerlukan Perakuan Tuan/ Puan Mohon login ke [url]<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Permohonan Tidak Lengkap',
            'code' => 'ectr4u.incompleted',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan semakan ke atas permohonan ini mendapati terdapat perkara-perkara yang tidak lengkap seperti berikut:<br>[list]<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Notis Perubahan Pegawai Didaftarkan',
            'code' => 'formlu.approved-ks',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa perubahan pegawai di dalam Borang L & U bertarikh [applied_at] telah di daftarkan pada [approved_at]. Dokumen kelulusan akan dikemukakan melalui pos.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Perubahan Pegawai Didaftarkan',
            'code' => 'formlu.approved-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa perubahan pegawai [entity_name] telah didaftarkan pada [approved_at].<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Perubahan Pegawai Tertunggak',
            'code' => 'formlu.rejected',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan bahawa perubahan pegawai di dalam Borang L & U bertarikh [applied_at] telah tertunggak kerana tiada dokumen fizikal diterima melebihi 7 hari.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'formlu.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan pihak Jabatan masih belum menerima dokumen fizikal dari pihak tuan / puan. Sila kemukakan segera bagi mengelakkan pendaftaran pegawai kesatuan tuan / puan tertunggak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Perubahan Pegawai Telah Dihantar',
            'code' => 'formlu.sent',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Tuan/Puan.<br><br>Permohonan tuan/puan telah diterima. Sila kemukakan dokumen-dokumen dalam masa 7 hari ke Pejabat Jabatan Hal Ehwal Kesatuan Sekerja (JHEKS) Negeri/Wilayah yang berkenaan seperti berikut :<br><br>i. Borang L (dicetak melalui sistem)<br>ii. Borang U (dicetak melalui sistem)<br>iii. Minit Mesyuarat Agung / Minit Mesyuarat Agung Luar Biasa<br>iv. Borang Praecipe bersetem hasil RM1.00<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Notis Perubahan Pegawai Didaftarkan',
            'code' => 'forml.approved-ks',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa perubahan pegawai di dalam Borang L bertarikh [applied_at] telah di daftarkan pada [approved_at]. Dokumen kelulusan akan dikemukakan melalui pos.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Perubahan Pegawai Didaftarkan',
            'code' => 'forml.approved-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa perubahan pegawai [entity_name] telah didaftarkan pada [approved_at].<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Perubahan Pegawai Tertunggak',
            'code' => 'forml.rejected',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan bahawa perubahan pegawai di dalam Borang L bertarikh [applied_at] telah tertunggak kerana tiada dokumen fizikal diterima melebihi 7 hari.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'forml.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan pihak Jabatan masih belum menerima dokumen fizikal dari pihak tuan / puan. Sila kemukakan segera bagi mengelakkan pendaftaran pegawai kesatuan tuan / puan tertunggak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Perubahan Pegawai Telah Dihantar',
            'code' => 'forml.sent',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Tuan/Puan.<br><br>Permohonan tuan/puan telah diterima. Sila kemukakan dokumen-dokumen dalam masa 7 hari ke Pejabat Jabatan Hal Ehwal Kesatuan Sekerja (JHEKS) Negeri/Wilayah yang berkenaan seperti berikut :<br><br>i. Borang L (dicetak melalui sistem)<br>ii. Minit Mesyuarat Agung / Minit Mesyuarat Agung Luar Biasa<br>iii. Borang Praecipe bersetem hasil RM1.00<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Notis Perubahan Pekerja Didaftarkan',
            'code' => 'forml1.approved-ks',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa perubahan pekerja di dalam Borang L (1) bertarikh [applied_at] telah di daftarkan pada [approved_at]. Dokumen kelulusan akan dikemukakan melalui pos.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Perubahan Pekerja Didaftarkan',
            'code' => 'forml1.approved-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa perubahan pekerja [entity_name] telah didaftarkan pada [approved_at].<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Perubahan Pekerja Tertunggak',
            'code' => 'forml1.rejected',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan bahawa perubahan pekerja di dalam Borang L (1) bertarikh [applied_at] telah tertunggak kerana tiada dokumen fizikal diterima melebihi 7 hari.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'forml1.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan pihak Jabatan masih belum menerima dokumen fizikal dari pihak tuan / puan. Sila kemukakan segera bagi mengelakkan pendaftaran pekerja kesatuan tuan / puan tertunggak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Perubahan Pekerja Telah Dihantar',
            'code' => 'forml1.sent',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Tuan/Puan.<br><br>Permohonan tuan/puan telah diterima. Sila kemukakan dokumen-dokumen dalam masa 7 hari ke Pejabat Jabatan Hal Ehwal Kesatuan Sekerja (JHEKS) Negeri/Wilayah yang berkenaan seperti berikut :<br><br>i. Borang L (1) (dicetak melalui sistem)<br>ii. Minit Mesyuarat Agung / Minit Mesyuarat Agung Luar Biasa<br>iii. Borang Praecipe bersetem hasil RM1.00<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'formb.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan tuan/puan telah diterima. Sila kemukakan dokumen-dokumen dalam masa 30 hari ke Pejabat Jabatan Hal Ehwal Kesatuan Sekerja (JHEKS) Negeri/Wilayah yang berkenaan seperti berikut :<br><br>i.Borang B (dicetak melalui sistem)<br>ii.Buku perlembagaan tanpa cawangan / buku perlembagaan bercawangan (dicetak melalui sistem)<br>iii.Minit Mesyuarat Penubuhan<br>iv.Sijil Suruhanjaya Syarikat Malaysia (SSM) majikan<br>v.Salinan Kad Pengenalan pemohon dan pegawai penaja<br>vi.Bukti penggajian pemohon & pegawai penaja<br>vii.Surat pengesahan majikan/surat tawaran pekerjaan pemohon & pegawai penaja<br>viii.Surat kebenaran menggunakan alamat majikan (jika berkenaan)<br>ix.Borang Praecipe bersetem hasil RM30.00<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'formb.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan pihak Jabatan masih belum menerima dokumen fizikal bagi permohonan ini.<br><br>Sehubungan itu, permohonan pendaftaran kesatuan sekerja tuan/puan tidak dapat dipertimbangkan untuk didaftarkan kerana telah melebihi tempoh 30 hari dari tarikh penubuhan kesatuan berdasarkan peruntukan Sekyen 8(1) Akta Kesatuan Sekerja 1959.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'formb.rejected',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan pendaftaran kesatuan tuan/puan tidak diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Peringatan Mesyuarat Agung',
            'code' => 'formb.reminder-meeting',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Peringatan. [entity_name] didapati masih belum mengadakan Mesyuarat Agung seperti kehendak Peraturan 12, Perlembagaan Kesatuan yang meyatakan kesatuan dikehendaki mengadakan Mesyuarat Agung dan Pemilihan Pegawai-Pegawai dalam masa 6 bulan dari tarikh pendaftaran. Kesatuan dikehendaki mengadakan Mesyuarat Agung dengan segera. Sila abaikan emel ini sekiranya kesatuan telah berbuat demikian.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penangguhan',
            'code' => 'formb.delayed',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan pendaftaran [entity_name] ditangguhkan atas sebab:<br><br>[reasons]<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'formb.document-approved',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan bawah pendaftaran [entity_name] telah didaftarkan. Sila sediakan dokumen kelulusan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan',
            'code' => 'formb.approved',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan pendaftaran kesatuan tuan/puan telah diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'formbb.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan tuan/puan telah diterima. Sila kemukakan dokumen-dokumen dalam masa 30 hari ke Pejabat Jabatan Hal Ehwal Kesatuan Sekerja (JHEKS) Negeri/Wilayah yang berkenaan seperti berikut :<br><br>i.Borang BB (dicetak melalui sistem)<br>ii.Buku perlembagaan (dicetak melalui sistem)<br>iii.Minit Mesyuarat Penubuhan<br>iv.Sijil Suruhanjaya Syarikat Malaysia (SSM) majikan<br>v.Salinan Kad Pengenalan pemohon dan pegawai penaja<br>vi.Bukti penggajian pemohon & pegawai penaja<br>vii.Surat pengesahan majikan/surat tawaran pekerjaan pemohon & pegawai penaja<br>viii.Surat kebenaran menggunakan alamat majikan (jika berkenaan)<br>ix.Borang Praecipe bersetem hasil RM30.00<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'formbb.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan pihak Jabatan masih belum menerima dokumen fizikal bagi permohonan ini.<br><br>Sehubungan itu, permohonan pendaftaran persekutuan kesatuan sekerja tuan/puan tidak dapat dipertimbangkan untuk didaftarkan kerana telah melebihi tempoh 30 hari dari tarikh penubuhan kesatuan berdasarkan peruntukan Sekyen 8(1) Akta Kesatuan Sekerja 1959.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'formbb.rejected',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan pendaftaran persekutuan kesatuan tuan/puan tidak diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Peringatan Mesyuarat Agung',
            'code' => 'formbb.reminder-meeting',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Peringatan. [entity_name] didapati masih belum mengadakan Mesyuarat Agung seperti kehendak Peraturan 12, Perlembagaan Kesatuan yang meyatakan kesatuan dikehendaki mengadakan Mesyuarat Agung dan Pemilihan Pegawai-Pegawai dalam masa 6 bulan dari tarikh pendaftaran. Kesatuan dikehendaki mengadakan Mesyuarat Agung dengan segera. Sila abaikan emel ini sekiranya kesatuan telah berbuat demikian.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penangguhan',
            'code' => 'formbb.delayed',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan pendaftaran [entity_name] ditangguhkan atas sebab:<br><br>[reasons]<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'formbb.document-approved',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan bawah pendaftaran [entity_name] telah didaftarkan. Sila sediakan dokumen kelulusan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan',
            'code' => 'formbb.approved',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan pendaftaran kesatuan tuan/puan telah diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Notis Penggabungan Telah Dihantar',
            'code' => 'formpq.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan tuan/puan telah diterima. Sila kemukakan dokumen-dokumen dalam masa 7 hari ke Pejabat Jabatan Hal Ehwal Kesatuan Sekerja (JHEKS) Negeri/Wilayah yang berkenaan seperti berikut:<br><br>i.Surat iringan<br>ii.Minit Mesyuarat Agung/ Persidangan Perwakilan (Borang Q)<br>iii.Minit Mesyuarat Exco Persekutuan (Borang R)<br>iv.Surat kelulusan dari YB Menteri Sumber Manusia (jika berkenaan)<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'formpq.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan pihak Jabatan masih belum menerima dokumen fizikal bagi permohonan ini.<br><br>Sehubungan itu, permohonan tuan/puan tidak dapat dipertimbangkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'formpq.rejected',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan tidak diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'formpq.document-approved',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan bawah permohonan [entity_name] telah didaftarkan. Sila sediakan dokumen kelulusan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (KS)',
            'code' => 'formpq.approved-ks',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan penggabungan kesatuan tuan/puan telah diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (PWN)',
            'code' => 'formpq.approved-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa permohonan [entity_name] telah didaftarkan pada [approved_at].<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Notis Penggabungan Telah Dihantar',
            'code' => 'formw.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan tuan/puan telah diterima. Sila kemukakan dokumen-dokumen dalam masa 7 hari ke pejabat Jabatan Hal Ehwal Kesatuan Sekerja (JHEKS) negeri/wilayah yang berkenaan seperti berikut:<br><br>i.Surat iringan<br>ii.Minit mesyuarat agung / persidangan perwakilan<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat jheks dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'formw.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan pihak Jabatan masih belum menerima dokumen fizikal bagi permohonan ini.<br><br>Sehubungan itu, permohonan tuan/puan tidak dapat dipertimbangkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'formw.rejected',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan tidak diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'formw.document-approved',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan bawah permohonan [entity_name] telah didaftarkan. Sila sediakan dokumen kelulusan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (KS)',
            'code' => 'formw.approved-ks',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan telah diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (PWN)',
            'code' => 'formw.approved-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa permohonan [entity_name] telah didaftarkan pada [approved_at].<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Notis Penggabungan Telah Dihantar',
            'code' => 'formww.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan tuan/puan telah diterima. Sila kemukakan dokumen-dokumen dalam masa 7 hari ke pejabat Jabatan Hal Ehwal Kesatuan Sekerja (JHEKS) negeri/wilayah yang berkenaan seperti berikut:<br><br>i.Surat iringan<br>ii.Minit mesyuarat agung / persidangan perwakilan<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat jheks dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'formww.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan pihak Jabatan masih belum menerima dokumen fizikal bagi permohonan ini.<br><br>Sehubungan itu, permohonan tuan/puan tidak dapat dipertimbangkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'formww.rejected',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan tidak diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'formww.document-approved',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan bawah permohonan [entity_name] telah didaftarkan. Sila sediakan dokumen kelulusan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (KS)',
            'code' => 'formww.approved-ks',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan penggabungan kesatuan tuan/puan telah diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (PWN)',
            'code' => 'formww.approved-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa permohonan [entity_name] telah didaftarkan pada [approved_at].<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'formg.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan tuan/puan telah diterima. Sila kemukakan dokumen-dokumen dalam masa 14 hari ke Pejabat Jabatan Hal Ehwal Kesatuan Sekerja (JHEKS) Negeri/Wilayah. Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'formg.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan pihak Jabatan masih belum menerima dokumen fizikal bagi permohonan ini. Sehubungan itu, permohonan tuan/puan tidak dapat dipertimbang untuk didaftarkan kerana telah melebihi tempoh 14 hari.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'formg.rejected',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan tidak diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'formg.document-approved',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan bawah permohonan [entity_name] telah didaftarkan. Sila sediakan dokumen kelulusan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (KS)',
            'code' => 'formg.approved-ks',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan notis pertukaran nama kesatuan tuan/puan telah diluluskan. Surat kelulusan akan dikemukakan melalui pos.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (PWN)',
            'code' => 'formg.approved-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa permohonan [entity_name] telah didaftarkan pada [approved_at].<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Peringatan Buku Perlembagaan',
            'code' => 'formg.reminder-constitution',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah diingatkan bahawa Kesatuan Sekerja diminta mengemukakan buku perlembagaan yang telah dikemaskini dalam tempoh 30 hari dari tarikh peraturan dibuat/dipinda kepada Ketua Pengarah Kesatuan Sekerja dengan memasukkan nombor rujukan di bahagian tepi sebelah kanan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'formj.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan tuan/puan telah diterima. Sila kemukakan dokumen-dokumen dalam masa 14 hari ke Pejabat Jabatan Hal Ehwal Kesatuan Sekerja (JHEKS) Negeri/Wilayah. Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'formj.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan pihak Jabatan masih belum menerima dokumen fizikal bagi permohonan ini. Sehubungan itu, permohonan tuan/puan tidak dapat dipertimbang untuk didaftarkan kerana telah melebihi tempoh 14 hari.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'formj.rejected',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan tidak diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'formj.document-approved',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan bawah permohonan [entity_name] telah didaftarkan. Sila sediakan dokumen kelulusan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (KS)',
            'code' => 'formj.approved-ks',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan notis perubahan alamat kesatuan tuan/puan telah diluluskan. Surat kelulusan akan dikemukakan melalui pos.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (PWN)',
            'code' => 'formj.approved-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa permohonan [entity_name] telah didaftarkan pada [approved_at].<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Peringatan Buku Perlembagaan',
            'code' => 'formj.reminder-constitution',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah diingatkan bahawa Kesatuan Sekerja diminta mengemukakan buku perlembagaan yang telah dikemaskini dalam tempoh 30 hari dari tarikh peraturan dibuat/dipinda kepada Ketua Pengarah Kesatuan Sekerja dengan memasukkan nombor rujukan di bahagian tepi sebelah kanan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'formk.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Permohonan tuan/puan telah diterima. Sila kemukakan dokumen-dokumen dalam masa 14 hari ke Pejabat Jabatan Hal Ehwal Kesatuan Sekerja (JHEKS) Alamat (Negeri/Wilayah) yang berkenaan seperti berikut:<br><br>i. Borang K<br>ii.Borang U (Jika Perlu) **Sekiranya undi sulit dijalankan<br>iii. Senarai Pindaan<br>iv. Borang Praecipe dengan melekatkan setem hasil RM 10.00<br>v. Minit Mesyuarat Berkaitan<br>vi. Usul Pindaan Peraturan Baru<br>vii. Senarai Pindaan Peraturan Baru<br>viii. Buku Perlembagaan Asal Kesatuan Terkini<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'formk.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan pihak Jabatan masih belum menerima dokumen fizikal bagi permohonan ini. Sehubungan itu, permohonan pindaan peraturan kesatuan sekerja tuan/puan tidak dapat dipertimbangkan untuk didaftarkan kerana telah melebihi tempoh 30 hari daripada tarikh Persidangan Perwakilan/Mesyuarat Agung berdasarkan peruntukan Sekyen 38(3) Akta Kesatuan Sekerja 1959.Permohonan baru boleh dikemukakan sekiranya kesatuan masih BERMINAT.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'formk.rejected',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan tidak diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'formk.document-approved',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan bawah permohonan [entity_name] telah didaftarkan. Sila sediakan dokumen kelulusan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (KS)',
            'code' => 'formk.approved-ks',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan pindaan buku perlembagaan kesatuan tuan/puan telah diluluskan. Surat kelulusan akan dikemukakan melalui pos.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (PWN)',
            'code' => 'formk.approved-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa permohonan [entity_name] telah didaftarkan pada [approved_at].<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Peringatan Buku Perlembagaan',
            'code' => 'formk.reminder-constitution',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah diingatkan bahawa Kesatuan Sekerja diminta mengemukakan buku perlembagaan yang telah dikemaskini dalam tempoh 30 hari dari tarikh peraturan dibuat/dipinda kepada Ketua Pengarah Kesatuan Sekerja dengan memasukkan nombor rujukan di bahagian tepi sebelah kanan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Penerimaan Buku Perlembagaan',
            'code' => 'formk.received-constitution',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan salinan buku perlembagaan [entity_name] telah diterima.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Buku Perlembagaan Belum Diterima',
            'code' => 'formk.not-received-constitution',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan pihak Jabatan masih belum menerima salinan buku perlembagaan fizikal bagi permohonan ini. Sehubungan itu, permohonan pindaan peraturan kesatuan sekerja tuan/puan tidak dapat dipertimbangkan untuk didaftarkan kerana telah melebihi tempoh 30 hari daripada tarikh kelulusan. Permohonan baru boleh dikemukakan sekiranya kesatuan masih BERMINAT.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Kelulusan Buku Perlembagaan',
            'code' => 'formk.approved-constitution',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan telah selesai dan Buku Perlembagaan akan dihantar kepada kesatuan sekerja. Permohonan selesai dan tamat.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'fund.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Permohonan tuan/puan telah diterima. Sila kemukakan dokumen-dokumen dalam masa 7 hari ke Pejabat Jabatan Hal Ehwal Kesatuan Sekerja (JHEKS) Negeri/Wilayah yang berkenaan seperti berikut:<br><br>i. Melengkapkan Borang Iklan Derma<br>ii. Minit Mesyuarat Agung/Persidangan Perwakilan *Usul Permohonan Pertama Kali<br>iii. Minit Mesyuarat Jawatankuasa Kerja/Agung *Usul Pembaharuan Kelulusan<br>iv. Anggaran Belanjawan Aktiviti<br>v. Surat Kebenaran Ketua Jabatan/ Kementerian Berkenaan (Sektor Kerajaan)<br>vi. Surat kebenaran Permit Penerbitan di Bawah Akta Mesin Cetak dan Penerbitan (AMCP) 1984. (Pindaan 2012)<br>vii. Salinan Perjanjian di antara Kesatuan dengan pihak ketiga<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'fund.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan pihak Jabatan masih belum menerima dokumen fizikal bagi permohonan ini. Sehubungan itu, permohonan Kutipan Dana & Wang kesatuan sekerja tuan/puan tidak dapat dipertimbangkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'fund.rejected',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan tidak diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'fund.document-approved',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan bawah permohonan [entity_name] telah didaftarkan. Sila sediakan dokumen kelulusan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (KS)',
            'code' => 'fund.approved-ks',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan Kutipan Dana & Wang kesatuan tuan/puan telah diluluskan. Surat kelulusan akan dikemukakan melalui pos.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (PWN)',
            'code' => 'fund.approved-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa permohonan [entity_name] telah didaftarkan pada [approved_at].<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Peringatan Penyata Penerimaan Dan Pembayaran',
            'code' => 'fund.reminder-statement',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah diingatkan bahawa Kesatuan sekerja hendaklah menghantar penyata penerimaan dan pembayaran berkenaan kutipan wang yang dirancangkan itu yang telah disahkan oleh tiga orang pegawai utama kesatuan sekerja ke Ibu Pejabat JHEKS selepas aktiviti selesai.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'insurance.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Permohonan tuan/puan telah diterima. Sila kemukakan dokumen-dokumen dalam masa 7 hari ke Pejabat Jabatan Hal Ehwal Kesatuan Sekerja (JHEKS) Negeri/Wilayah yang berkenaan seperti berikut:<br><br>i) 1 salinan Minit Mesyuarat Agung/Persidangan Perwakilan<br><br>ii) 1 salinan sebut harga daripada syarikat insuran.<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'insurance.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan pihak Jabatan masih belum menerima dokumen fizikal bagi permohonan ini. Sehubungan itu, permohonan Kutipan Dana & Wang kesatuan sekerja tuan/puan tidak dapat dipertimbangkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'insurance.rejected',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan tidak diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'insurance.document-approved',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan bawah permohonan [entity_name] telah didaftarkan. Sila sediakan dokumen kelulusan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (KS)',
            'code' => 'insurance.approved-ks',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan pembelian insuran kesatuan tuan/puan telah diluluskan. Surat kelulusan akan dikemukakan melalui pos.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (PWN)',
            'code' => 'insurance.approved-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa permohonan [entity_name] telah didaftarkan pada [approved_at].<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'levy.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Permohonan tuan/puan telah diterima. Sila kemukakan dokumen (secara fizikal) seperti senarai di bawah dalam tempoh 7 hari dari tarikh hari ini.<br><br>i. Borang U<br>ii. Minit Mesyuarat yang meluluskan usul pengenaan Levi<br>iii. Contoh Kertas Undi<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'levy.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan ditolak kerana dokumen fizikal tidak diterima dalam tempoh yang ditetapkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'levy.rejected',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan tidak diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'levy.document-approved',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan bawah permohonan [entity_name] telah didaftarkan. Sila sediakan dokumen kelulusan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (KS)',
            'code' => 'levy.approved-ks',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan telah diluluskan. Surat kelulusan akan dikemukakan melalui pos.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (PWN)',
            'code' => 'levy.approved-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa permohonan [entity_name] telah didaftarkan pada [approved_at].<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'formjl1.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Permohonan tuan/puan telah diterima. Sila kemukakan dokumen (secara fizikal) dalam tempoh 7 hari dari tarikh hari ini.<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'formjl1.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan ditolak kerana dokumen fizikal tidak diterima dalam tempoh yang ditetapkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'formjl1.rejected',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan tidak diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'formjl1.document-approved',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan bawah permohonan [entity_name] telah didaftarkan. Sila sediakan dokumen kelulusan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (KS)',
            'code' => 'formjl1.approved-ks',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan telah diluluskan. Surat kelulusan akan dikemukakan melalui pos.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (PWN)',
            'code' => 'formjl1.approved-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa permohonan [entity_name] telah didaftarkan pada [approved_at].<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'formn.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Permohonan tuan/puan telah diterima. Sila kemukakan dokumen (secara fizikal) dalam tempoh 7 hari dari tarikh hari ini.<br><br>• Maklumat asas kesatuan<br>• Bilangan anggota semasa Kesatuan<br>• Pecahan ahli mengikut jantina dan bangsa<br>• Penyata "1"<br>(i)Penyata penerimaan dan pembayaran,<br>(ii)Penyata aset-aset dan liabiliti-liabiliti (PENYATA KEWANGAN)<br>• Penyata "2" Pertukaran pegawai-pegawai yang dibuat sepanjang tahun, (i)pegawai-pegawai yang meninggalkan jawatan, (ii)pegawai-pegawai yang dilantik<br>• Pengisyhtiharan auditor<br>• Senarai sekuriti-sekuriti – pengesahan oleh Majistret (Pesuruhjaya Sumpah)<br>• Surat kelulusan Juruaudit Luar<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'formn.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan ditolak kerana dokumen fizikal tidak diterima dalam tempoh yang ditetapkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'formn.rejected',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan tidak diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'formn.document-approved',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan bawah permohonan [entity_name] telah didaftarkan. Sila sediakan dokumen kelulusan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (KS)',
            'code' => 'formn.approved-ks',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan telah diluluskan. Surat kelulusan akan dikemukakan melalui pos.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (PWN)',
            'code' => 'formn.approved-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Sukacita dimaklumkan bahawa permohonan [entity_name] telah didaftarkan pada [approved_at].<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'strike.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Permohonan tuan/puan telah diterima. Sila kemukakan dokumen (secara fizikal) dalam tempoh 7 hari dari tarikh hari ini.<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>**Kesatuan adalah dilarang mengadakan mogok sebelum tamat 7 hari dari tarikh dokumen Borang U diterima oleh PWN.<br><br>** Borang U hendaklah diterima oleh PWN dalam tempoh 14 hari dari tarikh keputusan undi.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'strike.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan ditolak kerana dokumen fizikal tidak diterima dalam tempoh yang ditetapkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'strike.rejected',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan tidak diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'strike.document-approved',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan bawah permohonan [entity_name] telah didaftarkan. Sila sediakan dokumen kelulusan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (KS)',
            'code' => 'strike.approved-ks',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan telah diluluskan. Surat kelulusan akan dikemukakan melalui pos.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (PWN)',
            'code' => 'strike.approved-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>[entity_name] didapati telah mematuhi prosidur mogok yang ditetapkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'lockout.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Permohonan tuan/puan telah diterima. Sila kemukakan dokumen (secara fizikal) dalam tempoh 7 hari dari tarikh hari ini.<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>**Kesatuan adalah dilarang mengadakan tutup pintu sebelum tamat 7 hari dari tarikh dokumen Borang U diterima oleh PWN.<br><br>** Borang U hendaklah diterima oleh PWN dalam tempoh 14 hari dari tarikh keputusan undi.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'lockout.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan ditolak kerana dokumen fizikal tidak diterima dalam tempoh yang ditetapkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'lockout.rejected',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan tidak diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'lockout.document-approved',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan bawah permohonan [entity_name] telah didaftarkan. Sila sediakan dokumen kelulusan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (KS)',
            'code' => 'lockout.approved-ks',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan telah diluluskan. Surat kelulusan akan dikemukakan melalui pos.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan (PWN)',
            'code' => 'lockout.approved-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>[entity_name] didapati telah mematuhi prosidur tutup pintu yang ditetapkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'complaint.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Aduan daripada [complaint_by] telah diterima pada [received_at] dengan rujukan fail [reference_no]. Pegawai pengendali adalah [officer_name].<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'complaint.distributed-pkpp',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Aduan telah dikemukakan kepada Pengarah Kanan Bahagian Perundangan Dan Penguatkuasaan. Sila kemaskini status dalam eTUIS dan Fail Aduan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'complaint.result-updated',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Keputusan KPKS telah disampaikan kepada PW. Sila kemaskini sistem.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'affidavit.sent-pkpp',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Terdapat satu permohonan semakan kehakiman dalam inbox yang perlu disemak oleh tuan/puan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'formieu.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Permohonan tuan/puan telah diterima. Sila kemukakan dokumen (secara fizikal) dalam tempoh 7 hari selepas pengisian maklumat secara online.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan',
            'code' => 'formf.approved',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan bahawa KP bersetuju pembatalan [entity_name] ini.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'formf.rejected-pwn',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan bahawa KP tidak setuju / KIV mengenai pembatalan [entity_name] ini.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Maklum Balas Pembatalan',
            'code' => 'formf.response-required',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan bahawa KP telah mengeluarkan notis pembatalan untuk [entity_name], diminta memberi maklum balas dalam tempoh 30 hari dari tarikh notis dikeluarkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'eligibility-issue.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Laporan tuan/puan telah diterima. Sila kemukakan dokumen (secara fizikal) dalam tempoh 14 hari dari tarikh hari ini.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'eligibility-issue.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan Ibu Pejabat masih belum menerima laporan daripada pihak tuan/puan. Sila kemukakan laporan dengan segera.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'eligibility-issue.result-kpppm',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Keputusan Isu Kelayakan oleh KPPPM telah dikeluarkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'pp30.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Permohonan tuan/puan telah diterima. Sila kemukakan dokumen (secara fizikal) dalam tempoh 7 hari dari tarikh permohonan online.<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'pp30.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan ditolak kerana dokumen fizikal tidak diterima dalam tempoh yang ditetapkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'pp30.result-updated',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Sila cetak surat makluman kepada Kesatuan Sekerja.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Permohonan Telah Dihantar',
            'code' => 'pp68.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Permohonan tuan/puan telah diterima. Sila kemukakan dokumen (secara fizikal) dalam tempoh 7 hari dari tarikh permohonan online.<br><br>Permohonan tanpa mengemukakan dokumen fizikal ke pejabat JHEKS dalam masa yang ditetapkan akan ditolak.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Dokumen Belum Diterima',
            'code' => 'pp68.not-received',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan ditolak kerana dokumen fizikal tidak diterima dalam tempoh yang ditetapkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Penolakan',
            'code' => 'pp68.rejected',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan tidak diluluskan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Sedia Dokumen Kelulusan',
            'code' => 'pp68.document-approved',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Sila cetak surat keputusan dan hantar kepada Kesatuan Sekerja.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Kelulusan',
            'code' => 'pp68.approved',
            'message' => 'Salam Negaraku Malaysia.<br><br>Tuan/Puan,<br><br>Adalah dimaklumkan permohonan kesatuan tuan/puan telah diluluskan. Surat kelulusan akan dikemukakan melalui pos.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Memo Pendakwaan Telah Dikeluarkan',
            'code' => 'prosecution.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Memo pendakwaan telah dikeluarkan, diminta PW melantik pegawai penyiasat. Sekian terima kasih.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Perlantikan Pegawai Penyiasat',
            'code' => 'prosecution.appointed_io',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Lantikan sebagai Pegawai Penyiasat kes no : [case_no]<br><br>Merujuk kepada perkara di atas,<br><br>2. Dimaklumkan bahawa tuan/puan telah dilantik sebagai Pegawai Penyiasat bagi kes no : [case_no]<br><br>3. Sehubungan itu tuan/puan di minta menjalankan siasatan lanjutan dan mengemukakan kertas siasatan ke Ibu Pejabat dalam tempoh 14 hari dari tarikh arahan ini.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Perlantikan Pegawai Pendakwa',
            'code' => 'prosecution.appointed_po',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Lantikan sebagai Pegawai Pendakwa kes no : [case_no]<br><br>Merujuk kepada perkara di atas,<br><br>2. Dimaklumkan bahawa tuan/puan telah dilantik sebagai Pegawai Pendakwa bagi kes no : [case_no]<br><br>3. Sehubungan itu tuan/puan di minta menjalankan siasatan lanjutan dan mengemukakan kertas siasatan ke Ibu Pejabat dalam tempoh 14 hari dari tarikh arahan ini.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Keputusan Kelulusan PUU',
            'code' => 'prosecution.approved-puu',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>PPU memberi izin untuk dakwa.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Keputusan Penolakan PUU',
            'code' => 'prosecution.rejected-puu',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>PPU tidak memberi izin untuk dakwa.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Keputusan Mahkamah',
            'code' => 'prosecution.result-updated',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Keputusan mahkamah telah dikeluarkan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        ///////////////////////////////////////////////////////////////////////////////////////////

        DB::table('notification')->insert([
            'name' => 'Laporan Telah Dihantar',
            'code' => 'enforcement.sent',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Laporan pemeriksaan berkanun keatas [entity_name] telah dikemukakan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);

        DB::table('notification')->insert([
            'name' => 'Notis Pematuhan Pemeriksaan Berkanun',
            'code' => 'enforcement.result-updated',
            'message' => 'Salam Negaraku Malaysia,<br><br>Tuan/ Puan,<br><br>Adalah dimaklumkan satu notis pematuhan telah dihantar ke email berdaftar kesatuan.<br><br>Sekian, terima kasih.',
            'created_by_user_id' => 1
        ]);
    }
}
