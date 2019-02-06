<style>
#document table {
	width: 100%;
	margin-top: 20px;
}
#document td {
	text-align: justify;
}

#document .collapse {
	border-collapse: collapse;
}

#document .justify {
	text-align: justify;
}
#document .parent {
	position: relative;
}
#document .child {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
}
#document .bold {
	font-weight: bold;
}
#document .border {
	border: 1px solid black;
}
#document .uppercase {
	text-transform: uppercase;
}
#document .lowercase {
	text-transform: lowercase;
}
#document .italic {
	font-style: italic;
}
#document .camelcase {
	text-transform: capitalize;
}
#document .left {
	text-align: left !important;
}
#document .center {
	text-align: center !important;
}
#document .right {
	text-align: right !important;
}
#document .break {
	page-break-before: always;
	margin-top: 25px;
}
#document .divider {
	width: 5px;
	vertical-align: top;
}
#document .no-padding {
	padding: 0px;
}
#document .padding-30 {
	padding: 30px;
}
#document .fit {
	max-width:100%;
	white-space:nowrap;
}
#document .absolute-center {
	margin: auto;
	position: absolute;
	top: 0; left: 0; bottom: 0; right: 0;
}
#document .top {
	vertical-align: top;
}
#document .dotted{
    border-bottom: 2px dotted black;
    margin-bottom:3px;
}
#document .margin-custom {
	margin: 150px;
}
#document .margin-50 {
	margin: 50px;
}
#document .bottom {
	padding-bottom: 5cm;
}
#document .height26 {
	height: 26;
}
</style>

<div id="document">
	<div style="text-align: center;">
		<span class="uppercase bold center">PERATURAN-PERATURAN</span><br><br>
		<span class="uppercase bold center"><span class="entity_name">{{ $formb->union->name }}</span></span>
	</div><br><br>
	<div class="bold uppercase left">PERATURAN 1&nbsp; - &nbsp;NAMA DAN ALAMAT PEJABAT BERDAFTAR</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Nama Kesatuan Sekerja yang ditubuhkan menurut Peraturan-peraturan ini ialah <b><span class="entity_name">{{ strtoupper($formb->union->name) }}</span> (yang selepas ini disebut 'Kesatuan')</b><br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Pejabat berdaftar kesatuan ialah <span class="uppercase entity_address">{{ strtoupper($formb->address->address1.
	    	($formb->address->address2 ? ', '.$formb->address->address2 : '').
	    	($formb->address->address3 ? ', '.$formb->address->address3 : '').', '.
	    	$formb->address->postcode.' '.
	    	($formb->address->district ? $formb->address->district->name : '').', '.
	    	($formb->address->state ? $formb->address->state->name : '')) }}</span> dan tempat mesyuaratnya ialah di pejabat berdaftar ini atau di mana-mana tempat lain yang ditetapkan oleh Majlis Jawatankuasa Kerja.</td>
		</tr>
	</table>
	<br><br>
	<div class="bold uppercase left">PERATURAN 2 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; TUJUAN</div>
	<br>
	<div class="left">(1)&nbsp;&nbsp;&nbsp;Tujuan Kesatuan ini ialah untuk :-</div>

	<table class="justify" width="">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Mengorganisasikan pekerja-pekerja yang disebut di bawah Peraturan 3(1) sebagai anggota Kesatuan dan memajukan kepentingan mereka dalam bidang perhubungan perusahaan, kemasyarakatan dan ilmu pengetahuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>Mengatur perhubungan di antara pekerja dengan majikan bagi maksud melaksanakan perhubungan perusahaan yang baik dan harmoni, meningkatkan daya pengeluaran dan memperolehi serta mengekalkan bagi anggota-anggotanya keselamatan pekerjaan, sukatan gaji yang adil dan sesuai serta syarat-syarat pekerjaan yang berpatutan<br>&nbsp;.</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>Mengatur perhubungan di antara anggota dengan anggota atau di antara anggota-anggota dengan pekerja-pekerja lain, di antara anggota dengan Kesatuan atau pegawai Kesatuan, atau di antara pegawai Kesatuan dengan Kesatuan dan menyelesaikan sebarang perselisihan atau pertikaian di antara mereka itu dengan cara aman dan bermuafakat atau melalui jentera penimbangtara menurut Peraturan 26 atau Peraturan 27.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>Memajukan kebajikan anggota-anggota Kesatuan dari segi sosial, ekonomi dan pendidikan dengan cara yang sah di sisi undang-undang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>Memberi bantuan guaman kepada anggota-anggota berhubung dengan pekerjaan mereka jika dipersetujui oleh Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>Memberi bantuan seperti pembiayaan semasa teraniaya atau semasa pertikaian perusahaan jika dipersetujui oleh Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(g)&nbsp;&nbsp;&nbsp;</td>
			<td>Menganjurkan dan mengendalikan kursus, dialog, seminar dan sebagainya untuk faedah anggota-anggota Kesatuan khasnya dan para pekerja amnya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(h)&nbsp;&nbsp;&nbsp;</td>
			<td>Mengendalikan urusan mengarang, menyunting, mencetak, menerbit dan mengedarkan sebarang jurnal, majalah, buletin atau penerbitan lain untuk menjayakan tujuan-tujuan Kesatuan ini atau untuk kepentingan anggota-anggota Kesatuan jika dipersetujui oleh Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(i)&nbsp;&nbsp;&nbsp;</td>
			<td>Menubuhkan Tabung Wang Kebajikan dan menggubalkan peraturan-peraturan tambahan untuk mentadbir dan mengawal tabung itu jika dipersetujui oleh Mesyuarat Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(j)&nbsp;&nbsp;&nbsp;</td>
			<td>Secara amnya melaksanakan sebarang tujuan Kesatuan Sekerja yang sah di sisi undang-undang.</td>
		</tr>
	</table>

	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Tujuan yang dinyatakan di bawah Peraturan 2 (1) hendaklah dilaksanakan menurut peraturan-peraturan ini, Akta Kesatuan Sekerja 1959 dan undang-undang bertulis yang lain yang ada kaitan.</td>
		</tr>
	</table><br>


	<div class="bold uppercase left">PERATURAN 3 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; ANGGOTA KESATUAN</div>

	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Keanggotaan kesatuan ini terbuka kepada <span class="membership_target">.................................</span> yang digaji oleh <span class="paid_by">................................</span> kecuali mereka yang memegang jawatan pengurusan, eksekutif, sulit atau keselamatan. Pekerja-pekerja itu hendaklah berumur lebih dari 16 tahun dan mempunyai tempat kerjanya di <span class="workplace">......... (Semenanjung Malaysia/ Sabah/ Sarawak)</span> tertakluk kepada syarat bahawa seseorang yang diuntukkan pendidikan dalam sesuatu sekolah, politeknik, kolej, universiti, kolej universiti atau institusi lain yang ditubuhkan di bawah mana-mana undang-undang bertulis tidak boleh menjadi anggota Kesatuan kecuali sekiranya ia :-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Sebenarnya seseorang pekerja menurut takrif dalam Akta Kesatuan Sekerja 1959; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>Berumur lebih daripada 18 tahun</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Permohonan untuk menjadi anggota hendaklah dilakukan dengan mengisi borang yang ditentukan oleh Kesatuan dan menyampaikannya kepada Setiausaha. Setiausaha hendaklah mengemukakan permohonan itu kepada Majlis Jawatankuasa Kerja untuk kelulusan. Majlis Jawatankuasa Kerja hendaklah memaklumkan keputusan permohonan tersebut kepada pemohon.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah permohonan seseorang itu diluluskan oleh Majlis Jawatankuasa Kerja dan yuran masuk serta yuran bulanan yang pertama dijelaskan maka namanya hendaklah didaftarkan dalam Daftar Yuran/Keanggotaan sebagai anggota.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang anggota itu hendaklah diberikan senaskah buku Peraturan-peraturan Kesatuan dengan percuma apabila diterima sebagai anggota.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(5)&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang yang diterima masuk menjadi anggota dan kemudian berhenti daripada tempat kerjanya, tred atau industri seperti dinyatakan dalam Peraturan 3(1) akan dengan sendirinya terhenti dari menjadi anggota Kesatuan. Namanya hendaklah dikeluarkan daripada Daftar Yuran / Keanggotaan tertakluk kepada peruntukan berkenaan di bawah Peraturan Tambahan Tabung Wang Kebajikan (jika ada).<br>&nbsp;</td>
		</tr>
	</table>
	<br>
	<div class="bold uppercase left">PERATURAN 4 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; YURAN DAN TUNGGAKAN</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Tujuan Kesatuan ini ialah untuk :-<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;"> &nbsp;&nbsp;&nbsp;</td>
			<td>Yuran Masuk &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RM <span class="entrance_fee">.........</span></td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;"> &nbsp;&nbsp;&nbsp;</td>
			<td>Yuran Bulanan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RM <span class="monthly_fee">.........</span></td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">&nbsp;&nbsp;&nbsp;</td>
			<td>Sebarang kenaikan yuran hendaklah diputuskan dengan undi rahsia menurut Peraturan 25.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Yuran bulanan hendaklah dijelaskan sebelum tujuh (7) haribulan pada tiap-tiap bulan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang anggota yang terhutang yuran selama tiga (3) bulan berturut-turut akan dengan sendirinya terhenti daripada menjadi anggota Kesatuan. Haknya dalam Kesatuan akan hilang dan namanya hendaklah dipotong dari Daftar Yuran / Keanggotaan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang yang terhenti daripada menjadi anggota kerana tunggakan yuran boleh memohon semula untuk menjadi anggota menurut Peraturan 3 (2).<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(5)&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Kerja berkuasa menetapkan kadar bayaran yuran bulanan yang kurang atau mengecualikan buat sementara waktu mana-mana anggota daripada bayaran yuran bulanan atau sebarang kutipan atau yuran khas (jika ada):-<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(6)&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang yang terhenti daripada menjadi anggota kerana tunggakan yuran boleh memohon semula untuk menjadi anggota menurut Peraturan 3 (2).</td>
		</tr>
	</table>
	<table class="justify" width="">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>jika dia jatuh sakit teruk atau ditimpa kesusahan yang berat;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>dia dibuang kerja, diberhentikan atau diketepikan dan masih menunggu keputusan sesuatu perundingan atau perbicaraan tentang pembuangan kerja, pemberhentian atau pengenepian itu; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>kerana sebarang sebab lain yang difikirkan munasabah dan wajar oleh Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
	</table><br>

	<div class="bold uppercase left">PERATURAN 5 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; BERHENTI MENJADI ANGGOTA</div><br>

	<div class="left justify">Seseorang anggota yang ingin berhenti menjadi anggota Kesatuan hendaklah memberi notis secara bertulis sekurang-kurangnya seminggu sebelum tarikh berhenti kepada Setiausaha dan hendaklah menjelaskan terlebih dahulu semua tunggakan yuran dan hutang (jika ada). Nama anggota berkenaan hendaklah dipotong dari Daftar Yuran / Keanggotaan.</div><br>

	<div class="bold uppercase left">PERATURAN 6 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; HAK ANGGOTA</div><br>
	<div class="left justify">Semua anggota mempunyai hak yang sama dalam kesatuan kecuali dalam perkara-perkara tertentu yang dinyatakan di dalam peraturan-peraturan ini.</div><br>

	<div class="bold uppercase left">PERATURAN 7 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; KEWAJIPAN DAN TANGGUNGJAWAB ANGGOTA-ANGGOTA</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Setiap anggota hendaklah menjelaskan yurannya menepati masa dan mendapatkan resit rasmi bagi bayarannya itu. Pembayaran yuran bulanan dalam tempoh masa yang ditetapkan adalah menjadi tanggungjawab setiap anggota dan bukannya tanggungjawab pegawai-pegawai Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Setiap anggota hendaklah memberitahu Setiausaha dengan segera apabila berpindah tempat tinggal atau bertukar tempat kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang anggota yang menghadiri mesyuarat Kesatuan atau menggunakan pejabat Kesatuan hendaklah berkelakuan baik, jika tidak ia akan diarah keluar oleh seorang pegawai Kesatuan yang bertanggungjawab.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang anggota tidak boleh mengeluarkan sebarang dokumen atau surat pekeliling tentang Kesatuan tanpa mendapat kelulusan Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(5)&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang anggota tidak boleh mendedahkan sebarang hal tentang kegiatan Kesatuan kepada orang yang bukan anggota atau kepada pertubuhan lain atau pihak akhbar tanpa mendapat izin Majlis Jawatankuasa Kerja.</td>
		</tr>
	</table><br>

	<div class="bold uppercase left">PERATURAN 8 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PERLEMBAGAAN DAN PENTADBIRAN</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Kuasa yang tertinggi sekali di dalam Kesatuan terletak kepada Mesyuarat Agung melainkan perkara-perkara yang hendaklah diputuskan melalui undi rahsia menurut Peraturan 25.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Tertakluk kepada syarat tersebut di atas Kesatuan hendaklah ditadbirkan oleh Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 9 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; MESYUARAT AGUNG <span class="meeting_yearly">.......</span> TAHUNAN</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan hendaklah diadakan seberapa segera selepas 31 Mac dan tidak lewat dari 30 September setiap <span class="meeting_yearly">.......</span> tahun. Tarikh, masa dan tempat mesyuarat itu hendaklah ditetapkan oleh Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Notis permulaan bagi Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan yang menyatakan tarikh, masa, tempat mesyuarat, permintaan usul-usul untuk perbincangan dalam mesyuarat itu (termasuk usul pindaan peraturan) dan penamaan calon bagi pemilihan anggota Majlis Jawatankuasa Kerja hendaklah dihantar oleh Setiausaha kepada semua anggota sekurang-kurangnya 30 hari sebelum tarikh mesyuarat. Anggota di sini bermakna anggota yang berhak mengundi pada masa pengundian itu dijalankan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Pencalonan bagi setiap jawatan dalam kesatuan dan usul-usul untuk perbincangan dalam Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan hendaklah dihantar oleh anggota kepada Setiausaha sekurang-kurangnya 21 hari sebelum Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Semua pencalonan hendaklah dibuat dengan mengemukakan borang yang ditentukan oleh Kesatuan dan hendaklah mengandungi perkara-perkara yang berikut:-
			<br>Nama jawatan yang ditandingi, nama calon, nombor kad pengenalan, nombor keanggotaan, tarikh lahir, alamat kediaman, pekerjaan dan nombor sijil kerakyatan/taraf kerakyatan.<br>&nbsp;</td>
		</tr>
	</table>
	<div class="left">(5)&nbsp;&nbsp;&nbsp;Sesuatu pencalonan tidak sah jika:</div>

	<table class="justify" width="">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>ia tidak ditandatangani oleh seorang pencadang dan seorang penyokong yang merupakan anggota-anggota berhak; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>ia tidak mengandungi persetujuan bertulis calon yang hendak bertanding.</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(6)&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha hendaklah menghantar kepada semua anggota sekurang kurangnya 14 hari sebelum tarikh Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan suatu agenda yang mengandungi usul-usul, penyata tahunan dan penyata kewangan (jika ada) untuk perbincangan dan kelulusan (serta kertas undi rahsia) mengikut kembaran kepada peraturan-peraturan ini bagi pemilihan Majlis Jawatankuasa Kerja dan sebarang perkara yang akan diputuskan dengan undi rahsia (jika ada).<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(7)&nbsp;&nbsp;&nbsp;</td>
			<td>Satu perempat (1/4) dari jumlah anggota yang berhak akan menjadi kuorum Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(8)&nbsp;&nbsp;&nbsp;</td>
			<td>Jika selepas satu (1) jam dari masa yang ditentukan bilangan anggota yang hadir tidak mencukupi maka mesyuarat itu hendaklah ditangguhkan kepada suatu tarikh (tidak lewat dari empat belas hari kemudian) yang ditetapkan oleh Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(9)&nbsp;&nbsp;&nbsp;</td>
			<td>Sekiranya kuorum bagi Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan yang ditangguhkan itu masih belum mencukupi pada masa yang ditentukan maka anggota-anggota yang hadir berkuasa menguruskan mesyuarat itu, akan tetapi tidak berkuasa meminda peraturan-peraturan Kesatuan.<br>&nbsp;</td>
		</tr>
	</table>
	<div class="left">(10)&nbsp;&nbsp;&nbsp;Urusan Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan antara lain ialah :-</div>

	<table class="justify" width="">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>menerima dan meluluskan laporan-laporan daripada Setiausaha, Bendahari dan Majlis Jawatankuasa Kerja;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>membincang dan memutuskan sebarang perkara atau usul tentang kebajikan anggota-anggota dan kemajuan Kesatuan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>melantik :-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">i)&nbsp;&nbsp;&nbsp;</td>
			<td>Pemegang Amanah, jika perlu;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">ii)&nbsp;&nbsp;&nbsp;</td>
			<td>Ahli Jemaah Penimbangtara, jika perlu;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">iii)&nbsp;&nbsp;&nbsp;</td>
			<td>Juruaudit Dalam; dan</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">iv)&nbsp;&nbsp;&nbsp;</td>
			<td>Pemeriksa Undi; untuk melaksanakan pemilihan pegawai-pegawai Kesatuan bagi tempoh yang akan datang.</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>meluluskan perlantikan pegawai atau pekerja sepenuh masa Kesatuan sekiranya perlu dan menetapkan skel gaji serta syarat-syarat pekerjaannya;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>membincang dan memutuskan perkara-perkara lain yang terkandung di dalam agenda; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>menerima penyata Jemaah Pemeriksa Undi tentang pemilihan Majlis Jawatankuasa Kerja dan perkara-perkara lain (jika ada).<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 10 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; MESYUARAT AGUNG LUARBIASA</div><br>
	<div class="left">(1)&nbsp;&nbsp;&nbsp;Mesyuarat Agung Luarbiasa hendaklah diadakan :-<br>&nbsp;</div>

	<table class="justify" width="">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>apabila difikirkan mustahak oleh Majlis Jawatankuasa Kerja; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>apabila menerima permintaan bersama secara bertulis daripada sekurang-kurangnya satu perempat (1/4) daripada jumlah anggota yang berhak mengundi. Permintaan itu hendaklah menyatakan tujuan dan sebab anggota-anggota berkenaan mahu mesyuarat itu diadakan.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Mesyuarat Agung Luarbiasa yang diminta oleh anggota-anggota atau yang difikirkan mustahak oleh Majlis Jawatankuasa Kerja hendaklah diadakan oleh Setiausaha dalam tempoh 21 hari dari tarikh permintaan itu diterima. Notis dan agenda hendaklah disampaikan oleh Setiausaha kepada anggota-anggota sekurang-kurangnya tujuh (7) hari sebelum tarikh Mesyuarat Agung Luarbiasa.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Peruntukan-peruntukan Peraturan 9 tentang kuorum dan penangguhan mesyuarat agung adalah terpakai kepada Mesyuarat Agung Luarbiasa yang diadakan kerana difikirkan mustahak oleh Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Bagi Mesyuarat Agung Luarbiasa yang diminta oleh anggota-anggota ditangguhkan kerana tidak cukup kuorum mengikut peraturan 9(7) maka mesyuarat yang ditangguhkan itu hendaklah ditutupkan sekiranya kuorum masih tidak diperolehi selepas satu (1) jam dari masa yang dijadualkan. Mesyuarat Agung Luarbiasa bagi perkara yang sama tidak boleh diminta lagi dalam tempoh enam (6) bulan dari tarikh mesyuarat itu ditutupkan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(5)&nbsp;&nbsp;&nbsp;</td>
			<td>Jika Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan tidak dapat diadakan dalam masa yang ditentukan mengikut Peraturan 9, maka Mesyuarat Agung Luarbiasa berkuasa menjalankan sebarang kerja yang lazimnya dijalankan oleh Mesyuarat Agung dengan syarat Mesyuarat Agung Luarbiasa yang demikian mestilah diadakan sebelum 31 Disember tahun yang berkenaan.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 11 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PEGAWAI DAN PEKERJA KESATUAN</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Pegawai Kesatuan bererti seseorang Ahli Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang tidak boleh dipilih atau bertugas sebagai pegawai kesatuan jika ia :-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>bukan anggota Kesatuan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>belum sampai umur 21 tahun;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>bukan warganegara Malaysia;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>pernah menjadi anggota eksekutif mana-mana kesatuan yang pendaftarannya telah ditutupkan di bawah seksyen 15(1) (b) (iv), (v) dan (vi) Akta Kesatuan Sekerja 1959 atau enakmen yang telah dimansuhkan oleh Akta itu;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>pernah disabitkan oleh mahkamah kerana kesalahan pecah amanah, pemerasan atau intimidasi atau apa-apa kesalahan di bawah Seksyen 49, 50 atau 50A Akta Kesatuan Sekerja 1959 atau sebarang kesalahan lain yang pada pendapat Ketua Pengarah Kesatuan Sekerja menyebabkan tidak layak menjadi pegawai sesebuah kesatuan sekerja;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>seorang pemegang jawatan (office bearer) atau pekerja sesebuah parti politik; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(g)&nbsp;&nbsp;&nbsp;</td>
			<td>seorang yang masih bankrap.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Kerja berkuasa menggaji pekerja-pekerja sepenuh masa yang difikirkan perlu setelah mendapat kelulusan Mesyuarat Agung. Seseorang pekerja Kesatuan selain daripada mereka yang tersebut dalam proviso kepada seksyen 29 (1) Akta Kesatuan Sekerja 1959, tidak boleh menjadi pegawai Kesatuan atau bertugas dan bertindak sedemikian rupa sehingga urusan hal ehwal Kesatuan seolah-olah dalam pengawalannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang tidak boleh digaji sebagai pekerja Kesatuan jika dia :-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>bukan warganegara Malaysia;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>telah disabitkan oleh sesebuah mahkamah kerana melakukan suatu kesalahan jenayah dan belum lagi mendapat pengampunan bagi kesalahan tersebut dan kesalahan itu pada pendapat Ketua Pengarah Kesatuan Sekerja tidak melayakkannya digaji oleh sesebuah kesatuan sekerja;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>seorang pegawai atau pekerja sesebuah kesatuan sekerja yang lain; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>seorang pemegang jawatan (office-bearer) atau pekerja sesebuah parti politik.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 12 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; MAJLIS JAWATANKUASA KERJA</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Kerja adalah menjadi badan yang menjalankan pentadbiran dan pengurusan hal ehwal Kesatuan termasuk hal pertikaian perusahaan dalam masa di antara dua Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Kerja hendaklah terdiri daripada seorang Presiden, seorang Naib Presiden, seorang Setiausaha, seorang Penolong Setiausaha, seorang Bendahari, seorang Penolong Bendahari dan <span class="total_ajk">......... ( )</span> orang Ahli Jawatankuasa. Mereka dikenali sebagai Pegawai-Pegawai Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Ahli Jawatankuasa Kerja hendaklah dipilih tiap-tiap <span class="ajk_yearly">.......</span> tahun dengan undi rahsia oleh semua anggota yang berhak.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Sekiranya seorang calon bagi sesuatu jawatan tidak ditandingi dan pencalonannya telah dilaksanakan menurut cara-cara yang ditentukan dalam Peraturan 9 (4), maka dia akan dianggap telah dipilih dan namanya akan diasingkan dari kertas undi bagi pemilihan pegawai-pegawai.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(5)&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Kerja yang pertama hendaklah dipilih dengan undi rahsia dalam masa enam (6) bulan setelah Kesatuan didaftarkan dan sehingga pemilihan itu dijalankan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(6)&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Penaja yang dipilih semasa penubuhan Kesatuan hendaklah menguruskan hal ehwal Kesatuan. Majlis Jawatankuasa Penaja juga hendaklah melantik jemaah pemeriksa undi sementara untuk mengendalikan pemilihan pegawai yang pertama.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(7)&nbsp;&nbsp;&nbsp;</td>
			<td>Ahli Majlis Jawatankuasa Kerja akan memegang jawatan daripada satu Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan ke satu Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan berikutnya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(8)&nbsp;&nbsp;&nbsp;</td>
			<td>Sekiranya dalam satu Mesyuarat Agung Luarbiasa suatu usul tidak percaya telah diluluskan terhadap Majlis Jawatankuasa Kerja oleh dua pertiga (2/3) suara terbanyak, Majlis Jawatankuasa Kerja hendaklah dengan serta merta bertugas sebagai pengurus sementara dan hendaklah mengadakan pemilihan semula pegawai-pegawai Kesatuan dengan undi rahsia dalam tempoh sebulan setelah Mesyuarat Agung Luarbiasa itu. Pegawai-pegawai yang dipilih dengan cara ini akan memegang jawatan sehingga Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan yang akan datang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(9)&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila berlakunya pertukaran pegawai-pegawai, pegawai atau Majlis Jawatankuasa Kerja yang bakal meninggalkan jawatan hendaklah dalam satu (1) minggu menyerahkan segala rekod berhubung dengan jawatannya kepada pegawai atau Majlis Jawatankuasa Kerja yang mengambil alih jawatan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(10)&nbsp;&nbsp;&nbsp;</td>
			<td>Pemberitahuan tentang pemilihan pegawai-pegawai hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja dalam tempoh 14 hari selepas pemilihan itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(11)&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Kerja hendaklah bermesyuarat sekurang-kurangnya tiga (3) bulan sekali dan setengah (1/2) daripada jumlah anggotanya akan menjadi kuorum mesyuarat. Minit mesyuarat Majlis Jawatankuasa Kerja hendaklah disahkan pada mesyuarat yang berikutnya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(12)&nbsp;&nbsp;&nbsp;</td>
			<td>Mesyuarat Majlis Jawatankuasa Kerja hendaklah diadakan oleh Setiausaha dengan arahan atau persetujuan Presiden.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(13)&nbsp;&nbsp;&nbsp;</td>
			<td>Notis dan agenda mesyuarat hendaklah diberi kepada semua ahli Majlis Jawatankuasa Kerja sekurang-kurangnya lima (5) hari sebelum mesyuarat.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(14)&nbsp;&nbsp;&nbsp;</td>
			<td>Permintaan secara bertulis untuk mengadakan mesyuarat Majlis Jawatankuasa Kerja boleh dibuat oleh sekurang-kurangnya setengah daripada jumlah ahli Majlis Jawatankuasa Kerja. Permintaan itu hendaklah dikemukakan kepada Setiausaha yang akan mengadakan mesyuarat yang diminta dalam tempoh 14 hari dari tarikh permintaan berkenaan diterima.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(15)&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila berlaku sesuatu perkara yang memerlukan keputusan serta-merta oleh Majlis Jawatankuasa Kerja dan di mana tidak dapat diadakan mesyuarat tergempar maka Setiausaha boleh dengan persetujuan Presiden mendapatkan keputusan melalui surat pekeliling. Syarat-syarat yang tersebut di bawah ini hendaklah disempurnakan sebelum perkara itu boleh dianggap sebagai telah diputuskan oleh Majlis Jawatankuasa Kerja :-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>perkara dan tindakan yang dicadangkan hendaklah dinyatakan dengan jelas dan salinan surat pekeliling itu disampaikan kepada semua ahli Majlis Jawatankuasa Kerja;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>sekurang-kurangnya setengah daripada jumlah ahli Majlis Jawatankuasa Kerja telah menyatakan secara bertulis sama ada mereka itu bersetuju atau tidak dengan cadangan tersebut; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>suara yang terbanyak daripada mereka yang menyatakan sokongan atau sebaliknya tentang cadangan tersebut akan menjadi keputusan.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(16)&nbsp;&nbsp;&nbsp;</td>
			<td>Keputusan yang didapati melalui surat pekeliling hendaklah dilaporkan oleh Setiausaha dalam mesyuarat Majlis Jawatankuasa Kerja yang akan datang dan dicatatkan dalam minit mesyuarat itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(17)&nbsp;&nbsp;&nbsp;</td>
			<td>Ahli Majlis Jawatankuasa Kerja yang tidak menghadiri mesyuarat tiga (3) kali berturut-turut tidak lagi berhak menyandang jawatannya kecuali dia dapat memberi alasan yang memuaskan kepada Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(18)&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila seseorang pegawai Kesatuan meninggal dunia, berhenti atau terlucut hak maka calon yang mendapat undi yang terkebawah sedikit bagi jawatan berkenaan dalam masa undian yang lalu hendaklah dijemput untuk mengisi tempat yang kosong itu. Bagi jawatan Presiden, Naib Presiden, Setiausaha, Penolong Setiausaha, Bendahari atau Penolong Bendahari, calon tersebut hendaklah mendapat tidak kurang daripada satu perempat (1/4) jumlah undi yang dibuang bagi jawatan itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(19)&nbsp;&nbsp;&nbsp;</td>
			<td>Jika tiada calon yang layak atau calon yang layak enggan menerima jawatan itu, Majlis Jawatankuasa Kerja berkuasa melantik seseorang anggota yang layak untuk mengisi kekosongan itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(20)&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha hendaklah menghantar notis pertukaran pegawai-pegawai kepada Ketua Pengarah Kesatuan Sekerja dalam masa 14 hari dari tarikh pertukaran dibuat.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(21)&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Kerja boleh menggunakan sebarang kuasa dan menjalankan sebarang kerja yang difikirkan perlu bagi mencapai tujuan-tujuan Kesatuan dan untuk memajukan kepentingannya dengan mematuhi peraturan-peraturan ini, Akta Kesatuan Sekerja 1959 dan Peraturan-peraturan Kesatuan Sekerja 1959.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(22)&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Kerja hendaklah mengawal tabung wang Kesatuan supaya tidak dibelanjakan dengan boros atau disalahgunakan. Majlis Jawatankuasa Kerja hendaklah mengarahkan Setiausaha atau pegawai yang lain mengambil langkah-langkah sewajarnya supaya seseorang pegawai, pekerja ataupun anggota Kesatuan didakwa di mahkamah kerana menyalahguna atau mengambil secara tidak sah wang atau harta kepunyaan Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(23)&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Kerja hendaklah mengarah Setiausaha atau pegawai yang lain supaya mengurus kerja-kerja Kesatuan dengan sempurna.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(24)&nbsp;&nbsp;&nbsp;</td>
			<td>Tertakluk kepada Peraturan 11 (3), Majlis Jawatankuasa Kerja boleh menggaji mana-mana pegawai atau pekerja sepenuh masa yang difikirkan mustahak atas kadar gaji dan syarat-syarat pekerjaan yang diluluskan oleh Mesyuarat Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(25)&nbsp;&nbsp;&nbsp;</td>
			<td>Pegawai-pegawai atau pekerja-pekerja Kesatuan boleh digantung kerja atau diberhentikan oleh Majlis Jawatankuasa Kerja kerana kelalaian, tidak amanah, tidak cekap atau enggan melaksanakan sebarang keputusan atau kerana sebab-sebab lain yang difikirkan munasabah atau wajar demi kepentingan Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(26)&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Kerja akan memberi arahan kepada Pemegang-pemegang Amanah tentang pelaburan wang Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(27)&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Kerja boleh menggantung atau memecat keanggotaan atau melarang daripada memegang jawatan seseorang anggota:-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Jika didapati bersalah kerana cuba hendak merosakkan Kesatuan atau melakukan perbuatan yang melanggar peraturan-peraturan ini atau membuat atau melibatkan diri dengan sebarang perbuatan mencela, mengeji atau mencerca Kesatuan, Pegawai atau dasar Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>Sebelum tindakan tersebut diambil, anggota berkenaan hendaklah diberi peluang untuk membela diri terhadap tuduhan berkenaan. Sesuatu perintah penggantungan, pemecatan atau larangan hendaklah bertulis dan menyatakan dengan jelas bentuk dan alasan tentang penggantungan, pemecatan atau larangan tersebut. Jika berkenaan, perintah itu hendaklah juga menyatakan tempoh ianya berkuatkuasa dan syarat-syarat yang membolehkan ia ditarik balik.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>Jika seseorang yang telah digantung faedahnya, dipecat atau dilarang daripada memegang jawatan rasa terkilan, dia berhak merujukkan kilanan berkenaan melalui Majlis Jawatankuasa Kerja untuk diselesaikan oleh Jemaah Penimbangtara di Peraturan 26 dan Peraturan 27 atau merayu terus kepada Mesyuarat Agung di mana keputusan Mesyuarat Agung adalah muktamad.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(28)&nbsp;&nbsp;&nbsp;</td>
			<td>Dalam masa antara Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan, Majlis Jawatankuasa Kerja hendaklah mentafsirkan peraturan-peraturan Kesatuan dan jika perlu, akan menentukan perkara yang tidak ternyata dalam Peraturan-peraturan ini.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(29)&nbsp;&nbsp;&nbsp;</td>
			<td>Sebarang keputusan Majlis Jawatankuasa Kerja hendaklah dipatuhi oleh semua anggota Kesatuan kecuali sehingga ianya ditutupkan oleh suatu ketetapan dalam Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan melainkan keputusan yang berkehendakkan undi rahsia.<br>&nbsp;</td>
		</tr>
	</table>
	<br>
	<div class="bold uppercase left">PERATURAN 12.A &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; JAWATANKUASA TEMPATAN</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Kerja boleh menubuhkan Jawatankuasa Tempatan di sebarang daerah / tempat pekerjaan untuk menjaga kepentingan anggota-anggota di daerah / tempat pekerjaan itu jika difikirkan perlu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Komposisi keanggotaan bagi tiap-tiap Jawatankuasa Tempatan hendaklah ditentukan oleh Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Kerja hendaklah menggubal peraturan-peraturan kecil sejajar dengan peraturan-peraturan ini bagi menentukan cara-cara penubuhan, pembubaran, perlantikan anggota Jawatankuasa Tempatan dan tugas-tugas Jawatankuasa Tempatan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Setiap Jawatankuasa Tempatan akan bertugas sebagai penyelaras sahaja dan tidak mempunyai kuasa eksekutif selain daripada kuasa yang diberikan kepadanya secara bertulis oleh Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
	</table>
	<br>
	<div class="bold uppercase left">PERATURAN 13 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; TUGAS PEGAWAI-PEGAWAI KESATUAN</div>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Presiden</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Menjadi Pengerusi semua mesyuarat dan bertanggungjawab tentang ketenteraman dan kesempurnaan mesyuarat-mesyuarat itu serta mempunyai undian pemutus dalam semua isu semasa pada masa mesyuarat kecuali perkara-perkara yang melibatkan undi rahsia;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>mengesahkan dan menandatangani minit tiap-tiap mesyuarat;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>menandatangani semua cek Kesatuan bersama-sama dengan Setiausaha dan Bendahari; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>mengawasi pentadbiran dan perjalanan Kesatuan serta memastikan peraturan-peraturan kesatuan dipatuhi oleh semua yang berkenaan.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">(2)&nbsp;&nbsp;&nbsp;</td>
			<td class="left">Naib Presiden</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Membantu Presiden dalam menjalankan tugas-tugasnya dan memangku jawatan Presiden pada masa ketiadaannya; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>menjalankan tugas-tugas sebagaimana diarahkan oleh Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Mengelolakan kerja-kerja Kesatuan mengikut peraturan-peraturan ini dan melaksanakan perintah-perintah dan arahan-arahan Mesyuarat Agung, atau Majlis Jawatankuasa Kerja;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>mengawasi kerja-kerja kakitangan Kesatuan dan bertanggungjawab tentang surat-menyurat dan menyimpan buku-buku, surat-surat keterangan dan kertas-kertas Kesatuan mengikut cara dan aturan yang diarahkan oleh Majlis Jawatankuasa Kerja;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>menetapkan serta menyediakan agenda mesyuarat Majlis Jawatankuasa Kerja dengan persetujuan Presiden dan menghadiri semua mesyuarat, menulis minit-minit mesyuarat dan menyediakan Penyata Tahunan Kesatuan untuk Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>menyediakan atau menguruskan supaya disediakan Penyata-penyata Tahunan dan surat keterangan lain yang dikehendaki oleh Ketua Pengarah Kesatuan Sekerja dalam masa yang ditentukan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>menyimpan dan mengemaskini suatu Daftar Keanggotaan yang mengandungi Nama Anggota, Alamat Kediaman, Nombor Kad Pengenalan dan Tarikh Menjadi Anggota Kesatuan; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>menandatangani semua cek Kesatuan bersama dengan Presiden dan Bendahari.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Penolong Setiausaha</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Bertanggungjawab dalam urusan Penerimaan dan Pembayaran wang Kesatuan dan urusan penyimpanan dokumen kewangan sebagaimana yang dikehendaki oleh Peraturan-peraturan Kesatuan Sekerja 1959;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>menjalankan tugas-tugas sebagaimana diarah oleh Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">(5)&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Bertanggungjawab dalam urusan Penerimaan dan Pembayaran wang Kesatuan dan urusan penyimpanan dokumen kewangan sebagaimana yang dikehendaki oleh Peraturan-peraturan Kesatuan Sekerja 1959;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>mengeluarkan Resit Rasmi bagi sebarang wang yang diterima;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>bertanggungjawab tentang keselamatan simpanan buku-buku kewangan dan surat-surat keterangan yang berkenaan di Ibu Pejabat. Buku-buku dan surat-surat keterangan ini tidak boleh dikeluarkan dari tempat rasminya tanpa kebenaran yang bertulis daripada Presiden pada tiap-tiap kali ia hendak dikeluarkan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>menyediakan Penyata Kewangan bagi tiap-tiap Mesyuarat Majlis Jawatankuasa Kerja dan bagi Mesyuarat Agung ; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>menandatangani semua cek Kesatuan bersama dengan Presiden dan Setiausaha.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">(6)&nbsp;&nbsp;&nbsp;</td>
			<td>Penolong Bendahari</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Membantu Bendahari dalam urusan kewangan Kesatuan dan memangku jawatan Bendahari pada masa ketiadaannya; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>menjalankan tugas-tugas sebagaimana diarah oleh Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 14 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PEMEGANG AMANAH</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Tiga (3) orang Pemegang Amanah yang berumur tidak kurang dari 21 tahun dan bukan Setiausaha atau Bendahari Kesatuan hendaklah dilantik / dipilih di dalam Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan yang pertama. Mereka akan menyandang jawatan itu selama yang dikehendaki oleh Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Sebarang harta (tanah, bangunan, pelaburan dan lain-lain) yang dimiliki oleh Kesatuan hendaklah diserahkan kepada mereka untuk diuruskan sebagaimana diarahkan oleh Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Pemegang Amanah tidak boleh menjual, menarik balik atau memindah milik sebarang harta tanpa persetujuan dan kuasa daripada Majlis Jawatankuasa Kerja yang disampaikan dengan bertulis oleh Setiausaha dan Bendahari.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang Pemegang Amanah boleh diberhentikan daripada jawatannya oleh Majlis Jawatankuasa Kerja kerana tidak sihat, tidak sempurna fikiran, tidak berada dalam negeri atau kerana sebarang sebab lain yang menyebabkan dia tidak boleh menjalankan tugasnya atau tidak dapat menyempurnakan tugasnya dengan memuaskan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(5)&nbsp;&nbsp;&nbsp;</td>
			<td>Jika seseorang Pemegang Amanah meninggal dunia, berhenti atau diberhentikan maka kekosongan itu hendaklah diisi oleh mana-mana anggota yang dilantik oleh Majlis Jawatankuasa Kerja sehingga Mesyuarat Agung yang akan datang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(6)&nbsp;&nbsp;&nbsp;</td>
			<td>Mesyuarat Agung boleh melantik sebuah Syarikat Pemegang Amanah yang ditakrifkan di bawah Akta Syarikat Amanah 1949 (Trust Companies Act 1949) atau undang-undang lain yang bertulis yang mengawal syarikat- syarikat Pemegang Amanah di Malaysia untuk menjadi Pemegang Amanah yang tunggal bagi Kesatuan ini. Jika syarikat Pemegang Amanah tersebut dilantik maka rujukan Pemegang Amanah dalam peraturan-peraturan ini hendaklah difahamkan sebagai Pemegang Amanah yang dilantik.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(7)&nbsp;&nbsp;&nbsp;</td>
			<td>Butir-butir pelantikan Pemegang Amanah atau pertukaran Pemegang Amanah hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja dalam tempoh 14 hari untuk dimasukkan ke dalam daftar Kesatuan. Sebarang perlantikan atau pemilihan tidak boleh dikuatkuasakan sehingga didaftarkan sedemikian.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 15 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; JURUAUDIT DALAM</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Dua orang Juruaudit Dalam yang bukan anggota Majlis Jawatankuasa Kerja hendaklah dipilih secara angkat tangan dalam Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan. Mereka hendaklah memeriksa kira-kira Kesatuan pada penghujung tiap-tiap tiga (3) bulan dan menyampaikan laporannya kepada Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Dokumen-dokumen pentadbiran dan kewangan Kesatuan hendaklah diaudit bersama-sama oleh kedua-dua Juruaudit Dalam dan mereka itu berhak melihat semua buku dan surat keterangan yang perlu untuk menyempurnakan tugas mereka.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang anggota Kesatuan boleh mengadu dengan bersurat kepada Juruaudit Dalam tentang sebarang hal kewangan yang tidak betul.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila berlaku kekosongan jawatan oleh sebarang sebab, kekosongan ini bolehlah diisi dengan cara lantikan oleh Majlis Jawatankuasa Kerja sehingga Mesyuarat Agung yang akan datang.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 16 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; JURUAUDIT LUAR</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Kesatuan hendaklah melantik seorang Juruaudit Luar bertauliah dan seterusnya memperolehi kelulusan Ketua Pengarah Kesatuan Sekerja bagi pelantikan ini. Juruaudit Luar itu hendaklah merupakan seorang akauntan yang telah memperolehi kebenaran bertulis daripada Menteri Kewangan untuk mengaudit kira-kira syarikat-syarikat di bawah Akta Syarikat 1965.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang Juruaudit Luar yang sama tidak boleh dilantik melebihi tempoh tiga (3) tahun berturut-turut.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Kira-kira Kesatuan hendaklah diaudit oleh Juruaudit Luar dengan segera selepas sahaja tahun kewangan ditutup pada 31 Mac dan hendaklah selesai sebelum 31 Ogos tiap-tiap tahun.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Juruaudit Luar berhak menyemak semua buku dan surat keterangan yang perlu untuk menyempurnakan tugasnya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(5)&nbsp;&nbsp;&nbsp;</td>
			<td>Kira-kira Kesatuan yang diaudit hendaklah diakui benar oleh Bendahari dengan surat akuan bersumpah (statutory declaration).<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(6)&nbsp;&nbsp;&nbsp;</td>
			<td>Satu salinan Penyata Kira-kira yang diaudit dan Laporan Juruaudit Luar itu hendaklah diedarkan kepada semua anggota sebelum Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan. Penyata kira-kira dan Laporan Juruaudit Luar tersebut hendaklah dibentangkan dalam Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan untuk kelulusan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(7)&nbsp;&nbsp;&nbsp;</td>
			<td>Kira-kira Kesatuan yang diaudit hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja berserta dengan Borang N sebelum 1 Oktober tiap-tiap tahun.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 17 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; JEMAAH PEMERIKSA UNDI</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Satu Jemaah Pemeriksa Undi yang terdiri daripada lima (5) orang anggota hendaklah dipilih secara angkat tangan dalam Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan dan seorang daripadanya hendaklah dipilih sebagai Ketua Pemeriksa Undi. Mereka hendaklah bukan pegawai Kesatuan atau calon bagi pemilihan pegawai-pegawai kesatuan. Seboleh-bolehnya anggota-anggota yang dipilih ini hendaklah anggota-anggota yang tinggal di sekitar kawasan Ibu Pejabat Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Jemaah Pemeriksa Undi ini bertanggungjawab mengendalikan segala perjalanan undi rahsia yang dijalankan oleh kesatuan. Mereka akan berkhidmat dari suatu Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan ke Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan yang berikutnya. Apabila berlaku kekosongan, kekosongan ini hendaklah diisi dengan cara lantikan oleh Majlis Jawatankuasa Kerja sehingga Mesyuarat Agung yang akan datang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Sekurang-kurangnya tiga (3) Pemeriksa Undi hendaklah hadir apabila pembuangan undi dijalankan. Mereka hendaklah memastikan aturcara yang tertera di dalam kembaran kepada peraturan-peraturan ini dipatuhi dengan sepenuhnya.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 18 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; GAJI DAN BAYARAN-BAYARAN LAIN</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Skim gaji serta syarat-syarat pekerjaan bagi Pegawai-pegawai Kesatuan yang berkerja sepenuh masa dengan Kesatuan dan pekerja-pekerja Kesatuan hendaklah ditetapkan melalui usul yang diluluskan di Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Pegawai-pegawai Kesatuan yang dikehendaki berkhidmat separuh masa bagi pihak Kesatuan boleh dibayar saguhati. Jumlah pembayaran saguhati itu hendaklah ditetapkan oleh Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Pegawai-pegawai atau wakil-wakil Kesatuan boleh diberi bayaran gantirugi dengan kelulusan oleh Majlis Jawatankuasa Kerja kerana hilang masa kerjanya dan perbelanjaan serta elaun yang munasabah bagi menjalankan kerja-kerja Kesatuan. Mereka itu hendaklah mengemukakan satu penyata yang menunjukkan butir-butir perjalanan dan bukti hilang masa kerjanya (jika berkenaan) dan perbelanjaan yang disokong dengan resit atau keterangan pembayaran lain. Had maksima bayaran, elaun dan perbelanjaan yang boleh dibayar hendaklah ditentukan dari semasa ke semasa oleh Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan dan Majlis Jawatankuasa Kerja tidak boleh meluluskan sebarang bayaran yang melebihi had yang ditentukan oleh Mesyuarat Agung itu.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 19 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; KEWANGAN DAN AKAUN</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Wang-wang Kesatuan boleh dibelanjakan bagi perkara-perkara berikut:-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran gaji, elaun dan perbelanjaan kepada Pegawai Kesatuan dan pekerja-pekerja Kesatuan tertakluk kepada Peraturan 18.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran dan perbelanjaan pentadbiran Kesatuan termasuk bayaran mengaudit kira-kira Kesatuan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran urusan pendakwaan atau pembelaan dalam prosiding undang-undang di mana Kesatuan atau seorang anggotanya menjadi satu pihak yang bertujuan untuk memperolehi atau mempertahankan hak Kesatuan atau sebarang hak yang terbit daripada perhubungan di antara seseorang anggota dengan majikannya;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran urusan pertikaian perusahaan bagi pihak Kesatuan atau anggota-anggotanya dengan syarat bahawa pertikaian perusahaan itu tidak bertentangan dengan Akta Kesatuan Sekerja 1959 atau Undang-undang bertulis yang lain;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran gantirugi kepada anggota kerana kerugian akibat daripada pertikaian perusahaan yang melibatkan anggota itu dengan syarat bahawa pertikaian perusahaan itu tidak bertentangan dengan Akta Kesatuan Sekerja 1959 atau Undang-undang bertulis yang lain;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran elaun kepada anggota kerana berumur tua, sakit, ditimpa kemalangan atau hilang pekerjaan atau bayaran kepada tanggungannya apabila anggota itu meninggal dunia.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(g)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran yuran mengenai pergabungan dengan, atau keanggotaan dengan mana-mana persekutuan kesatuan-kesatuan sekerja yang telah didaftarkan di bawah Bahagian XII Akta Kesatuan Sekerja 1959, atau mana-mana badan perunding atau badan yang serupa yang mana kelulusan telah diberi oleh Ketua Pengarah di bawah seksyen 76A (1) Akta Kesatuan Sekerja 1959 atau Ketua Pengarah telah diberitahu di bawah seksyen 76A (2) Akta Kesatuan Sekerja 1959;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(h)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran-bayaran untuk :-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">(i)&nbsp;&nbsp;&nbsp;</td>
			<td>Tambang keretapi, perbelanjaan pengangkutan lain yang perlu, perbelanjaan makan dan tempat tidur, yang beralaskan resit atau sebanyak mana yang telah ditentukan oleh Kesatuan, tertakluk kepada had-had yang ditentukan di bawah Peraturan 18.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">(ii)&nbsp;&nbsp;&nbsp;</td>
			<td>Amaun kehilangan gaji yang sebenar oleh wakil Kesatuan kerana menghadiri mesyuarat berkaitan atau berhubung dengan hal perhubungan perusahaan atau menyempurnakan perkara-perkara yang dikehendaki oleh Ketua Pengarah Kesatuan Sekerja berkaitan dengan Akta Kesatuan Sekerja 1959 atau sebarang peraturan tertakluk kepada had yang ditentukan di bawah Peraturan 18.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">(iii)&nbsp;&nbsp;&nbsp;</td>
			<td>Perbelanjaan bagi menubuhkan atau mengekalkan Persekutuan Kesatuan Sekerja yang didaftarkan di bawah Bahagian XII Akta Kesatuan Sekerja 1959, atau badan perunding atau badan yang serupa yang mana kelulusan telah diberi oleh Ketua Pengarah Kesatuan Sekerja di bawah seksyen 76A (1) Akta Kesatuan Sekerja 1959 atau Ketua Pengarah Kesatuan Sekerja telah diberitahu di bawah seksyen 76A (2) Akta Kesatuan Sekerja 1959.</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(i)&nbsp;&nbsp;&nbsp;</td>
			<td>Urusan mengarang, mencetak, menerbit dan mengedarkan sebarang suratkhabar, majalah, surat berita atau penerbitan lain, yang dikeluarkan oleh Kesatuan untuk menjayakan tujuan-tujuannya atau untuk memelihara kepentingan anggota-anggota selaras dengan peraturan-peraturan ini.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(j)&nbsp;&nbsp;&nbsp;</td>
			<td>Penyelesaian pertikaian di bawah Bahagian VI Akta Kesatuan Sekerja 1959.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(k)&nbsp;&nbsp;&nbsp;</td>
			<td>Aktiviti-aktiviti sosial, sukan, pendidikan dan amal kebajikan anggota-anggota Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(l)&nbsp;&nbsp;&nbsp;</td>
			<td>Pembayaran premium kepada syarikat-syarikat insurans berdaftar di Malaysia yang diluluskan oleh Ketua Pengarah Kesatuan Sekerja dari semasa ke semasa.</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Tabung wang Kesatuan tidak boleh digunakan sama ada secara langsung atau sebaliknya untuk membayar denda atau hukuman yang dikenakan oleh Mahkamah kepada sesiapa pun.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Wang-wang Kesatuan yang tidak dikehendaki untuk perbelanjaan semasa yang telah diluluskan hendaklah dimasukkan ke dalam bank oleh Bendahari dalam tempoh tujuh (7) hari dari tarikh penerimaannya. Akaun Bank itu hendaklah di atas nama kesatuan dan butir-butir akaun itu hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja. Pembukaan sesuatu akaun bank itu hendaklah diluluskan oleh Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Semua cek atau notis pengeluaran wang atas akaun Kesatuan hendaklah ditandatangani bersama oleh Presiden (pada masa ketiadaannya oleh Naib Presiden), Setiausaha (pada masa ketiadaannya oleh Penolong Setiausaha), dan Bendahari (pada masa ketiadaannya oleh Penolong Bendahari).<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(5)&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari dibenarkan menyimpan wang tunai tidak lebih daripada <span class="max_savings">......... ratus ringgit (RM........)</span> pada sesuatu masa. Sebarang perbelanjaan yang melebihi <span class="max_expenses">......... ratus ringgit (RM......)</span> tidak boleh dilakukan pada sesuatu masa kecuali dengan persetujuan terlebih dahulu daripada Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(6)&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari hendaklah menyediakan satu anggaran belanjawan tahunan untuk diluluskan oleh Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan dan semua perbelanjaan yang dibuat oleh Kesatuan hendaklah dalam had-had yang ditetapkan oleh belanjawan yang diluluskan itu. Belanjawan tersebut boleh disemak semula dari semasa ke semasa dengan dipersetujui terlebih dahulu oleh anggota-anggota di dalam Mesyuarat Agung Luarbiasa atau melalui undi rahsia.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(7)&nbsp;&nbsp;&nbsp;</td>
			<td>Semua harta kesatuan hendaklah dimiliki bersama atas nama Pemegang-pemegang Amanah. Wang-wang kesatuan yang tidak dikehendaki untuk urusan pentadbiran harian Kesatuan boleh digunakan bagi tujuan-tujuan seperti berikut:-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Membeli atau memajak sebarang tanah atau bangunan untuk kegunaan kesatuan. Tanah atau bangunan ini tertakluk kepada sesuatu undang-undang bertulis atau undang-undang lain yang boleh dipakai, dipajak atau dengan persetujuan anggota-anggota kesatuan yang diperoleh melalui usul yang dibawa dalam Mesyuarat Agung boleh dijual, ditukar atau digadai;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>Melabur dalam amanah saham (securities) atau dalam pinjaman kepada mana-mana syarikat mengikut Undang-undang yang berkaitan dengan pemegang amanah;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>Disimpan dalam Bank Simpanan Nasional, di mana-mana Bank yang diperbadankan di Malaysia atau di mana-mana Syarikat Kewangan yang merupakan anak syarikat bank tersebut ; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>Dengan mendapat kelulusan terlebih dahulu daripada Menteri Sumber Manusia dan tertakluk kepada syarat-syarat yang dikenakan oleh beliau bagi melabur :-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">(i)&nbsp;&nbsp;&nbsp;</td>
			<td>dalam mana-mana Syarikat Kerjasama yang berdaftar; atau</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">(ii)&nbsp;&nbsp;&nbsp;</td>
			<td>dalam mana-mana pengusahaan perdagangan, perindustrian, atau pertanian atau dalam enterprise bank yang diperbadankan dan beroperasi di Malaysia.</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(8)&nbsp;&nbsp;&nbsp;</td>
			<td>Semua belian dan pelaburan di bawah peraturan ini hendaklah diluluskan terlebih dahulu oleh Mesyuarat Majlis Jawatankuasa Kerja dan dibuat atas nama Pemegang-pemegang Amanah Kesatuan. Kelulusan ini hendaklah disahkan oleh Mesyuarat Agung yang akan datang. Pemegang-pemegang Amanah hendaklah memegang saham-saham atau pelaburan-pelaburan bagi pihak anggota-anggota Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(9)&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari hendaklah merekod atau menguruskan supaya direkodkan dalam dokumen kewangan Kesatuan sebarang penerimaan dan perbelanjaan wang Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(10)&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari hendaklah pada atau sebelum 1 Oktober tiap-tiap tahun, atau apabila dia berhenti atau meletak jawatan daripada pekerjaannya, atau pada bila-bila masa dia dikehendaki berbuat demikian oleh Majlis Jawatankuasa Kerja atau oleh anggota-anggota melalui suatu ketetapan yang dibuat dalam Mesyuarat Agung atau apabila dikehendaki oleh Ketua Pengarah Kesatuan Sekerja mengemukakan kepada Kesatuan dan anggota-anggotanya atau kepada Ketua Pengarah Kesatuan Sekerja yang mana ada kaitan, satu penyata kewangan yang benar dan betul tentang semua wang yang diterima dan dibayarnya dari masa dia mula memegang jawatan itu atau, jika dia pernah membentangkan penyata kewangan terdahulu, dari tarikh penyata kewangan itu dibentangkan, baki wang dalam tangannya pada masa ia mengemukakan penyata kewangan itu dan juga semua bon dan jaminan atau harta-harta Kesatuan yang lain dalam simpanan atau jagaannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(11)&nbsp;&nbsp;&nbsp;</td>
			<td>Penyata kewangan tersebut hendaklah mengikut bentuk yang ditentukan oleh Peraturan-peraturan Kesatuan Sekerja 1959 dan hendaklah diakui benar oleh Bendahari dengan surat akuan bersumpah (statutory declaration). Kesatuan hendaklah menguruskan penyata kewangan tersebut diaudit mengikut Peraturan 16. Selepas penyata kewangan itu diaudit, Bendahari hendaklah menyerahkan kepada pemegang-pemegang amanah Kesatuan jika dikehendaki oleh mereka itu semua bon, sekuriti, perkakasan, buku, surat dan harta Kesatuan yang ada dalam simpanan atau jagaannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(12)&nbsp;&nbsp;&nbsp;</td>
			<td>Selain daripada Bendahari, pegawai-pegawai atau pekerja-pekerja Kesatuan tidak boleh menerima wang atau mengeluarkan resit rasmi tanpa kuasa yang bertulis oleh Presiden pada tiap-tiap kali mereka itu berbuat demikian.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 20 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PEMERIKSAAN DOKUMEN DAN AKAUN</div>
	<br>
	<div class="left">Tiap-tiap orang yang mempunyai kepentingan dalam tabung wang Kesatuan berhak memeriksa dokumen-dokumen pentadbiran, kewangan Kesatuan dan rekod nama-nama anggota Kesatuan pada masa yang munasabah di tempat rekod itu disimpan setelah memberi notis yang mencukupi dan berpatutan.</div><br>

	<div class="bold uppercase left">PERATURAN 21 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; YURAN KHAS (LEVI)</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah satu usul diputuskan dengan undi rahsia menurut Peraturan 25, Majlis Jawatankuasa Kerja boleh memungut yuran khas( levi) daripada semua anggota Kesatuan kecuali mereka yang telah dikecualikan daripada bayaran ini oleh Majlis Jawatankuasa Kerja menurut Peraturan 4 (5).<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Jika seseorang anggota tidak menjelaskan yuran khas(levi) itu dalam tempoh enam (6) minggu dari tarikh ia dikenakan atau dalam tempoh yang lebih panjang yang ditetapkan dalam usul berkenaan maka yuran khas (levi) itu akan dikira sebagai tunggakan yuran Kesatuan dan anggota itu boleh terlucut haknya menurut Peraturan 4 (3).</td>
		</tr>
	</table><br>

	<div class="bold uppercase left">PERATURAN 22 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PERTIKAIAN PERUSAHAAN</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Jika seseorang anggota berhajat supaya tindakan diambil terhadap syarat-syarat pekerjaannya atau sebarang hal yang lain maka dia hendaklah memberitahu Setiausaha tentang aduannya secara bertulis. Setiausaha hendaklah menyampaikan aduan itu kepada Majlis Jawatankuasa Kerja dengan serta-merta.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Jika berbangkit sesuatu pertikaian perusahaan maka anggota-anggota yang terlibat hendaklah menyampaikan hal itu kepada Setiausaha dan Setiausaha hendaklah dengan serta-merta melaporkan hal itu kepada Majlis Jawatankuasa Kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Kesatuan tidak boleh melancarkan mogok dan anggota-anggotanya tidak boleh mengambil bahagian dalam mogok :<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Tanpa mendapat kelulusan Majlis Jawatankuasa Kerja terlebih dahulu;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>tanpa mendapat persetujuan dengan undi rahsia daripada sekurang-kurangnya dua pertiga (2/3) daripada jumlah anggota yang layak mengundi dan terlibat dengan mogok yang akan dijalankan itu;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>sebelum luput tempoh tujuh (7) hari selepas keputusan undi rahsia itu dikemukakan kepada Ketua Pengarah Kesatuan Sekerja mengikut seksyen 40 (5) Akta Kesatuan Sekerja 1959;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>sekiranya undi rahsia untuk cadangan mogok telah luput tempohnya atau tidak sah menurut peruntukan-peruntukan seksyen 40 (2), 40 (6) atau 40 (9) Akta Kesatuan Sekerja 1959;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>jika mogok itu menyalahi atau tidak mematuhi peraturan-peraturan ini;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>berkaitan dengan apa-apa perkara yang diliputi oleh suatu arahan atau keputusan Menteri Sumber Manusia yang diberi atau dibuat terhadap sesuatu rayuan di bawah Akta Kesatuan Sekerja 1959; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(g)&nbsp;&nbsp;&nbsp;</td>
			<td>jika mogok itu menyalahi atau tidak mematuhi mana-mana peruntukan lain Akta Kesatuan Sekerja 1959 atau mana-mana peruntukan Undang-undang lain yang bertulis.</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Kerja tidak boleh menyokong pemogokan dengan memberi bantuan kewangan atau bantuan lain jika peruntukan-peruntukan Peraturan 22 (3) tidak dipatuhi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(5)&nbsp;&nbsp;&nbsp;</td>
			<td>Sesuatu undi rahsia yang diambil tentang apa-apa perkara berkaitan dengan pemogokan hendaklah mengandungi suatu usul yang menerangkan dengan jelas akan isu yang menyebabkan cadangan pemogokan itu. Usul itu hendaklah juga menerangkan dengan jelas rupa bentuk tindakan yang akan dilakukan atau yang tidak akan dilakukan di sepanjang pemogokan itu. Undi rahsia yang tidak memenuhi kehendak- kehendak ini tidaklah sah dan tidak boleh dikuatkuasakan dan pemogokan tidak boleh dilakukan berdasarkan undi rahsia tersebut.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(6)&nbsp;&nbsp;&nbsp;</td>
			<td>Mana-mana anggota Kesatuan yang memulakan mogok, mengambil bahagian atau bertindak bagi melanjutkan pemogokan yang melanggar Akta Kesatuan Sekerja 1959 atau peraturan-peraturan ini atau mana-mana peruntukan Undang-undang bertulis akan terhenti dengan sendirinya daripada menjadi anggota Kesatuan dan selepas itu tidak boleh menjadi anggota Kesatuan ini atau kesatuan yang lain tanpa kelulusan bertulis daripada Ketua Pengarah Kesatuan Sekerja terlebih dahulu. Kesatuan hendaklah dengan serta-merta:-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>mengeluarkan nama anggota tersebut daripada Daftar Keanggotaan/Yuran;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>memberitahu Ketua Pengarah Kesatuan Sekerja dan anggota berkenaan pengeluaran nama tersebut; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>mempamerkan di suatu tempat yang mudah dilihat di pejabat Kesatuan yang berdaftar satu senarai anggota yang namanya telah dikeluarkan itu.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 23 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; KEGIATAN PENDIDIKAN</div><br>
	<div class="justify left">Kesatuan boleh menjalankan aktiviti bagi menambah ilmu pengetahuan anggota-anggotanya dengan menganjurkan perjumpaan, seminar, bengkel, atau kursus. Selanjutnya kesatuan boleh menerbitkan bahan-bahan bacaan dan menjalankan urusan-urusan lain seumpama yang boleh memajukan pengetahuan anggota-anggota dalam hal perusahaan, kebudayaan dan kemasyarakatan dengan mematuhi kehendak undang-undang berkaitan perbelanjaan wang kesatuan sekerja yang dikuatkuasakan sekarang.</div><br>

	<div class="bold uppercase left">PERATURAN 24 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PERATURAN-PERATURAN DAN PINDAAN PERATURAN-PERATURAN</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Pindaan kepada Peraturan-peraturan yang akan meningkatkan lagi tanggungan anggota untuk mencarum atau mengurangkan faedah yang dinikmatinya hanya boleh dibuat jika diluluskan oleh anggota-anggota dengan undi rahsia. Pindaan Peraturan-peraturan lain boleh dibuat dengan kelulusan Mesyuarat Agung yang diadakan menurut Peraturan 9 atau Peraturan 10, atau dengan undi rahsia.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Tiap-tiap pindaan Peraturan-peraturan hendaklah berkuatkuasa dari tarikh pindaan itu didaftarkan oleh Ketua Pengarah Kesatuan Sekerja kecuali jika suatu tarikh yang terkemudian dari itu ditentukan di dalam peraturan-peraturan ini.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Suatu naskah Peraturan-peraturan Kesatuan yang bercetak hendaklah dipamerkan di suatu tempat yang mudah dilihat di pejabat Kesatuan yang didaftarkan. Setiausaha hendaklah memberi senaskah Peraturan-peraturan Kesatuan kepada sesiapa juga yang memintanya dengan bayaran tidak lebih dari RM10.00 senaskah.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 25 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; UNDI RAHSIA</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Keputusan-keputusan berkenaan dengan perkara-perkara yang tersebut di bawah ini hendaklah dibuat dengan undi rahsia oleh semua anggota berhak atau anggota-anggota berhak yang terlibat kecuali anggota yang belum cukup umur 18 tahun tidak berhak mengundi atas perkara-perkara (c), (d), (e) dan (g) ;-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Pemilihan Pegawai-pegawai Kesatuan menurut Peraturan 12;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>Pemilihan wakil-wakil untuk Persekutuan Kesatuan-Kesatuan sekerja;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>Semua perkara mengenai mogok menurut Peraturan 22 (3);<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>Mengenakan yuran khas (levi);<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>Pindaan peraturan-peraturan ini jika pindaan itu meningkatkan lagi tanggungan anggota untuk mencarum atau mengurangkan faedah yang dinikmatinya;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>Bercantum dengan kesatuan sekerja yang lain atau memindahkan urusan kepada kesatuan sekerja yang lain;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(g)&nbsp;&nbsp;&nbsp;</td>
			<td>Membubarkan Kesatuan atau Persekutuan Kesatuan-Kesatuan Sekerja</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Untuk menjalankan undi rahsia, aturcara yang dinyatakan di dalam kembaran kepada peraturan-peraturan ini hendaklah dipatuhi.</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 26 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PERLANTIKAN JEMAAH PENIMBANGTARA</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Satu Jemaah Penimbangtara yang terdiri dari lima (5) orang hendaklah dilantik dalam Mesyuarat Agung Kesatuan yang pertama untuk menyelesaikan sesuatu pertikaian dalam kesatuan. Jemaah Penimbangtara hendaklah bukan anggota kesatuan dan tidak ada kaitan langsung dengan kewangan Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila berlaku kekosongan oleh sebarang sebab maka kekosongan itu hendaklah diisi dengan melantik penggantinya di dalam Mesyuarat Agung yang akan datang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha hendaklah melaporkan kepada Ketua Pengarah Kesatuan Sekerja butir-butir peribadi Jemaah Penimbangtara (seperti nama, nombor kad pengenalan, jawatan dan alamat) dan sebarang perubahan tentang anggota Jemaah Penimbangtara.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha hendaklah mengemukakan sesuatu pertikaian kepada Jemaah Penimbangtara dalam masa tujuh (7) hari daripada permohonan diterima dari anggota atau seseorang yang terkilan. Apabila sesuatu pertikaian telah dirujuk kepada Jemaah Penimbangtara, pihak yang terkilan hendaklah memilih dengan mengundi tiga (3) daripada lima (5) orang Jemaah Penimbangtara tersebut. Setiausaha hendaklah menetapkan tempat dan masa bagi urusan ini. Laporan dan keputusan Jemaah Penimbangtara hendaklah dikemukakan kepada Majlis Jawatankuasa Kerja dengan seberapa segera.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 27 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PERTIKAIAN DALAM KESATUAN</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Tertakluk kepada perenggan dua (2) di bawah ini, tiap-tiap pertikaian yang berlaku di antara :-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang anggota atau seseorang yang menuntut melalui seorang anggota atau menurut Peraturan ini, di sebelah pihak, dan dengan Kesatuan atau Pegawai Kesatuan di pihak yang lagi satu; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang yang terkilan yang telah diberhentikan menjadi anggota Kesatuan, atau seseorang yang menuntut melalui orang yang terkilan itu, di sebelah pihak dengan Kesatuan atau Pegawai Kesatuan di pihak yang lagi satu; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td colspan="2"  style="padding-left: 1cm;" class="left">hendaklah diselesaikan melalui penimbangtaraan.</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Pihak yang menuntut dan pihak yang kena tuntut bolehlah bersama-sama merujuk pertikaian tentang perkara berikut :-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>pemilihan pegawai-pegawai Kesatuan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>akaun dan kewangan Kesatuan; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>melanggar peraturan-peraturan Kesatuan,<br>&nbsp;</td>
		</tr>
		<tr class="left justify" style="width: 30;">
			<td colspan="2"  style="padding-left: 1cm;" class="left">kepada Ketua Pengarah Kesatuan Sekerja dan keputusan Ketua Pengarah Kesatuan Sekerja tentang pertikaian tersebut adalah muktamad.</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha hendaklah secara bertulis menyampaikan sebarang pertikaian di bawah perenggan satu (1) kepada Jemaah Penimbangtara dalam tempoh tujuh (7) hari dari tarikh permohonan pihak yang menuntut diterima oleh Kesatuan. Jika tiada keputusan dibuat mengenai suatu pertikaian dalam tempoh 40 hari selepas permohonan dibuat kepada kesatuan, anggota atau seseorang yang terkilan itu boleh memohon kepada Mahkamah Sesyen dan Mahkamah Sesyen boleh mendengar dan membuat keputusan mengenai pertikaian tersebut.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Dalam peraturan ini perkataan pertikaian meliputi sebarang pertikaian tentang soal sama ada seseorang anggota atau orang yang terkilan itu berhak menjadi anggota atau terus menjadi anggota ataupun diterima semula menjadi anggota. Bagi seseorang yang telah berhenti menjadi anggota, perkataan pertikaian ini hanya meliputi pertikaian di antaranya dengan Kesatuan atau Pegawai Kesatuan tentang soal yang berbangkit di masa ia menjadi anggota.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(5)&nbsp;&nbsp;&nbsp;</td>
			<td>Pihak yang terkilan berhak membuat rayuan kepada Mesyuarat Agung <span class="meeting_yearly">.......</span> Tahunan terhadap sebarang keputusan yang telah dibuat oleh Penimbangtara dan keputusan Mesyuarat itu adalah muktamad.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 28 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PEMBUBARAN</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Kesatuan ini tidak boleh dibubarkan dengan sendirinya melainkan dengan persetujuan melalui undi rahsia tidak kurang dari 75% daripada jumlah anggota yang berhak mengundi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Sekiranya Kesatuan ini dibubarkan seperti yang tersebut di atas maka segala hutang dan tanggungan yang dibuat dengan cara sah bagi pihak Kesatuan hendaklah dijelaskan dengan sepenuhnya dan baki wang yang tinggal hendaklah diselesaikan menurut keputusan yang akan dibuat dengan undi rahsia. Penyata kewangan terakhir hendaklah diaudit oleh juruaudit bertauliah atau seseorang yang dipersetujui oleh Ketua Pengarah Kesatuan Sekerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Notis pembubaran dan dokumen-dokumen lain seperti yang dikehendaki oleh Peraturan-Peraturan Kesatuan Sekerja 1959, hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja dalam tempoh 14 hari selepas pembubaran. Pembubaran itu hanya akan berkuatkuasa dari tarikh pendaftarannya oleh Ketua Pengarah Kesatuan Sekerja.<br>&nbsp;</td>
		</tr>
	</table><br><br>
	<div class="bold uppercase center"><u>KEMBARAN</u></div><br>
	<div class="bold uppercase center">ATURCARA MENJALANKAN UNDI RAHSIA</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Kerja hendaklah menetapkan tarikh, masa dan tempat mengundi. Majlis Jawatankuasa Kerja hendaklah memberi hak dan peluang yang sama kepada semua anggota yang berhak untuk membuang undi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha hendaklah menyediakan kertas undi yang cukup seperti Contoh A dan hendaklah memberi kepada tiap-tiap anggota yang berhak mengundi satu kertas undi yang dimeterai dengan Mohor Kesatuan atau bertandatangan Setiausaha bersama dengan satu sampul surat yang dialamatkan kepada Ketua Pemeriksa Undi di alamat berdaftar kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha hendaklah menyediakan kertas undi yang cukup seperti Contoh B dan hendaklah memberi kepada tiap-tiap anggota yang berhak mengundi satu kertas undi yang dimeterai dengan Mohor Kesatuan atau bertandatangan Setiausaha bersama dengan satu sampul surat yang beralamat kepada Setiausaha.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Tentang kertas undi di Contoh B, isu-isu yang berlainan tujuannya hendaklah ditentukan dengan tanda-tanda pangkah secara berasingan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(5)&nbsp;&nbsp;&nbsp;</td>
			<td>Kertas-kertas undi hendaklah dikeluarkan menerusi pos atau dengan unjukan tangan. Sekiranya diberi dengan unjukan tangan, tandatangan sipenerima secara bersendirian hendaklah diperolehi sebagai bukti penerimaannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(6)&nbsp;&nbsp;&nbsp;</td>
			<td>Sampul surat itu hendaklah mengandungi perkataan Kertas Undi dan nombor anggota dicatatkan di atasnya. Kertas undi dan sampul surat itu hendaklah disampaikan kepada semua anggota berhak sekurang- kurangnya 14 hari sebelum tarikh Mesyuarat Agung bagi membolehkan anggota-anggota itu menghantar kembali kertas undi itu di dalam masa yang ditetapkan bagi urusan pengundian.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(7)&nbsp;&nbsp;&nbsp;</td>
			<td>Anggota-anggota bebas memilih sama ada hendak mengundi dengan pos atau secara peribadi. Sekiranya seorang anggota itu memilih hendak mengundi dengan pos dia hendaklah mengembalikan kertas undi yang telah ditandanya kepada Ketua Pemeriksa Undi atau menurut cara-cara yang ditentukan di dalam aturan ini tetapi sekiranya dia memilih untuk mengundi secara peribadi, dia hendaklah membuang undinya menurut cara-cara yang ditentukan di bawah ini.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(8)&nbsp;&nbsp;&nbsp;</td>
			<td>Jika seseorang yang berhak mengundi dan hadir di tempat mengundi menyatakan dengan bersurat bahawa ia belum lagi menerima kertas undi melalui pos, dia hendaklah diberi oleh Setiausaha satu kertas undi yang dimeterai dengan Mohor Kesatuan atau ditandatangani oleh Setiausaha berserta dengan satu sampul surat yang mengandungi perkataan Kertas Undi dan nombor anggota tertulis di atasnya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(9)&nbsp;&nbsp;&nbsp;</td>
			<td>Mana-mana anggota yang tidak membuat aduan kerana tidak menerima kertas undi sebelum Mesyuarat Agung, tidak boleh membuat aduan tentang hal ini kemudian.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(10)&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila sampai di tempat mengundi pada masa mengundi, anggota yang memilih untuk mengundi secara peribadi hendaklah masuk seorang demi seorang ke dalam bilik mengundi atau di bahagian dewan yang ditempatkan peti undi itu dan menurunkan undinya dengan menandakan satu pangkah atau beberapa pangkah di mana berkenaan di atas kertas undi itu. Tanda-tanda yang lain tidak boleh ditulis. Selepas itu lipatkan kertas undi itu sekurang-kurangnya sekali dan masukkannya ke dalam peti undi yang telah disediakan untuknya; setelah itu tinggalkan tempat mengundi itu dengan segera.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(11)&nbsp;&nbsp;&nbsp;</td>
			<td>Pembuangan undi hendaklah dilaksanakan di bawah pengawasanPemeriksa-pemeriksa Undi yang dipilih menurut Peraturan 17. Sekurang-kurangnya tiga (3) orang Pemeriksa Undi mestilah hadir sepanjang masa pembuangan undi itu dijalankan. Sebelum urusan undi dijalankan Setiausaha hendaklah meminta Pemeriksa-pemeriksa Undi menentukan yang peti undi itu kosong dan setelah itu mereka hendaklah mengunci, memeteri dan kemudian menyimpan kunci-kunci itu dalam jagaan mereka.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(12)&nbsp;&nbsp;&nbsp;</td>
			<td>Sebelum undi rahsia itu dijalankan, Pemeriksa-pemeriksa Undi hendaklah diberi oleh Setiausaha satu senarai anggota yang telah diberi kertas undi (dengan tangan atau dengan pos) dan mereka hendaklah menentukan dengan menyemak senarai itu dengan Buku Daftar Keanggotaan / Yuran, bahawa :-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">i.&nbsp;&nbsp;&nbsp;</td>
			<td>anggota-anggota yang berhak sahaja diberi peluang mengundi;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">ii.&nbsp;&nbsp;&nbsp;</td>
			<td>tiap-tiap anggota hanya mengundi sekali sahaja bagi sesuatu perkara;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">iii.&nbsp;&nbsp;&nbsp;</td>
			<td>anggota-anggota yang telah mengundi dengan pos itu tidak diberikertas undi menurut perenggan di atas; dan</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">iv.&nbsp;&nbsp;&nbsp;</td>
			<td>anggota-anggota boleh mengundi mengikut kehendak mereka dan undi mereka tidaklah diketahui oleh orang lain.</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(13)&nbsp;&nbsp;&nbsp;</td>
			<td>Seorang anggota yang mengundi melalui pos hendaklah menandakan (X) pada kertas undinya dan setelah itu hendaklah melipatkan kertas undi itu sekurang-kurangnya sekali dan memasukkannya ke dalam sampul surat yang telah disediakan untuknya serta menghantarkannya kepada Ketua Pemeriksa Undi bagi Contoh A dan kepada Setiausaha bagi Contoh B supaya sampai kepada mereka sebelum hari yang ditetapkan untuk mengundi itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(14)&nbsp;&nbsp;&nbsp;</td>
			<td>Ketua Pemeriksa Undi dan Setiausaha hendaklah menyimpan segala kertas undi itu tanpa dibuka di suatu tempat yang selamat sehingga hari yang ditetapkan. Mereka hendaklah menyerahkannya kepada Pemeriksa- pemeriksa Undi dan memasukkannya ke dalam peti undi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(15)&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah semua anggota yang berhak mengundi itu membuang undi masing-masing maka Ketua Pemeriksa Undi, setelah mengisytiharkan pembuangan undi ditutup, hendaklah membuka peti undi dan mengira sampul surat yang mengandungi kertas-kertas undi itu di hadapan sekurang-kurang tiga (3) orang saksi yang merupakan anggota kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(16)&nbsp;&nbsp;&nbsp;</td>
			<td>Pada permulaannya mereka hendaklah menyemak nombor anggota Kesatuan di atas sampul surat itu dengan senarai anggota yang diberi oleh Setiausaha. Sambil sampul surat itu disemak maka nombor anggota itu hendaklah dipotong hingga tidak dapat dibaca semula dan sampul-sampul surat itu dimasukkan dengan tidak dibuka ke dalam satu peti yang berkunci.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(17)&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah semua sampul surat itu disemak maka Pemeriksa-pemeriksa Undi hendaklah mengeluarkan sampul-sampul surat itu semula daripada peti berkunci itu, membuka sampul-sampul surat itu dan masukkan kertas undi yang masih terlipat itu ke dalam peti undi. Setelah itu mereka akan mula mengira undi. Jika pada pendapat seseorang Pemeriksa Undi ada undi yang tidak sah maka undi berkenaan hendaklah dianggap rosak dan ditolak.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(18)&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah kesemua undi itu dikira maka Pemeriksa-pemeriksa Undi yang hadir hendaklah menyediakan penyata keputusan undi dalam dua (2) salinan dan menyerahkan kedua-dua salinan itu kepada Setiausaha sesudah ditandatangani oleh mereka. Penyata itu hendaklah ditandatangani pula oleh Presiden dan Setiausaha. Ketua Pemeriksa Undi hendaklah memberitahu keputusan pengundian itu kepada anggota- anggota yang hadir.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(19)&nbsp;&nbsp;&nbsp;</td>
			<td>Satu (1) salinan penyata keputusan undi hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja dan satu (1) salinan lagi disimpan oleh Setiausaha selama tidak kurang dari enam (6) bulan dan boleh diperiksa oleh sesiapa juga anggota yang hendak memeriksanya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(20)&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah sahaja keputusan itu disahkan betul maka kertas-kertas undi yang telah diambilkira termasuk yang ditolak hendaklah disimpan di suatu tempat yang selamat selama tidak kurang daripada enam (6) bulan untuk diperiksa oleh pegawai-pegawai dari Jabatan Hal Ehwal Kesatuan Sekerja. Kertas-kertas undi itu boleh dimusnahkan oleh Presiden dan Setiausaha atau di bawah pengawasan Presiden dan Setiausaha apabila tamat tempoh tersebut.<br>&nbsp;</td>
		</tr>
	</table><br>

	<hr>

	<div style="text-align: right;" class="bold uppercase">CONTOH "A"</div><br>

	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="25%">Nama Kesatuan</td>
			<td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
			<td class="bold">Kesatuan Unijaya</td>
		</tr>
		<tr class="left justify" >
			<td>Nombor Pendaftaran</td>
			<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
			<td>1313-H</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;">Alamat</td>
			<td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
			<td>
				D-9-5, Megan Avenue 1, 189, Jalan Tun Razak, <br>
				Hampshire Park, 50450 Kuala Lumpur, Selangor
			</td>
		</tr>
	</table><br>

	<div style="text-align: left;" class="bold uppercase">KERTAS UNDI BAGI PEMILIHAN PEGAWAI-PEGAWAI KESATUAN</div><br>
	<div class="left bold camelcase"><u>Cara Mengundi:</u></div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Tuan / Puan berhak menanda satu (1) undi bagi jawatan Presiden, Naib Presiden, Setiausaha, Penolong Setiausaha, Bendahari, Penolong Bendahari dan .... undi bagi Ahli Jawatankuasa.</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Undi tuan / puan adalah RAHSIA dan tuan / puan hendaklah mencatatkan tanda pangkah seperti ini <b>X</b> di dalam ruangan yang disediakan bertentangan dengan nama calon yang tuan / puan pilih. <b>JANGAN DITULIS LAIN DARI TANDA X</b> dalam kertas undi ini dan janganlah mengundi lebih dari angka yang telah ditetapkan dan jika dibuat demikian kertas undi ini akan ditolak sebagai rosak dan tidak akan dikira.</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Sesudah undian itu, lipatkan kertas undi ini sekurang-kurangnya sekali dan masukkan ke dalam sampul surat dan masukkan ke dalam peti undi yang telah disediakan di dalam bilik mengundi. Jika tuan / puan mengundi dengan pos, lipatkan kertas undi ini sekurang-kurangnya sekali, masukkan ke dalam sampul surat yang telah disediakan dan hantarkan kepada Ketua Pemeriksa Undi supaya sampai kepadanya tidak lewat dari ............... 20 ..........</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PRESIDEN</div>

	<table class="simple-table border">
		<tr class="border center">
			<th class="border" width="6%">No.</th>
			<th class="border left">&nbsp;&nbsp;Nama Calon</th>
			<th class="border" width="35%">Undi satu (1) sahaja</th>
		</tr>
		<tr class="border">
			<td class="border center">1</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">2</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
	</table><br>
	<div class="bold uppercase left">NAIB PRESIDEN</div>

	<table class="simple-table border">
		<tr class="border center">
			<th class="border" width="6%">No.</th>
			<th class="border left">&nbsp;&nbsp;Nama Calon</th>
			<th class="border" width="35%">Undi satu (1) sahaja</th>
		</tr>
		<tr class="border">
			<td class="border center">1</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">2</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
	</table><br>
	<div class="bold uppercase left">SETIAUSAHA</div>

	<table class="simple-table border">
		<tr class="border center">
			<th class="border" width="6%">No.</th>
			<th class="border left">&nbsp;&nbsp;Nama Calon</th>
			<th class="border" width="35%">Undi satu (1) sahaja</th>
		</tr>
		<tr class="border">
			<td class="border center">1</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">2</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PENOLONG SETIAUSAHA</div>

	<table class="simple-table border">
		<tr class="border center">
			<th class="border" width="6%">No.</th>
			<th class="border left">&nbsp;&nbsp;Nama Calon</th>
			<th class="border" width="35%">Undi satu (1) sahaja</th>
		</tr>
		<tr class="border">
			<td class="border center">1</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">2</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
	</table><br>
	<div class="bold uppercase left">BENDAHARI</div>

	<table class="simple-table border">
		<tr class="border center">
			<th class="border" width="6%">No.</th>
			<th class="border left">&nbsp;&nbsp;Nama Calon</th>
			<th class="border" width="35%">Undi satu (1) sahaja</th>
		</tr>
		<tr class="border">
			<td class="border center">1</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">2</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PENOLONG BENDAHARI</div>

	<table class="simple-table border">
		<tr class="border center">
			<th class="border" width="6%">No.</th>
			<th class="border left">&nbsp;&nbsp;Nama Calon</th>
			<th class="border" width="35%">Undi satu (1) sahaja</th>
		</tr>
		<tr class="border">
			<td class="border center">1</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">2</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
	</table><br><br>
	<div class="bold uppercase left">AHLI JAWATAN KUASA</div>
	<table class="simple-table border">
		<tr class="border center">
			<th class="border" width="6%">No.</th>
			<th class="border left">&nbsp;&nbsp;Nama Calon</th>
			<th class="border" width="35%">Undi .......() sahaja</th>
		</tr>
		<tr class="border">
			<td class="border center">1</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">2</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">3</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">4</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">5</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">6</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">7</td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
	</table><br><br>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" colspan="2" class="bold">
				<div style="text-align: center; padding-left: 70%;">
					________________________________<br>
					 CAP Kesatuan<br>Atau Tandatangan Setiausaha
				</div>
			</td>
		</tr>
	</table><br>

	<hr>

	<div style="text-align: right;" class="bold uppercase">CONTOH "B"</div><br>

	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="25%">Nama Kesatuan</td>
			<td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
			<td class="bold">Kesatuan Unijaya</td>
		<tr class="left justify" >
			<td>Nombor Pendaftaran</td>
			<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
			<td>1313-H</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;">Alamat</td>
			<td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
			<td>
				D-9-5, Megan Avenue 1, 189, Jalan Tun Razak, <br>
				Hampshire Park, 50450 Kuala Lumpur, Selangor
			</td>
		</tr>
	</table><br><br>
	<div class="break"> </div>
	<div class="bold uppercase center"><u>KERTAS UNDI</u></div><br><br>

	<div class="bold left camelcase">Cara Mengundi:</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>
				Tuan / Puan berhak mengundi sama ada <b>MENYOKONG</b> atau <b>MEMBANGKANG</b> usul yang berikut:
				<br><br><br>
				<center><b>(tuliskan usul itu di sini)</b></center>
				<br><br>
			</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Tuliskan undi dengan <b>RAHSIA</b> dengan mencatatkan tanda pangkah seperti ini <b>X</b> di dalam ruang yang disediakan di bawah ini bertentangan dengan perkataan <b>MENYOKONG</b> atau perkataan <b>MEMBANGKANG</b> mengikut keputusan sendiri. Janganlah dituliskan lain daripada tanda X dalam kertas ini dan jika dibuat demikian kertas undi ini akan ditolak sebagai rosak dan tidak dikira.</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Sesudah menulis tanda undi, lipatkanlah kertas undi ini sekurang-kurangnya sekali, masukkan ke dalam sampul suratnya dan masukkan ke dalam peti undi yang telah disediakan di dalam bilik mengundi itu. Jika tuan / puan mengundi dengan pos, lipatkan kertas undi ini sekurang-kurangnya sekali, masukkan ke dalam sampul surat yang telah disediakan dan hantarkan kepada Setiausaha supaya sampai kepadanya tidak lewat dari .................... 20 ..........</td>
		</tr>
	</table><br>
	<table class="border collapse" style="width: 400;">
		<tr class="border center center">
			<th class="border" width="15%">Pilihan</th>
			<th class="border" width="15%">Undi di sini</th>
		</tr>
		<tr class="border">
			<td class="border left">MENYOKONG</td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border left">MEMBANGKANG</td>
			<td class="border left"></td>
		</tr>
	</table><br>
	<div class="right bold">______________________&nbsp;&nbsp;&nbsp;</div>
	<div class="right bold">CAP Kesatuan atau&nbsp;&nbsp;&nbsp;&nbsp;</div>
	<div class="right bold">Tandatangan Setiausaha</div>
	<br><br>
	<hr>
	<div style="page-break-before: always;">
		<span><u>SENARAI PEMOHON</u></span><br>
		<table class="simple-table border">
			<tr class="border center">
				<th class="border bold" width="3%">BIL.</th>
				<th class="border" width="15%">NAMA</th>
				<th class="border" width="15%">JAWATAN</th>
				<th class="border" width="15%">NO. KP</th>
				<th class="border" width="7%">TANDA<br>TANGAN</th>
			<tr class="border">
				<td class="border center" >1</td>
				<td class="border"></td>
				<td class="border"></td>
				<td class="border"></td>
				<td class="border"></td>
			</tr>
			<tr class="border">
				<td class="border center">2</td>
				<td class="border"></td>
				<td class="border"></td>
				<td class="border"></td>
				<td class="border"></td>
			</tr>
			<tr class="border">
				<td class="border center">3</td>
				<td class="border"></td>
				<td class="border"></td>
				<td class="border"></td>
				<td class="border"></td>
			</tr>
			<tr class="border">
				<td class="border center">4</td>
				<td class="border"></td>
				<td class="border"></td>
				<td class="border"></td>
				<td class="border"></td>
			</tr>
			<tr class="border">
				<td class="border center">5</td>
				<td class="border"></td>
				<td class="border"></td>
				<td class="border"></td>
				<td class="border"></td>
			</tr>
			<tr class="border">
				<td class="border center">6</td>
				<td class="border"></td>
				<td class="border"></td>
				<td class="border"></td>
				<td class="border"></td>
			</tr>
			<tr class="border">
				<td class="border center">7</td>
				<td class="border"></td>
				<td class="border"></td>
				<td class="border"></td>
				<td class="border"></td>
			</tr>
		</table>
	</div>
</div>
