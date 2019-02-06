<?php
use Illuminate\Database\Seeder;
class MasterConstitutionTemplateSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 1 - NAMA DAN ALAMAT PEJABAT BERDAFTAR',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Nama Kesatuan Sekerja yang ditubuhkan menurut peraturan-peraturan ini ialah _entity_name_ (yang selepas ini disebut \'Kesatuan\').',
            'parent_constitution_template_id' => 1,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Pejabat berdaftar kesatuan ialah _address_ dan tempat mesyuaratnya ialah di pejabat berdaftar ini atau di mana-mana tempat lain yang ditetapkan oleh Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 1,
            'below_constitution_template_id' => 2,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 2 - TUJUAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 1,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Tujuan Kesatuan ini ialah untuk :-',
            'parent_constitution_template_id' => 4,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Mengorganisasikan pekerja-pekerja yang disebut di bawah Peraturan 3(1) sebagai anggota Kesatuan dan memajukan kepentingan mereka dalam bidang perhubungan perusahaan, kemasyarakatan dan ilmu pengetahuan.',
            'parent_constitution_template_id' => 5,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) Mengatur perhubungan di antara pekerja dengan majikan bagi maksud melaksanakan perhubungan perusahaan yang baik dan harmoni, meningkatkan daya pengeluaran dan memperolehi serta mengekalkan bagi anggota-anggotanya keselamatan pekerjaan, sukatan gaji yang adil dan sesuai serta syarat-syarat pekerjaan yang berpatutan.',
            'parent_constitution_template_id' => 5,
            'below_constitution_template_id' => 6,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) Mengatur perhubungan di antara anggota dengan anggota atau di antara anggota-anggota dengan pekerja-pekerja lain, di antara anggota dengan Kesatuan atau pegawai Kesatuan, atau di antara pegawai Kesatuan dengan Kesatuan dan menyelesaikan sebarang perselisihan atau pertikaian di antara mereka itu dengan cara aman dan bermuafakat atau melalui jentera penimbangtara menurut Peraturan 26 atau Peraturan 27.',
            'parent_constitution_template_id' => 5,
            'below_constitution_template_id' => 7,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) Memajukan kebajikan anggota-anggota Kesatuan dari segi sosial, ekonomi dan pendidikan dengan cara yang sah di sisi undang-undang.',
            'parent_constitution_template_id' => 5,
            'below_constitution_template_id' => 8,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) Memberi bantuan guaman kepada anggota-anggota berhubung dengan pekerjaan mereka jika dipersetujui oleh Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 5,
            'below_constitution_template_id' => 9,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) Memberi bantuan seperti pembiayaan semasa teraniaya atau semasa pertikaian perusahaan jika dipersetujui oleh Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 5,
            'below_constitution_template_id' => 10,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(g) Menganjurkan dan mengendalikan kursus, dialog, seminar dan sebagainya untuk faedah anggota-anggota Kesatuan khasnya dan para pekerja amnya.',
            'parent_constitution_template_id' => 5,
            'below_constitution_template_id' => 11,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(h) Mengendalikan urusan mengarang, menyunting, mencetak, menerbit dan mengedarkan sebarang jurnal, majalah, buletin atau penerbitan lain untuk menjayakan tujuan-tujuan Kesatuan ini atau untuk kepentingan anggota-anggota Kesatuan jika dipersetujui oleh Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 5,
            'below_constitution_template_id' => 12,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(i) Menubuhkan Tabung Wang Kebajikan dan menggubalkan peraturan-peraturan tambahan untuk mentadbir dan mengawal tabung itu jika dipersetujui oleh Mesyuarat Agung.',
            'parent_constitution_template_id' => 5,
            'below_constitution_template_id' => 13,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(j) Secara amnya melaksanakan sebarang tujuan Kesatuan Sekerja yang sah di sisi undang-undang.',
            'parent_constitution_template_id' => 5,
            'below_constitution_template_id' => 14,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Tujuan yang dinyatakan di bawah Peraturan 2 (1) hendaklah dilaksanakan menurut peraturan-peraturan ini, Akta Kesatuan Sekerja 1959 dan undang-undang bertulis yang lain yang ada kaitan.',
            'parent_constitution_template_id' => 4,
            'below_constitution_template_id' => 5,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 3 - ANGGOTA KESATUAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 4,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Keanggotaan kesatuan ini terbuka kepada _membership_target_ yang digaji oleh _paid_by_ kecuali mereka yang memegang jawatan pengurusan, eksekutif, sulit atau keselamatan. Pekerja-pekerja itu hendaklah berumur lebih dari 16 tahun dan mempunyai tempat kerjanya di _Work_At_ tertakluk kepada syarat bahawa seseorang yang diuntukkan pendidikan dalam sesuatu sekolah, politeknik, kolej, universiti, kolej universiti atau institusi lain yang ditubuhkan di bawah mana-mana undang-undang bertulis tidak boleh menjadi anggota Kesatuan kecuali sekiranya ia :-',
            'parent_constitution_template_id' => 17,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Sebenarnya seseorang pekerja menurut takrif dalam Akta Kesatuan Sekerja 1959; dan',
            'parent_constitution_template_id' => 18,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) Berumur lebih daripada 18 tahun',
            'parent_constitution_template_id' => 18,
            'below_constitution_template_id' => 19,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Permohonan untuk menjadi anggota hendaklah dilakukan dengan mengisi borang yang ditentukan oleh Kesatuan dan menyampaikannya kepada Setiausaha. Setiausaha hendaklah mengemukakan permohonan itu kepada Majlis Jawatankuasa Kerja untuk kelulusan. Majlis Jawatankuasa Kerja hendaklah memaklumkan keputusan permohonan tersebut kepada pemohon.',
            'parent_constitution_template_id' => 17,
            'below_constitution_template_id' => 18,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Setelah permohonan seseorang itu diluluskan oleh Majlis Jawatankuasa Kerja dan yuran masuk serta yuran bulanan yang pertama dijelaskan maka namanya hendaklah didaftarkan dalam Daftar Yuran/Keanggotaan sebagai anggota.',
            'parent_constitution_template_id' => 17,
            'below_constitution_template_id' => 21,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(4) Seseorang anggota itu hendaklah diberikan senaskah buku Peraturanperaturan Kesatuan dengan percuma apabila diterima sebagai anggota.',
            'parent_constitution_template_id' => 17,
            'below_constitution_template_id' => 22,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(5) Seseorang yang diterima masuk menjadi anggota dan kemudian berhenti daripada tempat kerjanya, tred atau industri seperti dinyatakan dalam Peraturan 3(1) akan dengan sendirinya terhenti dari menjadi anggota Kesatuan. Namanya hendaklah dikeluarkan daripada Daftar Yuran / Keanggotaan tertakluk kepada peruntukan berkenaan di bawah Peraturan Tambahan Tabung Wang Kebajikan (jika ada).',
            'parent_constitution_template_id' => 17,
            'below_constitution_template_id' => 23,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 4 - YURAN DAN TUNGGAKAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 17,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Yuran Kesatuan adalah seperti berikut :- <br><br>Yuran Masuk RM _entrance_fee_ <br><br>Yuran Bulanan RM _monthly_fee_ <br><br>Sebarang kenaikan yuran hendaklah diputuskan dengan undi rahsia menurut Peraturan 25.',
            'parent_constitution_template_id' => 25,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Yuran bulanan hendaklah dijelaskan sebelum tujuh (7) haribulan pada tiap-tiap bulan.',
            'parent_constitution_template_id' => 25,
            'below_constitution_template_id' => 26,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Seseorang anggota yang terhutang yuran selama tiga (3) bulan berturutturut akan dengan sendirinya terhenti daripada menjadi anggota Kesatuan. Haknya dalam Kesatuan akan hilang dan namanya hendaklah dipotong dari Daftar Yuran / Keanggotaan.',
            'parent_constitution_template_id' => 25,
            'below_constitution_template_id' => 27,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(4) Seseorang yang terhenti daripada menjadi anggota kerana tunggakan yuran boleh memohon semula untuk menjadi anggota menurut Peraturan 3 (2).',
            'parent_constitution_template_id' => 25,
            'below_constitution_template_id' => 28,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(5) Majlis Jawatankuasa Kerja berkuasa menetapkan kadar bayaran yuran bulanan yang kurang atau mengecualikan buat sementara waktu manamana anggota daripada bayaran yuran bulanan atau sebarang kutipan atau yuran khas (jika ada):-',
            'parent_constitution_template_id' => 25,
            'below_constitution_template_id' => 28,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) jika dia jatuh sakit teruk atau ditimpa kesusahan yang berat;',
            'parent_constitution_template_id' => 30,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) dia dibuang kerja, diberhentikan atau diketepikan dan masih menunggu keputusan sesuatu perundingan atau perbicaraan tentang pembuangan kerja, pemberhentian atau pengenepian itu; atau',
            'parent_constitution_template_id' => 30,
            'below_constitution_template_id' => 31,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) kerana sebarang sebab lain yang difikirkan munasabah dan wajar oleh Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 30,
            'below_constitution_template_id' => 32,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 5 - BERHENTI MENJADI ANGGOTA',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 25,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'Seseorang anggota yang ingin berhenti menjadi anggota Kesatuan hendaklah memberi notis secara bertulis sekurang-kurangnya seminggu sebelum tarikh berhenti kepada Setiausaha dan hendaklah menjelaskan terlebih dahulu semua tunggakan yuran dan hutang (jika ada). Nama anggota berkenaan hendaklah dipotong dari Daftar Yuran / Keanggotaan.',
            'parent_constitution_template_id' => 34,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 6 - HAK ANGGOTA',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 34,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'Semua anggota mempunyai hak yang sama dalam kesatuan kecuali dalam perkara-perkara tertentu yang dinyatakan di dalam peraturan-peraturan ini.',
            'parent_constitution_template_id' => 36,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 7 - KEWAJIPAN DAN TANGGUNGJAWAB ANGGOTA-ANGGOTA',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 36,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Setiap anggota hendaklah menjelaskan yurannya menepati masa dan mendapatkan resit rasmi bagi bayarannya itu. Pembayaran yuran bulanan dalam tempoh masa yang ditetapkan adalah menjadi tanggungjawab setiap anggota dan bukannya tanggungjawab pegawai-pegawai Kesatuan.',
            'parent_constitution_template_id' => 38,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Setiap anggota hendaklah memberitahu Setiausaha dengan segera apabila berpindah tempat tinggal atau bertukar tempat kerja.',
            'parent_constitution_template_id' => 38,
            'below_constitution_template_id' => 39,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Seseorang anggota yang menghadiri mesyuarat Kesatuan atau menggunakan pejabat Kesatuan hendaklah berkelakuan baik, jika tidak ia akan diarah keluar oleh seorang pegawai Kesatuan yang bertanggungjawab.',
            'parent_constitution_template_id' => 38,
            'below_constitution_template_id' => 40,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(4) Seseorang anggota tidak boleh mengeluarkan sebarang dokumen atau surat pekeliling tentang Kesatuan tanpa mendapat kelulusan Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 38,
            'below_constitution_template_id' => 41,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(5) Seseorang anggota tidak boleh mendedahkan sebarang hal tentang kegiatan Kesatuan kepada orang yang bukan anggota atau kepada pertubuhan lain atau pihak akhbar tanpa mendapat izin Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 38,
            'below_constitution_template_id' => 42,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 8 - PERLEMBAGAAN DAN PENTADBIRAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 38,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Kuasa yang tertinggi sekali di dalam Kesatuan terletak kepada Mesyuarat Agung melainkan perkara-perkara yang hendaklah diputuskan melalui undi rahsia menurut Peraturan 25.',
            'parent_constitution_template_id' => 44,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Tertakluk kepada syarat tersebut di atas Kesatuan hendaklah ditadbirkan oleh Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 44,
            'below_constitution_template_id' => 45,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 9 - MESYUARAT AGUNG _MEETING_YEARLY_ TAHUNAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 44,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Mesyuarat Agung _Meeting_Yearly_ Tahunan hendaklah diadakan seberapa segera selepas 31 Mac dan tidak lewat dari 30 September setiap _meeting_yearly_ tahunan. Tarikh, masa dan tempat mesyuarat itu hendaklah ditetapkan oleh Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 47,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Notis permulaan bagi Mesyuarat Agung _Meeting_Yearly_ Tahunan yang menyatakan tarikh, masa, tempat mesyuarat, permintaan usul-usul untuk perbincangan dalam mesyuarat itu (termasuk usul pindaan peraturan) dan penamaan calon bagi pemilihan anggota Majlis Jawatankuasa Kerja hendaklah dihantar oleh Setiausaha kepada semua anggota sekurang-kurangnya 30 hari sebelum tarikh mesyuarat. “Anggota” di sini bermakna anggota yang berhak mengundi pada masa pengundian itu dijalankan.',
            'parent_constitution_template_id' => 47,
            'below_constitution_template_id' => 48,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Pencalonan bagi setiap jawatan dalam kesatuan dan usul-usul untuk perbincangan dalam Mesyuarat Agung _Meeting_Yearly_ Tahunan hendaklah dihantar oleh anggota kepada Setiausaha sekurang-kurangnya 21 hari sebelum Mesyuarat Agung _Meeting_Yearly_ Tahunan itu.',
            'parent_constitution_template_id' => 47,
            'below_constitution_template_id' => 49,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(4) Semua pencalonan hendaklah dibuat dengan mengemukakan borang yang ditentukan oleh Kesatuan dan hendaklah mengandungi perkara-perkara yang berikut:- <br><br>Nama jawatan yang ditandingi, nama calon, nombor kad pengenalan, nombor keanggotaan, tarikh lahir, alamat kediaman, pekerjaan dan nombor sijil kerakyatan/taraf kerakyatan.',
            'parent_constitution_template_id' => 47,
            'below_constitution_template_id' => 50,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(5) Sesuatu pencalonan tidak sah jika:',
            'parent_constitution_template_id' => 47,
            'below_constitution_template_id' => 51,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) ia tidak ditandatangani oleh seorang pencadang dan seorang penyokong yang merupakan anggota-anggota berhak; dan',
            'parent_constitution_template_id' => 52,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) ia tidak mengandungi persetujuan bertulis calon yang hendak bertanding.',
            'parent_constitution_template_id' => 52,
            'below_constitution_template_id' => 53,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(6) Setiausaha hendaklah menghantar kepada semua anggota sekurang kurangnya 14 hari sebelum tarikh Mesyuarat Agung _Meeting_Yearly_ Tahunan suatu agenda yang mengandungi usul-usul, penyata tahunan dan penyata kewangan (jika ada) untuk perbincangan dan kelulusan (serta kertas undi rahsia) mengikut kembaran kepada peraturan-peraturan ini bagi pemilihan Majlis Jawatankuasa Kerja dan sebarang perkara yang akan diputuskan dengan undi rahsia (jika ada).',
            'parent_constitution_template_id' => 47,
            'below_constitution_template_id' => 52,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(7) Satu perempat (1/4) dari jumlah anggota yang berhak akan menjadi kuorum Mesyuarat Agung _Meeting_Yearly_ Tahunan.',
            'parent_constitution_template_id' => 47,
            'below_constitution_template_id' => 55,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(8) Jika selepas satu (1) jam dari masa yang ditentukan bilangan anggota yang hadir tidak mencukupi maka mesyuarat itu hendaklah ditangguhkan kepada suatu tarikh (tidak lewat dari empat belas hari kemudian) yang ditetapkan oleh Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 47,
            'below_constitution_template_id' => 56,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(9) Sekiranya kuorum bagi Mesyuarat Agung _Meeting_Yearly_ Tahunan yang ditangguhkan itu masih belum mencukupi pada masa yang ditentukan maka anggota-anggota yang hadir berkuasa menguruskan mesyuarat itu, akan tetapi tidak berkuasa meminda peraturan-peraturan Kesatuan.',
            'parent_constitution_template_id' => 47,
            'below_constitution_template_id' => 57,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(10) Urusan Mesyuarat Agung _Meeting_Yearly_ Tahunan antara lain ialah :-',
            'parent_constitution_template_id' => 47,
            'below_constitution_template_id' => 58,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) menerima dan meluluskan laporan-laporan daripada Setiausaha, Bendahari dan Majlis Jawatankuasa Kerja;',
            'parent_constitution_template_id' => 59,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) membincang dan memutuskan sebarang perkara atau usul tentang kebajikan anggota-anggota dan kemajuan Kesatuan;',
            'parent_constitution_template_id' => 59,
            'below_constitution_template_id' => 60,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) melantik :-',
            'parent_constitution_template_id' => 59,
            'below_constitution_template_id' => 61,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'i) Pemegang Amanah, jika perlu;',
            'parent_constitution_template_id' => 62,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'ii) Ahli Jemaah Penimbangtara, jika perlu;',
            'parent_constitution_template_id' => 62,
            'below_constitution_template_id' => 63,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'iii) Juruaudit Dalam; dan',
            'parent_constitution_template_id' => 62,
            'below_constitution_template_id' => 64,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'iv) Pemeriksa Undi; untuk melaksanakan pemilihan pegawai-pegawai Kesatuan bagi tempoh yang akan datang.',
            'parent_constitution_template_id' => 62,
            'below_constitution_template_id' => 65,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) meluluskan perlantikan pegawai atau pekerja sepenuh masa Kesatuan sekiranya perlu dan menetapkan skel gaji serta syaratsyarat pekerjaannya;',
            'parent_constitution_template_id' => 59,
            'below_constitution_template_id' => 62,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) membincang dan memutuskan perkara-perkara lain yang terkandung di dalam agenda; dan',
            'parent_constitution_template_id' => 59,
            'below_constitution_template_id' => 67,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) menerima penyata Jemaah Pemeriksa Undi tentang pemilihan Majlis Jawatankuasa Kerja dan perkara-perkara lain (jika ada).',
            'parent_constitution_template_id' => 59,
            'below_constitution_template_id' => 68,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 10 - MESYUARAT AGUNG LUARBIASA',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 47,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Mesyuarat Agung Luarbiasa hendaklah diadakan :-',
            'parent_constitution_template_id' => 70,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) apabila difikirkan mustahak oleh Majlis Jawatankuasa Kerja; atau',
            'parent_constitution_template_id' => 71,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) apabila menerima permintaan bersama secara bertulis daripada sekurang-kurangnya satu perempat (1/4) daripada jumlah anggota yang berhak mengundi. Permintaan itu hendaklah menyatakan tujuan dan sebab anggota-anggota berkenaan mahu mesyuarat itu diadakan.',
            'parent_constitution_template_id' => 71,
            'below_constitution_template_id' => 72,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Mesyuarat Agung Luarbiasa yang diminta oleh anggota-anggota atau yang difikirkan mustahak oleh Majlis Jawatankuasa Kerja hendaklah diadakan oleh Setiausaha dalam tempoh 21 hari dari tarikh permintaan itu diterima. Notis dan agenda hendaklah disampaikan oleh Setiausaha kepada anggota-anggota sekurang-kurangnya tujuh (7) hari sebelum tarikh Mesyuarat Agung Luarbiasa.',
            'parent_constitution_template_id' => 70,
            'below_constitution_template_id' => 71,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Peruntukan-peruntukan Peraturan 9 tentang kuorum dan penangguhan mesyuarat agung adalah terpakai kepada Mesyuarat Agung Luarbiasa yang diadakan kerana difikirkan mustahak oleh Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 70,
            'below_constitution_template_id' => 74,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(4) Bagi Mesyuarat Agung Luarbiasa yang diminta oleh anggota-anggota ditangguhkan kerana tidak cukup kuorum mengikut peraturan 9(7) maka mesyuarat yang ditangguhkan itu hendaklah dibatalkan sekiranya kuorum masih tidak diperolehi selepas satu (1) jam dari masa yang dijadualkan. Mesyuarat Agung Luarbiasa bagi perkara yang sama tidak boleh diminta lagi dalam tempoh enam (6) bulan dari tarikh mesyuarat itu dibatalkan.',
            'parent_constitution_template_id' => 70,
            'below_constitution_template_id' => 75,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(5) Jika Mesyuarat Agung _Meeting_Yearly_ Tahunan tidak dapat diadakan dalam masa yang ditentukan mengikut Peraturan 9, maka Mesyuarat Agung Luarbiasa berkuasa menjalankan sebarang kerja yang lazimnya dijalankan oleh Mesyuarat Agung dengan syarat Mesyuarat Agung Luarbiasa yang demikian mestilah diadakan sebelum 31 Disember tahun yang berkenaan.',
            'parent_constitution_template_id' => 70,
            'below_constitution_template_id' => 76,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 11 - PEGAWAI DAN PEKERJA KESATUAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 70,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Pegawai Kesatuan bererti seseorang Ahli Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 78,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Seseorang tidak boleh dipilih atau bertugas sebagai pegawai kesatuan jika ia :-',
            'parent_constitution_template_id' => 78,
            'below_constitution_template_id' => 79,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) bukan anggota Kesatuan;',
            'parent_constitution_template_id' => 80,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) belum sampai umur 21 tahun;',
            'parent_constitution_template_id' => 80,
            'below_constitution_template_id' => 81,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) bukan warganegara Malaysia;',
            'parent_constitution_template_id' => 80,
            'below_constitution_template_id' => 82,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) pernah menjadi anggota eksekutif mana-mana kesatuan yang pendaftarannya telah dibatalkan di bawah seksyen 15(1) (b) (iv), (v) dan (vi) Akta Kesatuan Sekerja 1959 atau enakmen yang telah dimansuhkan oleh Akta itu;',
            'parent_constitution_template_id' => 80,
            'below_constitution_template_id' => 83,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) pernah disabitkan oleh mahkamah kerana kesalahan pecah amanah, pemerasan atau intimidasi atau apa-apa kesalahan di bawah Seksyen 49, 50 atau 50A Akta Kesatuan Sekerja 1959 atau sebarang kesalahan lain yang pada pendapat Ketua Pengarah Kesatuan Sekerja menyebabkan tidak layak menjadi pegawai sesebuah kesatuan sekerja;',
            'parent_constitution_template_id' => 80,
            'below_constitution_template_id' => 84,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) seorang pemegang jawatan (office bearer) atau pekerja sesebuah parti politik; atau',
            'parent_constitution_template_id' => 80,
            'below_constitution_template_id' => 85,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(g) seorang yang masih bankrap.',
            'parent_constitution_template_id' => 80,
            'below_constitution_template_id' => 86,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Majlis Jawatankuasa Kerja berkuasa menggaji pekerja-pekerja sepenuh masa yang difikirkan perlu setelah mendapat kelulusan Mesyuarat Agung. Seseorang pekerja Kesatuan selain daripada mereka yang tersebut dalam “proviso” kepada seksyen 29 (1) Akta Kesatuan Sekerja 1959, tidak boleh menjadi pegawai Kesatuan atau bertugas dan bertindak sedemikian rupa sehingga urusan hal ehwal Kesatuan seolah-olah dalam pengawalannya.',
            'parent_constitution_template_id' => 78,
            'below_constitution_template_id' => 80,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(4) Seseorang tidak boleh digaji sebagai pekerja Kesatuan jika dia :-',
            'parent_constitution_template_id' => 78,
            'below_constitution_template_id' => 88,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) bukan warganegara Malaysia;',
            'parent_constitution_template_id' => 89,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) telah disabitkan oleh sesebuah mahkamah kerana melakukan suatu kesalahan jenayah dan belum lagi mendapat pengampunan bagi kesalahan tersebut dan kesalahan itu pada pendapat Ketua Pengarah Kesatuan Sekerja tidak melayakkannya digaji oleh sesebuah kesatuan sekerja;',
            'parent_constitution_template_id' => 89,
            'below_constitution_template_id' => 90,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) seorang pegawai atau pekerja sesebuah kesatuan sekerja yang lain; atau',
            'parent_constitution_template_id' => 89,
            'below_constitution_template_id' => 91,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) seorang pemegang jawatan (office-bearer) atau pekerja sesebuah parti politik.',
            'parent_constitution_template_id' => 89,
            'below_constitution_template_id' => 92,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 12 - MAJLIS JAWATANKUASA KERJA',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 78,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Majlis Jawatankuasa Kerja adalah menjadi badan yang menjalankan pentadbiran dan pengurusan hal ehwal Kesatuan termasuk hal pertikaian perusahaan dalam masa di antara dua Mesyuarat Agung _Meeting_Yearly_ Tahunan.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Majlis Jawatankuasa Kerja hendaklah terdiri daripada seorang Presiden, seorang Naib Presiden, seorang Setiausaha, seorang Penolong Setiausaha, seorang Bendahari, seorang Penolong Bendahari dan _total_ajk_text_ ( _total_ajk_ ) orang Ahli Jawatankuasa. Mereka dikenali sebagai Pegawai-Pegawai Kesatuan.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 95,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Ahli Jawatankuasa Kerja hendaklah dipilih tiap-tiap _ajk_yearly_ tahunan dengan undi rahsia oleh semua anggota yang berhak.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 96,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(4) Sekiranya seorang calon bagi sesuatu jawatan tidak ditandingi dan pencalonannya telah dilaksanakan menurut cara-cara yang ditentukan dalam Peraturan 9 (4), maka dia akan dianggap telah dipilih dan namanya akan diasingkan dari kertas undi bagi pemilihan pegawai-pegawai.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 97,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(5) Majlis Jawatankuasa Kerja yang pertama hendaklah dipilih dengan undi rahsia dalam masa enam (6) bulan setelah Kesatuan didaftarkan dan sehingga pemilihan itu dijalankan.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 98,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(6) Majlis Jawatankuasa Penaja yang dipilih semasa penubuhan Kesatuan hendaklah menguruskan hal ehwal Kesatuan. Majlis Jawatankuasa Penaja juga hendaklah melantik jemaah pemeriksa undi sementara untuk mengendalikan pemilihan pegawai yang pertama. ',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 99,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(7) Ahli Majlis Jawatankuasa Kerja akan memegang jawatan daripada satu Mesyuarat Agung _Meeting_Yearly_ Tahunan ke satu Mesyuarat Agung _Meeting_Yearly_ Tahunan berikutnya.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 100,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(8) Sekiranya dalam satu Mesyuarat Agung Luarbiasa suatu usul "tidak percaya" telah diluluskan terhadap Majlis Jawatankuasa Kerja oleh dua pertiga (2/3) suara terbanyak, Majlis Jawatankuasa Kerja hendaklah dengan serta merta bertugas sebagai pengurus sementara dan hendaklah mengadakan pemilihan semula pegawai-pegawai Kesatuan dengan undi rahsia dalam tempoh sebulan setelah Mesyuarat Agung Luarbiasa itu. Pegawai-pegawai yang dipilih dengan cara ini akan memegang jawatan sehingga Mesyuarat Agung _Meeting_Yearly_ Tahunan yang akan datang.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 101,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(9) Apabila berlakunya pertukaran pegawai-pegawai, pegawai atau Majlis Jawatankuasa Kerja yang bakal meninggalkan jawatan hendaklah dalam satu (1) minggu menyerahkan segala rekod berhubung dengan jawatannya kepada pegawai atau Majlis Jawatankuasa Kerja yang mengambil alih jawatan.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 102,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(10) Pemberitahuan tentang pemilihan pegawai-pegawai hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja dalam tempoh 14 hari selepas pemilihan itu.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 103,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(11) Majlis Jawatankuasa Kerja hendaklah bermesyuarat sekurang-kurangnya tiga (3) bulan sekali dan setengah (1/2) daripada jumlah anggotanya akan menjadi kuorum mesyuarat. Minit mesyuarat Majlis Jawatankuasa Kerja hendaklah disahkan pada mesyuarat yang berikutnya.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 104,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(12) Mesyuarat Majlis Jawatankuasa Kerja hendaklah diadakan oleh Setiausaha dengan arahan atau persetujuan Presiden.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 105,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(13) Notis dan agenda mesyuarat hendaklah diberi kepada semua ahli Majlis Jawatankuasa Kerja sekurang-kurangnya lima (5) hari sebelum mesyuarat.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 106,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(14) Permintaan secara bertulis untuk mengadakan mesyuarat Majlis Jawatankuasa Kerja boleh dibuat oleh sekurang-kurangnya setengah daripada jumlah ahli Majlis Jawatankuasa Kerja. Permintaan itu hendaklah dikemukakan kepada Setiausaha yang akan mengadakan mesyuarat yang diminta dalam tempoh 14 hari dari tarikh permintaan berkenaan diterima.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 107,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(15) Apabila berlaku sesuatu perkara yang memerlukan keputusan serta-merta oleh Majlis Jawatankuasa Kerja dan di mana tidak dapat diadakan mesyuarat tergempar maka Setiausaha boleh dengan persetujuan Presiden mendapatkan keputusan melalui surat pekeliling. Syarat-syarat yang tersebut di bawah ini hendaklah disempurnakan sebelum perkara itu boleh dianggap sebagai telah diputuskan oleh Majlis Jawatankuasa Kerja :-',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 108,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) perkara dan tindakan yang dicadangkan hendaklah dinyatakan dengan jelas dan salinan surat pekeliling itu disampaikan kepada semua ahli Majlis Jawatankuasa Kerja;',
            'parent_constitution_template_id' => 109,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) sekurang-kurangnya setengah daripada jumlah ahli Majlis Jawatankuasa Kerja telah menyatakan secara bertulis sama ada mereka itu bersetuju atau tidak dengan cadangan tersebut; dan',
            'parent_constitution_template_id' => 109,
            'below_constitution_template_id' => 110,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) suara yang terbanyak daripada mereka yang menyatakan sokongan atau sebaliknya tentang cadangan tersebut akan menjadi keputusan',
            'parent_constitution_template_id' => 109,
            'below_constitution_template_id' => 111,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(16) Keputusan yang didapati melalui surat pekeliling hendaklah dilaporkan oleh Setiausaha dalam mesyuarat Majlis Jawatankuasa Kerja yang akan datang dan dicatatkan dalam minit mesyuarat itu.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 109,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(17) Ahli Majlis Jawatankuasa Kerja yang tidak menghadiri mesyuarat tiga (3) kali berturut-turut tidak lagi berhak menyandang jawatannya kecuali dia dapat memberi alasan yang memuaskan kepada Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 113,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(18) Apabila seseorang pegawai Kesatuan meninggal dunia, berhenti atau terlucut hak maka calon yang mendapat undi yang terkebawah sedikit bagi jawatan berkenaan dalam masa undian yang lalu hendaklah dijemput untuk mengisi tempat yang kosong itu. Bagi jawatan Presiden, Naib Presiden, Setiausaha, Penolong Setiausaha, Bendahari atau Penolong Bendahari, calon tersebut hendaklah mendapat tidak kurang daripada satu perempat (1/4) jumlah undi yang dibuang bagi jawatan itu.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 114,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(19) Jika tiada calon yang layak atau calon yang layak enggan menerima jawatan itu, Majlis Jawatankuasa Kerja berkuasa melantik seseorang anggota yang layak untuk mengisi kekosongan itu.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 115,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(20) Setiausaha hendaklah menghantar notis pertukaran pegawai-pegawai kepada Ketua Pengarah Kesatuan Sekerja dalam masa 14 hari dari tarikh pertukaran dibuat.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 116,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(21) Majlis Jawatankuasa Kerja boleh menggunakan sebarang kuasa dan menjalankan sebarang kerja yang difikirkan perlu bagi mencapai tujuantujuan Kesatuan dan untuk memajukan kepentingannya dengan mematuhi peraturan-peraturan ini, Akta Kesatuan Sekerja 1959 dan Peraturanperaturan Kesatuan Sekerja 1959.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 117,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(22) Majlis Jawatankuasa Kerja hendaklah mengawal tabung wang Kesatuan supaya tidak dibelanjakan dengan boros atau disalahgunakan. Majlis Jawatankuasa Kerja hendaklah mengarahkan Setiausaha atau pegawai yang lain mengambil langkah-langkah sewajarnya supaya seseorang pegawai, pekerja ataupun anggota Kesatuan didakwa di mahkamah kerana menyalahguna atau mengambil secara tidak sah wang atau harta kepunyaan Kesatuan.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 118,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(23) Majlis Jawatankuasa Kerja hendaklah mengarah Setiausaha atau pegawai yang lain supaya mengurus kerja-kerja Kesatuan dengan sempurna.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 119,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(24) Tertakluk kepada Peraturan 11 (3), Majlis Jawatankuasa Kerja boleh menggaji mana-mana pegawai atau pekerja sepenuh masa yang difikirkan mustahak atas kadar gaji dan syarat-syarat pekerjaan yang diluluskan oleh Mesyuarat Agung.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 120,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(25) Pegawai-pegawai atau pekerja-pekerja Kesatuan boleh digantung kerja atau diberhentikan oleh Majlis Jawatankuasa Kerja kerana kelalaian, tidak amanah, tidak cekap atau enggan melaksanakan sebarang keputusan atau kerana sebab-sebab lain yang difikirkan munasabah atau wajar demi kepentingan Kesatuan.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 121,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(26) Majlis Jawatankuasa Kerja akan memberi arahan kepada Pemegangpemegang Amanah tentang pelaburan wang Kesatuan.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 122,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(27) Majlis Jawatankuasa Kerja boleh menggantung atau memecat keanggotaan atau melarang daripada memegang jawatan seseorang anggota:-',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 123,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Jika didapati bersalah kerana cuba hendak merosakkan Kesatuan atau melakukan perbuatan yang melanggar peraturan-peraturan ini atau membuat atau melibatkan diri dengan sebarang perbuatan mencela, mengeji atau mencerca Kesatuan, Pegawai atau dasar Kesatuan.',
            'parent_constitution_template_id' => 123,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) Sebelum tindakan tersebut diambil, anggota berkenaan hendaklah diberi peluang untuk membela diri terhadap tuduhan berkenaan. Sesuatu perintah penggantungan, pemecatan atau larangan hendaklah bertulis dan menyatakan dengan jelas bentuk dan alasan tentang penggantungan, pemecatan atau larangan tersebut. Jika berkenaan, perintah itu hendaklah juga menyatakan tempoh ianya berkuatkuasa dan syarat-syarat yang membolehkan ia ditarik balik.',
            'parent_constitution_template_id' => 123,
            'below_constitution_template_id' => 124,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) Jika seseorang yang telah digantung faedahnya, dipecat atau dilarang daripada memegang jawatan rasa terkilan, dia berhak merujukkan kilanan berkenaan melalui Majlis Jawatankuasa Kerja untuk diselesaikan oleh Jemaah Penimbangtara di Peraturan 26 dan Peraturan 27 atau merayu terus kepada Mesyuarat Agung di mana keputusan Mesyuarat Agung adalah muktamad.',
            'parent_constitution_template_id' => 123,
            'below_constitution_template_id' => 125,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(28) Dalam masa antara Mesyuarat Agung _Meeting_Yearly_ Tahunan, Majlis Jawatankuasa Kerja hendaklah mentafsirkan peraturan-peraturan Kesatuan dan jika perlu, akan menentukan perkara yang tidak ternyata dalam Peraturan-peraturan ini.',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 123,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(29) Sebarang keputusan Majlis Jawatankuasa Kerja hendaklah dipatuhi oleh semua anggota Kesatuan kecuali sehingga ianya dibatalkan oleh suatu ketetapan dalam Mesyuarat Agung _Meeting_Yearly_ Tahunan melainkan keputusan yang berkehendakkan undi rahsia',
            'parent_constitution_template_id' => 94,
            'below_constitution_template_id' => 128,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 12.A - JAWATANKUASA TEMPATAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 94,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Majlis Jawatankuasa Kerja boleh menubuhkan Jawatankuasa Tempatan di sebarang daerah / tempat pekerjaan untuk menjaga kepentingan anggotaanggota di daerah / tempat pekerjaan itu jika difikirkan perlu.',
            'parent_constitution_template_id' => 130,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Komposisi keanggotaan bagi tiap-tiap Jawatankuasa Tempatan hendaklah ditentukan oleh Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 130,
            'below_constitution_template_id' => 131,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Majlis Jawatankuasa Kerja hendaklah menggubal peraturan-peraturan kecil sejajar dengan peraturan-peraturan ini bagi menentukan cara-cara penubuhan, pembubaran, perlantikan anggota Jawatankuasa Tempatan dan tugas-tugas Jawatankuasa Tempatan.',
            'parent_constitution_template_id' => 130,
            'below_constitution_template_id' => 132,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(4) Setiap Jawatankuasa Tempatan akan bertugas sebagai penyelaras sahaja dan tidak mempunyai kuasa eksekutif selain daripada kuasa yang diberikan kepadanya secara bertulis oleh Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 130,
            'below_constitution_template_id' => 133,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 13 - TUGAS PEGAWAI-PEGAWAI KESATUAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 130,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Presiden',
            'parent_constitution_template_id' => 135,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Menjadi Pengerusi semua mesyuarat dan bertanggungjawab tentang ketenteraman dan kesempurnaan mesyuarat-mesyuarat itu serta mempunyai undian pemutus dalam semua isu semasa pada masa mesyuarat kecuali perkara-perkara yang melibatkan undi rahsia;',
            'parent_constitution_template_id' => 136,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) mengesahkan dan menandatangani minit tiap-tiap mesyuarat;',
            'parent_constitution_template_id' => 136,
            'below_constitution_template_id' => 137,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) menandatangani semua cek Kesatuan bersama-sama dengan Setiausaha dan Bendahari; dan',
            'parent_constitution_template_id' => 136,
            'below_constitution_template_id' => 138,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) mengawasi pentadbiran dan perjalanan Kesatuan serta memastikan peraturan-peraturan kesatuan dipatuhi oleh semua yang berkenaan.',
            'parent_constitution_template_id' => 136,
            'below_constitution_template_id' => 139,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Naib Presiden',
            'parent_constitution_template_id' => 135,
            'below_constitution_template_id' => 136,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Membantu Presiden dalam menjalankan tugas-tugasnya dan memangku jawatan Presiden pada masa ketiadaannya; dan',
            'parent_constitution_template_id' => 141,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) menjalankan tugas-tugas sebagaimana diarahkan oleh Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 141,
            'below_constitution_template_id' => 142,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Setiausaha',
            'parent_constitution_template_id' => 135,
            'below_constitution_template_id' => 141,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Mengelolakan kerja-kerja Kesatuan mengikut peraturan-peraturan ini dan melaksanakan perintah-perintah dan arahan-arahan Mesyuarat Agung, atau Majlis Jawatankuasa Kerja;',
            'parent_constitution_template_id' => 144,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) mengawasi kerja-kerja kakitangan Kesatuan dan bertanggungjawab tentang surat-menyurat dan menyimpan buku-buku, surat-surat keterangan dan kertas-kertas Kesatuan mengikut cara dan aturan yang diarahkan oleh Majlis Jawatankuasa Kerja;',
            'parent_constitution_template_id' => 144,
            'below_constitution_template_id' => 145,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) menetapkan serta menyediakan agenda mesyuarat Majlis Jawatankuasa Kerja dengan persetujuan Presiden dan menghadiri semua mesyuarat, menulis minit-minit mesyuarat dan menyediakan Penyata Tahunan Kesatuan untuk Mesyuarat Agung _Meeting_Yearly_ Tahunan;',
            'parent_constitution_template_id' => 144,
            'below_constitution_template_id' => 146,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) menyediakan atau menguruskan supaya disediakan Penyatapenyata Tahunan dan surat keterangan lain yang dikehendaki oleh Ketua Pengarah Kesatuan Sekerja dalam masa yang ditentukan;',
            'parent_constitution_template_id' => 144,
            'below_constitution_template_id' => 147,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) menyimpan dan mengemaskini suatu Daftar Keanggotaan yang mengandungi Nama Anggota, Alamat Kediaman, Nombor Kad Pengenalan dan Tarikh Menjadi Anggota Kesatuan; dan',
            'parent_constitution_template_id' => 144,
            'below_constitution_template_id' => 148,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) menandatangani semua cek Kesatuan bersama dengan Presiden dan Bendahari.',
            'parent_constitution_template_id' => 144,
            'below_constitution_template_id' => 149,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(4) Penolong Setiausaha',
            'parent_constitution_template_id' => 135,
            'below_constitution_template_id' => 144,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Membantu Setiausaha dalam urusan pentadbiran Kesatuan dan memangku jawatan Setiausaha pada masa ketiadaannya; dan',
            'parent_constitution_template_id' => 151,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) menjalankan tugas-tugas sebagaimana diarah oleh Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 151,
            'below_constitution_template_id' => 152,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(5) Bendahari',
            'parent_constitution_template_id' => 135,
            'below_constitution_template_id' => 151,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Bertanggungjawab dalam urusan Penerimaan dan Pembayaran wang Kesatuan dan urusan penyimpanan dokumen kewangan sebagaimana yang dikehendaki oleh Peraturan-peraturan Kesatuan Sekerja 1959;',
            'parent_constitution_template_id' => 154,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) mengeluarkan Resit Rasmi bagi sebarang wang yang diterima;',
            'parent_constitution_template_id' => 154,
            'below_constitution_template_id' => 155,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) bertanggungjawab tentang keselamatan simpanan buku-buku kewangan dan surat-surat keterangan yang berkenaan di Ibu Pejabat. Buku-buku dan surat-surat keterangan ini tidak boleh dikeluarkan dari tempat rasminya tanpa kebenaran yang bertulis daripada Presiden pada tiap-tiap kali ia hendak dikeluarkan;',
            'parent_constitution_template_id' => 154,
            'below_constitution_template_id' => 156,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) menyediakan Penyata Kewangan bagi tiap-tiap Mesyuarat Majlis Jawatankuasa Kerja dan bagi Mesyuarat Agung ; dan',
            'parent_constitution_template_id' => 154,
            'below_constitution_template_id' => 157,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) menandatangani semua cek Kesatuan bersama dengan Presiden dan Setiausaha.',
            'parent_constitution_template_id' => 154,
            'below_constitution_template_id' => 158,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(6) Penolong Bendahari',
            'parent_constitution_template_id' => 135,
            'below_constitution_template_id' => 154,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Membantu Bendahari dalam urusan kewangan Kesatuan dan memangku jawatan Bendahari pada masa ketiadaannya; dan',
            'parent_constitution_template_id' => 160,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) menjalankan tugas-tugas sebagaimana diarah oleh Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 160,
            'below_constitution_template_id' => 161,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 14 - PEMEGANG AMANAH',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 135,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Tiga (3) orang Pemegang Amanah yang berumur tidak kurang dari 21 tahun dan bukan Setiausaha atau Bendahari Kesatuan hendaklah dilantik / dipilih di dalam Mesyuarat Agung _Meeting_Yearly_ Tahunan yang pertama. Mereka akan menyandang jawatan itu selama yang dikehendaki oleh Kesatuan.',
            'parent_constitution_template_id' => 163,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Sebarang harta (tanah, bangunan, pelaburan dan lain-lain) yang dimiliki oleh Kesatuan hendaklah diserahkan kepada mereka untuk diuruskan sebagaimana diarahkan oleh Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 163,
            'below_constitution_template_id' => 164,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Pemegang Amanah tidak boleh menjual, menarik balik atau memindah milik sebarang harta tanpa persetujuan dan kuasa daripada Majlis Jawatankuasa Kerja yang disampaikan dengan bertulis oleh Setiausaha dan Bendahari.',
            'parent_constitution_template_id' => 163,
            'below_constitution_template_id' => 165,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(4) Seseorang Pemegang Amanah boleh diberhentikan daripada jawatannya oleh Majlis Jawatankuasa Kerja kerana tidak sihat, tidak sempurna fikiran, tidak berada dalam negeri atau kerana sebarang sebab lain yang menyebabkan dia tidak boleh menjalankan tugasnya atau tidak dapat menyempurnakan tugasnya dengan memuaskan.',
            'parent_constitution_template_id' => 163,
            'below_constitution_template_id' => 166,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(5) Jika seseorang Pemegang Amanah meninggal dunia, berhenti atau diberhentikan maka kekosongan itu hendaklah diisi oleh mana-mana anggota yang dilantik oleh Majlis Jawatankuasa Kerja sehingga Mesyuarat Agung yang akan datang.',
            'parent_constitution_template_id' => 163,
            'below_constitution_template_id' => 167,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(6) Mesyuarat Agung boleh melantik sebuah Syarikat Pemegang Amanah yang ditakrifkan di bawah Akta Syarikat Amanah 1949 (Trust Companies Act 1949) atau undang-undang lain yang bertulis yang mengawal syarikatsyarikat Pemegang Amanah di Malaysia untuk menjadi Pemegang Amanah yang tunggal bagi Kesatuan ini. Jika syarikat Pemegang Amanah tersebut dilantik maka rujukan "Pemegang Amanah" dalam peraturan-peraturan ini hendaklah difahamkan sebagai Pemegang Amanah yang dilantik.',
            'parent_constitution_template_id' => 163,
            'below_constitution_template_id' => 168,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(7) Butir-butir pelantikan Pemegang Amanah atau pertukaran Pemegang Amanah hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja dalam tempoh 14 hari untuk dimasukkan ke dalam daftar Kesatuan. Sebarang perlantikan atau pemilihan tidak boleh dikuatkuasakan sehingga didaftarkan sedemikian.',
            'parent_constitution_template_id' => 163,
            'below_constitution_template_id' => 169,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 15 - JURUAUDIT DALAM',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 163,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Dua orang Juruaudit Dalam yang bukan anggota Majlis Jawatankuasa Kerja hendaklah dipilih secara angkat tangan dalam Mesyuarat Agung _Meeting_Yearly_ Tahunan. Mereka hendaklah memeriksa kira-kira Kesatuan pada penghujung tiap-tiap tiga (3) bulan dan menyampaikan laporannya kepada Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 171,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Dokumen-dokumen pentadbiran dan kewangan Kesatuan hendaklah diaudit bersama-sama oleh kedua-dua Juruaudit Dalam dan mereka itu berhak melihat semua buku dan surat keterangan yang perlu untuk menyempurnakan tugas mereka.',
            'parent_constitution_template_id' => 171,
            'below_constitution_template_id' => 172,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Seseorang anggota Kesatuan boleh mengadu dengan bersurat kepada Juruaudit Dalam tentang sebarang hal kewangan yang tidak betul.',
            'parent_constitution_template_id' => 171,
            'below_constitution_template_id' => 173,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(4) Apabila berlaku kekosongan jawatan oleh sebarang sebab, kekosongan ini bolehlah diisi dengan cara lantikan oleh Majlis Jawatankuasa Kerja sehingga Mesyuarat Agung yang akan datang.',
            'parent_constitution_template_id' => 171,
            'below_constitution_template_id' => 174,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 16 - JURUAUDIT LUAR',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 171,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Kesatuan hendaklah melantik seorang Juruaudit Luar bertauliah dan seterusnya memperolehi kelulusan Ketua Pengarah Kesatuan Sekerja bagi pelantikan ini. Juruaudit Luar itu hendaklah merupakan seorang akauntan yang telah memperolehi kebenaran bertulis daripada Menteri Kewangan untuk mengaudit kira-kira syarikat-syarikat di bawah Akta Syarikat 1965.',
            'parent_constitution_template_id' => 176,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Seseorang Juruaudit Luar yang sama tidak boleh dilantik melebihi tempoh tiga (3) tahun berturut-turut.',
            'parent_constitution_template_id' => 176,
            'below_constitution_template_id' => 177,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Kira-kira Kesatuan hendaklah diaudit oleh Juruaudit Luar dengan segera selepas sahaja tahun kewangan ditutup pada 31 Mac dan hendaklah selesai sebelum 31 Ogos tiap-tiap tahun.',
            'parent_constitution_template_id' => 176,
            'below_constitution_template_id' => 178,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(4) Juruaudit Luar berhak menyemak semua buku dan surat keterangan yang perlu untuk menyempurnakan tugasnya.',
            'parent_constitution_template_id' => 176,
            'below_constitution_template_id' => 179,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(5) Kira-kira Kesatuan yang diaudit hendaklah diakui benar oleh Bendahari dengan surat akuan bersumpah (statutory declaration).',
            'parent_constitution_template_id' => 176,
            'below_constitution_template_id' => 180,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(6) Satu salinan Penyata Kira-kira yang diaudit dan Laporan Juruaudit Luar itu hendaklah diedarkan kepada semua anggota sebelum Mesyuarat Agung _Meeting_Yearly_ Tahunan. Penyata kira-kira dan Laporan Juruaudit Luar tersebut hendaklah dibentangkan dalam Mesyuarat Agung _Meeting_Yearly_ Tahunan untuk kelulusan.',
            'parent_constitution_template_id' => 176,
            'below_constitution_template_id' => 181,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(7) Kira-kira Kesatuan yang diaudit hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja berserta dengan Borang N sebelum 1 Oktober tiap-tiap tahun.',
            'parent_constitution_template_id' => 176,
            'below_constitution_template_id' => 182,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 17 - JEMAAH PEMERIKSA UNDI',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 176,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Satu Jemaah Pemeriksa Undi yang terdiri daripada lima (5) orang anggota hendaklah dipilih secara angkat tangan dalam Mesyuarat Agung _Meeting_Yearly_ Tahunan dan seorang daripadanya hendaklah dipilih sebagai Ketua Pemeriksa Undi. Mereka hendaklah bukan pegawai Kesatuan atau calon bagi pemilihan pegawai-pegawai kesatuan. Seboleh-bolehnya anggotaanggota yang dipilih ini hendaklah anggota-anggota yang tinggal di sekitar kawasan Ibu Pejabat Kesatuan.',
            'parent_constitution_template_id' => 184,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Jemaah Pemeriksa Undi ini bertanggungjawab mengendalikan segala perjalanan undi rahsia yang dijalankan oleh kesatuan. Mereka akan berkhidmat dari suatu Mesyuarat Agung _Meeting_Yearly_ Tahunan ke Mesyuarat Agung _Meeting_Yearly_ Tahunan yang berikutnya. Apabila berlaku kekosongan, kekosongan ini hendaklah diisi dengan cara lantikan oleh Majlis Jawatankuasa Kerja sehingga Mesyuarat Agung yang akan datang.',
            'parent_constitution_template_id' => 184,
            'below_constitution_template_id' => 185,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Sekurang-kurangnya tiga (3) Pemeriksa Undi hendaklah hadir apabila pembuangan undi dijalankan. Mereka hendaklah memastikan aturcara yang tertera di dalam kembaran kepada peraturan-peraturan ini dipatuhi dengan sepenuhnya.',
            'parent_constitution_template_id' => 184,
            'below_constitution_template_id' => 186,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 18 - GAJI DAN BAYARAN-BAYARAN LAIN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 184,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Skim gaji serta syarat-syarat pekerjaan bagi Pegawai-pegawai Kesatuan yang berkerja sepenuh masa dengan Kesatuan dan pekerja-pekerja Kesatuan hendaklah ditetapkan melalui usul yang diluluskan di Mesyuarat Agung _Meeting_Yearly_ Tahunan.',
            'parent_constitution_template_id' => 188,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Pegawai-pegawai Kesatuan yang dikehendaki berkhidmat separuh masa bagi pihak Kesatuan boleh dibayar saguhati. Jumlah pembayaran saguhati itu hendaklah ditetapkan oleh Mesyuarat Agung _Meeting_Yearly_ Tahunan.',
            'parent_constitution_template_id' => 188,
            'below_constitution_template_id' => 189,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Pegawai-pegawai atau wakil-wakil Kesatuan boleh diberi bayaran gantirugi dengan kelulusan oleh Majlis Jawatankuasa Kerja kerana hilang masa kerjanya dan perbelanjaan serta elaun yang munasabah bagi menjalankan kerja-kerja Kesatuan. Mereka itu hendaklah mengemukakan satu penyata yang menunjukkan butir-butir perjalanan dan bukti hilang masa kerjanya (jika berkenaan) dan perbelanjaan yang disokong dengan resit atau keterangan pembayaran lain. Had maksima bayaran, elaun dan perbelanjaan yang boleh dibayar hendaklah ditentukan dari semasa ke semasa oleh Mesyuarat Agung _Meeting_Yearly_ Tahunan dan Majlis Jawatankuasa Kerja tidak boleh meluluskan sebarang bayaran yang melebihi had yang ditentukan oleh Mesyuarat Agung itu.',
            'parent_constitution_template_id' => 188,
            'below_constitution_template_id' => 190,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 19 - KEWANGAN DAN AKAUN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 188,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Wang-wang Kesatuan boleh dibelanjakan bagi perkara-perkara berikut:-',
            'parent_constitution_template_id' => 192,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Bayaran gaji, elaun dan perbelanjaan kepada Pegawai Kesatuan dan pekerja-pekerja Kesatuan tertakluk kepada Peraturan 18. ',
            'parent_constitution_template_id' => 193,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) Bayaran dan perbelanjaan pentadbiran Kesatuan termasuk bayaran mengaudit kira-kira Kesatuan;',
            'parent_constitution_template_id' => 193,
            'below_constitution_template_id' => 194,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) Bayaran urusan pendakwaan atau pembelaan dalam prosiding undang-undang di mana Kesatuan atau seorang anggotanya menjadi satu pihak yang bertujuan untuk memperolehi atau mempertahankan hak Kesatuan atau sebarang hak yang terbit daripada perhubungan di antara seseorang anggota dengan majikannya;',
            'parent_constitution_template_id' => 193,
            'below_constitution_template_id' => 195,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) Bayaran urusan pertikaian perusahaan bagi pihak Kesatuan atau anggota-anggotanya dengan syarat bahawa pertikaian perusahaan itu tidak bertentangan dengan Akta Kesatuan Sekerja 1959 atau Undang-undang bertulis yang lain;',
            'parent_constitution_template_id' => 193,
            'below_constitution_template_id' => 196,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) Bayaran gantirugi kepada anggota kerana kerugian akibat daripada pertikaian perusahaan yang melibatkan anggota itu dengan syarat bahawa pertikaian perusahaan itu tidak bertentangan dengan Akta Kesatuan Sekerja 1959 atau Undang-undang bertulis yang lain;',
            'parent_constitution_template_id' => 193,
            'below_constitution_template_id' => 197,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) Bayaran elaun kepada anggota kerana berumur tua, sakit, ditimpa kemalangan atau hilang pekerjaan atau bayaran kepada tanggungannya apabila anggota itu meninggal dunia. ',
            'parent_constitution_template_id' => 193,
            'below_constitution_template_id' => 198,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(g) Bayaran yuran mengenai pergabungan dengan, atau keanggotaan dengan mana-mana persekutuan kesatuan-kesatuan sekerja yang telah didaftarkan di bawah Bahagian XII Akta Kesatuan Sekerja 1959, atau mana-mana badan perunding atau badan yang serupa yang mana kelulusan telah diberi oleh Ketua Pengarah di bawah seksyen 76A (1) Akta Kesatuan Sekerja 1959 atau Ketua Pengarah telah diberitahu di bawah seksyen 76A (2) Akta Kesatuan Sekerja 1959;',
            'parent_constitution_template_id' => 193,
            'below_constitution_template_id' => 199,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(h) Bayaran-bayaran untuk :-',
            'parent_constitution_template_id' => 193,
            'below_constitution_template_id' => 200,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(i) Tambang keretapi, perbelanjaan pengangkutan lain yang perlu, perbelanjaan makan dan tempat tidur, yang beralaskan resit atau sebanyak mana yang telah ditentukan oleh Kesatuan, tertakluk kepada had-had yang ditentukan di bawah Peraturan 18.',
            'parent_constitution_template_id' => 201,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(ii) Amaun kehilangan gaji yang sebenar oleh wakil Kesatuan kerana menghadiri mesyuarat berkaitan atau berhubung dengan hal perhubungan perusahaan atau menyempurnakan perkara-perkara yang dikehendaki oleh Ketua Pengarah Kesatuan Sekerja berkaitan dengan Akta Kesatuan Sekerja 1959 atau sebarang peraturan tertakluk kepada had yang ditentukan di bawah Peraturan 18.',
            'parent_constitution_template_id' => 201,
            'below_constitution_template_id' => 202,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(iii) Perbelanjaan bagi menubuhkan atau mengekalkan Persekutuan Kesatuan Sekerja yang didaftarkan di bawah Bahagian XII Akta Kesatuan Sekerja 1959, atau badan perunding atau badan yang serupa yang mana kelulusan telah diberi oleh Ketua Pengarah Kesatuan Sekerja di bawah seksyen 76A (1) Akta Kesatuan Sekerja 1959 atau Ketua Pengarah Kesatuan Sekerja telah diberitahu di bawah seksyen 76A (2) Akta Kesatuan Sekerja 1959.',
            'parent_constitution_template_id' => 201,
            'below_constitution_template_id' => 203,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(i) Urusan mengarang, mencetak, menerbit dan mengedarkan sebarang suratkhabar, majalah, surat berita atau penerbitan lain, yang dikeluarkan oleh Kesatuan untuk menjayakan tujuan-tujuannya atau untuk memelihara kepentingan anggota-anggota selaras dengan peraturan-peraturan ini.',
            'parent_constitution_template_id' => 193,
            'below_constitution_template_id' => 201,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(j) Penyelesaian pertikaian di bawah Bahagian VI Akta Kesatuan Sekerja 1959.',
            'parent_constitution_template_id' => 193,
            'below_constitution_template_id' => 205,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(k) Aktiviti-aktiviti sosial, sukan, pendidikan dan amal kebajikan anggota-anggota Kesatuan.',
            'parent_constitution_template_id' => 193,
            'below_constitution_template_id' => 206,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(l) Pembayaran premium kepada syarikat-syarikat insurans berdaftar di Malaysia yang diluluskan oleh Ketua Pengarah Kesatuan Sekerja dari semasa ke semasa.',
            'parent_constitution_template_id' => 193,
            'below_constitution_template_id' => 207,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Tabung wang Kesatuan tidak boleh digunakan sama ada secara langsung atau sebaliknya untuk membayar denda atau hukuman yang dikenakan oleh Mahkamah kepada sesiapa pun',
            'parent_constitution_template_id' => 192,
            'below_constitution_template_id' => 193,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Wang-wang Kesatuan yang tidak dikehendaki untuk perbelanjaan semasa yang telah diluluskan hendaklah dimasukkan ke dalam bank oleh Bendahari dalam tempoh tujuh (7) hari dari tarikh penerimaannya. Akaun Bank itu hendaklah di atas nama kesatuan dan butir-butir akaun itu hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja. Pembukaan sesuatu akaun bank itu hendaklah diluluskan oleh Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 192,
            'below_constitution_template_id' => 209,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(4) Semua cek atau notis pengeluaran wang atas akaun Kesatuan hendaklah ditandatangani bersama oleh Presiden (pada masa ketiadaannya oleh Naib Presiden), Setiausaha (pada masa ketiadaannya oleh Penolong Setiausaha), dan Bendahari (pada masa ketiadaannya oleh Penolong Bendahari).',
            'parent_constitution_template_id' => 192,
            'below_constitution_template_id' => 210,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(5) Bendahari dibenarkan menyimpan wang tunai tidak lebih daripada _max_savings_text_ (RM _max_savings_) pada sesuatu masa. Sebarang perbelanjaan yang melebihi _max_expenses_text_ (RM _max_expenses_) tidak boleh dilakukan pada sesuatu masa kecuali dengan persetujuan terlebih dahulu daripada Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 192,
            'below_constitution_template_id' => 211,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(6) Bendahari hendaklah menyediakan satu anggaran belanjawan tahunan untuk diluluskan oleh Mesyuarat Agung _Meeting_Yearly_ Tahunan dan semua perbelanjaan yang dibuat oleh Kesatuan hendaklah dalam had-had yang ditetapkan oleh belanjawan yang diluluskan itu. Belanjawan tersebut boleh disemak semula dari semasa ke semasa dengan dipersetujui terlebih dahulu oleh anggota-anggota di dalam Mesyuarat Agung Luarbiasa atau melalui undi rahsia.',
            'parent_constitution_template_id' => 192,
            'below_constitution_template_id' => 212,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(7) Semua harta kesatuan hendaklah dimiliki bersama atas nama Pemegangpemegang Amanah. Wang-wang kesatuan yang tidak dikehendaki untuk urusan pentadbiran harian Kesatuan boleh digunakan bagi tujuan-tujuan seperti berikut:-',
            'parent_constitution_template_id' => 192,
            'below_constitution_template_id' => 213,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Membeli atau memajak sebarang tanah atau bangunan untuk kegunaan kesatuan. Tanah atau bangunan ini tertakluk kepada sesuatu undang-undang bertulis atau undang-undang lain yang boleh dipakai, dipajak atau dengan persetujuan anggota-anggota kesatuan yang diperoleh melalui usul yang dibawa dalam Mesyuarat Agung boleh dijual, ditukar atau digadai;',
            'parent_constitution_template_id' => 214,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) Melabur dalam amanah saham (securities) atau dalam pinjaman kepada mana-mana syarikat mengikut Undang-undang yang berkaitan dengan pemegang amanah;',
            'parent_constitution_template_id' => 214,
            'below_constitution_template_id' => 215,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) Disimpan dalam Bank Simpanan Nasional, di mana-mana Bank yang diperbadankan di Malaysia atau di mana-mana Syarikat Kewangan yang merupakan anak syarikat bank tersebut ; atau',
            'parent_constitution_template_id' => 214,
            'below_constitution_template_id' => 216,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) Dengan mendapat kelulusan terlebih dahulu daripada Menteri Sumber Manusia dan tertakluk kepada syarat-syarat yang dikenakan oleh beliau bagi melabur :-',
            'parent_constitution_template_id' => 214,
            'below_constitution_template_id' => 217,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(i) dalam mana-mana Syarikat Kerjasama yang berdaftar; atau',
            'parent_constitution_template_id' => 218,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(ii) dalam mana-mana pengusahaan perdagangan, perindustrian, atau pertanian atau dalam enterprise bank yang diperbadankan dan beroperasi di Malaysia.',
            'parent_constitution_template_id' => 218,
            'below_constitution_template_id' => 219,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(8) Semua belian dan pelaburan di bawah peraturan ini hendaklah diluluskan terlebih dahulu oleh Mesyuarat Majlis Jawatankuasa Kerja dan dibuat atas nama Pemegang-pemegang Amanah Kesatuan. Kelulusan ini hendaklah disahkan oleh Mesyuarat Agung yang akan datang. Pemegang-pemegang Amanah hendaklah memegang saham-saham atau pelaburan-pelaburan bagi pihak anggota-anggota Kesatuan.',
            'parent_constitution_template_id' => 192,
            'below_constitution_template_id' => 214,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(9) Bendahari hendaklah merekod atau menguruskan supaya direkodkan dalam dokumen kewangan Kesatuan sebarang penerimaan dan perbelanjaan wang Kesatuan.',
            'parent_constitution_template_id' => 192,
            'below_constitution_template_id' => 221,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(10) Bendahari hendaklah pada atau sebelum 1 Oktober tiap-tiap tahun, atau apabila dia berhenti atau meletak jawatan daripada pekerjaannya, atau pada bila-bila masa dia dikehendaki berbuat demikian oleh Majlis Jawatankuasa Kerja atau oleh anggota-anggota melalui suatu ketetapan yang dibuat dalam Mesyuarat Agung atau apabila dikehendaki oleh Ketua Pengarah Kesatuan Sekerja mengemukakan kepada Kesatuan dan anggota-anggotanya atau kepada Ketua Pengarah Kesatuan Sekerja yang mana ada kaitan, satu penyata kewangan yang benar dan betul tentang semua wang yang diterima dan dibayarnya dari masa dia mula memegang jawatan itu atau, jika dia pernah membentangkan penyata kewangan terdahulu, dari tarikh penyata kewangan itu dibentangkan, baki wang dalam tangannya pada masa ia mengemukakan penyata kewangan itu dan juga semua bon dan jaminan atau harta-harta Kesatuan yang lain dalam simpanan atau jagaannya.',
            'parent_constitution_template_id' => 192,
            'below_constitution_template_id' => 222,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(11) Penyata kewangan tersebut hendaklah mengikut bentuk yang ditentukan oleh Peraturan-peraturan Kesatuan Sekerja 1959 dan hendaklah diakui benar oleh Bendahari dengan surat akuan bersumpah (statutory declaration). Kesatuan hendaklah menguruskan penyata kewangan tersebut diaudit mengikut Peraturan 16. Selepas penyata kewangan itu diaudit, Bendahari hendaklah menyerahkan kepada pemegang-pemegang amanah Kesatuan jika dikehendaki oleh mereka itu semua bon, sekuriti, perkakasan, buku, surat dan harta Kesatuan yang ada dalam simpanan atau jagaannya.',
            'parent_constitution_template_id' => 192,
            'below_constitution_template_id' => 223,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(12) Selain daripada Bendahari, pegawai-pegawai atau pekerja-pekerja Kesatuan tidak boleh menerima wang atau mengeluarkan resit rasmi tanpa kuasa yang bertulis oleh Presiden pada tiap-tiap kali mereka itu berbuat demikian.',
            'parent_constitution_template_id' => 192,
            'below_constitution_template_id' => 224,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 20 - PEMERIKSAAN DOKUMEN DAN AKAUN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 192,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'Tiap-tiap orang yang mempunyai kepentingan dalam tabung wang Kesatuan berhak memeriksa dokumen-dokumen pentadbiran, kewangan Kesatuan dan rekod nama-nama anggota Kesatuan pada masa yang munasabah di tempat rekod itu disimpan setelah memberi notis yang mencukupi dan berpatutan.',
            'parent_constitution_template_id' => 226,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 21 - YURAN KHAS (LEVI)',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 226,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Setelah satu usul diputuskan dengan undi rahsia menurut Peraturan 25, Majlis Jawatankuasa Kerja boleh memungut yuran khas( levi) daripada semua anggota Kesatuan kecuali mereka yang telah dikecualikan daripada bayaran ini oleh Majlis Jawatankuasa Kerja menurut Peraturan 4 (5).',
            'parent_constitution_template_id' => 228,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Jika seseorang anggota tidak menjelaskan yuran khas(levi) itu dalam tempoh enam (6) minggu dari tarikh ia dikenakan atau dalam tempoh yang lebih panjang yang ditetapkan dalam usul berkenaan maka yuran khas (levi) itu akan dikira sebagai tunggakan yuran Kesatuan dan anggota itu boleh terlucut haknya menurut Peraturan 4 (3).',
            'parent_constitution_template_id' => 228,
            'below_constitution_template_id' => 229,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 22 - PERTIKAIAN PERUSAHAAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 228,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Jika seseorang anggota berhajat supaya tindakan diambil terhadap syaratsyarat pekerjaannya atau sebarang hal yang lain maka dia hendaklah memberitahu Setiausaha tentang aduannya secara bertulis. Setiausaha hendaklah menyampaikan aduan itu kepada Majlis Jawatankuasa Kerja dengan serta-merta.',
            'parent_constitution_template_id' => 231,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Jika berbangkit sesuatu pertikaian perusahaan maka anggota-anggota yang terlibat hendaklah menyampaikan hal itu kepada Setiausaha dan Setiausaha hendaklah dengan serta-merta melaporkan hal itu kepada Majlis Jawatankuasa Kerja.',
            'parent_constitution_template_id' => 231,
            'below_constitution_template_id' => 232,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Kesatuan tidak boleh melancarkan mogok dan anggota-anggotanya tidak boleh mengambil bahagian dalam mogok :',
            'parent_constitution_template_id' => 231,
            'below_constitution_template_id' => 233,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Tanpa mendapat kelulusan Majlis Jawatankuasa Kerja terlebih dahulu;',
            'parent_constitution_template_id' => 234,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) tanpa mendapat persetujuan dengan undi rahsia daripada sekurangkurangnya dua pertiga (2/3) daripada jumlah anggota yang layak mengundi dan terlibat dengan mogok yang akan dijalankan itu;',
            'parent_constitution_template_id' => 234,
            'below_constitution_template_id' => 235,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) sebelum luput tempoh tujuh (7) hari selepas keputusan undi rahsia itu dikemukakan kepada Ketua Pengarah Kesatuan Sekerja mengikut seksyen 40 (5) Akta Kesatuan Sekerja 1959;',
            'parent_constitution_template_id' => 234,
            'below_constitution_template_id' => 236,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) sekiranya undi rahsia untuk cadangan mogok telah luput tempohnya atau tidak sah menurut peruntukan-peruntukan seksyen 40 (2), 40 (6) atau 40 (9) Akta Kesatuan Sekerja 1959;',
            'parent_constitution_template_id' => 234,
            'below_constitution_template_id' => 237,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) jika mogok itu menyalahi atau tidak mematuhi peraturan-peraturan ini;',
            'parent_constitution_template_id' => 234,
            'below_constitution_template_id' => 238,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) berkaitan dengan apa-apa perkara yang diliputi oleh suatu arahan atau keputusan Menteri Sumber Manusia yang diberi atau dibuat terhadap sesuatu rayuan di bawah Akta Kesatuan Sekerja 1959; atau',
            'parent_constitution_template_id' => 234,
            'below_constitution_template_id' => 239,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(g) jika mogok itu menyalahi atau tidak mematuhi mana-mana peruntukan lain Akta Kesatuan Sekerja 1959 atau mana-mana peruntukan Undang-undang lain yang bertulis.',
            'parent_constitution_template_id' => 234,
            'below_constitution_template_id' => 240,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(4) Majlis Jawatankuasa Kerja tidak boleh menyokong pemogokan dengan memberi bantuan kewangan atau bantuan lain jika peruntukan-peruntukan Peraturan 22 (3) tidak dipatuhi.',
            'parent_constitution_template_id' => 231,
            'below_constitution_template_id' => 234,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(5) Sesuatu undi rahsia yang diambil tentang apa-apa perkara berkaitan dengan pemogokan hendaklah mengandungi suatu usul yang menerangkan dengan jelas akan isu yang menyebabkan cadangan pemogokan itu. Usul itu hendaklah juga menerangkan dengan jelas rupa bentuk tindakan yang akan dilakukan atau yang tidak akan dilakukan di sepanjang pemogokan itu. Undi rahsia yang tidak memenuhi kehendakkehendak ini tidaklah sah dan tidak boleh dikuatkuasakan dan pemogokan tidak boleh dilakukan berdasarkan undi rahsia tersebut.',
            'parent_constitution_template_id' => 231,
            'below_constitution_template_id' => 242,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(6) Mana-mana anggota Kesatuan yang memulakan mogok, mengambil bahagian atau bertindak bagi melanjutkan pemogokan yang melanggar Akta Kesatuan Sekerja 1959 atau peraturan-peraturan ini atau mana-mana peruntukan Undang-undang bertulis akan terhenti dengan sendirinya daripada menjadi anggota Kesatuan dan selepas itu tidak boleh menjadi anggota Kesatuan ini atau kesatuan yang lain tanpa kelulusan bertulis daripada Ketua Pengarah Kesatuan Sekerja terlebih dahulu. Kesatuan hendaklah dengan serta-merta:-',
            'parent_constitution_template_id' => 231,
            'below_constitution_template_id' => 243,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) mengeluarkan nama anggota tersebut daripada Daftar Keanggotaan/Yuran;',
            'parent_constitution_template_id' => 244,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) memberitahu Ketua Pengarah Kesatuan Sekerja dan anggota berkenaan pengeluaran nama tersebut; dan',
            'parent_constitution_template_id' => 244,
            'below_constitution_template_id' => 245,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) mempamerkan di suatu tempat yang mudah dilihat di pejabat Kesatuan yang berdaftar satu senarai anggota yang namanya telah dikeluarkan itu.',
            'parent_constitution_template_id' => 244,
            'below_constitution_template_id' => 246,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 23 - KEGIATAN PENDIDIKAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 231,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'Kesatuan boleh menjalankan aktiviti bagi menambah ilmu pengetahuan anggotaanggotanya dengan menganjurkan perjumpaan, seminar, bengkel, atau kursus. Selanjutnya kesatuan boleh menerbitkan bahan-bahan bacaan dan menjalankan urusan-urusan lain seumpama yang boleh memajukan pengetahuan anggotaanggota dalam hal perusahaan, kebudayaan dan kemasyarakatan dengan mematuhi kehendak undang-undang berkaitan perbelanjaan wang kesatuan sekerja yang dikuatkuasakan sekarang. ',
            'parent_constitution_template_id' => 248,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 24 - PERATURAN-PERATURAN DAN PINDAAN PERATURAN-PERATURAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 248,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Pindaan kepada Peraturan-peraturan yang akan meningkatkan lagi tanggungan anggota untuk mencarum atau mengurangkan faedah yang dinikmatinya hanya boleh dibuat jika diluluskan oleh anggota-anggota dengan undi rahsia. Pindaan Peraturan-peraturan lain boleh dibuat dengan kelulusan Mesyuarat Agung yang diadakan menurut Peraturan 9 atau Peraturan 10, atau dengan undi rahsia. ',
            'parent_constitution_template_id' => 250,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Tiap-tiap pindaan Peraturan-peraturan hendaklah berkuatkuasa dari tarikh pindaan itu didaftarkan oleh Ketua Pengarah Kesatuan Sekerja kecuali jika suatu tarikh yang terkemudian dari itu ditentukan di dalam peraturanperaturan ini.',
            'parent_constitution_template_id' => 250,
            'below_constitution_template_id' => 251,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Suatu naskah Peraturan-peraturan Kesatuan yang bercetak hendaklah dipamerkan di suatu tempat yang mudah dilihat di pejabat Kesatuan yang didaftarkan. Setiausaha hendaklah memberi senaskah Peraturan-peraturan Kesatuan kepada sesiapa juga yang memintanya dengan bayaran tidak lebih dari RM10.00 senaskah.',
            'parent_constitution_template_id' => 250,
            'below_constitution_template_id' => 252,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 25 - UNDI RAHSIA',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 250,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Keputusan-keputusan berkenaan dengan perkara-perkara yang tersebut di bawah ini hendaklah dibuat dengan undi rahsia oleh semua anggota berhak atau anggota-anggota berhak yang terlibat kecuali anggota yang belum cukup umur 18 tahun tidak berhak mengundi atas perkara-perkara (c), (d), (e) dan (g) ;-',
            'parent_constitution_template_id' => 254,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Pemilihan Pegawai-pegawai Kesatuan menurut Peraturan 12; ',
            'parent_constitution_template_id' => 255,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) Pemilihan wakil-wakil untuk Persekutuan Kesatuan-Kesatuan sekerja;',
            'parent_constitution_template_id' => 255,
            'below_constitution_template_id' => 256,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) Semua perkara mengenai mogok menurut Peraturan 22 (3);',
            'parent_constitution_template_id' => 255,
            'below_constitution_template_id' => 257,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) Mengenakan yuran khas (levi);',
            'parent_constitution_template_id' => 255,
            'below_constitution_template_id' => 258,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) Pindaan peraturan-peraturan ini jika pindaan itu meningkatkan lagi tanggungan anggota untuk mencarum atau mengurangkan faedah yang dinikmatinya;',
            'parent_constitution_template_id' => 255,
            'below_constitution_template_id' => 259,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) Bercantum dengan kesatuan sekerja yang lain atau memindahkan urusan kepada kesatuan sekerja yang lain;',
            'parent_constitution_template_id' => 255,
            'below_constitution_template_id' => 260,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(g) Membubarkan Kesatuan atau Persekutuan Kesatuan-Kesatuan Sekerja',
            'parent_constitution_template_id' => 255,
            'below_constitution_template_id' => 261,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Untuk menjalankan undi rahsia, aturcara yang dinyatakan di dalam kembaran kepada peraturan-peraturan ini hendaklah dipatuhi.',
            'parent_constitution_template_id' => 254,
            'below_constitution_template_id' => 255,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 26 - PERLANTIKAN JEMAAH PENIMBANGTARA',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 254,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Satu Jemaah Penimbangtara yang terdiri dari lima (5) orang hendaklah dilantik dalam Mesyuarat Agung Kesatuan yang pertama untuk menyelesaikan sesuatu pertikaian dalam kesatuan. Jemaah Penimbangtara hendaklah bukan anggota kesatuan dan tidak ada kaitan langsung dengan kewangan Kesatuan.',
            'parent_constitution_template_id' => 264,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Apabila berlaku kekosongan oleh sebarang sebab maka kekosongan itu hendaklah diisi dengan melantik penggantinya di dalam Mesyuarat Agung yang akan datang.',
            'parent_constitution_template_id' => 264,
            'below_constitution_template_id' => 265,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Setiausaha hendaklah melaporkan kepada Ketua Pengarah Kesatuan Sekerja butir-butir peribadi Jemaah Penimbangtara (seperti nama, nombor kad pengenalan, jawatan dan alamat) dan sebarang perubahan tentang anggota Jemaah Penimbangtara.',
            'parent_constitution_template_id' => 264,
            'below_constitution_template_id' => 266,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(4) Setiausaha hendaklah mengemukakan sesuatu pertikaian kepada Jemaah Penimbangtara dalam masa tujuh (7) hari daripada permohonan diterima dari anggota atau seseorang yang terkilan. Apabila sesuatu pertikaian telah dirujuk kepada Jemaah Penimbangtara, pihak yang terkilan hendaklah memilih dengan mengundi tiga (3) daripada lima (5) orang Jemaah Penimbangtara tersebut. Setiausaha hendaklah menetapkan tempat dan masa bagi urusan ini. Laporan dan keputusan Jemaah Penimbangtara hendaklah dikemukakan kepada Majlis Jawatankuasa Kerja dengan seberapa segera.',
            'parent_constitution_template_id' => 264,
            'below_constitution_template_id' => 267,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 27 - PERTIKAIAN DALAM KESATUAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 264,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Tertakluk kepada perenggan dua (2) di bawah ini, tiap-tiap pertikaian yang berlaku di antara :-',
            'parent_constitution_template_id' => 269,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Seseorang anggota atau seseorang yang menuntut melalui seorang anggota atau menurut Peraturan ini, di sebelah pihak, dan dengan Kesatuan atau Pegawai Kesatuan di pihak yang lagi satu; atau',
            'parent_constitution_template_id' => 270,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) Seseorang yang terkilan yang telah diberhentikan menjadi anggota Kesatuan, atau seseorang yang menuntut melalui orang yang terkilan itu, di sebelah pihak dengan Kesatuan atau Pegawai Kesatuan di pihak yang lagi satu; atau',
            'parent_constitution_template_id' => 270,
            'below_constitution_template_id' => 271,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) Kesatuan dengan seseorang Pegawai Kesatuan hendaklah diselesaikan melalui penimbangtaraan',
            'parent_constitution_template_id' => 270,
            'below_constitution_template_id' => 272,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Pihak yang menuntut dan pihak yang kena tuntut bolehlah bersama-sama merujuk pertikaian tentang perkara berikut :-',
            'parent_constitution_template_id' => 269,
            'below_constitution_template_id' => 270,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) pemilihan pegawai-pegawai Kesatuan;',
            'parent_constitution_template_id' => 274,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) akaun dan kewangan Kesatuan; atau',
            'parent_constitution_template_id' => 274,
            'below_constitution_template_id' => 275,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) melanggar peraturan-peraturan Kesatuan, kepada Ketua Pengarah Kesatuan Sekerja dan keputusan Ketua Pengarah Kesatuan Sekerja tentang pertikaian tersebut adalah muktamad.',
            'parent_constitution_template_id' => 274,
            'below_constitution_template_id' => 276,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Setiausaha hendaklah secara bertulis menyampaikan sebarang pertikaian di bawah perenggan satu (1) kepada Jemaah Penimbangtara dalam tempoh tujuh (7) hari dari tarikh permohonan pihak yang menuntut diterima oleh Kesatuan. Jika tiada keputusan dibuat mengenai suatu pertikaian dalam tempoh 40 hari selepas permohonan dibuat kepada kesatuan, anggota atau seseorang yang terkilan itu boleh memohon kepada Mahkamah Sesyen dan Mahkamah Sesyen boleh mendengar dan membuat keputusan mengenai pertikaian tersebut.',
            'parent_constitution_template_id' => 269,
            'below_constitution_template_id' => 274,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(4) Dalam peraturan ini perkataan “pertikaian” meliputi sebarang pertikaian tentang soal sama ada seseorang anggota atau orang yang terkilan itu berhak menjadi anggota atau terus menjadi anggota ataupun diterima semula menjadi anggota. Bagi seseorang yang telah berhenti menjadi anggota, perkataan "pertikaian" ini hanya meliputi pertikaian di antaranya dengan Kesatuan atau Pegawai Kesatuan tentang soal yang berbangkit di masa ia menjadi anggota.',
            'parent_constitution_template_id' => 269,
            'below_constitution_template_id' => 278,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(5) Pihak yang terkilan berhak membuat rayuan kepada Mesyuarat Agung _Meeting_Yearly_ Tahunan terhadap sebarang keputusan yang telah dibuat oleh Penimbangtara dan keputusan Mesyuarat itu adalah muktamad.',
            'parent_constitution_template_id' => 269,
            'below_constitution_template_id' => 279,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 28 - PEMBUBARAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 269,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Kesatuan ini tidak boleh dibubarkan dengan sendirinya melainkan dengan persetujuan melalui undi rahsia tidak kurang dari 75% daripada jumlah anggota yang berhak mengundi.',
            'parent_constitution_template_id' => 281,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(2) Sekiranya Kesatuan ini dibubarkan seperti yang tersebut di atas maka segala hutang dan tanggungan yang dibuat dengan cara sah bagi pihak Kesatuan hendaklah dijelaskan dengan sepenuhnya dan baki wang yang tinggal hendaklah diselesaikan menurut keputusan yang akan dibuat dengan undi rahsia. Penyata kewangan terakhir hendaklah diaudit oleh juruaudit bertauliah atau seseorang yang dipersetujui oleh Ketua Pengarah Kesatuan Sekerja',
            'parent_constitution_template_id' => 281,
            'below_constitution_template_id' => 282,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(3) Notis pembubaran dan dokumen-dokumen lain seperti yang dikehendaki oleh Peraturan-Peraturan Kesatuan Sekerja 1959, hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja dalam tempoh 14 hari selepas pembubaran. Pembubaran itu hanya akan berkuatkuasa dari tarikh pendaftarannya oleh Ketua Pengarah Kesatuan Sekerja.',
            'parent_constitution_template_id' => 281,
            'below_constitution_template_id' => 283,
            'constitution_type_id' => 1,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 1 NAMA DAN ALAMAT PEJABAT BERDAFTAR',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Nama Kesatuan Sekerja yang ditubuhkan menurut peraturan-peraturan ini ialah _entity_name_ (yang selepas ini disebut \'Kesatuan\')',
            'parent_constitution_template_id' => 285,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Pejabat berdaftar kesatuan ialah _address_ dan tempat mesyuaratnya ialah di pejabat berdaftar ini atau di mana-mana tempat lain yang ditetapkan oleh Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 285,
            'below_constitution_template_id' => 286,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 2 TUJUAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 285,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Tujuan Kesatuan ini ialah untuk:',
            'parent_constitution_template_id' => 288,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Mengorganisasikan pekerja-pekerja yang disebut di bawah Peraturan 3(1) sebagai anggota Kesatuan dan memajukan kepentingan mereka dalam bidang perhubungan perusahaan, kemasyarakatan dan ilmu pengetahuan.',
            'parent_constitution_template_id' => 289,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) Mengatur perhubungan di antara pekerja dengan majikan bagi maksud melaksanakan perhubungan perusahaan yang baik dan harmoni, meningkatkan daya pengeluaran dan memperolehi serta mengekalkan bagi anggota-anggotanya keselamatan pekerjaan, sukatan gaji yang adil dan sesuai serta syarat-syarat pekerjaan yang berpatutan.',
            'parent_constitution_template_id' => 289,
            'below_constitution_template_id' => 290,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) Mengatur perhubungan di antara anggota dengan anggota atau di antara anggota-anggota dengan pekerja-pekerja lain, di antara anggota dengan Kesatuan atau Pegawai Kesatuan, atau di antara Pegawai Kesatuan dengan Kesatuan dan menyelesaikan sebarang perselisihan atau pertikaian di antara mereka itu dengan cara aman dan bermuafakat atau melalui Jemaah Penimbangtara menurut Peraturan 26 atau Peraturan 27.',
            'parent_constitution_template_id' => 289,
            'below_constitution_template_id' => 291,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) Memajukan kebajikan anggota-anggota Kesatuan dari segi sosial, ekonomi dan pendidikan dengan cara yang sah di sisi undang-undang.',
            'parent_constitution_template_id' => 289,
            'below_constitution_template_id' => 292,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) Memberi bantuan guaman kepada anggota-anggota berhubung dengan pekerjaan mereka jika dipersetujui oleh Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 289,
            'below_constitution_template_id' => 293,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) Memberi bantuan seperti pembiayaan semasa teraniaya atau semasa pertikaian perusahaan jika dipersetujui oleh Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 289,
            'below_constitution_template_id' => 294,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(g) Menganjurkan dan mengendalikan kursus, dialog, seminar dan sebagainya untuk faedah anggota-anggota Kesatuan khasnya dan para pekerja amnya.',
            'parent_constitution_template_id' => 289,
            'below_constitution_template_id' => 295,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(h) Mengendalikan urusan mengarang, menyunting, mencetak, menerbit dan mengedarkan sebarang jurnal, majalah, buletin atau penerbitan lain untuk menjayakan tujuan-tujuan Kesatuan ini atau untuk kepentingan anggota-anggota Kesatuan jika dipersetujui oleh Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 289,
            'below_constitution_template_id' => 296,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(i) Menubuhkan Tabung Wang Kebajikan dan menggubalkan peraturanperaturan tambahan untuk mentadbir dan mengawal tabung itu jika dipersetujui oleh Persidangan Perwakilan.',
            'parent_constitution_template_id' => 289,
            'below_constitution_template_id' => 297,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(j) Secara amnya melaksanakan sebarang tujuan kesatuan sekerja yang sah di sisi undang-undang.',
            'parent_constitution_template_id' => 289,
            'below_constitution_template_id' => 298,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Tujuan yang dinyatakan dibawah Peraturan 2(1) hendaklah dilaksanakan menurut peraturan-peraturan ini, Akta Kesatuan Sekerja 1959 dan undang-undang bertulis yang lain yang ada kaitan.',
            'parent_constitution_template_id' => 288,
            'below_constitution_template_id' => 289,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 3 ANGGOTA KESATUAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 288,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Keanggotaan Kesatuan ini terbuka kepada _membership_target_ yang digaji oleh _paid_by_ kecuali mereka yang memegang jawatan pengurusan, eksekutif, sulit atau keselamatan. Pekerja-pekerja itu hendaklah berumur lebih dari 16 tahun dan mempunyai tempat kerjanya di _Work_At_ tertakluk kepada syarat bahawa seseorang yang diuntukkan pendidikan dalam sesuatu sekolah, politeknik, kolej, universiti, kolej universiti atau institusi lain yang ditubuhkan di bawah mana-mana undang-undang bertulis tidak boleh menjadi anggota Kesatuan kecuali jika sekiranya ia:-',
            'parent_constitution_template_id' => 301,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) sebenarnya seorang pekerja menurut takrif dalam Akta Kesatuan Sekerja 1959; dan',
            'parent_constitution_template_id' => 302,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) berumur lebih dari 18 tahun',
            'parent_constitution_template_id' => 302,
            'below_constitution_template_id' => 303,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Permohonan untuk menjadi anggota hendaklah dilakukan dengan mengisi borang yang ditentukan oleh Kesatuan dan menyampaikannya kepada Setiausaha Cawangan. Setiausaha Cawangan hendaklah mengemukakan permohonan itu kepada Setiausaha Agung dan seterusnya menyampaikan permohonan tersebut kepada Majlis Jawatankuasa Agung untuk kelulusan. Majlis Jawatankuasa Agung hendaklah memaklumkan keputusan permohonan tersebut kepada Setiausaha Cawangan dan pemohon.',
            'parent_constitution_template_id' => 301,
            'below_constitution_template_id' => 302,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Setelah permohonan seseorang itu diluluskan oleh Majlis Jawatankuasa Agung dan yuran masuk serta yuran bulanan yang pertama dijelaskan maka namanya hendaklah didaftarkan dalam Daftar Yuran / Keanggotaan sebagai anggota.',
            'parent_constitution_template_id' => 301,
            'below_constitution_template_id' => 305,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Seseorang anggota itu hendaklah diberikan senaskah buku Peraturanperaturan Kesatuan dengan percuma apabila diterima sebagai anggota.',
            'parent_constitution_template_id' => 301,
            'below_constitution_template_id' => 306,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Seseorang yang diterima masuk menjadi anggota dan kemudian berhenti daripada tempat kerjanya, tred atau industri seperti dinyatakan dalam Peraturan 3(1) akan dengan sendirinya terhenti dari menjadi anggota Kesatuan. Namanya hendaklah dikeluarkan daripada Daftar Yuran/ Keanggotaan tertakluk kepada peruntukan berkenaan di bawah Peraturan Tambahan Tabung Kebajikan (jika ada).',
            'parent_constitution_template_id' => 301,
            'below_constitution_template_id' => 307,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 4 YURAN DAN TUNGGAKAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 301,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Yuran Kesatuan adalah seperti berikut:- <br><br>Yuran Masuk RM _entrance_fee_  <br><br>Yuran Bulanan RM _monthly_fee_ <br><br>Sejumlah RM _fixed_fee_ / _percentage_fee_ % daripada Yuran Bulanan hendaklah diagihkan kepada setiap cawangan mengikut jumlah keahlian cawangan sebelum 15hb setiap bulan. Sebarang kenaikan yuran hendaklah diputuskan dengan undi rahsia menurut Peraturan 25.',
            'parent_constitution_template_id' => 309,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Yuran bulanan hendaklah dijelaskan sebelum tujuh (7) haribulan pada tiaptiap bulan.',
            'parent_constitution_template_id' => 309,
            'below_constitution_template_id' => 310,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Seseorang anggota yang terhutang yuran selama tiga bulan berturut-turut akan hilang haknya sebagai anggota kesatuan dan sekiranya masih terhutang selama enam bulan berturut-turut dengan sendirinya terhenti daripada menjadi anggota Kesatuan. Namanya hendaklah dipotong dari Daftar Yuran / Keanggotaan.',
            'parent_constitution_template_id' => 309,
            'below_constitution_template_id' => 311,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Seseorang yang terhenti daripada menjadi anggota kerana tunggakan yuran boleh memohon semula untuk menjadi anggota menurut Peraturan 3(2).',
            'parent_constitution_template_id' => 309,
            'below_constitution_template_id' => 312,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Majlis Jawatankuasa Agung berkuasa menetapkan kadar bayaran yuran bulanan yang kurang atau mengecualikan buat sementara waktu mana-mana anggota daripada bayaran yuran bulanan atau sebarang kutipan atau yuran khas (jika ada):-',
            'parent_constitution_template_id' => 309,
            'below_constitution_template_id' => 313,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) jika dia jatuh sakit teruk atau ditimpa kesusahan yang berat;',
            'parent_constitution_template_id' => 314,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) dia dibuang kerja, diberhentikan atau diketepikan dan masih menunggu keputusan sesuatu perundingan atau perbicaraan tentang pembuangan kerja, pemberhentian atau pengenepian itu; atau',
            'parent_constitution_template_id' => 314,
            'below_constitution_template_id' => 315,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) kerana sebarang sebab lain yang difikirkan munasabah dan wajar oleh Majlis Jawatankuasa Agung',
            'parent_constitution_template_id' => 314,
            'below_constitution_template_id' => 316,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 5 BERHENTI MENJADI ANGGOTA',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 309,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'Seseorang anggota yang ingin berhenti menjadi anggota Kesatuan hendaklah memberi notis secara bertulis sekurang-kurangnya seminggu sebelum tarikh berhenti kepada Setiausaha Cawangan dan hendaklah menjelaskan terlebih dahulu semua tunggakan yuran dan hutang (jika ada). Setiausaha Agung hendaklah mengemukakan notis tersebut kepada Majlis Jawatankuasa Agung untuk disahkan dan nama anggota berkenaan hendaklah dipotong dari Daftar Yuran / Keanggotaan.',
            'parent_constitution_template_id' => 318,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 6 HAK ANGGOTA',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 318,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'Semua anggota mempunyai hak yang sama dalam Kesatuan kecuali dalam perkaraperkara tertentu yang dinyatakan dalam peraturan-peraturan ini.',
            'parent_constitution_template_id' => 320,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 7 KEWAJIPAN DAN TANGGUNGJAWAB ANGGOTA-ANGGOTA',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 320,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Setiap anggota hendaklah menjelaskan yurannya menepati masa dan mendapatkan resit rasmi bagi bayarannya itu. Pembayaran yuran bulanan dalam tempoh masa yang ditetapkan adalah tanggungjawab setiap anggota dan bukannya tanggungjawab pegawai-pegawai Kesatuan.',
            'parent_constitution_template_id' => 322,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Setiap anggota hendaklah memberitahu Setiausaha Cawangan dengan segera apabila berpindah tempat tinggal atau bertukar tempat kerja.',
            'parent_constitution_template_id' => 322,
            'below_constitution_template_id' => 323,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Seseorang anggota yang menghadiri mesyuarat Kesatuan atau menggunakan pejabat Kesatuan hendaklah berkelakuan baik, jika tidak ia akan diarah keluar oleh seorang pegawai Kesatuan yang bertanggungjawab.',
            'parent_constitution_template_id' => 322,
            'below_constitution_template_id' => 324,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Seseorang anggota tidak boleh mengeluarkan sebarang dokumen atau surat pekeliling tentang Kesatuan tanpa mendapat kelulusan Majlis Jawatankuasa Agung',
            'parent_constitution_template_id' => 322,
            'below_constitution_template_id' => 325,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Seseorang anggota tidak boleh  endedahkan sebarang hal tentang kegiatan Kesatuan kepada orang yang bukan anggota atau kepada pertubuhan lain atau pihak akhbar tanpa mendapat izin Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 322,
            'below_constitution_template_id' => 326,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 8 PERLEMBAGAAN DAN PENTADBIRAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 322,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Kuasa yang tertinggi sekali dalam Kesatuan terletak kepada Persidangan Perwakilan melainkan perkara-perkara yang hendaklah diputuskan melalui undi rahsia menurut Peraturan 25.',
            'parent_constitution_template_id' => 328,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Tertakluk kepada syarat tersebut di atas Kesatuan hendaklah ditadbirkan oleh Majlis Jawatankuasa Agung dan Cawangan-cawangan Kesatuan ditadbirkan oleh Jawatankuasa Cawangan.',
            'parent_constitution_template_id' => 328,
            'below_constitution_template_id' => 329,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 9 PERSIDANGAN PERWAKILAN _CONFERENCE_YEARLY_ TAHUNAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 328,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Persidangan Perwakilan _Conference_Yearly_ Tahunan Kesatuan ini hendaklah diadakan dengan seberapa segera selepas 30hb. Jun dan tidak lewat dari 31hb. Oktober pada tiap-tiap _conference_yearly_ tahunan. Tarikh, masa dan tempat persidangan itu hendaklah ditetapkan oleh Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 331,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Persidangan Perwakilan _Conference_Yearly_ Tahunan itu hendaklah terdiri daripada wakil-wakil yang dipilih oleh cawangan-cawangan dan anggota-anggota Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 331,
            'below_constitution_template_id' => 332,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Wakil-wakil cawangan hendaklah dipilih oleh semua anggota berhak di cawangan masing-masing pada tiap-tiap _rep_yearly_ tahunan dengan undi rahsia di dalam Mesyuarat Agung _Meeting_Yearly_ Tahunan Cawangan masing-masing. Tiap-tiap cawangan hendaklah memilih dua orang wakil bagi _first_member_ anggota yang pertama atau sebahagian daripadanya dan seorang wakil bagi tiap-tiap _next_member_ orang anggota lebih daripada _first_member_ anggota yang pertama itu. Tiap-tiap satu cawangan berhak menghantar tidak lebih daripada _max_rep_ orang wakil sahaja. "Anggota" di sini adalah bermakna anggota yang berhak mengundi pada masa pengundian wakil-wakil itu dijalankan.',
            'parent_constitution_template_id' => 331,
            'below_constitution_template_id' => 333,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Ahli Majlis Jawatankuasa Agung tidak boleh dipilih menjadi wakil.',
            'parent_constitution_template_id' => 331,
            'below_constitution_template_id' => 334,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Hanya wakil-wakil sahaja yang boleh mengundi di dalam Persidangan Perwakilan. Pengerusi Persidangan Perwakilan boleh memberi undi pemutus kecuali perkara-perkara di bawah Peraturan 25. Persidangan itu boleh mengadakan Aturan Tetap untuk mengawal perjalanan mesyuarat bagi semua Persidangan Perwakilan dan cara-cara mengundi dalam persidanganpersidangan itu.',
            'parent_constitution_template_id' => 331,
            'below_constitution_template_id' => 335,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6. Notis permulaan bagi Persidangan Perwakilan _Conference_Yearly_ Tahunan yang menyatakan tarikh, masa dan tempat persidangan hendaklah dihantar oleh Setiausaha Agung kepada semua Setiausaha Cawangan sekurangkurangnya tiga puluh (30) hari sebelum tarikh persidangan.',
            'parent_constitution_template_id' => 331,
            'below_constitution_template_id' => 336,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '7. Semua Setiausaha Cawangan hendaklah menghantar kepada Setiausaha Agung sekurang-kurangnya dua puluh satu (21) hari sebelum Persidangan Perwakilan butir-butir mengenai wakil-wakil cawangan masing-masing, namanama calon bagi pegawai kanan dan nama-nama Ahli Majlis Jawatankuasa Agung serta usul-usul (jika ada) termasuk usul pindaan peraturan untuk dibincangkan di dalam persidangan.',
            'parent_constitution_template_id' => 331,
            'below_constitution_template_id' => 337,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8. Majlis Jawatankuasa Agung hendaklah menyediakan tatacara pengisian borang pencalonan dan asas-asas penolakan pencalonan dan diedarkan kepada semua cawangan. Semua pencalonan hendaklah dibuat di atas borang yang ditentukan oleh kesatuan dan mengandungi butir-butir berikut :- <br><br>Nama jawatan yang ditandingi, nama calon, nombor kad pengenalan, nombor keanggotaan, tarikh lahir, alamat kediaman, pekerjaan dan nombor sijil kerakyatan/ taraf kerakyatan.',
            'parent_constitution_template_id' => 331,
            'below_constitution_template_id' => 338,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '9. Sesuatu pencalonan tidak sah jika :',
            'parent_constitution_template_id' => 331,
            'below_constitution_template_id' => 339,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) ia tidak ditandatangani oleh seorang pencadang dan seorang penyokong yang merupakan anggota-anggota berhak; dan',
            'parent_constitution_template_id' => 340,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) ia tidak mengandungi persetujuan bertulis calon yang hendak bertanding.',
            'parent_constitution_template_id' => 340,
            'below_constitution_template_id' => 341,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '10. Setiausaha Agung hendaklah menghantar kepada semua Setiausaha Cawangan sekurang-kurangnya empat belas (14) hari sebelum tarikh persidangan suatu agenda yang mengandungi usul-usul untuk perbincangan, penyata tahunan dan penyata kewangan (jika ada) dan kertas-kertas undi rahsia dengan secukupnya menurut kembaran kepada peraturan-peraturan ini untuk pemilihan Pegawai-pegawai Kanan Kesatuan dan untuk mengundi perkara-perkara yang akan diputuskan dengan undi rahsia. Setiausaha Cawangan hendaklah mengedarkan kertas-kertas undi itu dengan sampulnya kepada anggota-anggota cawangan yang berhak mengundi.',
            'parent_constitution_template_id' => 331,
            'below_constitution_template_id' => 340,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11. Cukup kuorum mesyuarat jika wakil-wakil yang hadir, dengan tidak kira bilangan orangnya, mewakili lebih daripada setengah (½) dari jumlah bilangan cawangan-cawangan kesatuan.',
            'parent_constitution_template_id' => 331,
            'below_constitution_template_id' => 343,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '12. Jika selepas satu jam dari masa yang ditentukan itu bilangan wakil yang hadir tidak mencukupi maka persidangan itu hendaklah ditangguhkan kepada satu tarikh (tidak lewat daripada dua puluh satu (21) hari kemudian) yang akan ditetapkan oleh Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 331,
            'below_constitution_template_id' => 344,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '13. Sekiranya kuorum bagi Persidangan Perwakilan _Conference_Yearly_ Tahunan yang ditangguhkan itu masih belum mencukupi pada masa yang ditentukan maka wakil-wakil yang hadir berkuasa menguruskan persidangan itu akan tetapi tidak berkuasa meminda peraturan-peraturan kesatuan.',
            'parent_constitution_template_id' => 331,
            'below_constitution_template_id' => 345,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '14. Urusan Persidangan Perwakilan _Conference_Yearly_ Tahunan antara lain ialah :-',
            'parent_constitution_template_id' => 331,
            'below_constitution_template_id' => 346,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) menerima dan meluluskan laporan-laporan daripada Setiausaha Agung, Bendahari Agung dan Majlis Jawatankuasa Agung;',
            'parent_constitution_template_id' => 347,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) membincang dan memutuskan sebarang perkara atau usul mengenai kebajikan anggota-anggota dan kemajuan kesatuan;',
            'parent_constitution_template_id' => 347,
            'below_constitution_template_id' => 348,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'c) memilih/ melantik :-',
            'parent_constitution_template_id' => 347,
            'below_constitution_template_id' => 349,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'i) Pemegang Amanah; jika perlu',
            'parent_constitution_template_id' => 350,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'ii) Ahli Jemaah Penimbangtara; ',
            'parent_constitution_template_id' => 350,
            'below_constitution_template_id' => 351,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'iii) Juruaudit Dalam; dan',
            'parent_constitution_template_id' => 350,
            'below_constitution_template_id' => 352,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'v) Pemeriksa Undi.',
            'parent_constitution_template_id' => 350,
            'below_constitution_template_id' => 353,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'd) meluluskan pelantikan pegawai atau pekerja sepenuh masa (tetap/ kontrak) Kesatuan sekiranya perlu dan menetapkan skim gaji serta syarat-syarat pekerjaannya;',
            'parent_constitution_template_id' => 347,
            'below_constitution_template_id' => 350,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'e) membincang dan memutuskan perkara-perkara lain yang terkandung di dalam agenda; dan',
            'parent_constitution_template_id' => 347,
            'below_constitution_template_id' => 355,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'f) menerima penyata Jemaah Pemeriksa Undi tentang pemilihan Majlis Jawatankuasa Agung dan perkara-perkara lain (jika ada).',
            'parent_constitution_template_id' => 347,
            'below_constitution_template_id' => 356,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '15. Setiausaha Agung hendaklah menyampaikan kepada semua Setiausaha Cawangan satu salinan rangka minit Persidangan Perwakilan _Conference_Yearly_ Tahunan dalam tempoh tidak melebihi tujuh (7) hari sesudah sahaja selesai persidangan itu.',
            'parent_constitution_template_id' => 331,
            'below_constitution_template_id' => 347,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 10 PERSIDANGAN PERWAKILAN LUAR BIASA ',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 331,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Persidangan Perwakilan luar biasa hendaklah diadakan :-',
            'parent_constitution_template_id' => 359,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) apabila difikirkan mustahak oleh Majlis Jawatankuasa Agung; atau',
            'parent_constitution_template_id' => 360,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) apabila menerima permintaan bersama secara bertulis daripada sekurang-kurangnya dua cawangan atau lebih dan kedua-dua cawangan berkenaan masing-masing mewakili sekurang-kurangnya satu perempat (1/4) dari jumlah anggota cawangan itu. Permintaan tersebut hendaklah menyatakan tujuan dan sebab persidangan itu perlu diadakan.',
            'parent_constitution_template_id' => 360,
            'below_constitution_template_id' => 361,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Persidangan Perwakilan Luarbiasa yang diminta oleh cawangan-cawangan itu hendaklah diadakan dalam tempoh tiga puluh (30) hari dari tarikh permintaan itu diterima.',
            'parent_constitution_template_id' => 359,
            'below_constitution_template_id' => 360,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Notis dan agenda bagi Persidangan Perwakilan Luarbiasa hendaklah disampaikan oleh Setiausaha Agung kepada semua Setiausaha Cawangan sekurang-kurangnya sepuluh (10 hari) sebelum tarikh Persidangan Perwakilan Luarbiasa.',
            'parent_constitution_template_id' => 359,
            'below_constitution_template_id' => 363,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Persidangan Perwakilan Luarbiasa yang difikirkan mustahak oleh Majlis Jawatankuasa Agung hendaklah diadakan oleh Setiausaha Agung dalam tempoh dua puluh satu (21) hari dari tarikh permintaan itu diterima. Notis dan agenda hendaklah disampaikan oleh Setiausaha Agung kepada wakil-wakil sekurang-kurangnya tujuh (7) hari sebelum tarikh Persidangan Perwakilan Luarbiasa.',
            'parent_constitution_template_id' => 359,
            'below_constitution_template_id' => 364,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Peruntukan-peruntukan Peraturan 9 tentang kuorum dan penangguhan Persidangan Perwakilan adalah terpakai kepada Persidangan Perwakilan Luarbiasa.',
            'parent_constitution_template_id' => 359,
            'below_constitution_template_id' => 365,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6. Bagi Persidangan Perwakilan Luarbiasa yang diminta oleh cawangancawangan atau diadakan kerana difikirkan mustahak oleh Majlis Jawatankuasa Agung ditangguhkan kerana tidak cukup kuorum mengikut Peraturan 9, maka Persidangan Perwakilan Luarbiasa yang ditangguhkan itu hendaklah dibatalkan sekiranya kuorum masih tidak diperolehi selepas satu (1) jam dari masa yang dijadualkan. Persidangan Perwakilan Luarbiasa bagi perkara yang sama tidak boleh diminta lagi dalam tempoh enam (6) bulan dari tarikh mesyuarat itu dibatalkan.',
            'parent_constitution_template_id' => 359,
            'below_constitution_template_id' => 366,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '7. Setiausaha Agung hendaklah menyampaikan kepada semua Setiausaha Cawangan satu salinan rangka minit Persidangan Perwakilan Luarbiasa dalam tempoh tidak melebihi tujuh (7) hari selepas selesai persidangan itu.',
            'parent_constitution_template_id' => 359,
            'below_constitution_template_id' => 367,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8. Jika sesuatu Persidangan Perwakilan _Conference_Yearly_ Tahunan itu tidak dapat diadakan dalam masa yang ditentukan di bawah Peraturan 9, maka Persidangan Perwakilan Luarbiasa berkuasa menjalankan sebarang tugastugas yang lazim dijalankan oleh Persidangan Perwakilan _Conference_Yearly_ Tahunan dengan syarat Persidangan Perwakilan Luarbiasa yang demikian mestilah diadakan sebelum 31 Disember dalam tahun berkenaan.',
            'parent_constitution_template_id' => 359,
            'below_constitution_template_id' => 368,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 11 PEGAWAI DAN KAKITANGAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 359,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Pegawai Kesatuan bererti seorang yang menjadi Ahli Majlis Jawatankuasa Agung atau Ahli Jawatankuasa Cawangan.',
            'parent_constitution_template_id' => 370,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Seseorang tidak boleh dipilih atau bertugas sebagai pegawai kesatuan sekiranya :-',
            'parent_constitution_template_id' => 370,
            'below_constitution_template_id' => 371,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) bukan anggota kesatuan;',
            'parent_constitution_template_id' => 372,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) belum genap umur 21 tahun;',
            'parent_constitution_template_id' => 372,
            'below_constitution_template_id' => 373,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) bukan warganegara Malaysia;',
            'parent_constitution_template_id' => 372,
            'below_constitution_template_id' => 374,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) pernah menjadi anggota eksekutif mana-mana kesatuan yang pendaftarannya telah dibatalkan di bawah Seksyen 15(1)(b)(iv), (v) dan (vi) Akta Kesatuan Sekerja 1959 atau Enakmen yang telah dimansuhkan oleh Akta itu;',
            'parent_constitution_template_id' => 372,
            'below_constitution_template_id' => 375,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) telah disabitkan oleh mahkamah kerana kesalahan pecah amanah, pemerasan atau intimidasi atau apa-apa kesalahan di bawah Seksyen 49, 50 atau 50A Akta Kesatuan Sekerja 1959 atau sebarang kesalahan lain yang pada pendapat Ketua Pengarah Kesatuan Sekerja menyebabkan tidak layak menjadi pegawai sesebuah kesatuan sekerja;',
            'parent_constitution_template_id' => 372,
            'below_constitution_template_id' => 376,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) pemegang jawatan (office bearer) atau pekerja sesebuah parti politik; atau',
            'parent_constitution_template_id' => 372,
            'below_constitution_template_id' => 377,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(g) masih bankrap.',
            'parent_constitution_template_id' => 372,
            'below_constitution_template_id' => 378,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Majlis Jawatankuasa Agung berkuasa menggaji pekerja-pekerja sepenuh masa yang difikirkan perlu setelah mendapat kelulusan Persidangan Perwakilan. Seseorang pekerja Kesatuan selain daripada mereka yang tersebut dalam "proviso" kepada Seksyen 29(1) Akta Kesatuan Sekerja 1959, tidak boleh menjadi pegawai Kesatuan atau bertugas dan bertindak sedemikian rupa sehingga urusan hal ehwal Kesatuan seolah-olah dalam pengawalannya.',
            'parent_constitution_template_id' => 370,
            'below_constitution_template_id' => 372,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Seseorang tidak boleh digaji sebagai pekerja Kesatuan jika dia:',
            'parent_constitution_template_id' => 370,
            'below_constitution_template_id' => 380,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) bukan warganegara Malaysia;',
            'parent_constitution_template_id' => 381,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) telah disabitkan oleh sesebuah mahkamah kerana melakukan suatu kesalahan jenayah dan belum lagi mendapat pengampunan bagi kesalahan tersebut dan kesalahan itu pada pendapat Ketua Pengarah Kesatuan Sekerja tidak melayakkannya digaji oleh sesebuah Kesatuan sekerja;',
            'parent_constitution_template_id' => 381,
            'below_constitution_template_id' => 382,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) pegawai atau pekerja sesebuah kesatuan sekerja yang lain; atau',
            'parent_constitution_template_id' => 381,
            'below_constitution_template_id' => 383,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) pemegang jawatan (office-bearer) atau pekerja sesebuah parti politik.',
            'parent_constitution_template_id' => 381,
            'below_constitution_template_id' => 384,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 12 MAJLIS JAWATANKUASA AGUNG',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 370,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Majlis Jawatankuasa Agung adalah menjadi badan yang menjalankan pentadbiran dan pengurusan hal ehwal kesatuan termasuk hal-hal pertikaian perusahaan dalam masa di antara dua Persidangan Perwakilan _Conference_Yearly_ Tahunan.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Majlis Jawatankuasa Agung hendaklah terdiri daripada :-',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 387,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(1) Seorang Presiden<br><br>(2) Seorang Naib Presiden<br><br>(3) Seorang Setiausaha Agung<br><br>(4) Seorang Penolong Setiausaha Agung<br><br>(5) Seorang Bendahari Agung<br><br>(6) Seorang Penolong Bendahari Agung<br><br>dan<br><br>Seorang Ahli Majlis Jawatankuasa Agung dari tiap-tiap cawangan<br><br>akan dinamakan sebagai "Pegawai-pegawai Kanan Kesatuan" dan hendaklah dipilih setiap _rep_yearly_ tahunan dengan undi rahsia oleh semua anggota berhak.<br><br>Ahli-ahli Majlis Jawatankuasa Agung<br>bagi mewakili cawangan hendaklah dipilih mengikut susun taraf berikut :- Pengerusi atau Naib Pengerusi atau Setiausaha atau Bendahari atau Ahli Jawatankuasa mengikut jumlah undian tertinggi yang diterima. Seseorang Pegawai Kanan Kesatuan tidak dibenarkan menjadi Ahli Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 388,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Sekiranya seseorang calon untuk jawatan itu tidak ditandingi dan pencalonannya telah dilaksanakan menurut cara-cara yang ditentukan di dalam Peraturan 9(7) maka dia akan dianggap telah dipilih dan namanya hendaklah diasingkan dari kertas undi bagi pemilihan pegawai-pegawai.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 388,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Majlis Jawatankuasa Agung pertama hendaklah dipilih dengan undi rahsia dalam masa enam bulan setelah kesatuan didaftarkan dan sehingga pemilihan itu dijalankan.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 390,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Majlis Jawatankuasa Penaja yang dipilih semasa penubuhan kesatuan hendaklah menguruskan hal ehwal kesatuan. Majlis Jawatankuasa Penaja juga hendaklah melantik lima (5) orang pemeriksa undi sementara dan seorang daripadanya hendaklah dipilih sebagai Ketua Pemeriksa Undi untuk mengendalikan pemilihan pegawai yang pertama.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 391,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6. Ahli Majlis Jawatankuasa Agung akan memegang jawatan daripada satu Persidangan Perwakilan _Conference_Yearly_ Tahunan ke satu Persidangan Perwakilan _Conference_Yearly_ Tahunan berikutnya.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 392,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '7. Sekiranya dalam satu (1) Persidangan Perwakilan Luarbiasa suatu usul "tidak percaya" telah diluluskan terhadap  ajlis Jawatankuasa Agung oleh dua pertiga (2/3) suara terbanyak, Majlis Jawatankuasa Agung hendaklah dengan serta merta bertugas sebagai pengurus sementara dan hendaklah mengadakan pemilihan semula pegawai-pegawai Kesatuan dengan undi rahsia dalam tempoh sebulan setelah Persidangan Perwakilan Luarbiasa itu. Pegawai-pegawai yang dipilih dengan cara ini akan memegang jawatan sehingga Persidangan Perwakilan _Conference_Yearly_ Tahunan yang akan datang.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 393,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8. Apabila berlakunya pertukaran pegawai-pegawai, pegawai atau Majlis Jawatankuasa Agung yang bakal meninggalkan jawatan hendaklah dalam satu (1) minggu menyerahkan segala rekod berhubung dengan jawatannya kepada pegawai atau Majlis Jawatankuasa Agung yang mengambil alih jawatan.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 394,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '9. Pemberitahuan tentang pemilihan pegawai-pegawai hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja dalam tempoh empat belas (14) hari selepas pemilihan itu.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 395,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '10. Majlis Jawatankuasa Agung hendaklah bermesyuarat sekurang-kurangnya tiga (3) bulan sekali dan setengah (1/2) daripada jumlah anggotanya akan menjadi kuorum mesyuarat. Minit Mesyuarat Majlis Jawatankuasa Agung hendaklah disahkan pada mesyuarat berikutnya.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 396,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11. Mesyuarat Majlis Jawatankuasa Agung hendaklah diuruskan oleh Setiausaha Agung dengan arahan atau persetujuan Presiden. Notis dan agenda mesyuarat hendaklah diberi kepada semua Ahli Majlis Jawatankuasa Agung sekurang-kurangnya lima (5) hari sebelum mesyuarat tersebut diadakan.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 397,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '12. Permintaan secara bertulis untuk mengadakan mesyuarat Majlis Jawatankuasa Agung boleh dibuat oleh sekurang-kurangnya setengah daripada jumlah Ahli Majlis Jawatankuasa Agung. Permintaan itu hendaklah dikemukakan kepada Setiausaha Agung yang akan mengadakan mesyuarat yang diminta dalam tempoh empat belas (14) hari dari tarikh pemintaan berkenaan diterima.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 398,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '13. Apabila berlaku sesuatu perkara yang memerlukan keputusan serta merta oleh Majlis Jawatankuasa Agung dan tidak dapat diadakan mesyuarat tergempar maka Setiausaha Agung boleh dengan persetujuan Presiden mendapatkan kelulusan melalui surat pekeliling. Syarat-syarat yang tersebut di bawah ini hendaklah disempurnakan sebelum perkara itu boleh dianggap sebagai telah diputuskan oleh Majlis Jawatankuasa Agung :-',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 399,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) perkara dan tindakan yang dicadangkan hendaklah dinyatakan dengan jelas dan salinan surat pekeliling itu disampaikan kepada semua Ahli Majlis Jawatankuasa Agung;',
            'parent_constitution_template_id' => 400,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) sekurang-kurangnya setengah (1/2) daripada jumlah Ahli Majlis Jawatankuasa Agung telah menyatakan secara bertulis sama ada mereka itu bersetuju atau tidak dengan cadangan tersebut; dan',
            'parent_constitution_template_id' => 400,
            'below_constitution_template_id' => 401,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) suara yang terbanyak daripada mereka yang menyatakan sokongan atau sebaliknya tentang cadangan tersebut akan menjadi keputusan.',
            'parent_constitution_template_id' => 400,
            'below_constitution_template_id' => 402,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '14. Keputusan yang didapati melalui surat pekeliling itu hendaklah dilaporkan oleh Setiausaha Agung dalam mesyuarat Majlis Jawatankuasa Agung atau Persidangan Perwakilan yang akan datang dan dicatatkan dalam minit mesyuarat itu.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 400,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '15. Ahli Majlis Jawatankuasa Agung yang tidak menghadiri mesyuarat tiga (3) kali berturut-turut tidak lagi berhak menyandang jawatannya kecuali dia dapat memberi alasan yang memuaskan kepada Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 404,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '16. Apabila seseorang pegawai Kesatuan dan wakil-wakil meninggal dunia, berhenti atau terlucut hak, maka calon yang mendapat undi yang terkebawah sedikit bagi jawatan berkenaan dalam masa undian yang lalu hendaklah dijemput untuk mengisi tempat yang kosong itu. Bagi jawatan Presiden, Naib Presiden, Setiausaha Agung, Penolong Setiausaha Agung, Bendahari Agung atau Penolong Bendahari Agung calon tersebut hendaklah mendapat tidak kurang daripada satu perempat (1/4) jumlah undi yang telah dibuang bagi jawatan itu.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 405,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '17. Jika tiada calon yang layak atau calon yang layak enggan menerima jawatan tersebut maka Majlis Jawatankuasa Agung berkuasa melantik seorang anggota yang layak untuk mengisi kekosongan itu.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 406,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '18. Setiausaha Agung hendaklah menghantar notis pertukaran pegawai-pegawai kepada Ketua Pengarah Kesatuan Sekerja dalam masa empat belas (14) hari dari tarikh pertukaran dibuat.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 407,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '19. Majlis Jawatankuasa Agung boleh menggunakan sebarang kuasa dan menjalankan sebarang kerja yang difikirkan perlu bagi mencapai tujuan-tujuan kesatuan dan untuk memajukan kepentingannya dengan mematuhi peraturan-peraturan ini, Akta Kesatuan Sekerja 1959 dan Peraturan-peraturan Kesatuan Sekerja 1959.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 408,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '20. Majlis Jawatankuasa Agung hendaklah mengawal tabung wang Kesatuan supaya tidak dibelanjakan dengan boros atau disalahgunakan. Majlis Jawatankuasa Agung hendaklah mengarahkan Setiausaha Agung atau pegawai yang lain mengambil langkah-langkah sewajarnya supaya seseorang pegawai, pekerja ataupun anggota Kesatuan didakwa di mahkamah kerana menyalahguna atau mengambil secara tidak sah wang atau harta kepunyaan Kesatuan.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 409,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '21. Majlis Jawatankuasa Agung hendaklah mengarahkan Setiausaha Agung atau pegawai yang lain supaya menguruskan kerja-kerja Kesatuan dengan sempurna.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 410,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '22. Tertakluk kepada Peraturan 11(3), Majlis Jawatankuasa Agung boleh menggaji mana-mana pegawai atau pekerja sepenuh masa yang difikirkan mustahak atas skim gaji dan syarat-syarat pekerjaan yang diluluskan oleh Persidangan Perwakilan.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 411,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '23. Pegawai-pegawai atau pekerja-pekerja Kesatuan boleh digantung kerja atau diberhentikan oleh Majlis Jawatankuasa Agung kerana kelalaian, tidak amanah, tidak cekap atau enggan melaksanakan sebarang keputusan atau kerana sebab-sebab lain yang difikirkan munasabah atau wajar demi kepentingan Kesatuan.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 412,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '24. Majlis Jawatankuasa Agung akan memberi arahan kepada Pemegangpemegang Amanah tentang pelaburan wang Kesatuan.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 413,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '25. Majlis Jawatankuasa Agung boleh menggantung atau memecat keanggotaan atau melarang daripada memegang jawatan seseorang anggota jika didapati bersalah kerana cuba hendak merosakkan Kesatuan atau melakukan perbuatan yang melanggar peraturan-peraturan ini atau membuat atau melibatkan diri dengan sebarang perbuatan mencela, mengeji atau mencerca Kesatuan, pegawai atau dasar Kesatuan. Sebelum tindakan tersebut diambil kesatuan hendaklah:',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 414,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) memberi peluang kepada anggota berkenaan untuk membela diri terhadap tuduhan berkenaan;',
            'parent_constitution_template_id' => 415,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) perintah penggantungan, pemecatan atau larangan tersebut hendaklah dibuat secara bertulis dan menyatakan dengan jelas bentuk dan alasan tentang penggantungan, pemecatan atau larangan tersebut; dan',
            'parent_constitution_template_id' => 415,
            'below_constitution_template_id' => 416,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) perintah tersebut (jika berkenaan) hendaklah menyatakan tempoh ianya berkuatkuasa dan syarat-syarat yang membolehkan ia ditarik balik.',
            'parent_constitution_template_id' => 415,
            'below_constitution_template_id' => 417,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '26. Jika seseorang yang telah digantung faedahnya, dipecat atau dilarang daripada memegang jawatan berasa terkilan, dia berhak merujukkan kilanan berkenaan melalui Majlis Jawatankuasa Agung untuk diselesaikan oleh Jemaah Penimbangtara di bawah Peraturan 26 dan Peraturan 27 atau merayu terus kepada Persidangan Perwakilan dimana keputusan Persidangan Perwakilan adalah muktamad.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 415,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '27. Dalam masa antara Persidangan Perwakilan _Conference_Yearly_ Tahunan, Majlis Jawatankuasa Agung hendaklah mentafsirkan peraturan-peraturan Kesatuan dan jika perlu, akan menentukan perkara yang tidak ternyata dalam peraturan-peraturan ini.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 419,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '28. Sebarang keputusan Majlis Jawatankuasa Agung hendaklah dipatuhi oleh semua anggota Kesatuan kecuali sehingga ianya dibatalkan oleh suatu ketetapan dalam Persidangan Perwakilan melainkan keputusan yang berkehendakkan undi rahsia.',
            'parent_constitution_template_id' => 386,
            'below_constitution_template_id' => 420,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 13 TUGAS PEGAWAI-PEGAWAI KANAN KESATUAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 386,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Presiden',
            'parent_constitution_template_id' => 422,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Menjadi Pengerusi semua mesyuarat dan bertanggungjawab tentang ketenteraman dan kesempurnaan mesyuarat-mesyuarat itu serta mempunyai undian pemutus dalam semua isu semasa pada masa mesyuarat kecuali perkara-perkara yang melibatkan undi rahsia;',
            'parent_constitution_template_id' => 423,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) mengesahkan dan menandatangani minit tiap-tiap mesyuarat;',
            'parent_constitution_template_id' => 423,
            'below_constitution_template_id' => 424,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) menandatangani semua cek Kesatuan bersama-sama dengan Setiausaha Agung dan Bendahari Agung; dan',
            'parent_constitution_template_id' => 423,
            'below_constitution_template_id' => 425,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) mengawasi pentadbiran dan perjalanan Kesatuan serta memastikan peraturan-peraturan kesatuan dipatuhi oleh semua yang berkenaan.',
            'parent_constitution_template_id' => 423,
            'below_constitution_template_id' => 426,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Naib Presiden',
            'parent_constitution_template_id' => 422,
            'below_constitution_template_id' => 423,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Membantu Presiden dalam menjalankan tugas-tugasnya dan memangku jawatan Presiden pada masa ketiadaannya; dan',
            'parent_constitution_template_id' => 428,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) menjalankan tugas-tugas sebagaimana diarahkan oleh Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 428,
            'below_constitution_template_id' => 429,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Setiausaha Agung',
            'parent_constitution_template_id' => 422,
            'below_constitution_template_id' => 428,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Mengelolakan kerja-kerja Kesatuan mengikut peraturan-peraturan ini dan melaksanakan perintah-perintah dan arahan-arahan Persidangan Perwakilan atau Majlis Jawatankuasa Agung;',
            'parent_constitution_template_id' => 431,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) mengawasi kerja-kerja kakitangan Kesatuan dan bertanggungjawab tentang surat-menyurat dan menyimpan buku-buku, surat-surat keterangan dan kertas-kertas Kesatuan mengikut cara dan aturan yang diarahkan oleh Majlis Jawatankuasa Agung;',
            'parent_constitution_template_id' => 431,
            'below_constitution_template_id' => 432,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) menetapkan serta menyediakan agenda mesyuarat Majlis Jawatankuasa Agung dengan persetujuan Presiden dan menghadiri semua mesyuarat, menulis minit-minit mesyuarat dan menyediakan Laporan Tahunan Kesatuan untuk Persidangan Perwakilan _Conference_Yearly_ Tahunan;',
            'parent_constitution_template_id' => 431,
            'below_constitution_template_id' => 433,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) menyediakan atau menguruskan supaya disediakan Penyata-penyata Tahunan dan surat keterangan lain yang dikehendaki oleh Ketua Pengarah Kesatuan Sekerja dalam masa yang ditentukan;',
            'parent_constitution_template_id' => 431,
            'below_constitution_template_id' => 434,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) menyimpan dan mengemaskini suatu Daftar Keanggotaan yang mengandungi nama anggota, nombor kad pengenalan, nombor keanggotaan, tarikh lahir, jantina, bangsa, yuran masuk, tarikh menjadi anggota, tarikh berhenti menjadi anggota, tarikh mula bekerja, alamat kediaman, nama dan alamat tempat pekerjaan, nombor telefon bimbit, butir-butir bilangan lelaki/perempuan, bilangan anggota dalam daftar dan bilangan anggota berhak.',
            'parent_constitution_template_id' => 431,
            'below_constitution_template_id' => 435,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) menandatangani semua cek Kesatuan bersama dengan Presiden dan Bendahari Agung.',
            'parent_constitution_template_id' => 431,
            'below_constitution_template_id' => 436,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Penolong Setiausaha Agung',
            'parent_constitution_template_id' => 422,
            'below_constitution_template_id' => 431,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Membantu Setiausaha Agung dalam urusan pentadbiran kesatuan dan memangku jawatan Setiausaha Agung pada masa ketiadaannya; dan',
            'parent_constitution_template_id' => 438,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) menjalankan tugas-tugas sebagaimana diarah oleh Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 438,
            'below_constitution_template_id' => 439,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Bendahari Agung',
            'parent_constitution_template_id' => 422,
            'below_constitution_template_id' => 438,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Bertanggungjawab dalam urusan penerimaan dan pembayaran wang Kesatuan dan urusan penyimpanan dokumen kewangan sebagaimana yang dikehendaki oleh Peraturan-peraturan Kesatuan Sekerja 1959;',
            'parent_constitution_template_id' => 441,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) menyediakan Penyata Tahunan sebagaimana yang dikehendaki di bawah Seksyen 56, Akta Kesatuan Sekerja 1959;',
            'parent_constitution_template_id' => 441,
            'below_constitution_template_id' => 442,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) mengeluarkan Resit Rasmi bagi sebarang wang yang diterima;',
            'parent_constitution_template_id' => 441,
            'below_constitution_template_id' => 443,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) bertanggungjawab tentang keselamatan simpanan buku-buku kewangan dan surat-surat keterangan yang berkenaan di Ibu Pejabat. Buku-buku dan surat-surat keterangan ini tidak boleh dikeluarkan dari tempat rasminya tanpa kebenaran yang bertulis daripada Presiden pada tiap-tiap kali ia hendak dikeluarkan;',
            'parent_constitution_template_id' => 441,
            'below_constitution_template_id' => 444,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) menyediakan Penyata Kewangan bagi tiap-tiap mesyuarat Majlis Jawatankuasa Agung dan Persidangan Perwakilan; dan',
            'parent_constitution_template_id' => 441,
            'below_constitution_template_id' => 445,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) Menandatangani semua cek Kesatuan bersama dengan Presiden dan Setiausaha Agung.',
            'parent_constitution_template_id' => 441,
            'below_constitution_template_id' => 446,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6. Penolong Bendahari Agung',
            'parent_constitution_template_id' => 422,
            'below_constitution_template_id' => 441,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Membantu Bendahari Agung dalam urusan kewangan Kesatuan dan memangku jawatan Bendahari Agung pada masa ketiadaannya; dan',
            'parent_constitution_template_id' => 448,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) menjalankan tugas-tugas sebagaimana diarah oleh Majlis Jawatankuasa Agung. ',
            'parent_constitution_template_id' => 448,
            'below_constitution_template_id' => 449,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 14 PEMEGANG AMANAH',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 422,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Tiga orang Pemegang Amanah yang berumur tidak kurang dari 21 tahun dan bukan Setiausaha Agung atau Bendahari Agung Kesatuan hendaklah dilantik/dipilih di dalam Persidangan Perwakilan _Conference_Yearly_ Tahunan yang pertama. Mereka akan menyandang jawatan itu selama yang dikehendaki oleh Kesatuan.',
            'parent_constitution_template_id' => 451,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Sebarang harta (tanah, bangunan, pelaburan dan lain-lain) yang dimiliki oleh Kesatuan hendaklah diserah kepada mereka untuk diuruskan sebagaimana yang diarahkan oleh Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 451,
            'below_constitution_template_id' => 452,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Pemegang Amanah tidak boleh menjual, menarik balik atau memindah milik sebarang harta Kesatuan tanpa persetujuan dan kuasa daripada Majlis Jawatankuasa Agung yang disampaikan dengan bertulis oleh Setiausaha Agung dan Bendahari Agung.',
            'parent_constitution_template_id' => 451,
            'below_constitution_template_id' => 453,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Seseorang Pemegang Amanah boleh diberhentikan daripada jawatannya oleh Majlis Jawatankuasa Agung kerana tidak sihat, tidak sempurna fikiran, tidak berada dalam negeri atau kerana sebarang sebab lain yang menyebabkan dia tidak boleh menjalankan tugasnya atau tidak dapat menyempurnakan tugasnya dengan memuaskan.',
            'parent_constitution_template_id' => 451,
            'below_constitution_template_id' => 454,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Jika seseorang Pemegang Amanah meninggal dunia, berhenti atau diberhentikan maka kekosongan itu hendaklah diisi oleh mana-mana anggota yang dilantik oleh Majlis Jawatankuasa Agung sehingga Persidangan Perwakilan yang akan datang.',
            'parent_constitution_template_id' => 451,
            'below_constitution_template_id' => 455,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6. Persidangan Perwakilan boleh melantik sebuah syarikat pemegang amanah seperti yang ditakrifkan di bawah Akta Syarikat Amanah 1949 (Trust Companies Act 1949) atau undang-undang lain yang bertulis yang megawal syarikat-syarikat Pemegang Amanah di Malaysia untuk menjadi Pemegang Amanah yang tunggal bagi Kesatuan ini. Jika syarikat Pemegang Amanah tersebut dilantik maka rujukan "Pemegang Amanah" dalam peraturanperaturan ini hendaklah difahamkan sebagai Pemegang Amanah yang dilantik.',
            'parent_constitution_template_id' => 451,
            'below_constitution_template_id' => 456,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '7. Butir-butir pelantikan Pemegang Amanah atau pertukaran Pemegang Amanah hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja dalam tempoh empat belas (14) hari selepas pelantikan atau pertukaran berkenaan untuk dimasukkan ke dalam daftar kesatuan. Sebarang perlantikan atau pertukaran tidak boleh dikuatkuasakan sehingga didaftarkan sedemikian.',
            'parent_constitution_template_id' => 451,
            'below_constitution_template_id' => 457,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 15 JURUAUDIT DALAM',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 451,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Dua orang Juruaudit Dalam yang bukan anggota Majlis Jawatankuasa Agung hendaklah dipilih secara angkat tangan dalam Persidangan Perwakilan _Conference_Yearly_ Tahunan. Mereka hendaklah memeriksa kira-kira Kesatuan pada penghujung tiap-tiap tiga (3) bulan dan menyediakan laporan kepada Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 459,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Dokumen-dokumen pentadbiran dan kewangan Kesatuan hendaklah diaudit bersama-sama oleh kedua-dua Juruaudit Dalam dan mereka itu berhak melihat semua buku dan surat keterangan yang perlu untuk menyempurnakan tugas mereka.',
            'parent_constitution_template_id' => 459,
            'below_constitution_template_id' => 460,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Seseorang anggota Kesatuan boleh mengadu secara bertulis kepada Juruaudit Dalam tentang sebarang hal kewangan yang tidak betul.',
            'parent_constitution_template_id' => 459,
            'below_constitution_template_id' => 461,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Apabila berlaku kekosongan jawatan oleh sebarang sebab, kekosongan ini bolehlah diisi dengan cara lantikan oleh Majlis Jawatankuasa Agung sehingga Persidangan Perwakilan yang akan datang.',
            'parent_constitution_template_id' => 459,
            'below_constitution_template_id' => 462,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 16 JURUAUDIT LUAR',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 459,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Kesatuan hendaklah melantik seorang Juruaudit Luar bertauliah dan seterusnya memperolehi kelulusan Ketua Pengarah Kesatuan Sekerja bagi perlantikan ini. Juruaudit Luar itu hendaklah merupakan seorang akauntan yang telah memperolehi kebenaran bertulis daripada Menteri Kewangan untuk mengaudit kira-kira syarikat-syarikat di bawah Akta Syarikat 1965.',
            'parent_constitution_template_id' => 464,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Seseorang Juruaudit Luar yang sama tidak boleh dilantik melebihi tempoh tiga (3) tahun berturut-turut.',
            'parent_constitution_template_id' => 464,
            'below_constitution_template_id' => 465,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Kira-kira Kesatuan hendaklah diaudit oleh Juruaudit Luar dengan segera selepas sahaja tahun kewangan ditutup pada 31 Mac dan hendaklah selesai sebelum 30 Ogos tiap-tiap tahun.',
            'parent_constitution_template_id' => 464,
            'below_constitution_template_id' => 466,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Juruaudit Luar berhak menyemak semua buku dan surat keterangan yang perlu untuk menyempurnakan tugasnya.',
            'parent_constitution_template_id' => 464,
            'below_constitution_template_id' => 467,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Kira-kira Kesatuan yang diaudit hendaklah diakui benar oleh Bendahari Agung dengan surat akuan bersumpah (statutory declaration).',
            'parent_constitution_template_id' => 464,
            'below_constitution_template_id' => 468,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6. Satu salinan penyata kira-kira yang diaudit dan laporan Juruaudit Luar itu hendaklah diedarkan kepada tiap-tiap perwakilan sebelum Persidangan Perwakilan _Conference_Yearly_ Tahunan. Penyata kira-kira dan Laporan Juruaudit Luar tersebut hendaklah dibentangkan dalam Persidangan Perwakilan _Conference_Yearly_ Tahunan untuk kelulusan.',
            'parent_constitution_template_id' => 464,
            'below_constitution_template_id' => 469,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '7. Kira-kira Kesatuan yang diaudit hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja berserta dengan Borang N sebelum 1 Oktober tiap-tiap tahun.',
            'parent_constitution_template_id' => 464,
            'below_constitution_template_id' => 470,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 17 JEMAAH PEMERIKSA UNDI',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 464,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Satu Jemaah Pemeriksa Undi yang terdiri daripada lima (5) orang anggota hendaklah dipilih secara angkat tangan dalam Persidangan Perwakilan _Conference_Yearly_ Tahunan untuk mengendalikan segala perjalanan undi rahsia. Seorang daripada mereka hendaklah dipilih sebagai ketua pemeriksa undi.',
            'parent_constitution_template_id' => 472,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Mereka hendaklah bukan pegawai Kesatuan atau calon bagi pemilihan pegawai-pegawai Kesatuan. Seboleh-bolehnya anggota-anggota yang dipilih ini hendaklah anggota-anggota yang tinggal di sekitar kawasan Ibu Pejabat Kesatuan.',
            'parent_constitution_template_id' => 472,
            'below_constitution_template_id' => 473,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Jemaah Pemeriksa Undi ini bertanggungjawab mengendalikan segala perjalanan undi rahsia yang dijalankan oleh kesatuan. Mereka akan berkhidmat dari suatu Persidangan Perwakilan _Conference_Yearly_ Tahunan ke Persidangan Perwakilan _Conference_Yearly_ Tahunan yang berikutnya. Apabila berlaku kekosongan, kekosongan ini hendaklah diisi dengan cara lantikan oleh Majlis Jawatankuasa Agung sehingga Mesyuarat Agung yang akan datang.',
            'parent_constitution_template_id' => 472,
            'below_constitution_template_id' => 474,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Sekurang-kurangnya tiga Pemeriksa Undi hendaklah hadir apabila pembuangan undi dijalankan. Mereka hendaklah memastikan aturcara yang tertera di dalam kembaran kepada peraturan-peraturan ini dipatuhi dengan sepenuhnya.',
            'parent_constitution_template_id' => 472,
            'below_constitution_template_id' => 475,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 18 GAJI DAN BAYARAN-BAYARAN LAIN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 472,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Skim gaji serta syarat-syarat pekerjaan bagi pegawai-pegawai kesatuan yang bekerja sepenuh masa dengan Kesatuan dan pekerja-pekerja Kesatuan hendaklah ditetapkan melalui usul yang diluluskan di Persidangan Perwakilan _Conference_Yearly_ Tahunan.',
            'parent_constitution_template_id' => 477,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Pegawai-pegawai Kesatuan yang dikehendaki berkhidmat separuh masa bagi pihak Kesatuan boleh dibayar saguhati. Jumlah pembayaran saguhati itu hendaklah ditetapkan oleh Persidangan Perwakilan _Conference_Yearly_ Tahunan.',
            'parent_constitution_template_id' => 477,
            'below_constitution_template_id' => 478,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Pegawai-pegawai atau wakil-wakil Kesatuan boleh diberi bayaran gantirugi dengan kelulusan oleh Majlis Jawatankuasa Agung kerana hilang masa kerjanya dan perbelanjaan serta elaun yang munasabah bagi menjalankan kerja-kerja Kesatuan. Mereka itu hendaklah mengemukakan satu penyata yang menunjukkan butir-butir perjalanan dan bukti hilang masa kerjanya (jika berkenaan) dan perbelanjaan yang disokong resit atau keterangan pembayaran lain. Had maksimum bayaran, elaun dan perbelanjaan yang boleh dibayar hendaklah ditentukan dari semasa ke semasa oleh Persidangan Perwakilan _Conference_Yearly_ Tahunan dan Majlis Jawatankuasa Agung tidak boleh meluluskan sebarang bayaran yang melebihi had yang ditentukan oleh Persidangan Perwakilan itu.',
            'parent_constitution_template_id' => 477,
            'below_constitution_template_id' => 479,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 19 KEWANGAN DAN AKAUN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 477,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Wang-wang kesatuan boleh dibelanjakan bagi perkara-perkara berikut :',
            'parent_constitution_template_id' => 481,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Bayaran gaji, elaun dan perbelanjaan kepada pegawai kesatuan dan pekerja-pekerja Kesatuan tertakluk kepada Peraturan 18.',
            'parent_constitution_template_id' => 482,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) Bayaran dan perbelanjaan pentadbiran Kesatuan termasuk bayaran mengaudit akaun Kesatuan.',
            'parent_constitution_template_id' => 482,
            'below_constitution_template_id' => 483,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) Bayaran urusan pendakwaan atau pembelaan dalam prosiding undang-undang di mana Kesatuan atau seseorang anggotanya menjadi satu pihak yang bertujuan untuk memperolehi atau mempertahankan hak Kesatuan atau sebarang hak yang terbit daripada perhubungan di antara seseorang anggota dengan majikannya.',
            'parent_constitution_template_id' => 482,
            'below_constitution_template_id' => 484,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) Bayaran urusan pertikaian perusahaan bagi pihak Kesatuan atau anggota-anggotanya dengan syarat bahawa pertikaian perusahaan itu tidak bertentangan dengan Akta Kesatuan Sekerja 1959 atau undang-undang bertulis yang lain.',
            'parent_constitution_template_id' => 482,
            'below_constitution_template_id' => 485,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) Bayaran gantirugi kepada anggota kerana kerugian akibat daripada pertikaian perusahaan yang melibatkan anggota itu dengan syarat bahawa pertikaian perusahaan itu tidak bertentangan dengan Akta Kesatuan Sekerja 1959 atau undang-undang bertulis yang lain.',
            'parent_constitution_template_id' => 482,
            'below_constitution_template_id' => 486,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) Bayaran elaun kepada anggota kerana berumur tua, sakit, ditimpa kemalangan atau hilang pekerjaan atau bayaran kepada tanggungannya apabila anggota itu meninggal dunia.',
            'parent_constitution_template_id' => 482,
            'below_constitution_template_id' => 487,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(g) Bayaran yuran mengenai pergabungan atau keanggotaan dengan mana-mana persekutuan kesatuan sekerja yang telah didaftarkan di bawah Bahagian XII Akta Kesatuan Sekerja 1959 atau mana-mana badan perunding atau badan yang serupa yang mana kelulusan telah diberi oleh Ketua Pengarah Kesatuan Sekerja di bawah Seksyen 76A(1) Akta Kesatuan Sekerja 1959 atau Ketua Pengarah Kesatuan Sekerja telah diberitahu di bawah Seksyen 76A(2) Akta Kesatuan Sekerja 1959',
            'parent_constitution_template_id' => 482,
            'below_constitution_template_id' => 488,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(h) Bayaran-bayaran untuk:-',
            'parent_constitution_template_id' => 482,
            'below_constitution_template_id' => 489,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(i) tambang keretapi, perbelanjaan pengangkutan lain yang perlu, perbelanjaan makan dan tempat tidur yang disokong dengan resit atau sebanyak mana yang telah ditentukan oleh Kesatuan tertakluk kepada had-had yang ditentukan di bawah Peraturan 18.',
            'parent_constitution_template_id' => 490,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(ii) amaun kehilangan gaji yang sebenar oleh wakil Kesatuan kerana menghadiri mesyuarat berkaitan atau berhubung dengan hal perhubungan perusahaan atau menyempurnakan perkaraperkara yang dikehendaki oleh Ketua Pengarah Kesatuan Sekerja berkaitan dengan Akta Kesatuan Sekerja 1959 atau sebarang peraturan tertakluk kepada had yang ditentukan di bawah Peraturan 18.',
            'parent_constitution_template_id' => 490,
            'below_constitution_template_id' => 491,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(iii) perbelanjaan bagi menubuhkan atau mengekalkan persekutuan kesatuan sekerja yang didaftarkan di bawah Bahagian XII AktaKesatuan Sekerja 1959 atau badan perunding atau badan yang serupa yang mana kelulusan telah diberi oleh Ketua Pengarah Kesatuan Sekerja di bawah Seksyen 76A(1) Akta Kesatuan Sekerja 1959 atau Ketua Pengarah Kesatuan Sekerja telah diberitahu di bawah Seksyen 76A(2) Akta Kesatuan Sekerja 1959.',
            'parent_constitution_template_id' => 490,
            'below_constitution_template_id' => 492,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(i) Urusan mengarang, mencetak, menerbit dan mengedarkan sebarang suratkhabar, majalah, surat berita atau penerbitan lain yang dikeluarkan oleh Kesatuan untuk menjayakan tujuan-tujuannya atau untuk memelihara kepentingan anggota-anggota selaras dengan peraturan-peraturan ini.',
            'parent_constitution_template_id' => 482,
            'below_constitution_template_id' => 490,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(j) Penyelesaian pertikaian di bawah Bahagian VI Akta Kesatuan Sekerja 1959.',
            'parent_constitution_template_id' => 482,
            'below_constitution_template_id' => 494,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(k) Aktiviti-aktiviti sosial, sukan, pendidikan dan amal kebajikan anggota-anggota Kesatuan.',
            'parent_constitution_template_id' => 482,
            'below_constitution_template_id' => 495,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(l) Pembayaran premium kepada syarikat-syarikat insurans berdaftar di Malaysia yang diluluskan oleh Ketua Pengarah Kesatuan Sekerja dari semasa ke semasa.',
            'parent_constitution_template_id' => 482,
            'below_constitution_template_id' => 496,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Tabung wang Kesatuan tidak boleh digunakan sama ada secara langsung atau sebaliknya untuk membayar denda atau hukuman yang dikenakan oleh mahkamah kepada sesiapa pun.',
            'parent_constitution_template_id' => 481,
            'below_constitution_template_id' => 482,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Wang-wang Kesatuan yang tidak dikehendaki untuk perbelanjaan semasa yang telah diluluskan hendaklah dimasukkan ke dalam bank oleh Bendahari Agung dalam tempoh tujuh (7) hari dari tarikh penerimaannya. Akaun bank itu hendaklah di atas nama Kesatuan dan butir-butir akaun itu hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja. Pembukaan sesuatu akaun bank itu hendaklah diluluskan oleh Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 481,
            'below_constitution_template_id' => 498,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Semua cek atau notis pengeluaran wang atas akaun kesatuan hendaklah ditandatangani bersama oleh Presiden (pada masa ketiadaannya oleh Naib Presiden), Setiausaha Agung (pada masa ketiadaannya oleh Penolong Setiausaha Agung) dan Bendahari Agung (pada masa ketiadaannya oleh Penolong Bendahari Agung).',
            'parent_constitution_template_id' => 481,
            'below_constitution_template_id' => 499,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Bendahari Agung dibenarkan menyimpan wang tunai tidak lebih daripada _max_savings_text_ (RM _max_savings_) pada sesuatu masa. Sebarang perbelanjaan yang melebihi _max_expenses_text_ (RM _max_expenses_) tidak boleh dilakukan pada sesuatu masa kecuali dengan persetujuan terlebih dahulu daripada Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 481,
            'below_constitution_template_id' => 500,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6. Bendahari Agung hendaklah menyediakan satu penyata belanjawan tahunan untuk diluluskan oleh Persidangan Perwakilan _Conference_Yearly_ Tahunan dan semua perbelanjaan yang dibuat oleh Kesatuan hendaklah dalam had-had yang ditetapkan oleh belanjawan yang diluluskan itu. Belanjawan tersebut boleh disemak semula dari semasa ke semasa dengan dipersetujui terlebih dahulu oleh anggota-anggota di dalam Persidangan Perwakilan Luar Biasa atau melalui undi rahsia.',
            'parent_constitution_template_id' => 481,
            'below_constitution_template_id' => 501,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '7. Semua harta Kesatuan hendaklah dimiliki bersama atas nama Pemegangpemegang Amanah. Wang-wang Kesatuan yang tidak dikehendaki untuk urusan pentadbiran harian Kesatuan boleh digunakan bagi tujuan-tujuan seperti berikut:',
            'parent_constitution_template_id' => 481,
            'below_constitution_template_id' => 502,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) membeli atau memajak sebarang tanah atau bangunan untuk kegunaan Kesatuan. Tanah atau bangunan ini tertakluk kepada sesuatu undang-undang bertulis atau undang-undang lain yang boleh dipakai, dipajak atau dengan persetujuan anggota-anggota kesatuan yang diperolehi melalui usul yang dibawa dalam mesyuarat Agung boleh dijual, ditukar atau digadai;',
            'parent_constitution_template_id' => 503,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) melabur dalam amanah saham (securities) atau dalam pinjaman kepada mana-mana syarikat mengikut mana-mana undang-undang yang berkaitan dengan pemegang amanah;',
            'parent_constitution_template_id' => 503,
            'below_constitution_template_id' => 504,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) disimpan dalam Bank Simpanan Nasional, di mana-mana bank yang diperbadankan di Malaysia atau di mana-mana syarikat kewangan yang merupakan anak syarikat bank tersebut; atau',
            'parent_constitution_template_id' => 503,
            'below_constitution_template_id' => 505,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) dengan mendapat kelulusan terlebih dahulu daripada Menteri Sumber Manusia dan tertakluk kepada syarat-syarat yang dikenakan oleh beliau bagi melabur :-',
            'parent_constitution_template_id' => 503,
            'below_constitution_template_id' => 506,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(i) dalam mana-mana syarikat kerjasama yang berdaftar; atau',
            'parent_constitution_template_id' => 507,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(ii) dalam mana-mana pengusahaan perdagangan, perindustrian atau pertanian atau dalam enterprise bank yang diperbadankan dan beroperasi di Malaysia.',
            'parent_constitution_template_id' => 507,
            'below_constitution_template_id' => 508,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8. Semua belian dan pelaburan di bawah peraturan ini hendaklah diluluskan terlebih dahulu oleh Mesyuarat Majlis Jawatankuasa Agung dan dibuat di atas nama pemegang-pemegang amanah Kesatuan. Kelulusan ini hendaklah disahkan oleh Persidangan Perwakilan yang akan datang. Pemegangpemegang amanah hendaklah memegang saham-saham atau pelaburanpelaburan bagi pihak anggota-anggota Kesatuan.',
            'parent_constitution_template_id' => 481,
            'below_constitution_template_id' => 503,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '9. Bendahari Agung hendaklah merekod atau menguruskan supaya direkodkan dalam buku akaun kewangan Kesatuan sebarang penerimaan dan perbelanjaan wang kesatuan.',
            'parent_constitution_template_id' => 481,
            'below_constitution_template_id' => 510,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '10. Bendahari Agung hendaklah pada atau sebelum 1 Oktober tiap-tiap tahun, atau apabila dia berhenti atau meletak jawatan daripada pekerjaannya, atau pada bila-bila masa dia dikehendaki berbuat demikian oleh Majlis Jawatankuasa Agung atau oleh anggota-anggota melalui suatu ketetapan yang dibuat dalam Persidangan Perwakilan atau apabila dikehendaki oleh Ketua Pengarah Kesatuan Sekerja mengemukakan kepada Kesatuan dan anggota-anggotanya atau kepada Ketua Pengarah Kesatuan Sekerja yang mana ada kaitan, satu penyata kewangan yang benar dan betul tentang semua wang yang diterima dan dibayarnya dari masa dia mula memegang jawatan itu atau, jika dia pernah membentangkan penyata kewangan terdahulu, dari tarikh penyata kewangan itu dibentangkan, baki wang dalam tangannya pada masa ia mengemukakan penyata kewangan itu dan juga semua bon dan jaminan atau harta-harta Kesatuan yang lain dalam simpanan atau jagaanya.',
            'parent_constitution_template_id' => 481,
            'below_constitution_template_id' => 511,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11. Penyata kewangan tersebut hendaklah mengikut bentuk yang ditentukan oleh Peraturan-peraturan Kesatuan Sekerja 1959 dan hendaklah diakui benar oleh Bendahari Agung dengan surat akuan bersumpah (statutory declaration). Kesatuan hendaklah menguruskan penyata kewangan tersebut diaudit mengikut Peraturan 16. Selepas penyata kewangan itu diaudit, Bendahari Agung hendaklah menyerahkan kepada pemegang-pemegang amanah Kesatuan jika dikehendaki oleh mereka itu semua bon, sekuriti, perkakasan, buku, surat dan harta Kesatuan yang ada dalam simpanan atau jagaannya. ',
            'parent_constitution_template_id' => 481,
            'below_constitution_template_id' => 512,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '12. Selain daripada Bendahari Agung, pegawai-pegawai atau pekerja-pekerja kesatuan tidak boleh menerima wang atau mengeluarkan resit rasmi tanpa kuasa yang bertulis oleh Presiden pada tiap-tiap kali mereka itu berbuat demikian.',
            'parent_constitution_template_id' => 481,
            'below_constitution_template_id' => 513,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 20 PEMERIKSAAN DOKUMEN DAN AKAUN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 481,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'Tiap-tiap orang yang mempunyai kepentingan dalam tabung wang Kesatuan berhak memeriksa dokumen-dokumen pentadbiran kewangan kesatuan dan rekod namanama anggota Kesatuan pada masa yang munasabah di tempat rekod itu disimpan setelah memberi notis yang mencukupi dan berpatutan.',
            'parent_constitution_template_id' => 515,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 21 YURAN KHAS (LEVI)',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 516,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Setelah satu usul diputuskan dengan undi rahsia menurut Peraturan 25, Majlis Jawatankuasa Agung boleh memungut yuran khas( levi) daripada semua anggota Kesatuan kecuali mereka yang telah dikecualikan daripada bayaran ini oleh Majlis Jawatankuasa Agung menurut Peraturan 4 (5).',
            'parent_constitution_template_id' => 517,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Jika seseorang anggota tidak menjelaskan yuran khas(levi) itu dalam tempoh enam minggu dari tarikh ia dikenakan atau dalam tempoh yang lebih panjang yang ditetapkan dalam usul berkenaan maka yuran khas (levi) itu akan dikira sebagai tunggakan yuran Kesatuan dan anggota itu boleh terlucut haknya menurut Peraturan 4 (3). ',
            'parent_constitution_template_id' => 517,
            'below_constitution_template_id' => 518,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 22 PERTIKAIAN PERUSAHAAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 517,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Jika seseorang anggota tidak berpuas hati dengan syarat-syarat perkerjaannya atau sebarang hal yang lain maka ia bolehlah mengemukakan aduannya kepada Setiausaha Cawangan secara bertulis. Setiausaha Cawangan itu hendaklah menyampaikan hal pengaduan itu kepada Jawatankuasa Cawangan dengan serta merta. Jika pengaduan anggota itu dibuat dengan lisan maka Setiausaha Cawangan hendaklah menuliskannya dan menyampaikan aduan itu kepada Jawatankuasa Cawangan bersamasama dengan laporannya. Jawatankuasa Cawangan hendaklah memutuskan sama ada perkara itu akan diselenggarakan diperingkat Cawangan atau diserahkan kepada Majlis Jawatankuasa Agung.',
            'parent_constitution_template_id' => 520,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Jika berbangkit sesuatu pertikaian perusahaan, maka anggota-anggota yang berkenaan hendaklah menyampaikan hal itu kepada Setiausaha Cawangan dan Setiausaha Cawangan hendaklah serta-merta melaporkan hal itu kepada Jawatankuasa Cawangan Jawatankuasa Cawangan hendaklah menguruskan hal pertikaian itu jika difikirkan patut ia berbuat demikian atau merujuk perkara ini kepada Majlis Jawatankuasa Agung. Jawatankuasa Cawangan hendaklah memberitahu Majlis Jawatankuasa Agung berkaitan dengan perkembangan pertikaian itu sekiranya pertikaian itu diuruskan oleh Cawangan.',
            'parent_constitution_template_id' => 520,
            'below_constitution_template_id' => 521,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Kesatuan tidak boleh menganjurkan mogok dan anggota-anggotanya tidak dibenarkan menjalankan mogok :-',
            'parent_constitution_template_id' => 520,
            'below_constitution_template_id' => 522,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) tanpa mendapat kelulusan Majlis Jawatankuasa Agung terlebih dahulu;',
            'parent_constitution_template_id' => 523,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) tanpa mendapat persetujuan dengan undi rahsia sekurang-kurangnya 2/3 daripada jumlah anggota yang layak mengundi dan yang berkaitan dengan mogok yang akan dijalankan itu;',
            'parent_constitution_template_id' => 523,
            'below_constitution_template_id' => 524,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) sebelum luput tempoh tujuh (7) hari selepas keputusan udi rahsia itu dikemukakan kepada Ketua Pengarah Kesatuan Sekerja mengikut Seksyen 40(5) Akta Kesatuan Sekerja 1959;',
            'parent_constitution_template_id' => 523,
            'below_constitution_template_id' => 525,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) sekiranya undi rahsia untuk cadangan mogok telah luput tempohnya atau tidak sah menurut peruntukan-peruntukan Seksyen 40(2), 40(6) atau 40(9), Akta Kesatuan Sekerja 1959;',
            'parent_constitution_template_id' => 523,
            'below_constitution_template_id' => 526,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) jika mogok itu menyalahi atau tidak mematuhi peraturan-peraturan ini;',
            'parent_constitution_template_id' => 523,
            'below_constitution_template_id' => 527,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) berkaitan dengan apa-apa perkara yang diliputi oleh suatu arahan atau keputusan Menteri Sumber Manusia yang diberi atau dibuat terhadap sesuatu rayuan di bawah Akta Kesatuan Sekerja 1959; atau',
            'parent_constitution_template_id' => 523,
            'below_constitution_template_id' => 528,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(g) jika mogok itu menyalahi atau tidak mematuhi mana-mana peruntukan lain Akta Kesatuan Sekerja 1959, atau mana-mana peruntukan undang-undang lain yang bertulis',
            'parent_constitution_template_id' => 523,
            'below_constitution_template_id' => 529,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Majlis Jawatankuasa Agung tidak boleh menyokong pemogokan dengan memberi bantuan kewangan atau bantuan lain jika peruntukan-peruntukan Peraturan 22 (3) tidak dipatuhi.',
            'parent_constitution_template_id' => 520,
            'below_constitution_template_id' => 523,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Sesuatu undi rahsia yang diambil tentang apa-apa perkara berkaitan dengan pemogokan hendaklah mengandungi suatu usul yang menerangkan dengan jelas akan isu yang menyebabkan cadangan pemogokan itu. Usul itu hendaklah juga menerangkan dengan jelas rupa bentuk tindakan yang akan dilakukan atau yang tidak akan dilakukan di sepanjang pemogokan itu. Undi rahsia yang tidak memenuhi kehendak-kehendak ini tidaklah sah dan tidak boleh dikuatkuasakan dan pemogokan tidak boleh dilakukan berdasarkan undi rahsia tersebut.',
            'parent_constitution_template_id' => 520,
            'below_constitution_template_id' => 531,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6. Mana-mana anggota Kesatuan yang memulakan mogok, mengambil bahagian atau bertindak bagi melanjutkan pemogokan yang melanggar Akta Kesatuan Sekerja 1959 atau peraturan-peraturan ini atau mana-mana peruntukan Undang-undang bertulis akan terhenti dengan sendirinya daripada menjadi anggota Kesatuan dan selepas itu tidak boleh menjadi anggota Kesatuan ini atau kesatuan yang lain tanpa kelulusan bertulis daripada Ketua Pengarah Kesatuan Sekerja terlebih dahulu. Kesatuan hendaklah dengan serta-merta:-',
            'parent_constitution_template_id' => 520,
            'below_constitution_template_id' => 532,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) mengeluarkan nama anggota tersebut daripada Daftar Keanggotaan/Yuran;',
            'parent_constitution_template_id' => 533,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) memberitahu Ketua Pengarah Kesatuan Sekerja dan anggota berkenaan pengeluaran nama tersebut; dan',
            'parent_constitution_template_id' => 533,
            'below_constitution_template_id' => 534,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c ) mempamerkan di satu tempat yang mudah dilihat di pejabat kesatuan yang berdaftar satu senarai anggota-anggota yang nama mereka telah dikeluarkan itu.',
            'parent_constitution_template_id' => 533,
            'below_constitution_template_id' => 535,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 23 KEGIATAN PENDIDIKAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 520,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'Kesatuan boleh menjalankan aktiviti bagi menambah ilmu pengetahuan anggota-anggotanya dengan menganjurkan perjumpaan, seminar, bengkel, atau kursus. Selanjutnya kesatuan boleh menerbitkan bahan-bahan bacaan dan menjalankan urusan-urusan lain seumpama yang boleh memajukan pengetahuan anggota-anggota dalam hal perusahaan, kebudayaan dan kemasyarakatan dengan mematuhi kehendak undang-undang berkaitan perbelanjaan wang kesatuan sekerja yang dikuatkuasakan sekarang.',
            'parent_constitution_template_id' => 537,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATUAN 24 PERATURAN – PERATURAN DAN PINDAAN PERATURAN – PERATURAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 537,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Pindaan kepada peraturan-peraturan yang akan meningkatkan lagi tanggungan anggota untuk mencarum, atau mengurangkan faedah yang dinikmatinya hanya boleh dibuat jika diluluskan oleh anggota-anggota dengan undi rahsia. Pindaan peraturan-peraturan lain boleh dibuat dengan kelulusan Persidangan Perwakilan yang diadakan menurut Peraturan 9 atau Peraturan 10 atau dengan undi rahsia.',
            'parent_constitution_template_id' => 539,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Tiap-tiap pindaan peraturan-peraturan hendaklah berkuatkuasa dari tarikh pindaan itu didaftarkan oleh ketua Ketua Pengarah Sekerja kecuali jika suatu tarikh yang terkemudian dari itu ditentukan di dalam peraturan-peraturan ini.',
            'parent_constitution_template_id' => 539,
            'below_constitution_template_id' => 540,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Satu naskhah peraturan-peraturan Kesatuan yang becetak hendaklah dipamerkan di suatu tempat yang mudah dilihat di pejabat Kesatuan yang didaftarkan. Setiausaha hendaklah memberi senaskhah peraturan-peraturan Kesatuan kepada sesiapa juga yang memintanya dengan bayaran tidak lebih daripada sepuluh ringgit senaskhah.',
            'parent_constitution_template_id' => 539,
            'below_constitution_template_id' => 541,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 25 UNDI RAHSIA',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 539,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Keputusan-keputusan berkenaan dengan perkara-perkara yang tersebut di bawah ini hendaklah dibuat dengan undi rahsia oleh semua anggota berhak atau anggota-anggota berhak yang terlibat dengan pertikaian berkenaan, dengan syarat, anggota yang belum cukup 18 tahun tidak berhak mengundi atas perkara (c), (d), (e) dan (g);-',
            'parent_constitution_template_id' => 543,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) Pemilihan pegawai-pegawai kesatuan (selain dari Pemegangpemegang Amanah, Juruaudit Dalam dan Pemeriksa Undi) sebagaimana Peraturan 12;',
            'parent_constitution_template_id' => 544,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) pemilihan wakil-wakil ke Persidangan Perwakilan _Conference_Yearly_ Tahunan atau Persidangan Perwakilan Luarbiasa menurut Peraturan 9 atau pemilihan wakil-wakil Persekutuan Kesatuan-kesatuan sekerja;',
            'parent_constitution_template_id' => 544,
            'below_constitution_template_id' => 545,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'c) semua perkara mengenai mogok menurut Peraturan 22(3);',
            'parent_constitution_template_id' => 544,
            'below_constitution_template_id' => 546,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'd) mengenakan kutipan/yuran khas;',
            'parent_constitution_template_id' => 544,
            'below_constitution_template_id' => 547,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'e) pindaan peraturan-peraturan ini jika pindaan itu meningkatkan lagi tanggungan anggota untuk mencarum atau mengurangkan faedah yang dinikmatinya;',
            'parent_constitution_template_id' => 544,
            'below_constitution_template_id' => 548,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'f) bercantum dengan kesatuan sekerja yang lain atau memindahkan urusan kepada kesatuan sekerja yang lain; atau',
            'parent_constitution_template_id' => 544,
            'below_constitution_template_id' => 549,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'g) membubarkan kesatuan atau persekutuan kesatuan sekerja.',
            'parent_constitution_template_id' => 544,
            'below_constitution_template_id' => 550,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Untuk menjalankan undi rahsia, aturcara yang dinyatakan di dalam kembaran kepada peraturan-peraturan ini hendaklah dipatuhi.',
            'parent_constitution_template_id' => 543,
            'below_constitution_template_id' => 544,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 26 PERLANTIKAN JEMAAH PENIMBANGTARA',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 543,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Jemaah Penimbangtara yang terdiri dari lima (5) orang hendaklah dilantik dalam Persidangan Perwakilan Kesatuan untuk menyelesaikan sesuatu pertikaian dalam Kesatuan. Jemaah Penimbangtara hendaklah bukan anggota Kesatuan dan tidak ada kaitan langsung dengan kewangan Kesatuan.',
            'parent_constitution_template_id' => 553,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Apabila berlaku kekosongan kerana sebarang sebab maka kekosongan hendaklah diisi dengan melantik penggantinya di dalam Persidangan Perwakilan yang akan datang.',
            'parent_constitution_template_id' => 553,
            'below_constitution_template_id' => 554,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Setiausaha Agung hendaklah melaporkan kepada Ketua Pengarah Kesatuan Sekerja butir-butir peribadi Jemaah Penimbangtara (seperti nama, nombor kad pengenalan, jawatan, alamat) dan sebarang perubahan tentang anggota Jemaah Penimbangtara.',
            'parent_constitution_template_id' => 553,
            'below_constitution_template_id' => 555,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Apabila sesuatu pertikaian dirujuk kepada Jemaah Penimbangtara, pihak yang terkilan hendaklah memilih dengan mengundi tiga (3) daripada lima (5) orang anggota Jemaah Penimbangtara tersebut. Laporan dan keputusan Jemaah Penimbangtara hendaklah dikemukakan kepada Majlis Jawatankuasa Agung dengan seberapa segera.',
            'parent_constitution_template_id' => 553,
            'below_constitution_template_id' => 556,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 27 PERTIKAIAN DALAM KESATUAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 553,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Tertakluk kepada perenggan (2) di bawah ini, tiap-tiap pertikaian yang berlaku di antara :-',
            'parent_constitution_template_id' => 558,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) seseorang anggota atau seseorang yang menuntut melalui seorang anggota atau menurut peraturan ini, di sebelah pihak, dan dengan Kesatuan atau pegawai kesatuan di pihak yang lagi satu; atau',
            'parent_constitution_template_id' => 559,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) seseorang yang terkilan yang telah diberhentikan menjadi anggota Kesatuan, atau seseorang yang menuntut melalui orang yang terkilan itu, di sebelah pihak dengan Kesatuan atau pegawai Kesatuan di pihak yang lagi satu; atau',
            'parent_constitution_template_id' => 559,
            'below_constitution_template_id' => 560,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) kesatuan dengan seseorang pegawai Kesatuan hendaklah diselesaikan melalui penimbangtaraan.',
            'parent_constitution_template_id' => 559,
            'below_constitution_template_id' => 561,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Pihak yang menutut dan pihak yang kena tuntut bolehlah bersama-sama merujuk pertikaian tentang perkara berikut:-',
            'parent_constitution_template_id' => 558,
            'below_constitution_template_id' => 559,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) pemilihan pegawai-pegawai Kesatuan;',
            'parent_constitution_template_id' => 563,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) kira-kira dan kewangan Kesatuan; atau',
            'parent_constitution_template_id' => 563,
            'below_constitution_template_id' => 564,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) melanggar peraturan-peraturan Kesatuan kepada Ketua Pengarah Kesatuan Sekerja dan keputusan Ketua Pengarah Kesatuan Sekerja tentang pertikaian tersebut adalah muktamad.',
            'parent_constitution_template_id' => 563,
            'below_constitution_template_id' => 565,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Setiausaha hendaklah secara bertulis menyampaikan sebarang pertikaian dibawah perenggan (1) kepada Jemaah Penimbangtara dalam tempoh tujuh (7) hari dari tarikh permohonan pihak yang menuntut diterima oleh Kesatuan. Jika tiada keputusan dibuat mengenai suatu pertikaian dalam tempoh empat puluh (40) hari selepas permohonan dibuat kepada kesatuan, anggota atau seseorang yang terkilan itu boleh memohon kepada Mahkamah Sesyen dan Mahkamah Sesyen boleh mendengar dan membuat keputusan mengenai pertikaian tersebut.',
            'parent_constitution_template_id' => 558,
            'below_constitution_template_id' => 563,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Dalam peraturan ini perkataan "pertikaian" meliputi sebarang pertikaian tentang soal sama ada seseorang anggota atau orang terkilan itu berhak menjadi anggota atau terus menjadi anggota ataupun diterima semula menjadi anggota. Bagi seseorang yang telah berhenti menjadi anggota perkataan “pertikaian” ini hanya meliputi pertikaian diantaranya dengan Kesatuan atau pegawai Kesatuan tentang soal yang berbangkit di masa ia menjadi anggota.',
            'parent_constitution_template_id' => 558,
            'below_constitution_template_id' => 567,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Pihak yang terkilan berhak membuat rayuan kepada Persidangan Perwakilan terhadap sebarang keputusan yang telah dibuat oleh Penimbangtara dan keputusan Mesyuarat itu adalah muktamad.',
            'parent_constitution_template_id' => 558,
            'below_constitution_template_id' => 568,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 28 PEMBUBARAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 558,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Kesatuan ini tidak boleh dibubarkan dengan sendiri melainkan dengan undi rahsia sekurang-kurangnya setengah anggota-anggota yang layak untuk mengundi dikembalikan dan sekurang-kurangnya 50% dari undi yang dikembalikan bersetuju untuk pembubaran kesatuan. ',
            'parent_constitution_template_id' => 570,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Jika sekiranya kesatuan ini dibubarkan seperti yang tersebut di atas maka segala hutang dan tanggungan yang dibuat dengan cara sah bagi pihak kesatuan hendaklah dijelaskan dengan sepenuhnya dan baki wang yang tinggal hendaklah diselesaikan menurut keputusan yang akan dibuat dengan udi rahsia. Penyata kewangan terakhir hendaklah diaudit oleh Juruaudit bertauliah atau seseorang yang dipersetujui oleh Ketua Pengarah.',
            'parent_constitution_template_id' => 570,
            'below_constitution_template_id' => 571,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Notis pembubaran dan dokumen-dokumen lain seperti yang dinyatakan di dalam peraturan-peraturan Kesatuan Sekerja 1959 hendaklah dikemukakan kepada Ketua Pengarah dalam tempoh empat belas (14) hari selepas pembubaran dan pembubaran itu akan berkuatkuasa dari tarikh pendaftarannya oleh Ketua Pengarah Kesatuan Sekerja.',
            'parent_constitution_template_id' => 570,
            'below_constitution_template_id' => 572,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 29 PENUBUHAN DAN PEMBUBARAN CAWANGAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 570,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Majlis Jawatankuasa Agung boleh menubuhkan cawangan di mana-mana kawasan atau tempat kerja jika ada di kawasan tempat kerja itu sekurang-kurangnya _min_member_ orang anggota.',
            'parent_constitution_template_id' => 574,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Majlis Jawatankuasa Agung boleh membubarkan sesuatu cawangan :-',
            'parent_constitution_template_id' => 574,
            'below_constitution_template_id' => 575,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) apabila bilangan anggota cawangan itu kurang dari _low_member_ orang selama enam bulan berturut-turut',
            'parent_constitution_template_id' => 576,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) jika cawangan itu enggan atau gagal menurut peraturan-peraturan kesatuan ini atau keputusan Persidangan Perwakilan atau keputusan Majlis Jawatankuasa Agung, atau pada pendapat Majlis Jawatankuasa Agung, cawangan itu bersalah kerana melakukan sebarang perubahan yang merugikan kesatuan; atau',
            'parent_constitution_template_id' => 576,
            'below_constitution_template_id' => 577,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) apabila anggota-anggota melalui Mesyuarat Agung Cawangan/ Mesyuarat Agung Luarbiasa Cawangan bersetuju untuk membubarkan cawangan tersebut.',
            'parent_constitution_template_id' => 576,
            'below_constitution_template_id' => 578,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Jika sekiranya sesuatu cawangan itu dibubarkan dengan alasan yang tersebut diperenggan 2 (a) dan 2 (c) di atas maka Majlis Jawatankuasa Agung hendaklah memindahkan anggota-anggota yang tinggal itu ke cawangan yang berhampiran sekali.',
            'parent_constitution_template_id' => 574,
            'below_constitution_template_id' => 576,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Keputusan untuk membubarkan cawangan itu hendaklah dibuat dalam mesyuarat Majlis Jawatankuasa Agung dengan suara yang terbanyak. Akan tetapi jika sesuatu cawangan itu hendak dibubarkan menurut perenggan 2(b) maka jawatankuasa cawangan itu hendaklah diberi notis tiga puluh (30) hari dan diberi peluang untuk menjawab tuduhan-tuduhan ke atasnya. Sekiranya gagal, maka Majlis Jawatankuasa Agung boleh memecat semua jawatankuasa cawangan itu daripada menjadi anggota kesatuan dan anggotaanggota cawangannya akan dipindahkan ke cawangan yang berhampiran sekali.',
            'parent_constitution_template_id' => 574,
            'below_constitution_template_id' => 580,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Perintah membubarkan cawangan itu hendaklah ditandatangani oleh Setiausaha Agung. Apabila diterimanya perintah itu maka cawangan itu tidak lagi boleh menjalankan kerja kecuali kerja-kerja menutupnya.',
            'parent_constitution_template_id' => 574,
            'below_constitution_template_id' => 581,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6. Cawangan yang tidak berpuas hati dengan perintah pembubaran itu boleh mengemukakan surat kepada Setiausaha Agung bagi merayu kepada Persidangan Perwakilan dalam tempoh tiga puluh (30) hari dari tarikh penerimaan perintah itu. Meskipun rayuan itu dibuat, perintah pembubaran itu hendaklah juga dikuatkuasa sehingga ia dibatalkan. Dalam hal yang demikian, Majlis Jawatankuasa Agung boleh melantik di antara mereka itu sendiri suatu Jawatankuasa Pengelola untuk menguruskan hal ehwal cawangan itu sehingga rayuan itu mendapat keputusan. Cawangan tidak boleh diwakili peguam atau seseorang yang bukan anggota pada tarikh perintah pembubaran itu dikeluarkan.',
            'parent_constitution_template_id' => 574,
            'below_constitution_template_id' => 582,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '7. Adalah menjadi kewajipan Pengerusi, Setiausaha dan Bendahari Cawangan yang dibubarkan itu menyerahkan kepada Setiausaha Agung segala bukubuku, surat-surat, wang dan harta kepunyaan cawangan, bersama-sama dengan suatu kenyataan kewangan dari tarikh kira-kira yang lalu dibentangkan sehingga tarikh perintah pembubaran itu dikeluarkan.',
            'parent_constitution_template_id' => 574,
            'below_constitution_template_id' => 583,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 30 JAWATANKUASA CAWANGAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 574,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Jawatankuasa Cawangan hendaklah terdiri daripada seorang Pengerusi, seorang Naib Pengerusi, seorang Setiausaha, seorang Penolong Setiausaha, Bendahari, seorang Penolong Bendahari dan _total_ajk_ orang Ahli Jawatankuasa. Mereka dikenali sebagai Pegawai-Pegawai Cawangan dan dipilih setiap _ajk_yearly_ tahunan dengan undi rahsia oleh semua anggota berhak dalam cawangan masing-masing.',
            'parent_constitution_template_id' => 585,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Wakil-wakil cawangan yang menghadiri Persidangan Perwakilan hendaklah dipilih setiap _conference_yearly_ tahunan dengan undi rahsia dan keputusan undi bagi Ahli Jawatankuasa dan wakil-wakil hendaklah di umumkan dalam Mesyuarat Agung _Meeting_Yearly_ Tahunan Cawangan itu.',
            'parent_constitution_template_id' => 585,
            'below_constitution_template_id' => 586,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Sekiranya seseorang calon bagi sesuatu jawatan tidak ditandingi dan pencalonannya telah dilaksanakan menurut cara yang ditentukan di dalam Peraturan 32 (3), maka ia hendaklah dianggap telah dipilih dan namanya diasingkan dari kertas undi untuk pemilihan Ahli Jawatankuasa Cawangan dan wakil-wakil.',
            'parent_constitution_template_id' => 585,
            'below_constitution_template_id' => 587,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Jawatankuasa Cawangan dan wakil-wakil cawangan yang pertama hendaklah dipilih dengan undi rahsia dalam masa tiga bulan setelah cawangan itu ditubuhkan, dan sehingga pemilihan itu dijalankan Jawatankuasa Sementara Cawangan yang dilantik secara angkat tangan dalam Mesyuarat Penubuhan Cawangan itu hendaklah menguruskan hal ehwal cawangan. Ahli Jawatankuasa Cawangan hendaklah memegang jawatan dari satu Mesyuarat Agung _Meeting_Yearly_ Tahunan Cawangan ke satu Mesyuarat Agung _Meeting_Yearly_ Tahunan Cawangan akan datang.',
            'parent_constitution_template_id' => 585,
            'below_constitution_template_id' => 588,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Sekiranya pada sesuatu Mesyuarat Agung atau Mesyuarat Agung Luarbiasa suatu usul tidak percaya terhadap Jawatankuasa Cawangan telah diluluskan oleh dua pertiga (2/3) suara teramai, maka Jawatankuasa Cawangan hendaklah dengan serta merta bertugas atas dasar pengurusan sementara. Jawatankuasa Cawangan hendaklah mengadakan pemilihan semula pegawai-pegawai melalui undi rahsia dalam tempoh sebulan setelah Mesyuarat Agung atau Mesyuarat Agung Luarbiasa itu. Ahli-ahli Jawatankuasa yang dipilih dengan cara ini hendaklah memegang jawatan sehingga Mesyuarat Agung _Meeting_Yearly_ Tahunan Cawangan yang akan datang.',
            'parent_constitution_template_id' => 585,
            'below_constitution_template_id' => 589,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6. Apabila berlaku pertukaran pegawai-pegawai atau Jawatankuasa Cawangan, maka segala rekod dan dokumen yang berkaitan hendaklah diserahkan kepada pegawai-pegawai atau Jawatankuasa Cawangan yang baru dalam tempoh tujuh (7) hari .',
            'parent_constitution_template_id' => 585,
            'below_constitution_template_id' => 590,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '7. Keputusan pemilihan Pegawai-pegawai Cawangan hendaklah dikemukakan dalam borang yang ditetapkan kepada Setiausaha Agung dalam tempoh tujuh (7) hari selepas pemilihan. Pemberitahuan tentang pemilihan pegawai-pegawai tersebut hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja oleh Setiausaha Agung dalam tempoh empat belas (14) hari selepas pemilihan itu',
            'parent_constitution_template_id' => 585,
            'below_constitution_template_id' => 591,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8. Tanggungjawab Pegawai-pegawai Cawangan ialah menguruskan hal ehwal cawangan menurut peraturan-peraturan kesatuan dan arahan yang dikeluarkan oleh Majlis Jawatankuasa Agung',
            'parent_constitution_template_id' => 585,
            'below_constitution_template_id' => 592,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '9. Mesyuarat Jawatankuasa Cawangan hendaklah diuruskan oleh Setiausaha Cawangan dengan arahan atau persetujuan Pengerusi. Notis dan agenda mesyuarat hendaklah diberi kepada semua Ahli Jawatankuasa Cawangan sekurang-kurangnya lima (5) hari sebelum mesyuarat tersebut diadakan',
            'parent_constitution_template_id' => 585,
            'below_constitution_template_id' => 593,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '10. Jawatankuasa Cawangan hendaklah bermesyuarat sekurang-kurangnya tiga (3) bulan sekali dan cukup kuorum mesyuarat apabila setengah (½) daripada jumlah anggotanya hadir. Setiausaha Cawangan hendaklah menyampaikan kepada Setiausaha Agung minit mesyuarat dan laporan kewangan tidak lewat dari tujuh (7) hari selepas mesyuarat itu diadakan.',
            'parent_constitution_template_id' => 585,
            'below_constitution_template_id' => 594,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11. Ahli Jawatankuasa Cawangan yang tidak menghadiri mesyuarat tiga (3) kali berturut-turut tidak lagi berhak menyandang jawatannya kecuali dia dapat memberi alasan yang memuaskan kepada kepada Jawatankuasa Cawangan.',
            'parent_constitution_template_id' => 585,
            'below_constitution_template_id' => 595,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '12. Apabila seseorang pegawai Kesatuan dan wakil-wakil meninggal dunia, berhenti atau terlucut hak, maka calon yang mendapat undi terkebawah sedikit bagi jawatan berkenaan dalam masa undian yang lalu hendaklah dijemput untuk mengisi tempat yang kosong itu. Bagi jawatan Pengerusi, Naib Pengerusi, Setiausaha, Penolong Setiausaha, Bendahari dan Penolong Bendahari, calon tersebut hendaklah mendapat tidak kurang daripada satu perempat (1/4) jumlah undi yang telah dibuang bagi jawatan itu.',
            'parent_constitution_template_id' => 585,
            'below_constitution_template_id' => 596,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '13. Jika tiada calon yang layak atau calon yang layak enggan menerima jawatan tersebut maka Jawatankuasa Cawangan berkuasa melantik seorang anggota yang layak untuk mengisi kekosongan itu.',
            'parent_constitution_template_id' => 585,
            'below_constitution_template_id' => 597,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 31 TUGAS-TUGAS PEGAWAI-PEGAWAI CAWANGAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 585,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Pengerusi Cawangan',
            'parent_constitution_template_id' => 599,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Menjadi Pengerusi semua mesyuarat dan bertanggungjawab tentang ketenteraman dan kesempurnaan mesyuarat-mesyuarat itu serta mempunyai undian pemutus dalam semua isu semasa pada masa mesyuarat kecuali perkara-perkara yang melibatkan undi rahsia;',
            'parent_constitution_template_id' => 600,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) mengesahkan dan menandatangani minit tiap-tiap mesyuarat;',
            'parent_constitution_template_id' => 600,
            'below_constitution_template_id' => 601,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) menyelenggarakan urusan kewangan dan bank bersama-sama dengan Setiausaha dan Bendahari Cawangan menurut Peraturan 35; ',
            'parent_constitution_template_id' => 600,
            'below_constitution_template_id' => 602,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) menandatangani semua cek kesatuan bersama dengan Setiausaha dan Bendahari Cawangan; dan',
            'parent_constitution_template_id' => 600,
            'below_constitution_template_id' => 603,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) mengawasi pentadbiran Cawangan',
            'parent_constitution_template_id' => 600,
            'below_constitution_template_id' => 604,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Naib Pengerusi Cawangan',
            'parent_constitution_template_id' => 599,
            'below_constitution_template_id' => 600,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Membantu Pengerusi dalam menjalankan tugas-tugasnya dan memangku jawatan Pengerusi pada masa ketiadaannya;',
            'parent_constitution_template_id' => 606,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) menjalankan tugas-tugas sebagaimana diarahkan oleh Jawankuasa Cawangan.',
            'parent_constitution_template_id' => 606,
            'below_constitution_template_id' => 607,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Setiausaha Cawangan',
            'parent_constitution_template_id' => 599,
            'below_constitution_template_id' => 606,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Menguruskan kerja-kerja cawangan mengikut peraturan ini dan hendaklah menjalankan perintah-perintah dan arahan-arahan Persidangan Perwakilan, Majlis Jawatankuasa Agung, Mesyuarat Agung Cawangan atau Jawatankuasa Cawangan;',
            'parent_constitution_template_id' => 609,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) bertanggungjawab menyimpan dan menyelenggara dokumendokumen kesatuan sebagaimana arahan Majlis Jawatankuasa Agung atau Jawatankuasa Cawangan.',
            'parent_constitution_template_id' => 609,
            'below_constitution_template_id' => 610,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) menyimpan dan mengemaskini suatu Daftar Keanggotaan yang mengandungi Nama Anggota, Alamat Kediaman, Nombor KadPengenalan dan Tarikh Menjadi Anggota Kesatuan;',
            'parent_constitution_template_id' => 609,
            'below_constitution_template_id' => 611,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) menetapkan serta menyediakan agenda Mesyuarat Agung dan Mesyuarat Jawatankuasa Cawangan dengan persetujuan Pengerusi Cawangan dan menyediakan minit-minit mesyuarat itu; dan',
            'parent_constitution_template_id' => 609,
            'below_constitution_template_id' => 612,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) menyelenggarakan urusan kewangan dan bank bersama-sama dengan Pengerusi dan Bendahari Cawangan.',
            'parent_constitution_template_id' => 609,
            'below_constitution_template_id' => 613,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) menandatangani semua cek kesatuan bersama dengan Pengerusi dan Bendahari Cawangan. ',
            'parent_constitution_template_id' => 609,
            'below_constitution_template_id' => 614,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Penolong Setiausaha Cawangan',
            'parent_constitution_template_id' => 599,
            'below_constitution_template_id' => 609,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Membantu Setiausaha dalam urusan pentadbiran kesatuan dan memangku jawatan Setiausaha pada masa ketiadaannya; dan',
            'parent_constitution_template_id' => 616,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) menjalankan tugas-tugas sebagaimana yang diarahkan oleh Jawatankuasa Cawangan.',
            'parent_constitution_template_id' => 616,
            'below_constitution_template_id' => 617,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Bendahari Cawangan',
            'parent_constitution_template_id' => 599,
            'below_constitution_template_id' => 616,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Bertanggungjawab dalam urusan Penerimaan dan Pembayaran wang Kesatuan dan urusan penyimpanan dokumen kewangan sebagaimana yang dikehendaki oleh Peraturan-peraturan Kesatuan Sekerja 1959;',
            'parent_constitution_template_id' => 619,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) mengeluarkan resit rasmi bagi segala wang yang diterima. ',
            'parent_constitution_template_id' => 619,
            'below_constitution_template_id' => 620,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) bertanggungjawab tentang keselamatan simpanan dokumen kewangan dan surat-surat keterangan yang berkenaan di cawangan. Dokumen-dokumen dan surat-surat keterangan ini tidak boleh dikeluarkan dari tempat rasminya tanpa kebenaran yang bertulis daripada Pengerusi pada tiap-tiap kali ia hendak dikeluarkan.',
            'parent_constitution_template_id' => 619,
            'below_constitution_template_id' => 621,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) bertanggungjawab ke atas wang-wang dan harta-harta kesatuan di dalam jagaannya;',
            'parent_constitution_template_id' => 619,
            'below_constitution_template_id' => 622,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) menyediakan penyata kewangan bagi tiap-tiap Mesyuarat Jawatankuasa Cawangan dan Mesyuarat Agung Cawangan.',
            'parent_constitution_template_id' => 619,
            'below_constitution_template_id' => 623,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) menguruskan kira-kira bank cawangannya bersama-sama dengan Pengerusi dan Setiausaha Cawangan.',
            'parent_constitution_template_id' => 619,
            'below_constitution_template_id' => 624,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) menandatangani semua cek kesatuan bersama dengan Pengerusi dan Setiausaha Cawangan. ',
            'parent_constitution_template_id' => 619,
            'below_constitution_template_id' => 625,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6. Penolong Bendahari Cawangan',
            'parent_constitution_template_id' => 599,
            'below_constitution_template_id' => 619,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Membantu Bendahari dalam urusan kewangan Kesatuan dan memangku jawatan Bendahari pada masa ketiadaannya.',
            'parent_constitution_template_id' => 627,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Membantu Bendahari dalam urusan kewangan Kesatuan dan memangku jawatan Bendahari pada masa ketiadaannya.',
            'parent_constitution_template_id' => 627,
            'below_constitution_template_id' => 628,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 32 MESYUARAT AGUNG _MEETING_YEARLY_ CAWANGAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 599,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Mesyuarat Agung _Meeting_Yearly_ Cawangan hendaklah diadakan dengan seberapa segera selepas 31hb Mac dan tidak lewat dari 30hb Jun tiap-tiap _meeting_yearly_ tahunan. Tarikh, masa dan tempat mesyuarat hendaklah ditetapkan oleh Jawatankuasa Cawangan.',
            'parent_constitution_template_id' => 630,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Setiausaha Cawangan hendaklah mengirim notis permulaan mengenai Mesyuarat Agung _Meeting_Yearly_ Tahunan Cawangan kepada semua anggotaanggota berhak. Notis ini hendaklah dihantar sekurang-kurangnya tiga puluh (30) hari sebelum mesyuarat itu.',
            'parent_constitution_template_id' => 630,
            'below_constitution_template_id' => 631,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Notis permulaan tersebut hendaklah menyatakan tarikh, masa dan tempat Mesyuarat Agung akan diadakan. Notis tersebut juga hendaklah disertakan bersama dokumen-dokumen berikut :-',
            'parent_constitution_template_id' => 630,
            'below_constitution_template_id' => 632,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) Borang usul untuk perbincangan;',
            'parent_constitution_template_id' => 633,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) Borang pencalonan untuk pemilihan Ahli-ahli Jawatankuasa Cawangan serta wakil-wakil cawangan; dan',
            'parent_constitution_template_id' => 633,
            'below_constitution_template_id' => 634,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) Borang pencalonan untuk pemilihan Pegawai-pegawai Kanan seperti tersebut di dalam Peraturan 12(2), ',
            'parent_constitution_template_id' => 633,
            'below_constitution_template_id' => 635,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Nama-nama calon untuk pemilihan Pegawai-pegawai Kanan, Jawatankuasa Cawangan dan wakil-wakil cawangan serta usul-usul untuk dibincangkan di mesyuarat itu hendaklah dikemukakan oleh anggota-anggota kepada Setiausaha Cawangan sekurang-kurangnya dua puluh satu (21) hari sebelum Mesyuarat Agung...... Tahunan Cawangan.',
            'parent_constitution_template_id' => 630,
            'below_constitution_template_id' => 633,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Semua pencalonan hendaklah dibuat dalam borang yang disediakan oleh kesatuan dan hendaklah mengandungi perkara-perkara yang berikut :-<br><br>Nama jawatan yang ditandingi, nama calon, nombor kad pengenalan, nombor keanggotaan, tarikh lahir, alamat kediaman, pekerjaan, nombor sijil kerakyataan/taraf kerakyatan.',
            'parent_constitution_template_id' => 630,
            'below_constitution_template_id' => 637,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6. Sesuatu pencalonan tidak sah jika:-',
            'parent_constitution_template_id' => 630,
            'below_constitution_template_id' => 638,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) ia tidak ditandatangani oleh seorang pencadang dan seorang penyokong yang merupakan anggota-anggota berhak;',
            'parent_constitution_template_id' => 639,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) ia tidak mengandungi persetujuan bertulis calon yang hendak bertanding.',
            'parent_constitution_template_id' => 639,
            'below_constitution_template_id' => 640,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '7. Setiausaha Cawangan hendaklah memaklumkan kepada Setiausaha Agung tarikh Mesyuarat Agung Cawangan hendak diadakan sekurang-kurangnya tiga puluh (30) hari sebelum mesyuarat itu.',
            'parent_constitution_template_id' => 630,
            'below_constitution_template_id' => 639,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8. Setiausaha Cawangan hendaklah menghantar kepada semua anggota cawangan sekurang-kurangnya empat belas (14) hari sebelum mesyuarat, suatu agenda, usul-usul (jika ada), Laporan Tahunan dan Penyata Kewangan, kertas undi serta sampul-sampul surat yang secukupnya bagi pemilihan wakilwakil cawangan dan Jawatankuasa Cawangan.',
            'parent_constitution_template_id' => 630,
            'below_constitution_template_id' => 642,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '9. Satu perempat (1/4) dari jumlah anggota-anggota yang berhak mengundi akan menjadi kuorum Mesyuarat Agung Cawangan.',
            'parent_constitution_template_id' => 630,
            'below_constitution_template_id' => 643,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '10. Jika selepas satu (1) jam dari masa yang ditentukan bilangan anggota yang hadir tidak mencukupi maka mesyuarat itu hendaklah ditangguhkan kepada suatu tarikh (tidak lewat dari empat belas (14) hari kemudian) yang ditetapkan oleh Jawatankuasa Cawangan.',
            'parent_constitution_template_id' => 630,
            'below_constitution_template_id' => 644,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11. Sekiranya kuorum bagi Mesyuarat Agung .….. Tahunan Cawangan yang ditangguhkan itu masih belum mencukupi pada masa yang ditentukan maka anggota-anggota yang hadir berkuasa menguruskan mesyuarat itu, akan tetapi tidak berkuasa meminda peraturan-peraturan Kesatuan. ',
            'parent_constitution_template_id' => 630,
            'below_constitution_template_id' => 645,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '12. Urusan Mesyuarat Agung Cawangan antara lain ialah:-',
            'parent_constitution_template_id' => 630,
            'below_constitution_template_id' => 646,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) menerima dan meluluskan penyata-penyata dan laporan-laporan daripada Setiausaha dan Bendahari Cawangan;',
            'parent_constitution_template_id' => 647,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) membincang dan memutuskan usul-usul untuk dibawa ke Persidangan Perwakilan;',
            'parent_constitution_template_id' => 647,
            'below_constitution_template_id' => 648,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) memilih:-',
            'parent_constitution_template_id' => 647,
            'below_constitution_template_id' => 649,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(i) Juruaudit Dalam Cawangan; dan',
            'parent_constitution_template_id' => 650,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(ii) Jemaah Pemeriksa Undi Cawangan',
            'parent_constitution_template_id' => 650,
            'below_constitution_template_id' => 651,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) menerima Penyata Pemeriksa Undi bagi pemilihan Ahli Jawatankuasa Cawangan, wakil-wakil dan perkara-perkara lain; dan',
            'parent_constitution_template_id' => 647,
            'below_constitution_template_id' => 650,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) membincang dan memutuskan lain-lain perkara yang terkandung di dalam agenda.',
            'parent_constitution_template_id' => 647,
            'below_constitution_template_id' => 653,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 33 MESYUARAT AGUNG LUARBIASA CAWANGAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 630,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Mesyuarat Agung Luarbiasa Cawangan hendaklah diadakan;-',
            'parent_constitution_template_id' => 655,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) apabila diarah oleh Majlis Jawatankuasa Agung;',
            'parent_constitution_template_id' => 656,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) apabila sahaja difikirkan mustahak oleh Jawatankuasa Cawangan; atau',
            'parent_constitution_template_id' => 656,
            'below_constitution_template_id' => 657,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c ) apabila menerima permintaan bersama yang bertulis daripada sekurang-kurangnya satu perempat (1/4) daripada jumlah anggota yang berhak mengundi. Permintaan itu hendaklah menyatakan tujuan dan sebab anggota-anggota berkenaan mahu mesyuarat itu diadakan.',
            'parent_constitution_template_id' => 656,
            'below_constitution_template_id' => 658,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Mesyuarat Agung Luarbiasa Cawangan yang diminta oleh anggota-anggota hendaklah diadakan dalam tempoh empat belas (14) hari dari tarikh permintaan itu diterima.',
            'parent_constitution_template_id' => 655,
            'below_constitution_template_id' => 656,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Notis dan agenda bagi sesuatu Mesyuarat Agung Luarbiasa Cawangan hendaklah diedarkan oleh Setiausaha Cawangan kepada semua anggota berhak sekurang-kurangnya tujuh (7) hari sebelum mesyuarat itu.',
            'parent_constitution_template_id' => 655,
            'below_constitution_template_id' => 660,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Peruntukan-peruntukan Peraturan 32 tentang kuorum dan penangguhan Mesyuarat Agung Cawangan adalah terpakai kepada Mesyuarat Agung Luarbiasa Cawangan yang diadakan kerana difikirkan mustahak oleh Jawatankuasa Cawangan.',
            'parent_constitution_template_id' => 655,
            'below_constitution_template_id' => 661,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Bagi Mesyuarat Agung Luarbiasa Cawangan yang diminta oleh anggotaanggota ditangguhkan kerana tidak cukup kuorum mengikut Peraturan 32(9) maka mesyuarat yang ditangguhkan itu hendaklah dibatalkan sekiranya kuorum masih tidak diperolehi selepas satu (1) jam dari masa yang dijadualkan. Mesyuarat Agung Luarbiasa Cawangan bagi perkara yang sama tidak boleh diminta lagi dalam tempoh enam (6) bulan dari tarikh mesyuarat itu dibatalkan.',
            'parent_constitution_template_id' => 655,
            'below_constitution_template_id' => 662,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6. Jika Mesyuarat Agung _Meeting_Yearly_ Tahunan sesuatu cawangan tidak dapat diadakan dalam masa yang ditentukan di bawah Peraturan 32(1) maka suatu Mesyuarat Agung Luarbiasa Cawangan berkuasa menjalankan sebarang kerja yang lazimnya dijalankan oleh Mesyuarat Agung _Meeting_Yearly_ Tahunan Cawangan itu dengan syarat Mesyuarat Agung Luarbiasa Cawangan berkenaan mestilah diadakan sebelum Persidangan Perwakilan _Conference_Yearly_ Tahunan dalam tahun yang sama.',
            'parent_constitution_template_id' => 655,
            'below_constitution_template_id' => 663,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 34 JEMAAH PEMERIKSA UNDI CAWANGAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 655,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Jemaah Pemeriksa Undi yang terdiri daripada lima (5) orang anggota hendaklah dipilih secara angkat tangan dalam Mesyuarat Agung _Meeting_Yearly_ Tahunan Cawangan dan seorang daripadanya hendaklah dipilih sebagai Ketua Pemeriksa Undi. Mereka hendaklah bukan pegawai Kesatuan atau calon bagi pemilihan pegawai-pegawai kesatuan. Seboleh-bolehnya anggota-anggota yang dipilih ini hendaklah anggota-anggota yang tinggal di sekitar kawasan Pejabat Cawangan.',
            'parent_constitution_template_id' => 665,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Jemaah Pemeriksa Undi ini bertanggungjawab mengendalikan segala perjalanan undi rahsia yang dijalankan oleh kesatuan. Mereka akan berkhidmat dari suatu Mesyuarat Agung _Meeting_Yearly_ Tahunan ke Mesyuarat Agung _Meeting_Yearly_ Tahunan yang berikutnya. Apabila berlaku kekosongan, kekosongan ini hendaklah diisikan dengan cara lantikan oleh Jawatankuasa Cawangan sehingga Mesyuarat Agung yang akan datang.',
            'parent_constitution_template_id' => 665,
            'below_constitution_template_id' => 666,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Sekurang-kurangnya tiga (3) orang pemeriksa undi hendaklah hadir apabila pembuangan dan pengiraan undi dijalankan. Mereka hendaklah memastikan bahawa aturcara yang tertera di dalam kembaran kepada peraturan-peraturan ini dipatuhi dengan sepenuhnya.',
            'parent_constitution_template_id' => 665,
            'below_constitution_template_id' => 667,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 35 KEWANGAN DAN AKAUN CAWANGAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 665,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Segala wang yang terkumpul di Ibu Pejabat Kesatuan dan di Cawangancawangan Kesatuan adalah menjadi kepunyaan kesatuan seluruhnya.',
            'parent_constitution_template_id' => 669,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Majlis Jawatankuasa Agung hendaklah menetapkan dari semasa ke semasa perbelanjaan yang akan dibuat oleh cawangan dan jumlah wang yang boleh disimpan di cawangan sebagai tabung cawangan itu.',
            'parent_constitution_template_id' => 669,
            'below_constitution_template_id' => 670,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Bendahari Cawangan hendaklah menyampaikan kepada Setiausaha Agung sebelum tiap-tiap empat belas (14) haribulan apa-apa yuran yang diterimanya sesudah ditolak perbelanjaan yang dibenarkan dan potongan yang telah diluluskan untuk tabung cawangan. Bendahari Cawangan hendaklah juga menyampaikan kepada Setiausaha Agung sebelum hari yang ke empat belas (14) pada tiap-tiap bulan suatu Penyata Pendapatan dan Perbelanjaan Cawangan bagi bulan yang lalu.',
            'parent_constitution_template_id' => 669,
            'below_constitution_template_id' => 671,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Wang yang disimpan oleh Cawangan hendaklah dimasukkan ke dalam bank yang dipersetujui oleh Majlis Jawatankuasa Agung dengan nama Cawangan berkenaan dan akaun bank itu hendaklah diuruskan bersama-sama oleh Pengerusi, Setiausaha dan Bendahari Cawangan.',
            'parent_constitution_template_id' => 669,
            'below_constitution_template_id' => 672,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Bendahari Cawangan dibenarkan menyimpan wang tunai tidak lebih dari RM _branch_max_savings_ pada sesuatu masa. Ia tidak boleh membelanjakan lebih dari RM _branch_max_expenses pada sesuatu masa tanpa kebenaran Jawatankuasa Cawangan.',
            'parent_constitution_template_id' => 669,
            'below_constitution_template_id' => 673,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6. Bendahari Cawangan hendaklah memasukkan segala wang kesatuan yang diterima ke dalam bank yang dipersetujui oleh Majlis Jawatankuasa Agung dalam tempoh tujuh (7) hari kecuali had wang tunai yang dibenarkan.',
            'parent_constitution_template_id' => 669,
            'below_constitution_template_id' => 674,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 36 JURUAUDIT DALAM CAWANGAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 669,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Dua (2) orang Juruaudit Dalam yang bukan menjadi Ahli Jawatankuasa Cawangan, hendaklah dipilih secara angkat tangan oleh Mesyuarat Agung _Meeting_Yearly_ Tahunan Cawangan. Mereka hendaklah memeriksa akaun kesatuan pada penghujung tiap-tiap tiga (3) bulan dan menyampaikan laporannya kepada Jawatankuasa Cawangan.',
            'parent_constitution_template_id' => 676,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Dokumen pentadbiran dan kewangan kesatuan hendaklah diaudit bersamasama oleh kedua-dua Juruaudit Dalam dan mereka itu berhak melihat semua buku dan surat keterangan yang perlu untuk menyempurnakan tugas mereka.',
            'parent_constitution_template_id' => 676,
            'below_constitution_template_id' => 677,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Seseorang anggota kesatuan boleh mengadu dengan bersurat kepada Juruaudit Dalam mengenai sebarang hal kewangan yang tidak betul.',
            'parent_constitution_template_id' => 676,
            'below_constitution_template_id' => 678,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Apabila berlaku kekosongan jawatan oleh sebarang sebab, kekosongan ini bolehlah diisi dengan cara lantikan oleh Jawantankuasa Cawangan sehingga Mesyuarat Agung yang akan datang.',
            'parent_constitution_template_id' => 676,
            'below_constitution_template_id' => 679,
            'constitution_type_id' => 2,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 1 - NAMA DAN PEJABAT YANG BERDAFTAR',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1.1 Nama Persekutuan ialah "_entity_name_" (Selepas ini dipanggil sebagai Persekutuan).',
            'parent_constitution_template_id' => 681,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1.2 Pejabat yang berdaftar Persekutuan ialah di _address_, dan tempat mesyuaratnya ialah di pejabat berdaftar atau mana-mana tempat yang ditetapkan oleh Majlis Jawatankuasa Tertinggi.',
            'parent_constitution_template_id' => 681,
            'below_constitution_template_id' => 682,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 2 - TUJUAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 681,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2.1 Tujuan Persekutuan ialah :-',
            'parent_constitution_template_id' => 684,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) Membuat apa-apa yang perlu untuk menggalakkan kepentingan atau untuk kesempurnaan kerja-kerja semua atau mana-mana kesatuan sekerja gabungannya.',
            'parent_constitution_template_id' => 685,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) Melindungi kepentingan kesatuan-kesatuan sekerja gabungan dan anggotaanggotanya.',
            'parent_constitution_template_id' => 685,
            'below_constitution_template_id' => 686,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'c) Memberi nasihat dan bantuan dalam usaha memperbaiki keadaan-keadaan kerja misalnya pengambilan, masa kerja, kenaikan pangkat, tatatertib, keselamatan jawatan, gaji dan faedah-faedah persaraan kepada anggota-anggota kesatuan sekerja gabungannya apabila diperlukan.',
            'parent_constitution_template_id' => 685,
            'below_constitution_template_id' => 687,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'd) Mengatur atau membantu perhubungan di antara pihak majikan-majikan dengan kesatuan-anggota gabungan, di antara anggota gabungan dengan anggota gabungan yang lainnya atau di antara anggota gabungan dengan anggotanya, dan menasihat untuk menyelesaikan sebarang perselisihan di antara mereka itu dengan cara damai dan muafakat.',
            'parent_constitution_template_id' => 685,
            'below_constitution_template_id' => 688,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'e) Mengadakan faedah-faedah bagi anggota-anggota kesatuan sekerja gabungan sebagaimana yang akan diputuskan oleh Konvensyen Persekutuan.',
            'parent_constitution_template_id' => 685,
            'below_constitution_template_id' => 689,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'f) Berusaha membantu untuk memajukan pergerakan dan pentadbiran semua atau mana-mana kesatuan sekerja gabungan dan anggota-anggotanya.',
            'parent_constitution_template_id' => 685,
            'below_constitution_template_id' => 690,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'g) Membantu mana-mana kesatuan sekerja gabungan atau mana-mana anggotanya sama ada secara kewangan atau lain-lain untuk memperolehi apa-apa nasihat undang-undang tertakluk kepada peruntukan dalam undang-undang kesatuan sekerja yang berkuatkuasa.',
            'parent_constitution_template_id' => 685,
            'below_constitution_template_id' => 691,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'h) Menggalakkan pembentukan undang-undang mengenai kepentingan kesatuan sekerja gabungan khasnya atau kesatuan-kesatuan sekerja lainnya.',
            'parent_constitution_template_id' => 685,
            'below_constitution_template_id' => 692,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'i) Menjalankan, jika diputuskan oleh Majilis Jawatankuasa Tertinggi Persekutuan, kerja-kerja mengarang, mencetak, menerbit dan mengedarkan apa-apa akhbar, majalah, berita atau lain-lain persuratan bercetak untuk memajukan tujuan-tujuan Persekutuan atau menggalakkan kepentingan kesatuan-kesatuan sekerja gabungannya.',
            'parent_constitution_template_id' => 685,
            'below_constitution_template_id' => 693,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'j) Menggalakkan kebajikan, kebendaan, sosial dan pendidikan kesatuan sekerja gabungan dengan apa-apa cara yang sah yang dianggap patut oleh Konvensyen Persekutuan atau Majlis Jawatankuasa Tertinggi.',
            'parent_constitution_template_id' => 685,
            'below_constitution_template_id' => 694,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'k) Amnya menjalankan segala tindakan dan usaha yang perlu untuk memajukan tujuan-tujuan tersebut di atas mengikut keputusan-keputusan yang dibuat oleh Konvensyen Persekutuan atau Majlis Jawatankuasa Tertinggi.',
            'parent_constitution_template_id' => 685,
            'below_constitution_template_id' => 695,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 3 - KEANGGOTAAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 684,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3.1 Keanggotaan Persekutuan terbuka kepada semua kesatuan sekerja di dalam tred / pekerjaan / industri yang serupa yang berdaftar di Malaysia.',
            'parent_constitution_template_id' => 697,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3.2 Setiap kesatuan sekerja yang berdaftar yang ingin menjadi anggota gabungan hendaklah meluluskan satu ketetapan bersetuju menjadi anggota gabungan dalam mesyuarat agung atau persidangan perwakilan. Keputusan ketetapan ini hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja dalam masa satu bulan dari tarikh diluluskan berserta dengan satu pemberitahuan bertulis bahawa ketetapan tersebut telah diluluskan dalam mesyuarat agung atau persidangan perwakilan dan pemberitahuan seumpama itu hendaklah ditandatangani oleh Setiausaha dan tujuh orang anggota kesatuan sekerja tersebut.',
            'parent_constitution_template_id' => 697,
            'below_constitution_template_id' => 698,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3.3 Kesatuan sekerja yang berdaftar itu hendaklah menghantar kepada Setiausaha Agung Persekutuan di Ibu Pejabat berdaftar satu permohonan untuk menjadi anggota gabungan Persekutuan, berserta dengan satu salinan ketetapan anggota-anggota yang telah meluluskan permohonan itu dan satu salinan peraturan dan undang-undang kecilnya serta penyata anggota-anggota kesatuan sekerja yang membuat permohonan serta meluluskan ketetapan tersebut. Setiausaha Agung setelah menerima permohonan itu akan membawa semua permohonan menjadi anggota gabungan ke mesyuarat Majlis Jawatankuasa Tertinggi yang akan datang. Majlis Jawatankuasa Tertinggi adalah bebas menerima mana-mana permohonan menjadi anggota gabungan atau menolaknya dengan sebab-sebab yang pada pendapat Majlis Jawatankuasa Tertinggi adalah munasabah.',
            'parent_constitution_template_id' => 697,
            'below_constitution_template_id' => 699,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3.4 Setiap kesatuan sekerja yang berdaftar apabila diterima menjadi anggota gabungan Persekutuan akan diberi satu salinan Peraturan Persekutuan yang didaftarkan oleh Ketua Pengarah Kesatuan Sekerja dan satu Peraturan Tetap seperti yang dipersetujui oleh Konvensyen Persekutuan.',
            'parent_constitution_template_id' => 697,
            'below_constitution_template_id' => 700,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3.5 Setiausaha Agung akan memberitahu kesatuan sekerja yang berdaftar itu mengenai penerimaan permohonannya menjadi anggota gabungan dan meminta kesatuan sekerja yang berdaftar itu menghantar yuran masuk dan yuran tahunan pertama. Setelah menerima yuran-yuran tersebut daripada kesatuan sekerja yang berdaftar itu, Setiausaha Agung akan memberitahu Ketua Pengarah Kesatuan Sekerja bahawa permohonan menjadi anggota gabungan itu telah diluluskan. Setelah menerima pemberitahuan daripada Ketua Pengarah Kesatuan Sekerja bahawa catatan telah dibuat dalam daftar tentang gabungan tersebut, kesatuan sekerja yang berdaftar itu akan dianggap menjadi anggota gabungan Persekutuan.',
            'parent_constitution_template_id' => 697,
            'below_constitution_template_id' => 701,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 4 - MENARIK DIRI DARI MENJADI ANGGOTA GABUNGAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 697,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4.1 Setiap kesatuan sekerja yang menjadi anggota Persekutuan yang ingin menarik diri daripada menjadi anggota Persekutuan hendaklah mendapatkan persetujuan anggota-anggotanya melalui undi majoriti yang dijalankan di Mesyuarat Agung atau Persidangan Perwakilan kesatuan sekerja yang berkenaan. ',
            'parent_constitution_template_id' => 703,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4.2 Anggota gabungan yang ingin menarik diri daripada menjadi anggota Persekutuan itu apabila mendapat persetujuan anggota-anggotanya mengikut Peraturan 4.1 hendaklah mengemukakan notis bertulis dalam tempoh tiga (3) bulan yang dialamatkan kepada Setiausaha Agung Persekutuan. Satu salinan notis itu akan dihantar kepada Ketua Pengarah Kesatuan Sekerja. Selepas tamat tempoh tiga (3) bulan dari tarikh notis menarik diri daripada gabungan dengan Persekutuan, gabungan kesatuan sekerja tersebut akan terhenti, kecuali apa-apa wang yang terhutang yang patut diterima dari kesatuan sekerja yang berdaftar itu akan menjadi hutang dan perlu dibayar serta boleh diminta oleh Persekutuan.',
            'parent_constitution_template_id' => 703,
            'below_constitution_template_id' => 704,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 5 - HAK DAN TANGGUNGJAWAB KESATUAN ANGGOTA GABUNGAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 703,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5.1 Mana-mana anggota gabungan yang bertukar alamat hendaklah memberitahu Setiausaha Agung dalam tempoh 14 hari mengenai pertukaran alamat itu. Jika tidak, Persekutuan tidak akan bertanggungjawab di atas surat-surat yang tidak diterima yang dialamatkan kepada alamat terakhir anggota gabungan.',
            'parent_constitution_template_id' => 706,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5.2 Adalah menjadi tanggungjawab tiap-tiap anggota gabungan untuk memastikan supaya yuran-yuran dan bayaran-bayaran khas dibayar pada masa yang ditetapkan dan resit-resitnya diperolehi. Tanggungjawab supaya pembayaran dibuat mengikut jadual masanya terletak kepada kesatuan sekerja yang bergabung.',
            'parent_constitution_template_id' => 706,
            'below_constitution_template_id' => 707,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5.3 Anggota gabungan tidak boleh menerbitkan sebarang berita atau surat pekeliling mengenai Persekutuan melainkan dengan mendapat kebenaran dan kelulusan terlebih dahulu daripada Majlis Jawatankuasa Tertinggi. Anggota gabungan termasuk anggota-anggotanya tidak boleh mendedahkan sebarang kegiatan atau hal-hal Persekutuan kepada orang ramai yang bukan anggota-anggota gabungan atau kepada lain-lain pertubuhan atau pihak akhbar tanpa mendapat izin daripada Majlis Jawatankuasa Tertinggi.',
            'parent_constitution_template_id' => 706,
            'below_constitution_template_id' => 708,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 6 - YURAN MASUK, YURAN TAHUNAN DAN YURAN KHAS',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 706,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6.1 Tiap-tiap anggota gabungan hendaklah membayar yuran apabila diterima menjadi anggota gabungan Persekutuan seperti berikut:<br><br>Yuran Masuk – RM _entrance_fee_ <br><br>Yuran Tahunan – RM _yearly_fee_ <br><br>Yuran tahunan hendaklah dibayar selewat-lewatnya sebelum 31hb Januari setiap tahun. Yuran tahunan untuk tahun pertama akan dikira secara pro-rata tahun kewangan mengikut tarikh permohonan untuk bergabung diterima.',
            'parent_constitution_template_id' => 710,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6.2 Jika pada bila-bila masa jumlah pendapatan Persekutuan jatuh serendahrendahnya atau jika apa-apa tanggungan kewangan akan menjadi sangat berat kepada sumber-sumber kewangan Persekutuan, maka Konvensyen Persekutuan boleh mengenakan satu bayaran khas. Bagaimanapun, bayaran khas hanya boleh dikenakan sekiranya lebih daripada separuh anggota-anggota kesatuan sekerja yang bergabung bersetuju dengan bayaran khas tersebut mengikut Peraturan 26.',
            'parent_constitution_template_id' => 710,
            'below_constitution_template_id' => 711,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6.3 Sekiranya mana-mana anggota gabungan gagal menjelaskan yuran atau jumlah apa-apa bayaran khas yang dikenakan itu dalam tempoh tiga (3) bulan dari tarikh sepatutnya dijelaskan, maka anggota gabungan itu akan digantung daripada mendapat segala faedah (kewangan dan lain-lain) selama tempoh anggota gabungan itu terhutang dan selama tempoh tiga (3) bulan lagi daripada masa ia menjelaskan yuran atau bayaran khas itu. Sekiranya anggota gabungan gagal membayar yurannya atau mana-mana bayaran khas yang dikenakan itu selepas tempoh enam (6) bulan daripada tarikh yang sepatutnya, perkara tersebut akan dibawa kepada Majlis Jawantankuasa Tertinggi yang akan berkuasa mengeluarkan atau memecat anggota gabungan itu daripada Persekutuan atau menyelesaikan perkara tersebut dengan cara yang dianggap baik. Anggota gabungan itu mempunyai hak merayu kepada Konvensyen Persekutuan yang mana keputusannya adalah muktamad.',
            'parent_constitution_template_id' => 710,
            'below_constitution_template_id' => 712,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6.4 Sekiranya mana-mana anggota gabungan tidak dapat menjelaskan jumlah apaapa yuran atau jumlah apa-apa bayaran khas yang dikenakan itu, disebabkan kesulitan kewangannya, maka ia boleh membuat permohonan kepada Majlis Jawatankuasa Tertinggi secara bersurat yang dialamatkan kepada Setiausaha Agung bagi pengecualian sementara. Majlis Jawatankuasa Tertinggi mempunyai kuasa meluluskan permohonan itu dengan bersyarat dan bagi sesuatu tempoh atau tempoh-tempoh yang dianggap wajar. Dalam tempoh sesuatu pengecualian itu, anggota gabungan tersebut tidak mempunyai hak atas apa-apa faedah dan hanya akan mempunyai hak atas faedah-faedah yang sama apabila menjelaskan bayaran setelah tamat tempoh seperti yang ditetapkan oleh Majlis Jawatankuasa Tertinggi.',
            'parent_constitution_template_id' => 710,
            'below_constitution_template_id' => 713,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6.5 Sebuah kesatuan sekerja yang telah diberi pengecualian sementara oleh Majlis Jawatankuasa Tertinggi boleh dibenarkan mengambil bahagian dalam Konvensyen Persekutuan atau apa-apa kegiatan lain yang diluluskan oleh Majlis Jawatankuasa Tertinggi tertakluk kepada ketetapan yang mungkin ditetapkan oleh Majlis Jawatankuasa Tertinggi dengan syarat kesatuan berkenaan membayar penuh yuran tahunan semasa dengan serta merta dan memberi akuan secara bertulis untuk menyelesaikan hutang-hutang yuran serta yuran tahunan akan datang secara ansuran seperti yang dipersetujui oleh Majlis Jawatankuasa Tertinggi.',
            'parent_constitution_template_id' => 710,
            'below_constitution_template_id' => 714,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 7 - PERLEMBAGAAN DAN PENTADBIRAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 710,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '7.1 Kuasa yang tertinggi sekali di dalam Persekutuan ini terletak ke atas Konvensyen Persekutuan melainkan kuasa mengenai perkara-perkara yang keputusannya mesti diambil dengan undi rahsia menurut peraturan.',
            'parent_constitution_template_id' => 716,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '7.2 Persekutuan ini hendaklah ditadbir oleh Majlis Jawatankuasa Tertinggi.',
            'parent_constitution_template_id' => 716,
            'below_constitution_template_id' => 717,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 8 - KONVENSYEN _CONVENTION_YEARLY_ TAHUNAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 716,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8.1 Konvensyen Persekutuan _Convention_Yearly_ Tahunan hendaklah diadakan dengan seberapa segera selepas 1hb April dan tidak lewat dari 31hb Oktober pada setiap _convention_yearly_ tahunan. Tarikh, masa dan tempat Konvensyen itu hendaklah ditetapkan oleh Majlis Jawatankuasa Tertinggi Persekutuan.',
            'parent_constitution_template_id' => 719,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8.2 Konvensyen itu hendaklah terdiri daripada wakil-wakil kesatuan sekerja yang menjadi anggota Persekutuan dan anggota-anggota Majlis Jawatankuasa Tertinggi Persekutuan.',
            'parent_constitution_template_id' => 719,
            'below_constitution_template_id' => 720,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8.3 Konvensyen akan mengandungi wakil-wakil yang layak dibawah peraturanperaturan ini dan dilantik oleh kesatuan-kesatuan sekerja anggota secara undi rahsia mengikut bilangan keanggotaan masing-masing seperti yang didaftarkan di pejabat persekutuan.',
            'parent_constitution_template_id' => 719,
            'below_constitution_template_id' => 721,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8.4 Tiap-tiap kesatuan anggota akan berhak mempunyai dua wakil bagi _first_member_ ratus anggota yang pertama dan tambahan seorang lagi bagi tiap-tiap _next_member_ ratus anggota lagi atau sebahagian daripadanya.',
            'parent_constitution_template_id' => 719,
            'below_constitution_template_id' => 722,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8.5 Semua pemilihan tersebut di atas hendaklah diberitahu kepada Setiausaha Agung Persekutan tidak lewat dari 14 hari dari tarikh pemilihan.',
            'parent_constitution_template_id' => 719,
            'below_constitution_template_id' => 723,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8.6 Hanya wakil-wakil dan anggota Majlis Jawatankuasa Tertinggi sahaja yang boleh mengundi di dalam Konvensyen Persekutuan. Pengerusi Konvensyen boleh memberi undi pemutus apabila undi yang diterima adalah sama banyak di atas semua perkara kecuali perkara-perkara di bawah Peraturan 26. Konvensyen akan dijalankan mengikut perbekalan-perbekalan yang dinyatakan dalam Peraturan-peraturan Tetap Konvensyen Persekutuan yang dibuat oleh Persekutuan.',
            'parent_constitution_template_id' => 719,
            'below_constitution_template_id' => 724,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8.7 Notis permulaan bagi Konvensyen _Convention_Yearly_ Tahunan yang menyatakan tarikh, masa dan tempat konvensyen dan permintaan usul-usul (termasuk usul pindaan peraturan), penamaan calon-calon bagi menganggotai Majlis Jawatankuasa Tertinggi dan wakil-wakil, hendaklah dihantar oleh Setiausaha Agung kepada semua Setiausaha anggota gabungan sekurang-kurangnya 30 hari sebelum tarikh konvensyen. Penamaan calon bagi Majlis Jawatankuasa Tertinggi hendaklah atas nama jawatan dalam anggota gabungan masing-masing.',
            'parent_constitution_template_id' => 719,
            'below_constitution_template_id' => 725,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8.8 Tiap-tiap Setiausaha anggota gabungan hendaklah menghantar kepada Setiausaha Agung Persekutuan sekurang-kurangnya 14 hari sebelum Konvensyen, butir-butir mengenai wakil masing-masing, nama-nama calon bagi Pegawai-pegawai Utama dan anggota-anggota Majlis Jawatankuasa Tertinggi dan juga usul-usul (jika ada) untuk dibincangkan di dalam Konvensyen. Semua pencalonan hendaklah dibuat atas borang yang disediakan oleh Persekutuan yang mengandungi butir-butir yang berikut: nama jawatan yang ditandingi, nama calon, nombor anggota, nombor kad pengenalan, umur, alamat, pekerjaan dan nombor sijil kerakyatan atau taraf kerakyatan, seperti ditentukan di bawah Peraturan 12.2. Sesuatu pencalonan itu tidak sah kecuali:-',
            'parent_constitution_template_id' => 719,
            'below_constitution_template_id' => 726,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) ia ditandatangani oleh seorang pencadang dan seorang penyokong yang merupakan anggota-anggota berhak; dan',
            'parent_constitution_template_id' => 727,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) calon yang hendak bertanding itu memberi persetujuan secara bertulis.',
            'parent_constitution_template_id' => 727,
            'below_constitution_template_id' => 728,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8.9 Setiausaha Agung Persekutuan hendaklah menghantar kepada semua Setiausaha anggota gabungan sekurang-kurangnya 10 hari sebelum tarikh Konvensyen suatu agenda yang mengandungi usul-usul untuk perbincangan, penyata tahunan dan penyata kewangan dan kertas undi rahsia dengan secukupnya menurut kembaran kepada Peraturan-peraturan ini untuk pemilihan anggota Majlis Jawatankuasa Tertinggi dan untuk mengundi perkara-perkara yang akan diputuskan dengan undi sulit (jika ada). Setiausaha anggota gabungan hendaklah mengedarkan kertas-kertas undi itu dengan sampulnya kepada semua anggota yang berhak mengundi.',
            'parent_constitution_template_id' => 719,
            'below_constitution_template_id' => 727,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8.10 Dua Pertiga (2/3) dari jumlah perwakilan yang berhak hendaklah menjadi kuorum Konvensyen _Convention_Yearly_ Tahunan.',
            'parent_constitution_template_id' => 719,
            'below_constitution_template_id' => 730,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8.11 Jika satu jam kemudian dari masa yang ditentukan itu, bilangan wakil yang hadir (atau kuorum) tidak mencukupi maka Konvensyen itu hendaklah ditangguhkan kepada suatu tarikh (tidak lewat dari 21 hari kemudian) yang akan ditetapkan oleh Majlis Jawatankuasa Tertinggi.',
            'parent_constitution_template_id' => 719,
            'below_constitution_template_id' => 731,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8.12 Dalam Konvensyen yang ditangguhkan itu jika kuorumnya masih tidak mencukupi pada masa yang ditentukan maka wakil-wakil yang hadir berkuasa menjalankan Konvensyen itu akan tetapi tidak berkuasa meminda Peraturanperaturan Persekutuan.',
            'parent_constitution_template_id' => 719,
            'below_constitution_template_id' => 732,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8.13 Urusan Konvensyen _Convention_Yearly_ Tahunan antara lain-lain ialah:-',
            'parent_constitution_template_id' => 719,
            'below_constitution_template_id' => 733,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(a) menerima dan meluluskan laporan-laporan daripada Setiausaha Agung, Bendahari Agung dan Majlis Jawatankuasa Tertinggi Persekutuan; ',
            'parent_constitution_template_id' => 734,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(b) membincang dan memutuskan sebarang perkara atau usul mengenai kebajikan dan kemajuan anggota-anggota gabungan Persekutuan;',
            'parent_constitution_template_id' => 734,
            'below_constitution_template_id' => 735,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(c) memilih/melantik:-',
            'parent_constitution_template_id' => 734,
            'below_constitution_template_id' => 736,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'i. Pemegang Amanah; jika ada',
            'parent_constitution_template_id' => 737,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'ii. Ahli Jemaah Penimbangtara; jika perlu',
            'parent_constitution_template_id' => 737,
            'below_constitution_template_id' => 738,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'iii. Juruaudit Dalam; dan',
            'parent_constitution_template_id' => 737,
            'below_constitution_template_id' => 739,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'iv. Pemeriksa Undi',
            'parent_constitution_template_id' => 737,
            'below_constitution_template_id' => 740,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(d) meluluskan jawatan-jawatan sepenuh masa bagi pegawai-pegawai dan pekerja sekiranya perlu;',
            'parent_constitution_template_id' => 734,
            'below_constitution_template_id' => 736,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(e) menerima penyata Pemeriksa Undi berkenaan dengan undi rahsia bagi pemilihan anggota Majlis Jawatankuasa Tertinggi; dan',
            'parent_constitution_template_id' => 734,
            'below_constitution_template_id' => 742,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(f) membincang dan memutuskan perkara-perkara lain yang terkandung di dalam agenda.',
            'parent_constitution_template_id' => 734,
            'below_constitution_template_id' => 743,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '8.14 Setiausaha Agung hendaklah menyampaikan kepada semua Setiausaha anggota gabungan satu salinan minit Konvensyen _Convention_Yearly_ Tahunan dalam tempoh tidak melebihi 60 hari sesudah sahaja selesai Konvensyen itu.',
            'parent_constitution_template_id' => 719,
            'below_constitution_template_id' => 734,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 9 - KONVENSYEN LUAR BIASA PERSEKUTUAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 719,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '9.1 Konvensyen Luar Biasa Persekutuan hendaklah diadakan :-',
            'parent_constitution_template_id' => 746,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) apabila sahaja difikirkan mustahak oleh Majlis Jawatankuasa Tertinggi; atau',
            'parent_constitution_template_id' => 747,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) atas permintaan bersama secara bertulis daripada tidak kurang satu pertiga (1/3) daripada kesatuan-kesatuan sekerja yang mempunyai hak keanggotaan dalam Persekutuan. Permintaan itu hendaklah menyatakan tujuan-tujuan dan sebab-sebab mereka ingin Konvensyen itu diadakan.',
            'parent_constitution_template_id' => 747,
            'below_constitution_template_id' => 748,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '9.2 Konvensyen Luar Biasa Persekutuan yang diminta oleh kesatuan gabungan hendaklah dikendalikan oleh Setiausaha Agung dalam tempoh 21 hari dari tarikh permintaan itu diterima. Majlis Jawatankuasa Tertinggi hendaklah memastikan bahawa permintaan yang sah di bawah Peraturan 9.1 dilaksanakan dengan teratur tanpa gagal.',
            'parent_constitution_template_id' => 746,
            'below_constitution_template_id' => 747,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '9.3 Notis dan agenda bagi Konvensyen Luar Biasa Persekutuan hendaklah disampaikan oleh Setiausaha Agung kepada kesatuan gabungan sekurangkurangnya 7 hari sebelum tarikh Konvensyen.',
            'parent_constitution_template_id' => 746,
            'below_constitution_template_id' => 750,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '9.4 Peruntukan-peruntukan Peraturan 8 berkenaan dengan kuorum dan penangguhan Konvensyen Persekutuan _Convention_Yearly_ Tahunan adalah juga terpakai bagi Konvensyen Luar Biasa Persekutuan. Walau bagaimanapun dalam Konvensyen Luar Biasa yang diminta oleh kesatuan-kesatuan gabungan jika Konvensyen itu ditangguhkan kerana kuorum tidak cukup maka Konvensyen yang ditetapkan sesudah penangguhan itu hendaklah dibatalkan sekiranya kuorum masih tidak mencukupi selepas satu jam dari masa yang dijadualkan. Konvensyen berkenaan bagi perkara yang sama tidak boleh diadakan melainkan selepas enam (6) bulan dari tarikh konvensyen itu dibatalkan.',
            'parent_constitution_template_id' => 746,
            'below_constitution_template_id' => 751,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '9.5 Jika Konvensyen Persekutuan _Convention_Yearly_ Tahunan tidak dapat diadakan dalam masa yang ditentukan dalam Peraturan 8, maka berkuasalah Konvensyen Luar Biasa Persekutuan menjalankan sebarang kerja yang lazimnya dijalankan oleh Konvensyen Persekutuan _Convention_Yearly_ Tahunan dengan syarat Konvensyen Luar Biasa Persekutuan yang demikian mestilah diadakan sebelum 31hb Disember dalam tahun yang berkenaan.',
            'parent_constitution_template_id' => 746,
            'below_constitution_template_id' => 752,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 10 - MAJLIS JAWATANKUASA TERTINGGI',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 746,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '10.1 Pengurusan dan penyelenggaran Persekutuan termasuk pertikaian-pertikaian perusahaan, di antara tempoh Konvensyen Persekutuan _Convention_Yearly_ Tahunan akan terletak kepada Majlis Jawatankuasa Tertinggi. ',
            'parent_constitution_template_id' => 754,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '10.2 Majlis Jawatankuasa Tertinggi akan mengandungi -',
            'parent_constitution_template_id' => 754,
            'below_constitution_template_id' => 755,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '• seorang Presiden; <br><br>• seorang Naib Presiden; <br><br>• seorang Setiausaha Agung; dan akan dipilih menurut Peraturan<br><br>• seorang Penolong Setiausaha Agung; <br><br>• seorang Bendahari Agung; <br><br>• seorang Penolong Bendahari Agung; dan<br><br>• seorang Ahli Jawatankuasa dari Kesatuan masing-masing.<br><br>Mereka dikenali sebagai Pegawai-Pegawai Utama Persekutuan 8.7, setiap _convention_yearly_ tahunan sekali melalui undi rahsia oleh wakil-wakil.<br><br>Seorang Ahli Jawatankuasa akan dipilih oleh wakil-wakil di dalam Konvensyen menurut peraturan 8.3, daripada setiap kesatuan gabungan.',
            'parent_constitution_template_id' => 756,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '10.3 Semua pegawai Persekutuan hendaklah memegang jawatan sehingga pemilihan yang akan datang. Mereka layak untuk dicalonkan ataupun dipilih semula tertakluk kepada Peraturan 8.3.',
            'parent_constitution_template_id' => 746,
            'below_constitution_template_id' => 756,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '10.4 Sekiranya seseorang Ahli Majlis Jawatankuasa Tertinggi meletakkan jawatan maka Majlis Jawatankuasa Tertinggi berkuasa melantik atau mengisi kekosongan tertakluk kepada Peraturan 8.3. Jika kekosongan jawatan dalam Majlis Jawatankuasa Tertinggi disebabkan pegawai itu meninggal dunia atau tidak lagi berkelayakkan maka kesatuan gabungan yang pegawainya memegang jawatan berhak untuk menentukan pengganti.',
            'parent_constitution_template_id' => 746,
            'below_constitution_template_id' => 758,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '10.5 Ahli Majlis Jawatankuasa Tertinggi yang tidak menghadiri tiga (3) kali mesyuarat berturut-turut tidak lagi berhak menyandang jawatannya melainkan jika dapat ia memberi alasan yang memuaskan kepada Majlis Jawatankuasa Tertinggi.',
            'parent_constitution_template_id' => 746,
            'below_constitution_template_id' => 759,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 11 - TUGAS DAN FUNGSI MAJLIS JAWATANKUASA TERTINGGI',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 754,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11.1 Majlis Jawatankuasa Tertinggi akan mengadakan mesyuaratnya sekurangkurangnya tiga bulan sekali atau seberapa kerap yang perlu. Kuorum bagi mesyuarat Majlis Jawatankuasa Tertinggi ialah ½ daripada jumlah anggotanya.',
            'parent_constitution_template_id' => 761,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11.2 Tugas-tugas Majlis Jawatankuasa Tertinggi ialah -',
            'parent_constitution_template_id' => 761,
            'below_constitution_template_id' => 762,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) Menguruskan hal ehwal Persekutuan dan menggunakan semua atau mana-mana kuasa serta menjalankan semua tindakan, tugas dan kewajipan sebagaimana perlu untuk mencapai atau ada berkaitan atau untuk kebaikan bagi mencapai tujuan-tujuan dan kepentingankepentingan Persekutuan. Dalam menguruskan hal ehwal Persekutuan, Majlis Jawatankuasa Tertinggi itu akan patuh kepada semua arahan yang diberi oleh Konvensyen Persekutuan;',
            'parent_constitution_template_id' => 763,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) Membincang dan memberi nasihat atas semua soal yang dikemukakan oleh anggota dan wakil-wakil anggota gabungan; dan',
            'parent_constitution_template_id' => 763,
            'below_constitution_template_id' => 764,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'c) Apabila perlu, melantik jawatankuasa kecil atau perwakilan untuk menemui pihak-pihak yang terlibat dalam apa-apa perselisihan atau membuat penyelesaiannya dengan tujuan untuk mengelakkan atau pun menyelesaikan sesuatu pertikaian.',
            'parent_constitution_template_id' => 763,
            'below_constitution_template_id' => 765,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11.3 Majlis Jawatankuasa Tertinggi hendaklah memberi perintah-perintah kepada Setiausaha Agung dan pegawai-pegawai lain bagi mengendalikan hal-ehwal Persekutuan. Tertakluk kepada perbekalan-perbekalan Peraturan 12.3, ia boleh mengambil kakitangan yang dianggap perlu, dan boleh menggantung atau memecat mana-mana pegawai atau pekerja kerana kecuaian menjalankan tugas, tidak jujur, tidak berkelayakan, enggan menjalankan keputusankeputusan Majlis Jawatankuasa Tertinggi atau kerana apa-apa sebab yang lain yang dianggapnya berpatutan demi kepentingan Persekutuan.',
            'parent_constitution_template_id' => 761,
            'below_constitution_template_id' => 763,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11.4 Majlis Jawatankuasa Tertinggi hendaklah melindungi kewangan Persekutuan daripada pemborosan dan penipuan. Majlis Jawatankuasa Tertinggi hendaklah mengarahkan Setiausaha Agung atau mana-mana pegawai lain untuk mendakwa mana-mana pegawai atau anggota kerana menipu atau menahan mana-mana wang atau harta kepunyaan Persekutuan.',
            'parent_constitution_template_id' => 761,
            'below_constitution_template_id' => 767,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11.5 Di antara dua Konvensyen Persekutuan _Convention_Yearly_ Tahunan, maka Majlis Jawatankuasa Tertinggi akan mentafsirkan Peraturan dan, apabila perlu, menentukan apa-apa perkara yang tidak diterangkan dalam Peraturan ini.',
            'parent_constitution_template_id' => 761,
            'below_constitution_template_id' => 768,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11.6 Majlis Jawatankuasa Tertinggi mempunyai kuasa menggantungkan manamana anggota gabungan daripada mendapat faedah atau memecat daripada keanggotaan gabungan, atau melarang daripada memegang apa-apa jawatan, yang pada pendapatnya bersalah kerana cuba merosakkan Persekutuan atau kerana tindakan yang bercanggah dengan Peraturan Persekutuan atau membuat atau dengan apa-apa cara juga melibatkan diri dengan apa-apa serangan menfitnah, memburukkan atau mencerca Persekutuan, pegawai-pegawai atau dasar Persekutuan. Anggota gabungan yang digantung, dipecat atau dilarang mempunyai hak merayu kepada Konvensyen Persekutuan. Keputusan Konvensyen Persekutuan adalah muktamad.',
            'parent_constitution_template_id' => 761,
            'below_constitution_template_id' => 769,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11.7 Semua persoalan dalam Majlis Jawatankuasa Tertinggi (kecuali ada peruntukan yang lain dibekalkan) akan diputuskan dengan cara mengangkat tangan dan sekiranya undi sama banyak maka Presiden atau dalam ketiadaannya, Naib Presiden akan mempunyai undi pemutus.',
            'parent_constitution_template_id' => 761,
            'below_constitution_template_id' => 770,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11.8 Majlis Jawatankuasa Tertinggi jika perlu boleh memanggil anggota-anggota gabungan bermesyuarat untuk memutuskan secara bersama sesuatu dasar, upah atau gaji atau apa-apa perkara lain yang berkaitan dengan kepentingan Persekutuan. Apa-apa keputusan yang diambil akan tertakluk kepada kelulusan Konvensyen Persekutuan.',
            'parent_constitution_template_id' => 761,
            'below_constitution_template_id' => 771,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11.9 Sekiranya apa-apa persoalan atau perkara berbangkit yang pada pendapat Majlis Jawatankuasa Tertinggi tidak diliputi oleh peraturan ini atau yang mengenainya atau peraturan ini kelihatan samar-samar kepada Majlis Jawatankuasa Tertinggi, maka Majlis Jawatankuasa Tertinggi boleh memberi keputusan bagaimana soal atau perkara itu akan diselenggarakan, dan akan membawa keputusan mereka itu kepada Konvensyen Persekutuan yang akan datang, atau kepada Konvensyen Luar Biasa Persekutuan, jika Majlis Jawatankuasa Tertinggi menganggapnya perlu. Konvensyen Persekutuan boleh mempersetujui, mengubah atau membatalkan keputusan itu dan boleh mengekalkan keputusan itu dengan mengubah peraturan seperti yang dibekalkan dalam Peraturan 25. Keputusan itu berkuatkuasa sehingga keputusan Majlis Jawatankuasa Tertinggi diubah atau dibatalkan atau diketepikan oleh Mahkamah. Sekiranya, Konvensyen Persekutuan membatalkan atau mengubah keputusan itu maka Konvensyen Persekutuan boleh memberi arahan-arahan supaya pembatalan atau pengubahan itu berkuatkuasa dari tarikh kebelakangan jika difikirkan perlu.',
            'parent_constitution_template_id' => 761,
            'below_constitution_template_id' => 772,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11.10 Jika mana-mana anggota gabungan tidak berpuashati dengan mana-mana keputusan Majlis Jawatankuasa Tertinggi maka ia boleh merayu kepada Konvensyen Persekutuan, yang keputusannya di atas perkara tersebut adalah muktamad dan mengikat, kecuali diketepikan oleh sebuah Mahkamah. Manamana anggota gabungan yang ingin merayu hendaklah menghantar pemberitahuan mengenai keinginannya berserta butir-butir ringkas alasanalasan rayuannya itu kepada Setiausaha Agung dalam masa 30 hari setelah keputusan itu diberi oleh Majlis Jawatankuasa Tertinggi dan rayuan tersebut akan dibawa kepada Konvensyen Persekutuan yang akan datang.',
            'parent_constitution_template_id' => 761,
            'below_constitution_template_id' => 773,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11.11 Persekutuan dan Majlis Jawatankuasa Tertinggi hendaklah menghormati kedaulatan perlembagaan setiap anggota gabungannya.',
            'parent_constitution_template_id' => 761,
            'below_constitution_template_id' => 774,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11.12 Apabila berlaku sesuatu perkara yang memerlukan keputusan dari Majlis Jawatankuasa Tertinggi dengan serta merta dan tidak dapat diadakan satu mesyuarat tergempar, maka Setiausaha Agung boleh, dengan persetujuan Presiden, mendapatkan satu keputusan melalui satu surat pekeliling. Syaratsyarat berikut mestilah dipenuhi sebelum satu-satu keputusan Majlis Jawatankuasa Tertinggi itu dianggap telah diperolehi:-',
            'parent_constitution_template_id' => 761,
            'below_constitution_template_id' => 775,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) Perkara dan tindakan yang dicadangkan mestilah dinyatakan dengan jelas dalam surat pekeliling, dan salinan-salinan pekeliling tersebut mestilah dihantar kepada semua anggota Majlis Jawatankuasa Tertinggi;',
            'parent_constitution_template_id' => 776,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) Sekurang-kurangnya ½ daripada anggota-anggota Majlis Jawatankuasa Tertinggi mestilah menyatakan secara bertulis samada mereka bersetuju atau menentang cadangan itu; dan',
            'parent_constitution_template_id' => 776,
            'below_constitution_template_id' => 777,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'c) Suara yang terbanyak dari mereka yang menyatakan pendapatnya adalah menjadi keputusan.',
            'parent_constitution_template_id' => 776,
            'below_constitution_template_id' => 778,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11.13 Sesuatu keputusan yang diperolehi melalui surat pekeliling hendaklah dilaporkan oleh Setiausaha Agung kepada mesyuarat Majlis Jawatankuasa Tertinggi yang akan datang dan dicatatkan dalam minit.',
            'parent_constitution_template_id' => 761,
            'below_constitution_template_id' => 776,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '11.14 Majlis Jawatankuasa Tertinggi hendaklah memberi arahan kepada pemegangpemegang Amanah mengenai pelaburan wang Persekutuan.',
            'parent_constitution_template_id' => 761,
            'below_constitution_template_id' => 780,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 12 - PEGAWAI DAN KAKITANGAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 761,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '12.1 Erti pegawai dalam Persekutuan ini adalah seseorang yang menjadi anggota Majlis Jawatankuasa Tertinggi tetapi tidak termasuk Juruaudit.',
            'parent_constitution_template_id' => 782,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '12.2 Seseorang itu tidak boleh dipilih atau bertugas sebagai Pegawai Persekutuan jika orang itu:-',
            'parent_constitution_template_id' => 782,
            'below_constitution_template_id' => 783,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) bukan anggota kesatuan;',
            'parent_constitution_template_id' => 784,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) belum sampai 21 tahun umurnya;',
            'parent_constitution_template_id' => 784,
            'below_constitution_template_id' => 785,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'c) bukan warganegara Malaysia;',
            'parent_constitution_template_id' => 784,
            'below_constitution_template_id' => 786,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'd) pernah manjadi anggota eksekutif mana-mana kesatuan yang pendaftarannya telah dibatalkan di bawah seksyen 15 (1) (b) (iv), (v) atau (vi) Akta Kesatuan Sekerja 1959 atau enakmen yang telah dimansuhkan oleh Akta itu;',
            'parent_constitution_template_id' => 784,
            'below_constitution_template_id' => 787,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'e) pernah disabitkan salah oleh Mahkamah kerana pecah amanah, pemerasan atau mengugut, atau kerana melakukan sebarang kesalahan lain yang mengikut pendapat Ketua Pengarah Kesatuan Sekerja tidak melayakkannya menjadi pegawai sesebuah kesatuan sekerja;',
            'parent_constitution_template_id' => 784,
            'below_constitution_template_id' => 788,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'f) seorang pemegang jawatan atau pekerja sesebuah parti politik;',
            'parent_constitution_template_id' => 784,
            'below_constitution_template_id' => 789,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'g) seseorang yang masih bankrap; dan',
            'parent_constitution_template_id' => 784,
            'below_constitution_template_id' => 790,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'h) Memegang jawatan atau kakitangan lain-lain Persekutuan.',
            'parent_constitution_template_id' => 784,
            'below_constitution_template_id' => 791,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '12.3 Tertakluk kepada kelulusan Konvensyen Persekutuan, Majlis Jawatankuasa Tertinggi berkuasa menggaji orang yang difikirkan perlu. Dengan syarat seseorang pegawai atau kakitangan sepenuh masa itu selain daripada orangorang yang tersebut di dalam "proviso" kepada seksyen 29 (1) Akta Kesatuan Sekerja 1959, tidak boleh menjadi pegawai kesatuan (melainkan ianya dikecualikan di bawah seksyen 30 Akta Kesatuan Sekerja 1959) atau bertugas dengan sedemikian rupa hingga urusan hal ehwal Persekutuan itu nampak dalam kawalannya.',
            'parent_constitution_template_id' => 782,
            'below_constitution_template_id' => 784,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '12.4 Seseorang itu tidak boleh digaji sedemikian jika:-',
            'parent_constitution_template_id' => 782,
            'below_constitution_template_id' => 793,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) ia bukan warganegara Malaysia, atau',
            'parent_constitution_template_id' => 794,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) ia telah disabitkan salah oleh sebuah Mahkamah melakukan sesuatu kesalahan jenayah dan belum lagi mendapat pengampunan bagi kesalahan tersebut dan kesalahan itu mengikut pendapat Ketua Pengarah Kesatuan Sekerja tidak melayakkannya digaji oleh sebuah Kesatuan sekerja; atau',
            'parent_constitution_template_id' => 794,
            'below_constitution_template_id' => 795,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'c) ia adalah seorang pegawai atau pekerja sesebuah kesatuan sekerja yang lain; atau',
            'parent_constitution_template_id' => 794,
            'below_constitution_template_id' => 796,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'd) ia adalah seorang pemegang jawatan atau pekerja sesebuah parti politik.',
            'parent_constitution_template_id' => 794,
            'below_constitution_template_id' => 797,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 13 - KEWAJIPAN PEGAWAI-PEGAWAI UTAMA PERSEKUTUAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 782,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '1. Presiden',
            'parent_constitution_template_id' => 799,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) Dalam masa menyandang jawatannya hendaklah menjadi Pengerusi semua mesyuarat Konvensyen dan semua mesyuarat Majlis Jawatankuasa Tertinggi, dan hendaklah bertanggungjawab tentang ketenteraman dan kesempurnaan mesyuarat-mesyuarat itu. Ia mempunyai undian pemutus dalam isu-isu pada masa mesyuarat. Kuasa pemutus ini tidak termasuk perkara-perkara yang melibatkan undi rahsia;',
            'parent_constitution_template_id' => 800,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) Beliau hendaklah mengesahkan minit tiap-tiap mesyuarat dengan menandatanganinya;',
            'parent_constitution_template_id' => 800,
            'below_constitution_template_id' => 801,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'c) Ia hendaklah menandatangani segala cek bagi pihak Persekutuan bersama-sama dengan Setiausaha Agung dan Bendahari Agung Persekutuan; dan',
            'parent_constitution_template_id' => 800,
            'below_constitution_template_id' => 802,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'd) Ia hendaklah mengawasi semua pentadbiran dan perjalanan persekutuan dan juga hendaklah berikhtiar supaya peraturan-peraturan ini dipatuhi oleh sekalian yang berkenaan.',
            'parent_constitution_template_id' => 800,
            'below_constitution_template_id' => 803,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '2. Naib Presiden',
            'parent_constitution_template_id' => 799,
            'below_constitution_template_id' => 800,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) Naib Presiden hendaklah menggantikan Presiden dan memegang kuasanya dimasa ketiadaannya.',
            'parent_constitution_template_id' => 805,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '3. Setiausaha Agung',
            'parent_constitution_template_id' => 799,
            'below_constitution_template_id' => 805,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) Setiausaha Agung hendaklah mengelolakan kerja-kerja Persekutuan mengikut peraturan-peraturan ini dan hendaklah menjalankan perintahperintah dan arahan-arahan mesyuarat Konvensyen dan Majlis Jawatankuasa Tertinggi;',
            'parent_constitution_template_id' => 807,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) Ia hendaklah mengawasi kerja-kerja kakitangan Persekutuan dan hendaklah bertanggungjawab tentang surat menyurat dan menyimpan buku-buku, surat-surat keterangan dan kertas-kertas Persekutuan dengan cara dan aturan yang diarahkan oleh Majlis Jawatankuasa Tertinggi;',
            'parent_constitution_template_id' => 807,
            'below_constitution_template_id' => 808,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'c) Ia hendaklah menyediakan agenda dan menetapkan mesyuarat Majlis Jawatankuasa Tertinggi dengan persetujuan terlebih dahalu dari Presiden. Ia hendaklah menghadiri semua mesyuarat dan mencatat minit-minit mesyuarat itu dan hendaklah menyediakan penyata tahunan kegiatan Persekutuan untuk mesyuarat Konvensyen Persekutuan _Convention_Yearly_ Tahunan;',
            'parent_constitution_template_id' => 807,
            'below_constitution_template_id' => 809,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'd) Ia hendaklah menyediakan atau berikhtiar supaya disediakan Penyatapenyata tahunan dan lain-lain surat keterangan yang dikehendaki oleh Ketua Pengarah Kesatuan Sekerja dan hendaklah menghantarkannya kepada Ketua Pengarah Kesatuan Sekerja dalam masa yang ditentukan.',
            'parent_constitution_template_id' => 807,
            'below_constitution_template_id' => 810,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'e) Ia hendaklah menyimpan dan mengemaskinikan suatu Daftar Keanggotaan, nama alamat mereka, nombor anggota, dan tarikh mereka menjadi anggota Persekutuan.',
            'parent_constitution_template_id' => 807,
            'below_constitution_template_id' => 811,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'f) Setiausaha Agung hendaklah menandatangani segala cek bagi pihak Persekutuan bersama-sama dengan Presiden dan Bendahari Agung.',
            'parent_constitution_template_id' => 807,
            'below_constitution_template_id' => 812,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '4. Penolong Setiausaha Agung',
            'parent_constitution_template_id' => 799,
            'below_constitution_template_id' => 807,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) Penolong Setiausaha Agung hendaklah membantu Setiausaha Agung Persekutuan dalam urusan pentadbiran Persekutuan dan hendaklah menggantinya pada masa ketiadaannya; dan',
            'parent_constitution_template_id' => 814,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) Penolong Setiausaha Agung hendaklah juga menjalankan tugas-tugas yang diarah oleh Majlis Jawatankuasa Tertinggi.',
            'parent_constitution_template_id' => 814,
            'below_constitution_template_id' => 815,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '5. Bendahari Agung',
            'parent_constitution_template_id' => 799,
            'below_constitution_template_id' => 814,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) Bendahari Agung hendaklah bertanggungjawab dalam urusan penerimaan dan pembayaran wang bagi pihak Persekutuan dan urusan penyimpanan dan catatan di buku-buku kewangan sebagaimana yang dikehendaki oleh Peraturan-peraturan Kesatuan Sekerja 1959;',
            'parent_constitution_template_id' => 817,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) Ia hendaklah mengeluarkan resit-resit rasmi bagi tiap-tiap wang yang diterimanya.',
            'parent_constitution_template_id' => 817,
            'below_constitution_template_id' => 818,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'c) Tidaklah boleh pegawai-pegawai lain atau kakitangan Persekutuan di Ibu Pejabat menerima wang atau mengeluarkan resit rasmi tanpa kuasa yang diberikan dengan bersurat oleh Presiden pada tiap-tiap kali dikehendaki mereka itu berbuat demikian. ',
            'parent_constitution_template_id' => 817,
            'below_constitution_template_id' => 819,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'd) Ia hendaklah bertanggungjawab tentang keselamatan simpanan bukubuku kewangan dan surat-surat keterangan yang berkenaan di Ibu Pejabat. Buku-buku dan surat-surat keterangan ini tidak boleh dikeluarkan dari tempat rasminya tanpa kebenaran bertulis daripada Presiden pada setiap kali ia hendak dikeluarkan.',
            'parent_constitution_template_id' => 817,
            'below_constitution_template_id' => 820,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'e) Ia hendaklah menyediakan penyata kewangan bagi setiap mesyuarat Majlis Jawatankuasa Tertinggi Konvensyen Persekutuan. ',
            'parent_constitution_template_id' => 817,
            'below_constitution_template_id' => 821,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'f) Ia hendaklah menandatangani segala cek bagi pihak Persekutuan bersama-sama dengan Presiden dan Setiausaha Agung Persekutuan.',
            'parent_constitution_template_id' => 817,
            'below_constitution_template_id' => 822,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '6. Penolong Bendahari Agung ',
            'parent_constitution_template_id' => 799,
            'below_constitution_template_id' => 817,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) Penolong Bendahari Agung hendaklah membantu Bendahari Agung dalam urusan penyimpanan dan catatan di buku-buku kewangan dan hendaklah menggantikannya pada masa ketiadaannya. ',
            'parent_constitution_template_id' => 824,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 14 - GAJI DAN BAYARAN-BAYARAN LAIN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 799,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '14.1 Gaji mana-mana pegawai dan kakitangan yang bekerja sepenuh masa dengan Persekutuan hendaklah ditetapkan oleh Konvensyen _Convention_Yearly_ Tahunan. ',
            'parent_constitution_template_id' => 826,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '14.2 Pegawai-pegawai Persekutuan yang dikehendaki berkhidmat separuh masa bagi pihak Persekutuan bolehlah diberi bayaran saguhati. Jumlah wang yang akan dibayar hendaklah diputuskan oleh Majlis Jawatankuasa Tertinggi.',
            'parent_constitution_template_id' => 826,
            'below_constitution_template_id' => 827,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '14.3 Pegawai-pegawai dan wakil-wakil Persekutuan bolehlah diberi bayaran kerana hilang masa kerjanya dan kerana telah membuat perbelanjaan yang berpatutan bagi menjalankan kerja-kerja Persekutuan jika diluluskan oleh Majlis Jawatankuasa Tertinggi. Suatu keterangan perbelanjaan yang berserta resit atau lain-lain keterangan pembayaran hendaklah dihantar kepada Majlis Jawatankuasa Tertinggi. Had maksima yang boleh dibayar di bawah perenggan ini hendaklah ditentukan dari masa ke semasa oleh Majlis Jawatankuasa Tertinggi dan tidak boleh mengesahkan sebarang bayaran yang melebihi had yang telah ditentukan itu.',
            'parent_constitution_template_id' => 826,
            'below_constitution_template_id' => 828,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 15 - KEWANGAN DAN KIRA-KIRA',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 826,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '15.1 Wang Persekutuan bolehlah dibelanjakan bagi perkara-perkara yang tersebut di bawah :-',
            'parent_constitution_template_id' => 830,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) Bayaran gaji, bayaran elaun dan perbelanjaan kepada pegawai-pegawai dan pekerja-pekerja Persekutuan.',
            'parent_constitution_template_id' => 831,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) Bayaran dan perbelanjaan pentadbiran Persekutuan termasuk bayaran audit kira-kira Persekutuan.',
            'parent_constitution_template_id' => 831,
            'below_constitution_template_id' => 832,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'c) Bayaran urusan pendakwaan atau pembelaan dalam perbicaraan perundangan mengenai sesuatu hal berhubung dengan Persekutuan atau anggota gabungan Persekutuan dengan tujuan hendak memperolehi atau mempertahankan hak Persekutuan atau sebarang hak yang terbit dari perhubungan di antara anggota gabungan Persekutuan dengan majikannya.',
            'parent_constitution_template_id' => 831,
            'below_constitution_template_id' => 833,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'd) Bayaran urusan mengenai pertikaian kerja bagi pihak Persekutuan atau anggotanya dengan syarat bahawa pertikaian kerja itu tidak bertentangan dengan Akta Kesatuan Sekerja 1959 atau undang-undang bertulis yang lain.',
            'parent_constitution_template_id' => 831,
            'below_constitution_template_id' => 834,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'e) Bayaran yuran gabungan mengenai pergabungan dengan atau keanggotaan pada mana-mana persekutuan kesatuan-kesatuan sekerja yang telah di daftarkan di bawah Bahagian XII Akta Kesatuan Sekerja 1959, atau mana-mana badan perunding atau badan yang serupa yang mana kelulusan telah diberi oleh Ketua Pengarah di bawah seksyen 76A (1) atau Ketua Pengarah Kesatuan Sekerja telah diberitahu di bawah seksyen 76A (2), Akta Kesatuan Sekerja 1959.',
            'parent_constitution_template_id' => 831,
            'below_constitution_template_id' => 835,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'f) Bayaran-bayaran yang tersebut di bawah :-',
            'parent_constitution_template_id' => 831,
            'below_constitution_template_id' => 836,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(i) Tambang-tambang keretapi, perbelanjaan pengangkutan lain yang perlu, perbelanjaan makan dan tempat tidur, yang disertakan resit atau sebanyak mana yang telah ditentukan oleh Persekutuan, mengikut hadhad yang ditentukan di bawah Peraturan ini.',
            'parent_constitution_template_id' => 837,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(ii) Bayaran jumlah kehilangan gaji yang sebenar oleh wakil Persekutuan kerana menghadiri mesyuarat-mesyuarat mengenai atau berhubung dengan hal perhubungan perusahaan atau menyempurnakan apa-apa perkara seperti diperlukan oleh Ketua Pengarah Kesatuan Sekerja berkaitan dengan Akta Kesatuan Sekerja 1959 atau Peraturanperaturannya, mengikut had-had yang ditentukan di bawah Peraturan 14. ',
            'parent_constitution_template_id' => 837,
            'below_constitution_template_id' => 838,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'g) Perbelanjaan urusan mengarang, mencetak, menerbit dan mengedar sebarang surat khabar, majalah, surat berita atau lain-lain penerbitan yang dikeluarkan oleh Persekutuan untuk menjayakan tujuan-tujuannya atau untuk faedah anggota-anggota gabungan menurut peraturan yang telah didaftarkan.',
            'parent_constitution_template_id' => 831,
            'below_constitution_template_id' => 837,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'h) Perbelanjaan yang dibuat untuk menyelesaikan pertikaian di bawah Bahagian VI Akta Kesatuan Sekerja 1959.',
            'parent_constitution_template_id' => 831,
            'below_constitution_template_id' => 840,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'i) Bayaran mengenai aktiviti-aktiviti sosial, sukan, pelajaran dan amal kebajikan bagi anggota gabungan.',
            'parent_constitution_template_id' => 831,
            'below_constitution_template_id' => 841,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'j) Pembayaran premium kepada syarikat-syarikat insurans (berdaftar di Malaysia). Pembayaran premium ini hendaklah diluluskan oleh Ketua Pengarah Kesatuan Sekerja dari semasa ke semasa.',
            'parent_constitution_template_id' => 831,
            'below_constitution_template_id' => 842,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '15.2 Wang Persekutuan tidak boleh digunakan secara langsung atau sebaliknya untuk membayar denda atau hukuman yang dikenakan oleh Mahkamah kepada sesiapa pun.',
            'parent_constitution_template_id' => 830,
            'below_constitution_template_id' => 831,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '15.3 Wang Persekutuan yang tidak dikehendaki untuk perbelanjaan biasa yang telah diluluskan hendaklah dimasukkan kedalam Bank oleh Bendahari Agung dalam tempoh tujuh (7) hari dari tarikh penerimaannya. Kira-kira Bank itu hendaklah di atas nama Persekutuan dan Ketua Pengarah Kesatuan Sekerja hendaklah dibekalkan maklumat-maklumat mengenai nama-nama Bank, nombor akaun Bank dan butir-butir lain. Pelantikan sesuatu bank itu hendaklah diluluskan oleh Majlis Jawatankuasa Tertinggi.',
            'parent_constitution_template_id' => 830,
            'below_constitution_template_id' => 844,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '15.4 Semua cek atau notis pengeluaran wang atas nama Persekutuan hendaklah ditandatangani bersama-sama oleh Presiden (dimasa ketiadaannya oleh Naib Presiden), Setiausaha Agung (dimasa ketiadaannya oleh Penolong Setiausaha Agung), dan Bendahari Agung (dimasa ketiadaannya oleh Penolong Bendahari Agung).',
            'parent_constitution_template_id' => 830,
            'below_constitution_template_id' => 845,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '15.5 Bendahari Agung dibenarkan menyimpan wang tunai tidak lebih dari _max_savings_text_ (RM _max_savings_ ) pada satu masa dan tidak dibenarkan membelanjakan lebih daripada _max_expenses_text_ (RM _max_expenses_ ) pada satu masa tanpa terlebih dahulu mendapat kebenaran Majlis Jawatankuasa Tertinggi. Bendahari Agung hendaklah menyediakan satu belanjawan tahunan untuk diluluskan dalam Konvensyen Persekutuan dan segala had yang dibenarkan oleh belanjawan itu. Belanjawan itu bolehlah dipinda dari semasa ke semasa dengan mendapat kelulusan terlebih dahulu di dalam Konvensyen Persekutuan atau dengan surat pekeliling.',
            'parent_constitution_template_id' => 830,
            'below_constitution_template_id' => 846,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '15.6 Semua harta Persekutuan hendaklah dimiliki atas nama Pemegang-pemegang Amanah Persekutuan. Wang Persekutuan yang tidak dikehendaki untuk urusan pentadbiran Persekutuan sehari-hari bolehlah :',
            'parent_constitution_template_id' => 830,
            'below_constitution_template_id' => 847,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) digunakan untuk membeli atau memajak sebarang tanah atau bangunan untuk kegunaan Persekutuan. Tanah atau bangunan ini tertakluk kepada sesuatu undang-undang bertulis atau undang-undang lain yang boleh dipakai, dipajak atau dengan persetujuan anggota-anggota gabungan persekutuan yang diperolehi melalui usul yang dibawa dalam Konvensyen Persekutuan boleh dijual, ditukar atau digadai;',
            'parent_constitution_template_id' => 848,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) dilaburkan dalam amanah saham (securities) atau dalam mana-mana pinjaman kepada mana-mana Syarikat mengikut mana-mana Undangundang yang berkaitan dengan pemegang amanah;',
            'parent_constitution_template_id' => 848,
            'below_constitution_template_id' => 849,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'c) disimpan di dalam Bank Simpanan Nasional atau dalam mana-mana Bank yang ditubuhkan atau didaftarkan di Malaysia atau dalam mana-mana Syarikat Kewangan yang merupakan anak syarikat bank tersebut; atau',
            'parent_constitution_template_id' => 848,
            'below_constitution_template_id' => 850,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'd) dengan mendapat kelulusan terlebih dahulu daripada Menteri Sumber Manusia dan tertakluk kepada syarat-syarat yang mungkin dikenakan oleh beliau, dilaburkan :- ',
            'parent_constitution_template_id' => 848,
            'below_constitution_template_id' => 851,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(i) dalam mana-mana Syarikat Kerjasama yang berdaftar; atau',
            'parent_constitution_template_id' => 852,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '(ii) dalam mana-mana pengusahaan perdagangan, perindustrian atau pertanian atau bank yang ditubuhkan dan berjalan urusannya di Malaysia.',
            'parent_constitution_template_id' => 852,
            'below_constitution_template_id' => 853,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '15.7 Semua belian dan pelaburan-pelaburan di bawah Peraturan ini hendaklah diluluskan terlebih dahulu oleh Majlis Jawatankuasa Tertinggi dan dibuat atas nama Pemegang-pemegang Amanah Persekutuan. Pemegang-pemegang Amanah hendaklah memegang saham-saham atau pelaburan-pelaburan bagi pihak anggota gabungan. Kelulusan ini hendaklah disahkan oleh Konvensyen Persekutuan yang akan datang.',
            'parent_constitution_template_id' => 830,
            'below_constitution_template_id' => 848,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '15.8 Bendahari Agung hendaklah menulis atau menguruskan supaya ditulis di dalam buku kira-kira Persekutuan sebarang keterangan penerimaan dan pembayaran wang Persekutuan dan sebarang hasil dari pelaburan. Apabila ia berhenti atau meletak jawatan atau pekerjaannya pada atau sebelum 1hb Oktober setiap tahun, dan pada bila-bila masa ia dikehendaki berbuat demikian oleh Majlis Jawatankuasa Tertinggi atau melalui suatu ketetapan yang dibuat oleh Konvensyen Persekutuan atau Konvensyen Khas Persekutuan atau apabila dikehendaki oleh Ketua Pengarah Kesatuan Sekerja maka hendaklah ia menyerahkan kepada Persekutuan dan anggota gabungan atau kepada Ketua Pengarah Kesatuan Sekerja, mana-mana kehendak yang berkaitan, suatu kenyataan yang sah lagi betul perihal sekalian wang yang diterima dan dibayarnya dari tempoh ia mula memegang jawatan itu, atau jika ia telah pernah membentangkan kira-kira terlebih dahulu, maka dari tarikh kira-kira dahulu itu dibentangkan. Beliau hendaklah juga menyatakan baki wang ditangannya pada masa ia menyerah kira-kira itu dan semua bon dan jaminan (securities) atau lain-lain Persekutuan di dalam simpanan atau jagaannya.',
            'parent_constitution_template_id' => 830,
            'below_constitution_template_id' => 855,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '15.9 Borang yang akan digunakan untuk membentangkan kira-kira itu ialah sebagaimana yang ditentukan oleh Peraturan-peraturan Kesatuan Sekerja 1959. Kira-kira itu hendaklah diaudit menurut Peraturan 16 dan 17. Sesudah sahaja kira-kira itu diaudit maka Bendahari Agung hendaklah menyerah kepada Pemegang-pemegang Amanah Persekutuan jika dikehendaki oleh mereka itu, semua bon dan jaminan, perkakasan, buku-buku, surat dan harta Persekutuan yang ada di dalam simpanan atau jagaannya. ',
            'parent_constitution_template_id' => 830,
            'below_constitution_template_id' => 856,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 16- JURUAUDIT DALAM',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 830,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '16.1 Dua orang juruaudit dalam yang bukan menjadi anggota Majlis Jawatankuasa Tertinggi hendaklah dilantik secara angkat tangan dalam Konvensyen Persekutuan _Convention_Yearly_ Tahunan. Mereka itu hendaklah memeriksa kira-kira Persekutuan pada penghujung setiap tiga (3) bulan dan menyampaikan penyataannya kepada Setiausaha Agung yang akan menghantar satu salinan penyata itu kepada tiap-tiap anggota Majlis Jawatankuasa Tertinggi dalam masa empat belas (14) hari setelah diterimanya. ',
            'parent_constitution_template_id' => 858,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '16.2 Buku-buku dan kira-kira Persekutuan hendaklah diaudit bersama oleh keduadua juruaudit itu dan mereka itu berhak melihat semua buku-buku dan suratsurat keterangan yang perlu untuk menyempurnakan tugas mereka.',
            'parent_constitution_template_id' => 858,
            'below_constitution_template_id' => 859,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '16.3 Anggota gabungan Persekutuan bolehlah mengadu secara bersurat kepada Juruaudit Dalam mengenai sebarang hal kewangan yang tidak betul, yang telah sampai kepada pengetahuan mereka.',
            'parent_constitution_template_id' => 858,
            'below_constitution_template_id' => 860,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '16.4 Apabila berlaku apa-apa kekosongan jawatan ini oleh sebarang sebab di antara dua Konvensyen Persekutuan ia bolehlah diisi dengan cara lantikan oleh Majlis Jawatankuasa Tertinggi. ',
            'parent_constitution_template_id' => 858,
            'below_constitution_template_id' => 861,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 17 - PERLANTIKAN JURUAUDIT LUAR',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 858,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '17.1 Persekutuan hendaklah melantik seorang Juruaudit Luar bertauliah dan seterusnya memperolehi kelulusan Ketua Pengarah Kesatuan Sekerja bagi pelantikan ini. Juruaudit ini hendaklah seorang Akauntan yang memperolehi kebenaran bertulis daripada Kementerian Kewangan untuk mengaudit kira-kira syarikat-syarikat di bawah Akta Syarikat. Juruaudit ini hendaklah mengaudit Dokumen-dokumen dan akaun ini.',
            'parent_constitution_template_id' => 863,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '17.2 Dokumen-dokumen dan akaun Persekutuan yang diaudit itu hendaklah diakui benar oleh Juruaudit Luar dengan Surat Sumpah (Statutory Declaration).',
            'parent_constitution_template_id' => 863,
            'below_constitution_template_id' => 864,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '17.3 Dokumen-dokumen dan akaun Persekutuan hendaklah diaudit dengan segera selepas sahaja ditutup tahun kewangan Persekutuan pada 31 Mac dan hendaklah selesai sebelum 31 Ogos tiap-tiap tahun.',
            'parent_constitution_template_id' => 863,
            'below_constitution_template_id' => 865,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '17.4 Dokumen-dokumen dan akaun Persekutuan yang diaudit itu dan laporan Juruaudit Luar, hendaklah dibentangkan untuk kelulusan di dalam Konvensyen Persekutuan dan satu salinan penyata hendaklah di hantar kepada tiap-tiap anggota gabungan sebelum Konvensyen itu.',
            'parent_constitution_template_id' => 863,
            'below_constitution_template_id' => 866,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '17.5 Dokumen-dokumen dan akaun Persekutuan yang diaudit hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja berserta dengan "Borang N" sebelum 1 Oktober tiap-tiap tahun.',
            'parent_constitution_template_id' => 863,
            'below_constitution_template_id' => 867,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 18 - JEMAAH PEMERIKSA UNDI',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 863,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '18.1 Satu Jemaah Pemeriksa Undi yang terdiri daripada lima orang anggota hendaklah dipilih secara angkat tangan dalam Konvensyen Persekutuan untuk mengendalikan segala perjalanan undi rahsia. Mereka hendaklah bukan pegawai Persekutuan atau calon bagi pemilihan pegawai-pegawai Persekutuan. Seboleh-bolehnya anggota yang dipilih ini hendaklah anggotaanggota yang tinggal di sekitar kawasan Ibu Pejabat Persekutuan.',
            'parent_constitution_template_id' => 869,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '18.2 Jemaah Pemeriksa Undi ini akan berkhidmat dari satu Konvensyen Persekutuan _Convention_Yearly_ Tahunan ke Konvensyen Persekutuan _Convention_Yearly_ Tahunan yang berikutnya. Apabila berlaku kekosongan, kekosongan ini hendaklah diisi dengan cara lantikan oleh Majlis Jawatankuasa Tertinggi sehingga Konvensyen yang akan datang.',
            'parent_constitution_template_id' => 869,
            'below_constitution_template_id' => 870,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '18.3 Sekurang-kurangnya tiga orang Pemeriksa Undi hendaklah hadir apabila pembuangan undi dijalankan. Mereka hendaklah memastikan bahawa aturcara yang tertera di dalam Kembaran kepada Peraturan ini dipatuhi dengan sepenuhnya.',
            'parent_constitution_template_id' => 869,
            'below_constitution_template_id' => 871,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 19 - PEMERIKSAAN DOKUMEN DAN AKAUN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 869,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '19.1 Dokumen-dokumen dan akaun Persekutuan serta pendaftaran anggota gabungannya boleh dibuka untuk pemeriksaan oleh semua wakil yang berkelayakan daripada anggota-anggota gabungan atau orang-orang yang ada kepentingan dalam wang Persekutuan dengan menyampaikan notis sekurangkurangnya 14 hari kepada Setiausaha Agung mengenai keinginan dan niatnya melakukan pemeriksaan itu.',
            'parent_constitution_template_id' => 873,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 20 - PEMEGANG-PEMEGANG AMANAH',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 873,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '20.1 Tiga orang Pemegang Amanah yang umurnya tidak kurang dari 21 tahun dan bukan seorang Setiausaha Agung atau Bendahari Agung Persekutuan hendaklah dilantik atau dipilih di dalam Konvensyen Persekutuan yang pertama. Mereka itu akan menyandang jawatan itu selama yang dikehendaki oleh Persekutuan. Sebarang harta (tanah, bangunan, pelaburan dan lain-lain) yang dimiliki oleh Persekutuan hendaklah diserahkan kepada mereka itu untuk diuruskan sebagaimana yang diarahkan oleh Majlis Jawatankuasa Tertinggi.',
            'parent_constitution_template_id' => 875,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '20.2 Pemegang Amanah tidak boleh menjual, menarik balik atau memindahkan milik sebarang harta Persekutuan tanpa persetujuan dan kuasa daripada Majlis Jawatankuasa Tertinggi yang diberi dengan bertulis oleh Setiausaha Agung dan Bendahari Agung Persekutuan.',
            'parent_constitution_template_id' => 875,
            'below_constitution_template_id' => 876,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '20.3 Seseorang Pemegang Amanah boleh dilucutkan jawatannya oleh Majlis Jawatankuasa Tertinggi kerana tidak sihat, tidak sempurna akal, tidak berada dalam negara atau kerana sebarang sebab lain yang menyebabkan ia tidak boleh menjalankan tugasnya atau tidak dapat menyempurnakan tugasnya dengan memuaskan hati. Jika seseorang Pemegang Amanah itu meninggal dunia, berhenti atau diberhentikan diantara dua Konvensyen Persekutuan, maka kekosongan itu hendaklah diisi oleh mana-mana anggota yang dilantik oleh Majlis Jawatankuasa Tertinggi sehingga disahkan dalam Konvensyen Persekutuan yang akan datang.',
            'parent_constitution_template_id' => 875,
            'below_constitution_template_id' => 877,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '20.4 Konvensyen Persekutuan boleh melantik sebuah syarikat pemegang amanah seperti yang diterangkan di dalam Akta Syarikat Amanah 1949 (Trust Companies Act 1949) atau undang-undang lain yang bertulis yang mengawal syarikat-syarikat pemegang amanah di Malaysia, untuk menjadi pemegang amanah yang tunggal bagi Persekutuan ini. Jika syarikat pemegang amanah seperti yang tersebut itu dilantik maka rujukan “pemegang amanah“ di dalam Peraturan ini hendaklah difahamkan sebagai syarikat pemegang amanah yang dilantik.',
            'parent_constitution_template_id' => 875,
            'below_constitution_template_id' => 878,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '20.5 Butir-butir mengenai Pemegang Amanah atau apa-apa pertukaran mengenainya hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja dalam tempoh 14 hari selepas pelantikan atau pemilihan itu atau pertukaran berkenaan untuk pendaftaran. Pelantikan atau pemilihan ini tidak boleh berkuatkuasa sehingga didaftarkan oleh Ketua Pengarah Kesatuan Sekerja.',
            'parent_constitution_template_id' => 875,
            'below_constitution_template_id' => 879,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 21 - URUSAN DENGAN ANGGOTA-ANGGOTA KESATUAN GABUNGAN ',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 875,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '21.1 Semua urusan berkenaan dengan anggota gabungan akan dijalankan melalui Majlis Jawatankuasa Tertinggi atau badan lain yang menjaga hal ehwal setiap anggota gabungan. Semua surat menyurat akan di alamatkan kepada Setiausaha anggota gabungan dan sebaliknya dari Setiausaha anggota gabungan atau lain-lain pegawai yang sah anggota gabungan kepada Setiausaha Agung Persekutuan.',
            'parent_constitution_template_id' => 881,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '21.2 Anggota perseorangan dari mana-mana anggota gabungan tidak berhak membuat apa-apa permintaan terus atau mempunyai apa-apa hak sedemikian terhadap Persekutuan. ',
            'parent_constitution_template_id' => 881,
            'below_constitution_template_id' => 882,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 22 - ATURAN MENYELENGGARAKAN KESALAHAN-KESALAHAN ANGGOTA GABUNGAN ',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 881,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '22.1 Sekiranya mana-mana anggota gabungan gagal mematuhi mana-mana permintaan dari Majlis Jawatankuasa Tertinggi atau menjalankan apa-apa tugas yang patut dijalankan di bawah Peraturan-peraturan ini atau pada pendapat Majlis Jawatankuasa Tertinggi mana-mana anggota gabungan menjalankan tindakan yang bercanggah dengan Peraturan-peraturan ini atau dengan cara yang merugikan kepentingan kesatuan sekerja amnya, maka Majlis Jawatankuasa Tertinggi akan mengambil tindakan mengikut peraturan.',
            'parent_constitution_template_id' => 884,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '22.2 Apa-apa keputusan Majlis Jawatankuasa Tertinggi di bawah Peraturan ini akan tertakluk kepada rayuan kepada Konvensyen Persekutuan.',
            'parent_constitution_template_id' => 884,
            'below_constitution_template_id' => 885,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '22.3 Notis mengenai keinginan merayu itu hendaklah dikemukakan oleh anggota gabungan itu dalam masa 21 hari setelah keputusan itu dibuat dan rayuan itu akan dibawa ke Konvensyen Persekutuan yang akan datang selepas notis diterima.',
            'parent_constitution_template_id' => 884,
            'below_constitution_template_id' => 886,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '22.4 Konvensyen Persekutuan mempunyai kuasa penuh untuk mendengar semua perkara, mengubah atau meminda keputusan Majlis Jawatankuasa Tertinggi mengenai kesalahan dan hukuman, seperti berikut:-',
            'parent_constitution_template_id' => 884,
            'below_constitution_template_id' => 887,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) Pemberitahuan atas kesalahan itu akan disampaikan kepada Setiausaha kesatuan gabungan yang berkenaan;',
            'parent_constitution_template_id' => 888,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) Ia akan juga mengarahkan kesatuan gabungan itu melantik wakil-wakil Majlis Jawatankuasa Kerjanya menghadiri mesyuarat Majlis Jawatankuasa Tertinggi yang akan datang; dan',
            'parent_constitution_template_id' => 888,
            'below_constitution_template_id' => 889,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'c) Keputusan Majlis Jawatankuasa Tertinggi yang telah mengendalikan kes kesalahan kesatuan gabungan dan seterusnya memecat keanggotaan daripada Persekutuan atau mengenakan apa-apa tindakan lain.',
            'parent_constitution_template_id' => 888,
            'below_constitution_template_id' => 890,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 23- PERJANJIAN DAN PERTIKAIAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 884,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '23.1 Kuasa eksekutif kesatuan terletak di tangan Majlis Jawatankuasa Kerja kesatuan anggota gabungan masing-masing. Persekutuan tidak ada kuasa untuk campur tangan bagi maksud atau tujuan sah Kesatuan sebagaimana yang dinyatakan dalam peraturan-peraturan kesatuan gabungan.',
            'parent_constitution_template_id' => 892,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '23.2 Sebarang pertikaian di antara sebuah kesatuan gabungan dengan majikan akan diselenggarakan pada peringkat awalnya oleh kesatuan sekerja berkenaan mengikut peraturan dan arahan Majlis Jawatankuasa Kerja. Persekutuan bagaimanapun, atas permintaan kesatuan gabungan itu, boleh campurtangan dalam apa-apa pertikaian di antara anggota gabungan dengan majikan dan berunding bagi pihak anggota gabungan dan anggota-anggotanya dan apa-apa perjanjian yang dimeteraikan dengan persetujuan kesatuan berkenaan akan dipatuhi oleh anggota gabungan itu.',
            'parent_constitution_template_id' => 892,
            'below_constitution_template_id' => 893,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '23.3 Majlis Jawatankuasa Tertinggi Persekutuan mempunyai kuasa ke atas sebarang pertikaian perusahaan untuk menyiasat perkara yang dipertikaikan bertujuan mencari satu penyelesaian. Jika tidak tercapai penyelesaian dan tindakan mogok dipersetujui, maka anggota gabungan hendaklah mengikut Peraturan - peraturan anggota gabungan itu dan atas perintah yang dinyatakan oleh Majlis Jawatankuasa Kerja anggota gabungan yang berkenaan.',
            'parent_constitution_template_id' => 892,
            'below_constitution_template_id' => 894,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '23.4 Sekiranya satu pertikaian berbangkit maka Persekutuan akan berusaha membantu anggota gabungan yang terlibat dari segi kewangan atau dengan apa-apa cara yang sah.',
            'parent_constitution_template_id' => 892,
            'below_constitution_template_id' => 895,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '23.5 Persekutuan tidak akan mengambil apa-apa tindakan atau menyetujui apa-apa keputusan yang bercanggah dengan maksud-maksud dan tujuan-tujuan Persekutuan atau anggota gabungan.',
            'parent_constitution_template_id' => 892,
            'below_constitution_template_id' => 896,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '23.6 Semua perjanjian atau dokumen yang dimeteraikan oleh Persekutuan bagi pihak anggota gabungan akan ditandatangani oleh dua orang wakil yang dipersetujui oleh Majlis Jawatankuasa Tertinggi Persekutuan dan dua orang wakil anggota gabungan yang dipersetujui oleh Majlis Jawatankuasa Kerja kesatuan yang diwakili itu. Cap-cap Persekutuan dan anggota gabungan akan diperturunkan di atas perjanjian-perjanjian atau dokumen-dokumen itu.',
            'parent_constitution_template_id' => 892,
            'below_constitution_template_id' => 897,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 24 - PERTIKAIAN DI ANTARA ANGGOTA-ANGGOTA GABUNGAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 892,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '24.1 Persekutuan atas permintaan sebuah atau lebih anggota gabungannya, mempunyai kuasa untuk campurtangan dalam mana-mana pertikaian dan cuba menyelesaikan pertikaian di antara sebuah anggota Gabungan dengan anggota gabungan yang lain.',
            'parent_constitution_template_id' => 899,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '24.2 Dalam apa-apa pertikaian yang berbangkit di antara anggota gabungan, anggota gabungan berkenaan akan melaporkan kepada Majlis Jawatankuasa Tertinggi, yang mempunyai kuasa penuh untuk mengendalikan pertikaian tersebut dan cuba untuk menyelesaikannya.',
            'parent_constitution_template_id' => 899,
            'below_constitution_template_id' => 900,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '24.3 Anggota gabungan berkenaan berhak merayu kepada Konvensyen Persekutuan di atas keputusan-keputusan yang dibuat oleh Majlis Jawatankuasa Tertinggi. Konvensyen Persekutuan mempunyai hak untuk menarik balik, mengubah atau meluluskan keputusan-keputusan Majlis Jawatankuasa Tertinggi itu dan keputusan Konvensyen Persekutuan adalah muktamad. Pada masa yang sama juga, anggota-anggota kepada anggota gabungan boleh meneruskan aktiviti seperti biasa dalam tempoh pertikaian tersebut.',
            'parent_constitution_template_id' => 899,
            'below_constitution_template_id' => 901,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 25- PINDAAN PERATURAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 899,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '25.1 Usul-usul untuk meminda Peraturan hendaklah dikemukakan kepada Setiausaha Agung. Semua usul untuk pindaan kepada Peraturan akan diselenggarakan oleh Majlis Jawatankuasa Tertinggi dan akan berkuatkuasa selepas didaftarkan oleh Ketua Pengarah Kesatuan Sekerja.',
            'parent_constitution_template_id' => 903,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '25.2 Pindaan peraturan yang akan menyebabkan beratnya lagi tanggungan anggota gabungan untuk mencarum atau kurangnya faedah yang akan didapatinya hanya boleh dibuat jika diluluskan oleh anggota-anggota gabungan dengan undi rahsia. Peraturan-peraturan lain bolehlah dipinda dengan kelulusan Konvensyen Persekutuan atau dengan undi rahsia.',
            'parent_constitution_template_id' => 903,
            'below_constitution_template_id' => 904,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '25.3 Tiap-tiap pindaan Peraturan hendaklah berkuatkuasa dari tarikh pindaan itu didaftarkan oleh Ketua Pengarah Kesatuan Sekerja kecuali jika suatu tarikh yang terkemudian dari itu ada ditentukan di dalam Peraturan-peraturan ini.',
            'parent_constitution_template_id' => 903,
            'below_constitution_template_id' => 905,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '25.4 Satu naskah Peraturan Persekutuan yang dicetak dalam Bahasa Malaysia hendaklah dipamerkan di suatu tempat yang mudah dilihat di Pejabat Persekutuan yang didaftarkan. Setiausaha Agung Persekutuan hendaklah memberi senaskah peraturan Persekutuan kepada sesiapa juga yang memintanya dengan bayaran RM10.00.',
            'parent_constitution_template_id' => 903,
            'below_constitution_template_id' => 906,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 26- PENGUNDIAN DALAM KONVENSYEN PERSEKUTUAN DAN PERATURAN MENGUNDI',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 903,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '26.1 Keputusan-keputusan berkenaan dengan perkara-perkara yang tersebut di bawah ini hendaklah dibuat dengan undi rahsia oleh semua anggota berhak kepada anggota gabungan dengan syarat mereka di bawah umur 18 tahun, tidak boleh mengambil bahagian dalam pengundian atas perkara-perkara (a), (b), dan (c):-',
            'parent_constitution_template_id' => 908,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'a) mengenakan yuran khas;',
            'parent_constitution_template_id' => 909,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'b) membubarkan Persekutuan;',
            'parent_constitution_template_id' => 909,
            'below_constitution_template_id' => 910,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'c) pindaan kepada peraturan di mana pindaan itu menyebabkan bertambahnya tanggungan pembayaran anggota-anggota gabungan atau mengurangkan faedah-faedah yang didapati; dan',
            'parent_constitution_template_id' => 909,
            'below_constitution_template_id' => 911,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'd) apa-apa perkara lain jika diputuskan oleh Konvensyen Persekutuan.',
            'parent_constitution_template_id' => 909,
            'below_constitution_template_id' => 912,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '26.2 Undi rahsia hendaklah dijalankan sebagaimana yang dinyata di dalam Kembaran "A".',
            'parent_constitution_template_id' => 908,
            'below_constitution_template_id' => 909,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => 'PERATURAN 27- PEMBUBARAN',
            'parent_constitution_template_id' => NULL,
            'below_constitution_template_id' => 908,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '27.1 Persekutuan ini tidak boleh dibubarkan dengan sendirinya melainkan dengan persetujuan melalui undi rahsia tidak kurang daripada 75 % daripada jumlah anggota anggota gabungan yang berhak mengundi.',
            'parent_constitution_template_id' => 915,
            'below_constitution_template_id' => NULL,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '27.2 Jika sekiranya Persekutuan ini dibubarkan seperti yang tersebut di atas maka semua hutang dan tanggungan yang dibuat dengan cara sah oleh Persekutuan hendaklah dijelaskan dengan sepenuhnya dan baki wang yang tinggal hendaklah dibahagikan di antara anggota gabungan atas dasar purata bergantung pada bilangan tahun menjadi anggota gabungan serta jumlah yuran yang telah dibayar.',
            'parent_constitution_template_id' => 915,
            'below_constitution_template_id' => 916,
            'constitution_type_id' => 3,
        ]);

        DB::table('master_constitution_template')->insert([
            'code' => uniqid(),
            'content' => '27.3 Notis pembubaran dan dokumen-dokumen lain sebagaimana di kehendaki oleh Peraturan-peraturan Kesatuan Sekerja 1959 hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja dalam tempoh 14 hari selepas pembubaran. Pembubaran itu hanya berkuatkuasa dari tarikh pendaftarannya oleh Ketua Pengarah Kesatuan Sekerja.',
            'parent_constitution_template_id' => 915,
            'below_constitution_template_id' => 917,
            'constitution_type_id' => 3,
        ]);

    }
}
