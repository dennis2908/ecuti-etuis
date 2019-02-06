
<style>
table {
	width: 100%;
	margin-top: 20px;

}

#document td {
	text-align: justify;
}

.collapse {
	border-collapse: collapse;
}

.justify {
	text-align: justify;
}
.parent {
	position: relative;
}
.child {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
}
.bold {
	font-weight: bold;
}
.border {
	border: 1px solid black;
}
.uppercase {
	text-transform: uppercase;
}
.lowercase {
	text-transform: lowercase;
}
.italic {
	font-style: italic;
}
.camelcase {
	text-transform: capitalize;
}
.left {
	text-align: left !important;
}
.center {
	text-align: center !important;
}
.right {
	text-align: right !important;
}
.break {
	page-break-before: always;
	margin-top: 25px;
}
.divider {
	width: 5px;
	vertical-align: top;
}
.no-padding {
	padding: 0px;
}
.padding-custom {
	padding: 30px;
}
.fit {
	max-width:100%;
	white-space:nowrap;
}
.absolute-center {
	margin: auto;
	position: absolute;
	top: 0; left: 0; bottom: 0; right: 0;
}
.top {
	vertical-align: top;
}
.dotted{
    border-bottom: 2px dotted black;
    margin-bottom:3px;
}
.margin-custom {
	margin: 150px;
}
.margin-50 {
	margin: 50px;
}
.bottom {
	padding-bottom: 5cm;
}
.height26 {
	height: 26;
}
</style>

<div id="document">
	<div class="center">
		<span class="uppercase bold center">PERATURAN-PERATURAN</span><br><br>
		<span class="uppercase bold"><span class="entity_name">{{ $formb->union->name }}</span></span><br><br>
	</div>
	<div class="bold uppercase left">PERATURAN 1&nbsp; - &nbsp;NAMA DAN ALAMAT PEJABAT BERDAFTAR</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Nama Kesatuan Sekerja yang ditubuhkan menurut Peraturan-peraturan ini ialah <b><span class="entity_name">{{ strtoupper($formb->union->name) }}</span> (yang selepas ini disebut Kesatuan)</b><br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Pejabat berdaftar kesatuan ialah <span class="uppercase entity_address">{{ strtoupper($formb->address->address1.
	    	($formb->address->address2 ? ', '.$formb->address->address2 : '').
	    	($formb->address->address3 ? ', '.$formb->address->address3 : '').', '.
	    	$formb->address->postcode.' '.
	    	($formb->address->district ? $formb->address->district->name : '').', '.
	    	($formb->address->state ? $formb->address->state->name : '')) }}</span> dan tempat mesyuaratnya ialah di pejabat berdaftar ini atau di mana-mana tempat lain yang ditetapkan oleh Majlis Jawatankuasa Agung.</td>
		</tr>
	</table>
	<br><br>
	<div class="bold uppercase left">PERATURAN 2 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; TUJUAN</div>
	<br>
	<div class="left">1.&nbsp;&nbsp;&nbsp;Tujuan Kesatuan ini ialah untuk :-</div>

	<table class="justify" width="50%">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Mengorganisasikan pekerja-pekerja yang disebut di bawah Peraturan 3(1) sebagai anggota Kesatuan dan memajukan kepentingan mereka dalam bidang perhubungan perusahaan, kemasyarakatan dan ilmu pengetahuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>Mengatur perhubungan di antara pekerja dengan majikan bagi maksudmelaksanakan perhubungan perusahaan yang baik dan harmoni,meningkatkan daya pengeluaran dan memperolehi serta mengekalkanbagi anggota-anggotanya keselamatan pekerjaan, sukatan gaji yang adil dan sesuai serta syarat-syarat pekerjaan yang berpatutan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>Mengatur perhubungan di antara anggota dengan anggota atau di antara anggota-anggota dengan pekerja-pekerja lain, di antara anggota dengan Kesatuan atau Pegawai Kesatuan, atau di antara Pegawai Kesatuan dengan Kesatuan dan menyelesaikan sebarang perselisihan atau pertikaian di antara mereka itu dengan cara aman dan bermuafakat atau melalui Jemaah Penimbangtara menurut Peraturan 26 atau Peraturan 27.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>Memajukan kebajikan anggota-anggota Kesatuan dari segi sosial, ekonomi dan pendidikan dengan cara yang sah di sisi undang-undang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>Memberi bantuan guaman kepada anggota-anggota berhubung dengan pekerjaan mereka jika dipersetujui oleh Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>Memberi bantuan seperti pembiayaan semasa teraniaya atau semasa pertikaian perusahaan jika dipersetujui oleh Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(g)&nbsp;&nbsp;&nbsp;</td>
			<td>Menganjurkan dan mengendalikan kursus, dialog, seminar dan sebagainya untuk faedah anggota-anggota Kesatuan khasnya dan para pekerja amnya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(h)&nbsp;&nbsp;&nbsp;</td>
			<td>Mengendalikan urusan mengarang, menyunting, mencetak, menerbit dan mengedarkan sebarang jurnal, majalah, buletin atau penerbitan lain untuk menjayakan tujuan-tujuan Kesatuan ini atau untuk kepentingan anggota-anggota Kesatuan jika dipersetujui oleh Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(i)&nbsp;&nbsp;&nbsp;</td>
			<td>Menubuhkan Tabung Wang Kebajikan dan menggubalkan peraturan- peraturan tambahan untuk mentadbir danmengawal tabung itu jika dipersetujui oleh Persidangan Perwakilan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(j)&nbsp;&nbsp;&nbsp;</td>
			<td>Secara amnya melaksanakan sebarang tujuan kesatuan sekerja yang sah di sisi undang-undang.</td>
		</tr>
	</table>

	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Tujuan yang dinyatakan dibawah Peraturan 2(1) hendaklah dilaksanakan menurut peraturan-peraturan ini, Akta Kesatuan Sekerja 1959 dan undang-undang bertulis yang lain yang ada kaitan.<br>&nbsp;</td>
		</tr>
	</table><br>

	<div class="bold uppercase left">PERATURAN 3 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; ANGGOTA KESATUAN</div>

	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Keanggotaan Kesatuan ini terbuka kepada <span class="membership_target">.................................</span> yang digaji oleh <span class="paid_by">................................</span> kecuali mereka yang memegang jawatan pengurusan, eksekutif, sulit atau keselamatan. Pekerja-pekerja itu hendaklah berumur lebih dari 16 tahun dan mempunyai tempat kerjanya di <span class="workplace">......... (Semenanjung Malaysia/ Sabah/ Sarawak)</span> tertakluk kepada syarat bahawa seseorang yang diuntukkan pendidikan dalam sesuatu sekolah, politeknik, kolej, universiti, kolej universiti atau institusi lain yang ditubuhkan di bawah mana-mana undang-undang bertulis tidak boleh menjadi anggota Kesatuan kecuali jika sekiranya ia:-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Sebenarnya seseorang pekerja menurut takrif dalam Akta Kesatuan Sekerja 1959; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>Berumur lebih daripada 18 tahun<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Permohonan untuk menjadi anggota hendaklah dilakukan dengan mengisi borang yang ditentukan oleh Kesatuan dan menyampaikannya kepada Setiausaha Cawangan. Setiausaha Cawangan hendaklah mengemukakan permohonan itu kepada Setiausaha Agung dan seterusnya menyampaikan permohonan tersebut kepada Majlis Jawatankuasa Agung untuk kelulusan. Majlis Jawatankuasa Agung hendaklah memaklumkan keputusan permohonan tersebut kepada Setiausaha Cawangan dan pemohon.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah permohonan seseorang itu diluluskan oleh Majlis Jawatankuasa Agung dan yuran masuk serta yuran bulanan yang pertama dijelaskan maka namanya hendaklah didaftarkan dalam Daftar Yuran / Keanggotaan sebagai anggota.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang anggota itu hendaklah diberikan senaskah buku Peraturan-peraturan Kesatuan dengan percuma apabila diterima sebagai anggota.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang yang diterima masuk menjadi anggota dan kemudian berhenti daripada tempat kerjanya, tred atau industri seperti dinyatakan dalam Peraturan 3(1) akan dengan sendirinya terhenti dari menjadi anggota Kesatuan. Namanya hendaklah dikeluarkan daripada Daftar Yuran/Keanggotaan tertakluk kepada peruntukan berkenaan di bawah Peraturan Tambahan Tabung Kebajikan (jika ada).<br>&nbsp;</td>
		</tr>
	</table>
	<br>
	<div class="bold uppercase left">PERATURAN 4 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; YURAN DAN TUNGGAKAN</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Tujuan Kesatuan ini ialah untuk :-<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;"> &nbsp;&nbsp;&nbsp;</td>
			<td>Yuran Masuk &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RM <span class="entrance_fee">.........</span></td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;"> &nbsp;&nbsp;&nbsp;</td>
			<td>Yuran Bulanan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RM <span class="monthly_fee">.........</span><br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">&nbsp;&nbsp;&nbsp;</td>
			<td>
				Sejumlah RM <span class="fixed_fee">.........</span> / <span class="percentage_fee">.........</span> % daripada Yuran Bulanan hendaklah diagihkan kepada setiap cawangan mengikut jumlah keahlian cawangan sebelum 15hb setiap bulan.
				<br>
				Sebarang kenaikan yuran hendaklah diputuskan dengan undi rahsia menurutPeraturan 25.<br>&nbsp;
			</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Yuran bulanan hendaklah dijelaskan sebelum tujuh (7) haribulan pada tiap-tiap bulan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang anggota yang terhutang yuran selama tiga bulan berturut-turut akan hilang haknya sebagai anggota kesatuan dan sekiranya masih terhutang selama enam bulan berturut-turut dengan sendirinya terhenti daripada menjadi anggota Kesatuan. Namanya hendaklah dipotong dari Daftar Yuran / Keanggotaan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang yang terhenti daripada menjadi anggota kerana tunggakan yuran boleh memohon semula untuk menjadi anggota menurut Peraturan 3(2).<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung berkuasa menetapkan kadar bayaran yuran bulanan yang kurang atau mengecualikan buat sementara waktu mana-mana anggota daripada bayaran yuran bulanan atau sebarang kutipan atau yuran khas (jika ada):-<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify" width="50%">
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
			<td>kerana sebarang sebab lain yang difikirkan munasabah dan wajar oleh Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 5 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; BERHENTI MENJADI ANGGOTA</div><br>
	<div class="left justify">Seseorang anggota yang ingin berhenti menjadi anggota Kesatuan hendaklah memberi notis secara bertulis sekurang-kurangnya seminggu sebelum tarikh berhenti kepada Setiausaha Cawangan dan hendaklah menjelaskan terlebih dahulu semua tunggakan yuran dan hutang (jika ada). Setiausaha Agung hendaklah mengemukakan notis tersebut kepada Majlis Jawatankuasa Agung untuk disahkan dan nama anggota berkenaan hendaklah dipotong dari Daftar Yuran / Keanggotaan.<br>&nbsp;</div><br>

	<div class="bold uppercase left">PERATURAN 6 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; HAK ANGGOTA</div><br>
	<div class="left justify">Semua anggota mempunyai hak yang sama dalam Kesatuan kecuali dalam perkara-perkara tertentu yang dinyatakan dalam peraturan-peraturan ini.<br>&nbsp;</div><br>

	<div class="bold uppercase left">PERATURAN 7 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; KEWAJIPAN DAN TANGGUNGJAWAB ANGGOTA-ANGGOTA</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Setiap anggota hendaklah menjelaskan yurannya menepati masa dan mendapatkan resit rasmi bagi bayarannya itu. Pembayaran yuran bulanan dalam tempoh masa yang ditetapkan adalah tanggungjawab setiap anggota dan bukannya tanggungjawab pegawai-pegawai Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Setiap anggota hendaklah memberitahu Setiausaha Cawangan dengan segera apabila berpindah tempat tinggal atau bertukar tempat kerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang anggota yang menghadiri mesyuarat Kesatuan atau menggunakan pejabat Kesatuan hendaklah berkelakuan baik, jika tidak ia akan diarah keluar oleh seorang pegawai Kesatuan yang bertanggungjawab.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang anggota tidak boleh mengeluarkan sebarang dokumen atau surat pekeliling tentang Kesatuan tanpa mendapat kelulusan Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang anggota tidak boleh mendedahkan sebarang hal tentang kegiatan Kesatuan kepada orang yang bukan anggota atau kepada pertubuhan lain atau pihak akhbar tanpa mendapat izin Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
	</table><br>

	<div class="break"> </div><br>

	<div class="bold uppercase left">PERATURAN 8 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PERLEMBAGAAN DAN PENTADBIRAN</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Kuasa yang tertinggi sekali dalam Kesatuan terletak kepada Persidangan Perwakilan melainkan perkara-perkara yang hendaklah diputuskan melalui undi rahsia menurut Peraturan 25.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Tertakluk kepada syarat tersebut di atas Kesatuan hendaklah ditadbirkan oleh Majlis Jawatankuasa Agung dan Cawangan-cawangan Kesatuan ditadbirkan oleh Jawatankuasa Cawangan.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 9 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PERSIDANGAN PERWAKILAN <span class="conference_yearly">.........</span> TAHUNAN</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan Kesatuan ini hendaklah diadakan dengan seberapa segera selepas 30hb. Jun dan tidak lewat dari 31hb. Oktober pada tiap-tiap <span class="conference_yearly">.........</span> tahun. Tarikh, masa dan tempat persidangan itu hendaklah ditetapkan oleh Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan itu hendaklah terdiri daripada wakil-wakil yang dipilih oleh cawangan-cawangan dan anggota-anggota Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Wakil-wakil cawangan hendaklah dipilih oleh semua anggota berhak di cawangan masing-masing pada tiap-tiap <span class="rep_yearly">.........</span> tahun dengan undi rahsia di dalam Mesyuarat Agung <span class="meeting_yearly">.........</span> Tahunan Cawangan masing-masing. Tiap-tiap cawangan hendaklah memilih dua orang wakil bagi <span class="first_member">.......</span> anggota yang pertama atau sebahagian daripadanya dan seorang wakil bagi tiap-tiap <span class="next_member">.......</span> orang anggota lebih daripada <span class="first_member">.......</span> anggota yang pertama itu. Tiap-tiap satu cawangan berhak menghantar tidak lebih daripada <span class="max_rep">.......</span> orang wakil sahaja. &quot;Anggota&quot; di sini adalah bermakna anggota yang berhak mengundi pada masa pengundian wakil-wakil itu dijalankan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Ahli Majlis Jawatankuasa Agung tidak boleh dipilih menjadi wakil.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Hanya wakil-wakil sahaja yang boleh mengundi di dalam Persidangan Perwakilan. Pengerusi Persidangan Perwakilan boleh memberi undi pemutus kecuali perkara-perkara di bawah Peraturan 25. Persidangan itu boleh mengadakan Aturan Tetap untuk mengawal perjalanan mesyuarat bagi semua Persidangan Perwakilan dan cara-cara mengundi dalam persidangan-persidangan itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.&nbsp;&nbsp;&nbsp;</td>
			<td>Notis permulaan bagi Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan yang menyatakan tarikh, masa dan tempat persidangan hendaklah dihantar oleh Setiausaha Agung kepada semua Setiausaha Cawangan sekurang-kurangnya tiga puluh (30) hari sebelum tarikh persidangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">7.&nbsp;&nbsp;&nbsp;</td>
			<td>Semua Setiausaha Cawangan hendaklah menghantar kepada Setiausaha Agung sekurang-kurangnya dua puluh satu (21) hari sebelum Persidangan Perwakilan butir-butir mengenai wakil-wakil cawangan masing-masing, nama- nama calon bagi pegawai kanan dan nama-nama Ahli Majlis Jawatankuasa Agung serta usul-usul (jika ada) termasuk usul pindaan peraturan untuk dibincangkan di dalam persidangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung hendaklah menyediakan tatacara pengisian borang pencalonan dan asas-asas penolakan pencalonan dan diedarkan kepada semua cawangan. Semua pencalonan hendaklah dibuat di atas borang yang ditentukan oleh kesatuan dan mengandungi butir-butir berikut :-<br>
			Nama jawatan yang ditandingi, nama calon, nombor kad pengenalan, nombor keanggotaan, tarikh lahir, alamat kediaman, pekerjaan dan nombor sijil kerakyatan/ taraf kerakyatan.<br>&nbsp;</td>
		</tr>
	</table>
	<div class="left">9.&nbsp;&nbsp;&nbsp;Sesuatu pencalonan tidak sah jika:</div>

	<table class="justify" width="50%">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>ia tidak ditandatangani oleh seorang pencadang dan seorang penyokong yang merupakan anggota-anggota berhak; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>ia tidak mengandungi persetujuan bertulis calon yang hendak bertanding.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">10.&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Agung hendaklah menghantar kepada semua Setiausaha Cawangan sekurang-kurangnya empat belas (14) hari sebelum tarikh persidangan suatu agenda yang mengandungi usul-usul untuk perbincangan, penyata tahunan dan penyata kewangan (jika ada) dan kertas-kertas undi rahsia dengan secukupnya menurut kembaran kepada peraturan-peraturan ini untuk pemilihan Pegawai-pegawai Kanan Kesatuan dan untuk mengundi perkara-perkara yang akan diputuskan dengan undi rahsia. Setiausaha Cawangan hendaklah mengedarkan kertas-kertas undi itu dengan sampulnya kepada anggota-anggota cawangan yang berhak mengundi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.&nbsp;&nbsp;&nbsp;</td>
			<td>Cukup kuorum mesyuarat jika wakil-wakil yang hadir, dengan tidak kira bilangan orangnya, mewakili lebih daripada setengah (Â½) dari jumlah bilangan cawangan-cawangan kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">12.&nbsp;&nbsp;&nbsp;</td>
			<td>Jika selepas satu jam dari masa yang ditentukan itu bilangan wakil yang hadir tidak mencukupi maka persidangan itu hendaklah ditangguhkan kepada satu tarikh (tidak lewat daripada dua puluh satu (21) hari kemudian) yang akan ditetapkan oleh Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">13.&nbsp;&nbsp;&nbsp;</td>
			<td>Sekiranya kuorum bagi Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan yang ditangguhkan itu masih belum mencukupi pada masa yang ditentukan maka wakil-wakil yang hadir berkuasa menguruskan persidangan itu akan tetapi tidak berkuasa meminda peraturan-peraturan kesatuan.<br>&nbsp;</td>
		</tr>
	</table>
	<div class="left">14.&nbsp;&nbsp;&nbsp;Urusan Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan antara lain ialah :-</div>

	<table class="justify" width="50%">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>menerima dan meluluskan laporan-laporan daripada Setiausaha Agung, Bendahari Agung dan Majlis Jawatankuasa Agung;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>membincang dan memutuskan sebarang perkara atau usul tentang kebajikan anggota-anggota dan kemajuan Kesatuan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>memilih/ melantik :-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">i)&nbsp;&nbsp;&nbsp;</td>
			<td>Pemegang Amanah; jika perlu</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">ii)&nbsp;&nbsp;&nbsp;</td>
			<td>Ahli Jemaah Penimbangtara;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">iii)&nbsp;&nbsp;&nbsp;</td>
			<td>Juruaudit Dalam; dan</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">iv)&nbsp;&nbsp;&nbsp;</td>
			<td>Pemeriksa Undi.</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>meluluskan pelantikan pegawai atau pekerja sepenuh masa (tetap/kontrak) Kesatuan sekiranya perlu dan menetapkan skim gaji serta syarat-syarat pekerjaannya;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>membincang dan memutuskan perkara-perkara lain yang terkandung di dalam agenda; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>menerima penyata Jemaah Pemeriksa Undi tentang pemilihan Majlis Jawatankuasa Agung dan perkara-perkara lain (jika ada).<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">15.&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Agung hendaklah menyampaikan kepada semua Setiausaha Cawangan satu salinan rangka minit Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan dalam tempoh tidak melebihi tujuh (7) hari sesudah sahaja selesai persidangan itu.<br>&nbsp;</td>
		</tr>
	</table><br>

	<div class="break"> </div><br><br>

	<div class="bold uppercase left">PERATURAN 10 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; MESYUARAT AGUNG LUARBIASA</div><br>
	<div class="left">1.&nbsp;&nbsp;&nbsp;Persidangan Perwakilan luar biasa hendaklah diadakan :-<br>&nbsp;</div>

	<table class="justify" width="50%">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>apabila difikirkan mustahak oleh Majlis Jawatankuasa Agung; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>apabila menerima permintaan bersama secara bertulis daripada sekurang-kurangnya dua cawangan atau lebih dan kedua-dua cawangan berkenaan masing-masing mewakili sekurang-kurangnya satu perempat (1/4) dari jumlah anggota cawangan itu. Permintaan tersebut hendaklah menyatakan tujuan dan sebab persidangan itu perlu diadakan.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Persidangan Perwakilan Luarbiasa yang diminta oleh cawangan-cawangan itu hendaklah diadakan dalam tempoh tiga puluh (30) hari dari tarikh permintaan itu diterima.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Notis dan agenda bagi Persidangan Perwakilan Luarbiasa hendaklah disampaikan oleh Setiausaha Agung kepada semua Setiausaha Cawangan sekurang-kurangnya sepuluh (10 hari) sebelum tarikh Persidangan Perwakilan Luarbiasa.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Persidangan Perwakilan Luarbiasa yang difikirkan mustahak oleh Majlis Jawatankuasa Agung hendaklah diadakan oleh Setiausaha Agung dalam tempoh dua puluh satu (21) hari dari tarikh permintaan itu diterima. Notis dan agenda hendaklah disampaikan oleh Setiausaha Agung kepada wakil-wakil sekurang-kurangnya tujuh (7) hari sebelum tarikh Persidangan Perwakilan Luarbiasa.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Peruntukan-peruntukan Peraturan 9 tentang kuorum dan penangguhan Persidangan Perwakilan adalah terpakai kepada Persidangan Perwakilan Luarbiasa.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.&nbsp;&nbsp;&nbsp;</td>
			<td>Bagi Persidangan Perwakilan Luarbiasa yang diminta oleh cawangan-cawangan atau diadakan kerana difikirkan mustahak oleh Majlis Jawatankuasa Agung ditangguhkan kerana tidak cukup kuorum mengikut Peraturan 9, maka Persidangan Perwakilan Luarbiasa yang ditangguhkan itu hendaklah ditutupkan sekiranya kuorum masih tidak diperolehi selepas satu (1) jam dari masa yang dijadualkan. Persidangan Perwakilan Luarbiasa bagi perkara yang sama tidak boleh diminta lagi dalam tempoh enam (6) bulan dari tarikh mesyuarat itu ditutupkan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">7.&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Agung hendaklah menyampaikan kepada semua Setiausaha Cawangan satu salinan rangka minit Persidangan Perwakilan Luarbiasa dalam tempoh tidak melebihi tujuh (7) hari selepas selesai persidangan itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.&nbsp;&nbsp;&nbsp;</td>
			<td>Jika sesuatu Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan itu tidak dapat diadakan dalam masa yang ditentukan di bawah Peraturan 9, maka Persidangan Perwakilan Luarbiasa berkuasa menjalankan sebarang tugas- tugas yang lazim dijalankan oleh Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan dengan syarat Persidangan Perwakilan Luarbiasa yang demikian mestilah diadakan sebelum 31 Disember dalam tahun berkenaan.<br>&nbsp;</td>
		</tr>
	</table><br>

	<div class="break"> </div><br><br>

	<div class="bold uppercase left">PERATURAN 11 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PEGAWAI DAN KAKITANGAN</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Pegawai Kesatuan bererti seorang yang menjadi Ahli Majlis Jawatankuasa Agung atau Ahli Jawatankuasa Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang tidak boleh dipilih atau bertugas sebagai pegawai kesatuan sekiranya :-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>bukan anggota Kesatuan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>belum genap umur 21 tahun;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>bukan warganegara Malaysia;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>pernah menjadi anggota eksekutif mana-mana kesatuan yang pendaftarannya telah ditutupkan di bawah Seksyen 15(1)(b)(iv), (v) dan (vi) Akta Kesatuan Sekerja 1959 atau Enakmen yang telah dimansuhkan oleh Akta itu;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>telah disabitkan oleh mahkamah kerana kesalahan pecah amanah, pemerasan atau intimidasi atau apa-apa kesalahan di bawah Seksyen 49, 50 atau 50A Akta Kesatuan Sekerja 1959 atau sebarang kesalahan lain yang pada pendapat Ketua Pengarah Kesatuan Sekerja menyebabkan tidak layak menjadi pegawai sesebuah kesatuan sekerja;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>pemegang jawatan (office bearer) atau pekerja sesebuah parti politik; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(g)&nbsp;&nbsp;&nbsp;</td>
			<td>masih bankrap.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung berkuasa menggaji pekerja-pekerja sepenuh masa yang difikirkan perlu setelah mendapat kelulusan Persidangan Perwakilan. Seseorang pekerja Kesatuan selain daripada mereka yang tersebut dalam &quot;proviso&quot; kepada Seksyen 29(1) Akta Kesatuan Sekerja 1959, tidak boleh menjadi pegawai Kesatuan atau bertugas dan bertindak sedemikian rupa sehingga urusan hal ehwal Kesatuan seolah-olah dalam pengawalannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang tidak boleh digaji sebagai pekerja Kesatuan jika dia :-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>bukan warganegara Malaysia;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>telah disabitkan oleh sesebuah mahkamah kerana melakukan suatu kesalahan jenayah dan belum lagi mendapat pengampunan bagi kesalahan tersebut dan kesalahan itu pada pendapat Ketua Pengarah Kesatuan Sekerja tidak melayakkannya digaji oleh sesebuah Kesatuan sekerja;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>pegawai atau pekerja sesebuah kesatuan sekerja yang lain; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>pemegang jawatan (office-bearer) atau pekerja sesebuah parti politik.<br>&nbsp;</td>
		</tr>
	</table><br>

	<div class="break"> </div><br><br>

	<div class="bold uppercase left">PERATURAN 12 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; MAJLIS JAWATANKUASA AGUNG</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung adalah menjadi badan yang menjalankan pentadbiran dan pengurusan hal ehwal kesatuan termasuk hal-hal pertikaian perusahaan dalam masa di antara dua Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan.</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung hendaklah terdiri daripada :-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Seorang Presiden</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Seorang Naib Presiden</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Seorang Setiausaha Agung</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Seorang Penolong Setiausaha Agung</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(5)&nbsp;&nbsp;&nbsp;</td>
			<td>Seorang Bendahari Agung</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(6)&nbsp;&nbsp;&nbsp;</td>
			<td>Seorang Penolong Bendahari Agung</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="5%" class="right">&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>dan</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="5%" class="right">&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td class="left">Seorang Ahli Majlis Jawatankuasa <br> Agung dari tiap-tiap cawangan</td>
		</tr>
	</table>

	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Sekiranya seseorang calon untuk jawatan itu tidak ditandingi dan pencalonannya telah dilaksanakan menurut cara-cara yang ditentukan di dalam Peraturan 9(7) maka dia akan dianggap telah dipilih dan namanya hendaklah diasingkan dari kertas undi bagi pemilihan pegawai-pegawai.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung pertama hendaklah dipilih dengan undi rahsia dalam masa enam bulan setelah kesatuan didaftarkan dan sehingga pemilihan itu dijalankan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Penaja yang dipilih semasa penubuhan kesatuan hendaklah menguruskan hal ehwal kesatuan. Majlis Jawatankuasa Penaja juga hendaklah melantik lima (5) orang pemeriksa undi sementara dan seorang daripadanya hendaklah dipilih sebagai Ketua Pemeriksa Undi untuk mengendalikan pemilihan pegawai yang pertama.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.&nbsp;&nbsp;&nbsp;</td>
			<td>Ahli Majlis Jawatankuasa Agung akan memegang jawatan daripada satu Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan ke satu Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan berikutnya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">7.&nbsp;&nbsp;&nbsp;</td>
			<td>Sekiranya dalam satu (1) Persidangan Perwakilan Luarbiasa suatu usul &quot;tidak percaya&quot; telah diluluskan terhadap Majlis Jawatankuasa Agung oleh dua pertiga (2/3) suara terbanyak, Majlis Jawatankuasa Agung hendaklah dengan serta merta bertugas sebagai pengurus sementara dan hendaklah mengadakan pemilihan semula pegawai-pegawai Kesatuan dengan undi rahsia dalam tempoh sebulan setelah Persidangan Perwakilan Luarbiasa itu. Pegawai-pegawai yang dipilih dengan cara ini akan memegang jawatan sehingga Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan yang akan datang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila berlakunya pertukaran pegawai-pegawai, pegawai atau Majlis Jawatankuasa Agung yang bakal meninggalkan jawatan hendaklah dalam satu (1) minggu menyerahkan segala rekod berhubung dengan jawatannya kepada pegawai atau Majlis Jawatankuasa Agung yang mengambil alih jawatan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">9.&nbsp;&nbsp;&nbsp;</td>
			<td>Pemberitahuan tentang pemilihan pegawai-pegawai hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja dalam tempoh empat belas (14) hari selepas pemilihan itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">10.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung hendaklah bermesyuarat sekurang-kurangnya tiga (3) bulan sekali dan setengah (1/2) daripada jumlah anggotanya akan menjadi kuorum mesyuarat. Minit Mesyuarat Majlis Jawatankuasa Agung hendaklah disahkan pada mesyuarat berikutnya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.&nbsp;&nbsp;&nbsp;</td>
			<td>Mesyuarat Majlis Jawatankuasa Agung hendaklah diuruskan oleh Setiausaha Agung dengan arahan atau persetujuan Presiden. Notis dan agenda mesyuarat hendaklah diberi kepada semua Ahli Majlis Jawatankuasa Agung sekurang-kurangnya lima (5) hari sebelum mesyuarat tersebut diadakan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">12.&nbsp;&nbsp;&nbsp;</td>
			<td>Permintaan secara bertulis untuk mengadakan mesyuarat Majlis Jawatankuasa Agung boleh dibuat oleh sekurang-kurangnya setengah daripada jumlah Ahli Majlis Jawatankuasa Agung. Permintaan itu hendaklah dikemukakan kepada Setiausaha Agung yang akan mengadakan mesyuarat yang diminta dalam tempoh empat belas (14) hari dari tarikh pemintaan berkenaan diterima.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">13.&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila berlaku sesuatu perkara yang memerlukan keputusan serta merta oleh Majlis Jawatankuasa Agung dan tidak dapat diadakan mesyuarat tergempar maka Setiausaha Agung boleh dengan persetujuan Presiden mendapatkan kelulusan melalui surat pekeliling. Syarat-syarat yang tersebut di bawah ini hendaklah disempurnakan sebelum perkara itu boleh dianggap sebagai telah diputuskan oleh Majlis Jawatankuasa Agung :-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>perkara dan tindakan yang dicadangkan hendaklah dinyatakan dengan jelas dan salinan surat pekeliling itu disampaikan kepada semua Ahli Majlis Jawatankuasa Agung;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>sekurang-kurangnya setengah (1/2) daripada jumlah Ahli Majlis Jawatankuasa Agung telah menyatakan secara bertulis sama ada mereka itu bersetuju atau tidak dengan cadangan tersebut; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>suara yang terbanyak daripada mereka yang menyatakan sokongan atau sebaliknya tentang cadangan tersebut akan menjadi keputusan.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">14.&nbsp;&nbsp;&nbsp;</td>
			<td>Keputusan yang didapati melalui surat pekeliling itu hendaklah dilaporkan oleh Setiausaha Agung dalam mesyuarat Majlis Jawatankuasa Agung atau Persidangan Perwakilan yang akan datang dan dicatatkan dalam minit mesyuarat itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">15.&nbsp;&nbsp;&nbsp;</td>
			<td>Ahli Majlis Jawatankuasa Agung yang tidak menghadiri mesyuarat tiga (3) kali berturut-turut tidak lagi berhak menyandang jawatannya kecuali dia dapat memberi alasan yang memuaskan kepada Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">16.&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila seseorang pegawai Kesatuan dan wakil-wakil meninggal dunia, berhenti atau terlucut hak, maka calon yang mendapat undi yang terkebawah sedikit bagi jawatan berkenaan dalam masa undian yang lalu hendaklah dijemput untuk mengisi tempat yang kosong itu. Bagi jawatan Presiden, Naib Presiden, Setiausaha Agung, Penolong Setiausaha Agung, Bendahari Agung atau Penolong Bendahari Agung calon tersebut hendaklah mendapat tidak kurang daripada satu perempat (1/4) jumlah undi yang telah dibuang bagi jawatan itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">17.&nbsp;&nbsp;&nbsp;</td>
			<td>Jika tiada calon yang layak atau calon yang layak enggan menerima jawatan tersebut maka Majlis Jawatankuasa Agung berkuasa melantik seorang anggota yang layak untuk mengisi kekosongan itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">18.&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Agung hendaklah menghantar notis pertukaran pegawai-pegawai kepada Ketua Pengarah Kesatuan Sekerja dalam masa empat belas (14) hari dari tarikh pertukaran dibuat.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">19.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung boleh menggunakan sebarang kuasa dan menjalankan sebarang kerja yang difikirkan perlu bagi mencapai tujuan-tujuan kesatuan dan untuk memajukan kepentingannya dengan mematuhi peraturan-peraturan ini, Akta Kesatuan Sekerja 1959 dan Peraturan-peraturan Kesatuan Sekerja 1959.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">20.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung hendaklah mengawal tabung wang Kesatuan supaya tidak dibelanjakan dengan boros atau disalahgunakan. Majlis Jawatankuasa Agung hendaklah mengarahkan Setiausaha Agung atau pegawai yang lain mengambil langkah-langkah sewajarnya supaya seseorang pegawai, pekerja ataupun anggota Kesatuan didakwa di mahkamah kerana menyalahguna atau mengambil secara tidak sah wang atau harta kepunyaan Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">21.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung hendaklah mengarahkan Setiausaha Agung atau pegawai yang lain supaya menguruskan kerja-kerja Kesatuan dengan sempurna.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">22.&nbsp;&nbsp;&nbsp;</td>
			<td>Tertakluk kepada Peraturan 11(3), Majlis Jawatankuasa Agung boleh menggaji mana-mana pegawai atau pekerja sepenuh masa yang difikirkan mustahak atas skim gaji dan syarat-syarat pekerjaan yang diluluskan oleh Persidangan Perwakilan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">23.&nbsp;&nbsp;&nbsp;</td>
			<td>Pegawai-pegawai atau pekerja-pekerja Kesatuan boleh digantung kerja atau diberhentikan oleh Majlis Jawatankuasa Agung kerana kelalaian, tidak amanah, tidak cekap atau enggan melaksanakan sebarang keputusan atau kerana sebab-sebab lain yang difikirkan munasabah atau wajar demi kepentingan Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">24.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung akan memberi arahan kepada Pemegang-pemegang Amanah tentang pelaburan wang Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">25.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung boleh menggantung atau memecat keanggotaan atau melarang daripada memegang jawatan seseorang anggota jika didapati bersalah kerana cuba hendak merosakkan Kesatuan atau melakukan perbuatan yang melanggar peraturan-peraturan ini atau membuat atau melibatkan diri dengan sebarang perbuatan mencela, mengeji atau mencerca Kesatuan, pegawai atau dasar Kesatuan. Sebelum tindakan tersebut diambil kesatuan hendaklah:<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>memberi peluang kepada anggota berkenaan untuk membela diri terhadap tuduhan berkenaan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>perintah penggantungan, pemecatan atau larangan tersebut hendaklah dibuat secara bertulis dan menyatakan dengan jelas bentuk dan alasan tentang penggantungan, pemecatan atau larangan tersebut; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>perintah tersebut (jika berkenaan) hendaklah menyatakan tempoh ianya berkuatkuasa dan syarat-syarat yang membolehkan ia ditarik balik.<br>&nbsp;</td>
		</tr>
	</table>

	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">26.&nbsp;&nbsp;&nbsp;</td>
			<td>Jika seseorang yang telah digantung faedahnya, dipecat atau dilarang daripada memegang jawatan berasa terkilan, dia berhak merujukkan kilanan berkenaan melalui Majlis Jawatankuasa Agung untuk diselesaikan oleh Jemaah Penimbangtara di bawah Peraturan 26 dan Peraturan 27 atau merayu terus kepada Persidangan Perwakilan dimana keputusan Persidangan Perwakilan adalah muktamad.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">27.&nbsp;&nbsp;&nbsp;</td>
			<td>Dalam masa antara Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan, Majlis Jawatankuasa Agung hendaklah mentafsirkan peraturan-peraturan Kesatuan dan jika perlu, akan menentukan perkara yang tidak ternyata dalam peraturan-peraturan ini.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">28.&nbsp;&nbsp;&nbsp;</td>
			<td>Sebarang keputusan Majlis Jawatankuasa Agung hendaklah dipatuhi oleh semua anggota Kesatuan kecuali sehingga ianya ditutupkan oleh suatu ketetapan dalam Persidangan Perwakilan melainkan keputusan yang berkehendakkan undi rahsia.<br>&nbsp;</td>
		</tr>
	</table><br><br>

	<div class="break"> </div><br><br>

	<div class="bold uppercase left">PERATURAN 13 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; TUGAS PEGAWAI-PEGAWAI KANAN KESATUAN</div>
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
			<td>menandatangani semua cek Kesatuan bersama-sama dengan Setiausaha Agung dan Bendahari Agung; dan<br>&nbsp;</td>
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
			<td>menjalankan tugas-tugas sebagaimana diarahkan oleh Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Agung</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Mengelolakan kerja-kerja Kesatuan mengikut peraturan-peraturan ini dan melaksanakan perintah-perintah dan arahan-arahan Persidangan Perwakilan atau Majlis Jawatankuasa Agung;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>mengawasi kerja-kerja kakitangan Kesatuan dan bertanggungjawab tentang surat-menyurat dan menyimpan buku-buku, surat-surat keterangan dan kertas-kertas Kesatuan mengikut cara dan aturan yang diarahkan oleh Majlis Jawatankuasa Agung;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>menetapkan serta menyediakan agenda mesyuarat Majlis Jawatankuasa Agung dengan persetujuan Presiden dan menghadiri semua mesyuarat, menulis minit-minit mesyuarat dan menyediakan Laporan Tahunan Kesatuan untuk Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>menyediakan atau menguruskan supaya disediakan Penyata-penyata Tahunan dan surat keterangan lain yang dikehendaki oleh Ketua Pengarah Kesatuan Sekerja dalam masa yang ditentukan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>menyimpan dan mengemaskini suatu Daftar Keanggotaan yang mengandungi nama anggota, nombor kad pengenalan, nombor keanggotaan, tarikh lahir, jantina, bangsa, yuran masuk, tarikh menjadi anggota, tarikh berhenti menjadi anggota, tarikh mula bekerja, alamat kediaman, nama dan alamat tempat pekerjaan, nombor telefon bimbit, butir-butir bilangan lelaki/perempuan, bilangan anggota dalam daftar dan bilangan anggota berhak.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>menandatangani semua cek Kesatuan bersama dengan Presiden dan Bendahari Agung.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Penolong Setiausaha Agung</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Membantu Setiausaha Agung dalam urusan pentadbiran kesatuan dan memangku jawatan Setiausaha Agung pada masa ketiadaannya; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>menjalankan tugas-tugas sebagaimana diarah oleh Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">(5)&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari Agung</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Bertanggungjawab dalam urusan penerimaan dan pembayaran wang Kesatuan dan urusan penyimpanan dokumen kewangan sebagaimana yang dikehendaki oleh Peraturan-peraturan Kesatuan Sekerja 1959;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>menyediakan Penyata Tahunan sebagaimana yang dikehendaki di bawah Seksyen 56, Akta Kesatuan Sekerja 1959;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>mengeluarkan Resit Rasmi bagi sebarang wang yang diterima;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>bertanggungjawab tentang keselamatan simpanan buku-buku kewangan dan surat-surat keterangan yang berkenaan di Ibu Pejabat. Buku-buku dan surat-surat keterangan ini tidak boleh dikeluarkan dari tempat rasminya tanpa kebenaran yang bertulis daripada Presiden pada tiap-tiap kali ia hendak dikeluarkan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>menyediakan Penyata Kewangan bagi tiap-tiap mesyuarat Majlis Jawatankuasa Agung dan Persidangan Perwakilan; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>Menandatangani semua cek Kesatuan bersama dengan Presiden dan Setiausaha Agung.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">(6)&nbsp;&nbsp;&nbsp;</td>
			<td>Penolong Bendahari Agung</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Membantu Bendahari Agung dalam urusan kewangan Kesatuan dan memangku jawatan Bendahari Agung pada masa ketiadaannya; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>menjalankan tugas-tugas sebagaimana diarah oleh Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 14 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PEMEGANG AMANAH</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Tiga orang Pemegang Amanah yang berumur tidak kurang dari 21 tahun dan bukan Setiausaha Agung atau Bendahari Agung Kesatuan hendaklah dilantik/dipilih di dalam Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan yang pertama. Mereka akan menyandang jawatan itu selama yang dikehendaki oleh Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Sebarang harta (tanah, bangunan, pelaburan dan lain-lain) yang dimiliki oleh Kesatuan hendaklah diserah kepada mereka untuk diuruskan sebagaimana yang diarahkan oleh Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Pemegang Amanah tidak boleh menjual, menarik balik atau memindah milik sebarang harta Kesatuan tanpa persetujuan dan kuasa daripada Majlis Jawatankuasa Agung yang disampaikan dengan bertulis oleh Setiausaha Agung dan Bendahari Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang Pemegang Amanah boleh diberhentikan daripada jawatannya oleh Majlis Jawatankuasa Agung kerana tidak sihat, tidak sempurna fikiran, tidak berada dalam negeri atau kerana sebarang sebab lain yang menyebabkan dia tidak boleh menjalankan tugasnya atau tidak dapat menyempurnakan tugasnya dengan memuaskan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Jika seseorang Pemegang Amanah meninggal dunia, berhenti atau diberhentikan maka kekosongan itu hendaklah diisi oleh mana-mana anggota yang dilantik oleh Majlis Jawatankuasa Agung sehingga Persidangan Perwakilan yang akan datang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.&nbsp;&nbsp;&nbsp;</td>
			<td>Persidangan Perwakilan boleh melantik sebuah syarikat pemegang amanah seperti yang ditakrifkan di bawah Akta Syarikat Amanah 1949 (Trust Companies Act 1949) atau undang-undang lain yang bertulis yang megawal syarikat-syarikat Pemegang Amanah di Malaysia untuk menjadi Pemegang Amanah yang tunggal bagi Kesatuan ini. Jika syarikat Pemegang Amanah tersebut dilantik maka rujukan &quot;Pemegang Amanah&quot; dalam peraturan- peraturan ini hendaklah difahamkan sebagai Pemegang Amanah yang dilantik.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">7.&nbsp;&nbsp;&nbsp;</td>
			<td>Butir-butir pelantikan Pemegang Amanah atau pertukaran Pemegang Amanah hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja dalam tempoh empat belas (14) hari selepas pelantikan atau pertukaran berkenaan untuk dimasukkan ke dalam daftar kesatuan. Sebarang perlantikan atau pertukaran tidak boleh dikuatkuasakan sehingga didaftarkan sedemikian.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 15 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; JURUAUDIT DALAM</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Dua orang Juruaudit Dalam yang bukan anggota Majlis Jawatankuasa Agung hendaklah dipilih secara angkat tangan dalam Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan. Mereka hendaklah memeriksa kira-kira Kesatuan pada penghujung tiap-tiap tiga (3) bulan dan menyediakan laporan kepada Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Dokumen-dokumen pentadbiran dan kewangan Kesatuan hendaklah diaudit bersama-sama oleh kedua-dua Juruaudit Dalam dan mereka itu berhak melihat semua buku dan surat keterangan yang perlu untuk menyempurnakan tugas mereka.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang anggota Kesatuan boleh mengadu secara bertulis kepada Juruaudit Dalam tentang sebarang hal kewangan yang tidak betul.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila berlaku kekosongan jawatan oleh sebarang sebab, kekosongan ini bolehlah diisi dengan cara lantikan oleh Majlis Jawatankuasa Agung sehingga Persidangan Perwakilan yang akan datang.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 16 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; JURUAUDIT LUAR</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Kesatuan hendaklah melantik seorang Juruaudit Luar bertauliah dan seterusnya memperolehi kelulusan Ketua Pengarah Kesatuan Sekerja bagi perlantikan ini. Juruaudit Luar itu hendaklah merupakan seorang akauntan yang telah memperolehi kebenaran bertulis daripada Menteri Kewangan untuk mengaudit kira-kira syarikat-syarikat di bawah Akta Syarikat 1965.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang Juruaudit Luar yang sama tidak boleh dilantik melebihi tempoh tiga (3) tahun berturut-turut.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Kira-kira Kesatuan hendaklah diaudit oleh Juruaudit Luar dengan segera selepas sahaja tahun kewangan ditutup pada 31 Mac dan hendaklah selesai sebelum 30 Ogos tiap-tiap tahun.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Juruaudit Luar berhak menyemak semua buku dan surat keterangan yang perlu untuk menyempurnakan tugasnya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Kira-kira Kesatuan yang diaudit hendaklah diakui benar oleh Bendahari Agung dengan surat akuan bersumpah (statutory declaration).<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.&nbsp;&nbsp;&nbsp;</td>
			<td>Satu salinan penyata kira-kira yang diaudit dan laporan Juruaudit Luar itu hendaklah diedarkan kepada tiap-tiap perwakilan sebelum Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan. Penyata kira-kira dan Laporan Juruaudit Luar tersebut hendaklah dibentangkan dalam Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan untuk kelulusan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">7.&nbsp;&nbsp;&nbsp;</td>
			<td>Kira-kira Kesatuan yang diaudit hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja berserta dengan Borang N sebelum 1 Oktober tiap-tiap tahun.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 17 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; JEMAAH PEMERIKSA UNDI</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Satu Jemaah Pemeriksa Undi yang terdiri daripada lima (5) orang anggota hendaklah dipilih secara angkat tangan dalam Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan untuk mengendalikan segala perjalanan undi rahsia. Seorang daripada mereka hendaklah dipilih sebagai ketua pemeriksa undi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Mereka hendaklah bukan pegawai Kesatuan atau calon bagi pemilihan pegawai-pegawai Kesatuan. Seboleh-bolehnya anggota-anggota yang dipilih ini hendaklah anggota-anggota yang tinggal di sekitar kawasan Ibu Pejabat Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Jemaah Pemeriksa Undi ini bertanggungjawab mengendalikan segala perjalanan undi rahsia yang dijalankan oleh kesatuan. Mereka akan berkhidmat dari suatu Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan ke Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan yang berikutnya. Apabila berlaku kekosongan, kekosongan ini hendaklah diisi dengan cara lantikan oleh Majlis Jawatankuasa Agung sehingga Mesyuarat Agung yang akan datang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Sekurang-kurangnya tiga Pemeriksa Undi hendaklah hadir apabila pembuangan undi dijalankan. Mereka hendaklah memastikan aturcara yang tertera di dalam kembaran kepada peraturan-peraturan ini dipatuhi dengan sepenuhnya.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 18 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; GAJI DAN BAYARAN-BAYARAN LAIN</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Skim gaji serta syarat-syarat pekerjaan bagi pegawai-pegawai kesatuan yang bekerja sepenuh masa dengan Kesatuan dan pekerja-pekerja Kesatuan hendaklah ditetapkan melalui usul yang diluluskan di Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Pegawai-pegawai Kesatuan yang dikehendaki berkhidmat separuh masa bagi pihak Kesatuan boleh dibayar saguhati. Jumlah pembayaran saguhati itu hendaklah ditetapkan oleh Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Pegawai-pegawai atau wakil-wakil Kesatuan boleh diberi bayaran gantirugi dengan kelulusan oleh Majlis Jawatankuasa Agung kerana hilang masa kerjanya dan perbelanjaan serta elaun yang munasabah bagi menjalankan kerja-kerja Kesatuan. Mereka itu hendaklah mengemukakan satu penyata yang menunjukkan butir-butir perjalanan dan bukti hilang masa kerjanya (jika berkenaan) dan perbelanjaan yang disokong resit atau keterangan pembayaran lain. Had maksimum bayaran, elaun dan perbelanjaan yang boleh dibayar hendaklah ditentukan dari semasa ke semasa oleh Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan dan Majlis Jawatankuasa Agung tidak boleh meluluskan sebarang bayaran yang melebihi had yang ditentukan oleh Persidangan Perwakilan itu.<br>&nbsp;</td>
		</tr>
	</table><br>

	<div class="break"> </div><br><br>

	<div class="bold uppercase left">PERATURAN 19 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; KEWANGAN DAN AKAUN</div>

	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Wang-wang kesatuan boleh dibelanjakan bagi perkara-perkara berikut :<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran gaji, elaun dan perbelanjaan kepada pegawai kesatuan dan pekerja-pekerja Kesatuan tertakluk kepada Peraturan 18.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran dan perbelanjaan pentadbiran Kesatuan termasuk bayaran mengaudit akaun Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran urusan pendakwaan atau pembelaan dalam prosiding undang-undang di mana Kesatuan atau seseorang anggotanya menjadi satu pihak yang bertujuan untuk memperolehi atau mempertahankan hak Kesatuan atau sebarang hak yang terbit daripada perhubungan di antara seseorang anggota dengan majikannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran urusan pertikaian perusahaan bagi pihak Kesatuan atau anggota-anggotanya dengan syarat bahawa pertikaian perusahaan itu tidak bertentangan dengan Akta Kesatuan Sekerja 1959 atau undang- undang bertulis yang lain.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran gantirugi kepada anggota kerana kerugian akibat daripada pertikaian perusahaan yang melibatkan anggota itu dengan syarat bahawa pertikaian perusahaan itu tidak bertentangan dengan Akta Kesatuan Sekerja 1959 atau undang-undang bertulis yang lain.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran elaun kepada anggota kerana berumur tua, sakit, ditimpa kemalangan atau hilang pekerjaan atau bayaran kepada tanggungannya apabila anggota itu meninggal dunia.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(g)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran yuran mengenai pergabungan atau keanggotaan dengan mana-mana persekutuan kesatuan sekerja yang telah didaftarkan di bawah Bahagian XII Akta Kesatuan Sekerja 1959 atau mana-mana badan perunding atau badan yang serupa yang mana kelulusan telah diberi oleh Ketua Pengarah Kesatuan Sekerja di bawah Seksyen 76A(1) Akta Kesatuan Sekerja 1959 atau Ketua Pengarah Kesatuan Sekerja telah diberitahu di bawah Seksyen 76A(2) Akta Kesatuan Sekerja 1959.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(h)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran-bayaran untuk :-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">(i)&nbsp;&nbsp;&nbsp;</td>
			<td>tambang keretapi, perbelanjaan pengangkutan lain yang perlu, perbelanjaan makan dan tempat tidur yang disokong dengan resit atau sebanyak mana yang telah ditentukan oleh Kesatuan tertakluk kepada had-had yang ditentukan di bawah Peraturan 18.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">(ii)&nbsp;&nbsp;&nbsp;</td>
			<td>amaun kehilangan gaji yang sebenar oleh wakil Kesatuan kerana menghadiri mesyuarat berkaitan atau berhubung dengan hal perhubungan perusahaan atau menyempurnakan perkara-perkara yang dikehendaki oleh Ketua Pengarah Kesatuan Sekerja berkaitan dengan Akta Kesatuan Sekerja 1959 atau sebarang peraturan tertakluk kepada had yang ditentukan di bawah Peraturan 18.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">(iii)&nbsp;&nbsp;&nbsp;</td>
			<td>perbelanjaan bagi menubuhkan atau mengekalkan persekutuan kesatuan sekerja yang didaftarkan di bawah Bahagian XII Akta Kesatuan Sekerja 1959 atau badan perunding atau badan yang serupa yang mana kelulusan telah diberi oleh Ketua Pengarah Kesatuan Sekerja di bawah Seksyen 76A(1) Akta Kesatuan Sekerja 1959 atau Ketua Pengarah Kesatuan Sekerja telah diberitahu di bawah Seksyen 76A(2) Akta Kesatuan Sekerja 1959.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(i)&nbsp;&nbsp;&nbsp;</td>
			<td>Urusan mengarang, mencetak, menerbit dan mengedarkan sebarang suratkhabar, majalah, surat berita atau penerbitan lain yang dikeluarkan oleh Kesatuan untuk menjayakan tujuan-tujuannya atau untuk memelihara kepentingan anggota-anggota selaras dengan peraturan-peraturan ini.<br>&nbsp;</td>
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
			<td>Pembayaran premium kepada syarikat-syarikat insurans berdaftar di Malaysia yang diluluskan oleh Ketua Pengarah Kesatuan Sekerja dari semasa ke semasa.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Tabung wang Kesatuan tidak boleh digunakan sama ada secara langsung atau sebaliknya untuk membayar denda atau hukuman yang dikenakan oleh mahkamah kepada sesiapa pun.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Wang-wang Kesatuan yang tidak dikehendaki untuk perbelanjaan semasa yang telah diluluskan hendaklah dimasukkan ke dalam bank oleh Bendahari Agung dalam tempoh tujuh (7) hari dari tarikh penerimaannya. Akaun bank itu hendaklah di atas nama Kesatuan dan butir-butir akaun itu hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja. Pembukaan sesuatu akaun bank itu hendaklah diluluskan oleh Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Semua cek atau notis pengeluaran wang atas akaun kesatuan hendaklah ditandatangani bersama oleh Presiden (pada masa ketiadaannya oleh Naib Presiden), Setiausaha Agung (pada masa ketiadaannya oleh Penolong Setiausaha Agung) dan Bendahari Agung (pada masa ketiadaannya oleh Penolong Bendahari Agung).<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari Agung dibenarkan menyimpan wang tunai tidak lebih daripada <span class="max_savings">......... ringgit (RM........)</span> pada sesuatu masa. Sebarang perbelanjaan yang melebihi <span class="max_expenses">......... ringgit (RM......)</span> tidak boleh dilakukan pada sesuatu masa kecuali dengan persetujuan terlebih dahulu daripada Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari Agung hendaklah menyediakan satu penyata belanjawan tahunan untuk diluluskan oleh Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan dan semua perbelanjaan yang dibuat oleh Kesatuan hendaklah dalam had-had yang ditetapkan oleh belanjawan yang diluluskan itu. Belanjawan tersebut boleh disemak semula dari semasa ke semasa dengan dipersetujui terlebih dahulu oleh anggota-anggota di dalam Persidangan Perwakilan Luar Biasa atau melalui undi rahsia.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">7.&nbsp;&nbsp;&nbsp;</td>
			<td>Semua harta Kesatuan hendaklah dimiliki bersama atas nama Pemegang-pemegang Amanah. Wang-wang Kesatuan yang tidak dikehendaki untuk urusan pentadbiran harian Kesatuan boleh digunakan bagi tujuan-tujuan seperti berikut:<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>membeli atau memajak sebarang tanah atau bangunan untuk kegunaan Kesatuan. Tanah atau bangunan ini tertakluk kepada sesuatu undang-undang bertulis atau undang-undang lain yang boleh dipakai, dipajak atau dengan persetujuan anggota-anggota kesatuan yang diperolehi melalui usul yang dibawa dalam mesyuarat Agung boleh dijual, ditukar atau digadai;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>melabur dalam amanah saham (securities) atau dalam pinjaman kepada mana-mana syarikat mengikut mana-mana undang-undang yang berkaitan dengan pemegang amanah;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>disimpan dalam Bank Simpanan Nasional, di mana-mana bank yang diperbadankan di Malaysia atau di mana-mana syarikat kewangan yang merupakan anak syarikat bank tersebut; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>dengan mendapat kelulusan terlebih dahulu daripada Menteri Sumber Manusia dan tertakluk kepada syarat-syarat yang dikenakan oleh beliau bagi melabur :-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">(i)&nbsp;&nbsp;&nbsp;</td>
			<td>dalam mana-mana Syarikat Kerjasama yang berdaftar; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">(ii)&nbsp;&nbsp;&nbsp;</td>
			<td>dalam mana-mana pengusahaan perdagangan, perindustrian atau pertanian atau dalam <i>enterprise</i> bank yang diperbadankan dan beroperasi di Malaysia.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">8.&nbsp;&nbsp;&nbsp;</td>
			<td>Semua belian dan pelaburan di bawah peraturan ini hendaklah diluluskan terlebih dahulu oleh Mesyuarat Majlis Jawatankuasa Agung dan dibuat di atas nama pemegang-pemegang amanah Kesatuan. Kelulusan ini hendaklah disahkan oleh Persidangan Perwakilan yang akan datang. Pemegang-pemegang amanah hendaklah memegang saham-saham atau pelaburan-pelaburan bagi pihak anggota-anggota Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">9.&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari Agung hendaklah merekod atau menguruskan supaya direkodkan dalam buku akaun kewangan Kesatuan sebarang penerimaan dan perbelanjaan wang kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">10.&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari Agung hendaklah pada atau sebelum 1 Oktober tiap-tiap tahun, atau apabila dia berhenti atau meletak jawatan daripada pekerjaannya, atau pada bila-bila masa dia dikehendaki berbuat demikian oleh Majlis Jawatankuasa Agung atau oleh anggota-anggota melalui suatu ketetapan yang dibuat dalam Persidangan Perwakilan atau apabila dikehendaki oleh Ketua Pengarah Kesatuan Sekerja mengemukakan kepada Kesatuan dan anggota-anggotanya atau kepada Ketua Pengarah Kesatuan Sekerja yang mana ada kaitan, satu penyata kewangan yang benar dan betul tentang semua wang yang diterima dan dibayarnya dari masa dia mula memegang jawatan itu atau, jika dia pernah membentangkan penyata kewangan terdahulu, dari tarikh penyata kewangan itu dibentangkan, baki wang dalam tangannya pada masa ia mengemukakan penyata kewangan itu dan juga semua bon dan jaminan atau harta-harta Kesatuan yang lain dalam simpanan atau jagaanya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.&nbsp;&nbsp;&nbsp;</td>
			<td>Penyata kewangan tersebut hendaklah mengikut bentuk yang ditentukan oleh Peraturan-peraturan Kesatuan Sekerja 1959 dan hendaklah diakui benar oleh Bendahari Agung dengan surat akuan bersumpah (statutory declaration). Kesatuan hendaklah menguruskan penyata kewangan tersebut diaudit mengikut Peraturan 16. Selepas penyata kewangan itu diaudit, Bendahari Agung hendaklah menyerahkan kepada pemegang-pemegang amanah Kesatuan jika dikehendaki oleh mereka itu semua bon, sekuriti, perkakasan, buku, surat dan harta Kesatuan yang ada dalam simpanan atau jagaannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">12.&nbsp;&nbsp;&nbsp;</td>
			<td>Selain daripada Bendahari Agung, pegawai-pegawai atau pekerja-pekerja kesatuan tidak boleh menerima wang atau mengeluarkan resit rasmi tanpa kuasa yang bertulis oleh Presiden pada tiap-tiap kali mereka itu berbuat demikian.<br>&nbsp;<br>&nbsp;</td>
		</tr>
	</table>

	<div class="bold uppercase left">PERATURAN 20 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PEMERIKSAAN DOKUMEN DAN AKAUN</div>
	<br>
	<div class="left">Tiap-tiap orang yang mempunyai kepentingan dalam tabung wang Kesatuan berhak memeriksa dokumen-dokumen pentadbiran kewangan kesatuan dan rekod nama- nama anggota Kesatuan pada masa yang munasabah di tempat rekod itu disimpan setelah memberi notis yang mencukupi dan berpatutan.</div><br>

	<div class="break"> </div><br><br>

	<div class="bold uppercase left">PERATURAN 21 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; YURAN KHAS (LEVI)</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah satu usul diputuskan dengan undi rahsia menurut Peraturan 25, Majlis Jawatankuasa Agung boleh memungut yuran khas( levi) daripada semua anggota Kesatuan kecuali mereka yang telah dikecualikan daripada bayaran ini oleh Majlis Jawatankuasa Agung menurut Peraturan 4 (5).<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Jika seseorang anggota tidak menjelaskan yuran khas(levi) itu dalam tempoh enam minggu dari tarikh ia dikenakan atau dalam tempoh yang lebih panjang yang ditetapkan dalam usul berkenaan maka yuran khas (levi) itu akan dikira sebagai tunggakan yuran Kesatuan dan anggota itu boleh terlucut haknya menurut Peraturan 4 (3).<br>&nbsp;</td>
		</tr>
	</table><br>

	<div class="bold uppercase left">PERATURAN 22 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PERTIKAIAN PERUSAHAAN</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Jika seseorang anggota tidak berpuas hati dengan syarat-syarat perkerjaannya atau sebarang hal yang lain maka ia bolehlah mengemukakan duannya kepada Setiausaha Cawangan secara bertulis. Setiausaha Cawangan itu hendaklah menyampaikan hal pengaduan itu kepada Jawatankuasa Cawangan dengan serta merta. Jika pengaduan anggota itu dibuat dengan lisan maka Setiausaha Cawangan hendaklah menuliskannya dan menyampaikan aduan itu kepada Jawatankuasa Cawangan bersama-sama dengan laporannya. Jawatankuasa Cawangan hendaklah memutuskan sama ada perkara itu akan diselenggarakan diperingkat Cawangan atau diserahkan kepada Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Jika berbangkit sesuatu pertikaian perusahaan, maka anggota-anggota yang berkenaan hendaklah menyampaikan hal itu kepada Setiausaha Cawangan dan Setiausaha Cawangan hendaklah serta-merta melaporkan hal itu kepada Jawatankuasa Cawangan Jawatankuasa Cawangan hendaklah menguruskan hal pertikaian itu jika difikirkan patut ia berbuat demikian atau merujuk perkara ini kepada Majlis Jawatankuasa Agung. Jawatankuasa Cawangan hendaklah memberitahu Majlis Jawatankuasa Agung berkaitan dengan perkembangan pertikaian itu sekiranya pertikaian itu diuruskan oleh Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Kesatuan tidak boleh menganjurkan mogok dan anggota-anggotanya tidak dibenarkan menjalankan mogok :-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>tanpa mendapat kelulusan Majlis Jawatankuasa Agung terlebih dahulu;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>tanpa mendapat persetujuan dengan undi rahsia sekurang-kurangnya 2/3 daripada jumlah anggota yang layak mengundi dan yang berkaitan dengan mogok yang akan dijalankan itu;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>sebelum luput tempoh tujuh (7) hari selepas keputusan udi rahsia itudikemukakan kepada Ketua Pengarah Kesatuan Sekerja mengikut Seksyen 40(5) Akta Kesatuan Sekerja 1959;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>sekiranya undi rahsia untuk cadangan mogok telah luput tempohnya atau tidak sah menurut peruntukan-peruntukan Seksyen 40(2), 40(6) atau 40(9), Akta Kesatuan Sekerja 1959;<br>&nbsp;</td>
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
			<td>jika mogok itu menyalahi atau tidak mematuhi mana-mana peruntukan lain Akta Kesatuan Sekerja 1959, atau mana-mana peruntukan undang-undang lain yang bertulis</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung tidak boleh menyokong pemogokan dengan memberi bantuan kewangan atau bantuan lain jika peruntukan-peruntukan Peraturan 22 (3) tidak dipatuhi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Sesuatu undi rahsia yang diambil tentang apa-apa perkara berkaitan dengan pemogokan hendaklah mengandungi suatu usul yang menerangkan dengan jelas akan isu yang menyebabkan cadangan pemogokan itu. Usul itu hendaklah juga menerangkan dengan jelas rupa bentuk tindakan yang akan dilakukan atau yang tidak akan dilakukan di sepanjang pemogokan itu. Undi rahsia yang tidak memenuhi kehendak-kehendak ini tidaklah sah dan tidak boleh dikuatkuasakan dan pemogokan tidak boleh dilakukan berdasarkan undi rahsia tersebut.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.&nbsp;&nbsp;&nbsp;</td>
			<td>Mana-mana anggota Kesatuan yang memulakan mogok, mengambil bahagian atau bertindak bagi melanjutkan pemogokan yang melanggar Akta Kesatuan Sekerja 1959 atau peraturan-peraturan ini atau mana-mana peruntukan Undang-undang bertulis akan terhenti dengan sendirinya daripada menjadi anggota Kesatuan dan selepas itu tidak boleh menjadi anggota Kesatuan ini atau kesatuan yang lain tanpa kelulusan bertulis daripada Ketua Pengarah Kesatuan Sekerja terlebih dahulu. Kesatuan hendaklah dengan serta-merta:-<br>&nbsp;</td>
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
			<td>mempamerkan di satu tempat yang mudah dilihat di pejabat kesatuan yang berdaftar satu senarai anggota-anggota yang nama mereka telah dikeluarkan itu.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 23 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; KEGIATAN PENDIDIKAN</div><br>
	<div class="justify left">Kesatuan boleh menjalankan aktiviti bagi menambah ilmu pengetahuan anggota-anggotanya dengan menganjurkan perjumpaan, seminar, bengkel, atau kursus. Selanjutnya kesatuan boleh menerbitkan bahan-bahan bacaan dan menjalankan urusan-urusan lain seumpama yang boleh memajukan pengetahuan anggota-anggota dalam hal perusahaan, kebudayaan dan kemasyarakatan dengan mematuhi kehendak undang-undang berkaitan perbelanjaan wang kesatuan sekerja yang dikuatkuasakan sekarang.<br>&nbsp;</div><br>

	<div class="bold uppercase left">PERATURAN 24 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PERATURAN-PERATURAN DAN PINDAAN PERATURAN-PERATURAN</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Pindaan kepada peraturan-peraturan yang akan meningkatkan lagi tanggungan anggota untuk mencarum, atau mengurangkan faedah yang dinikmatinya hanya boleh dibuat jika diluluskan oleh anggota-anggota dengan undi rahsia. Pindaan peraturan-peraturan lain boleh dibuat dengan kelulusan Persidangan Perwakilan yang diadakan menurut Peraturan 9 atau Peraturan 10 atau dengan undi rahsia.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Tiap-tiap pindaan peraturan-peraturan hendaklah berkuatkuasa dari tarikh pindaan itu didaftarkan oleh ketua Ketua Pengarah Sekerja kecuali jika suatu tarikh yang terkemudian dari itu ditentukan di dalam peraturan-peraturan ini.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Satu naskhah peraturan-peraturan Kesatuan yang becetak hendaklah dipamerkan di suatu tempat yang mudah dilihat di pejabat Kesatuan yang didaftarkan. Setiausaha hendaklah memberi senaskhah peraturan-peraturan Kesatuan kepada sesiapa juga yang memintanya dengan bayaran tidak lebih daripada sepuluh ringgit senaskhah.<br>&nbsp;</td>
		</tr>
	</table><br>

	<div class="break"> </div><br><br>

	<div class="bold uppercase left">PERATURAN 25 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; UNDI RAHSIA</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Keputusan-keputusan berkenaan dengan perkara-perkara yang tersebut di bawah ini hendaklah dibuat dengan undi rahsia oleh semua anggota berhak atau anggota-anggota berhak yang terlibat dengan pertikaian berkenaan, dengan syarat, anggota yang belum cukup 18 tahun tidak berhak mengundi atas perkara (c), (d), (e) dan (g);-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Pemilihan pegawai-pegawai kesatuan (selain dari Pemegang-pemegang Amanah, Juruaudit Dalam dan Pemeriksa Undi) sebagaimana Peraturan 12;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>pemilihan wakil-wakil ke Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan atau Persidangan Perwakilan Luarbiasa menurut Peraturan 9 atau pemilihan wakil-wakil Persekutuan Kesatuan-kesatuan sekerja;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>semua perkara mengenai mogok menurut Peraturan 22(3);<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>mengenakan kutipan/yuran khas;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>pindaan peraturan-peraturan ini jika pindaan itu meningkatkan lagi tanggungan anggota untuk mencarum atau mengurangkan faedah yang dinikmatinya;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>bercantum dengan kesatuan sekerja yang lain atau memindahkan urusan kepada kesatuan sekerja yang lain; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(g)&nbsp;&nbsp;&nbsp;</td>
			<td>membubarkan kesatuan atau persekutuan kesatuan sekerja.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Untuk menjalankan undi rahsia, aturcara yang dinyatakan di dalam kembaran kepada peraturan-peraturan ini hendaklah dipatuhi.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 26 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PERLANTIKAN JEMAAH PENIMBANGTARA</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Jemaah Penimbangtara yang terdiri dari lima (5) orang hendaklah dilantik dalam Persidangan Perwakilan Kesatuan untuk menyelesaikan sesuatu pertikaian dalam Kesatuan. Jemaah Penimbangtara hendaklah bukan anggota Kesatuan dan tidak ada kaitan langsung dengan kewangan Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila berlaku kekosongan kerana sebarang sebab maka kekosongan hendaklah diisi dengan melantik penggantinya di dalam Persidangan Perwakilan yang akan datang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Agung hendaklah melaporkan kepada Ketua Pengarah Kesatuan Sekerja butir-butir peribadi Jemaah Penimbangtara (seperti nama, nombor kad pengenalan, jawatan, alamat) dan sebarang perubahan tentang anggota Jemaah Penimbangtara.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila sesuatu pertikaian dirujuk kepada Jemaah Penimbangtara, pihak yang terkilan hendaklah memilih dengan mengundi tiga (3) daripada lima (5) orang anggota Jemaah Penimbangtara tersebut. Laporan dan keputusan Jemaah Penimbangtara hendaklah dikemukakan kepada Majlis Jawatankuasa Agung dengan seberapa segera.<br>&nbsp;</td>
		</tr>
	</table><br>

	<div class="break"> </div><br><br>

	<div class="bold uppercase left">PERATURAN 27 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PERTIKAIAN DALAM KESATUAN</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Tertakluk kepada perenggan (2) di bawah ini, tiap-tiap pertikaian yang berlaku di antara :-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>seseorang anggota atau seseorang yang menuntut melalui seorang anggota atau menurut peraturan ini, di sebelah pihak, dan dengan Kesatuan atau pegawai kesatuan di pihak yang lagi satu; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>seseorang yang terkilan yang telah diberhentikan menjadi anggota Kesatuan, atau seseorang yang menuntut melalui orang yang terkilan itu, di sebelah pihak dengan Kesatuan atau pegawai Kesatuan di pihak yang lagi satu; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>kesatuan dengan seseorang pegawai Kesatuan hendaklah diselesaikan melalui penimbangtaraan.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Pihak yang menutut dan pihak yang kena tuntut bolehlah bersama-sama merujuk pertikaian tentang perkara berikut:-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>pemilihan pegawai-pegawai Kesatuan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>kira-kira dan kewangan Kesatuan; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>melanggar peraturan-peraturan Kesatuan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" style="width: 30;">
			<td colspan="2"  style="padding-left: 1cm;" class="left">kepada Ketua Pengarah Kesatuan Sekerja dan keputusan Ketua Pengarah Kesatuan Sekerja tentang pertikaian tersebut adalah muktamad.</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha hendaklah secara bertulis menyampaikan sebarang pertikaian dibawah perenggan (1) kepada Jemaah Penimbangtara dalam tempoh tujuh (7) hari dari tarikh permohonan pihak yang menuntut diterima oleh Kesatuan. Jika tiada keputusan dibuat mengenai suatu pertikaian dalam tempoh empat puluh (40) hari selepas permohonan dibuat kepada kesatuan, anggota atau seseorang yang terkilan itu boleh memohon kepada Mahkamah Sesyen dan Mahkamah Sesyen boleh mendengar dan membuat keputusan mengenaipertikaian tersebut.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Dalam peraturan ini perkataan pertikaian meliputi sebarang pertikaian tentang soal sama ada seseorang anggota atau orang terkilan itu berhak menjadi anggota atau terus menjadi anggota ataupun diterima semula menjadi anggota. Bagi seseorang yang telah berhenti menjadi anggota perkataan pertikaian ini hanya meliputi pertikaian diantaranya dengan Kesatuan atau pegawai Kesatuan tentang soal yang berbangkit di masa ia menjadi anggota.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Pihak yang terkilan berhak membuat rayuan kepada Persidangan Perwakilan terhadap sebarang keputusan yang telah dibuat oleh Penimbangtara dan keputusan Mesyuarat itu adalah muktamad.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 28 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PEMBUBARAN</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Kesatuan ini tidak boleh dibubarkan dengan sendiri melainkan dengan undi rahsia sekurang-kurangnya setengah anggota-anggota yang layak untuk mengundi dikembalikan dan sekurang-kurangnya 50% dari undi yang dikembalikan bersetuju untuk pembubaran kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Jika sekiranya kesatuan ini dibubarkan seperti yang tersebut di atas maka segala hutang dan tanggungan yang dibuat dengan cara sah bagi pihak kesatuan hendaklah dijelaskan dengan sepenuhnya dan baki wang yang tinggal hendaklah diselesaikan menurut keputusan yang akan dibuat dengan undi rahsia. Penyata kewangan terakhir hendaklah diaudit oleh Juruaudit bertauliah atau seseorang yang dipersetujui oleh Ketua Pengarah.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Notis pembubaran dan dokumen-dokumen lain seperti yang dinyatakan di dalam peraturan-peraturan Kesatuan Sekerja 1959 hendaklah dikemukakan kepada Ketua Pengarah dalam tempoh empat belas (14) hari selepas pembubaran dan pembubaran itu akan berkuatkuasa dari tarikh pendaftarannya oleh Ketua Pengarah Kesatuan Sekerja.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 29 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PENUBUHAN DAN PEMBUBARAN CAWANGAN</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung boleh menubuhkan cawangan di mana-mana kawasan atau tempat kerja jika ada di kawasan tempat kerja itu sekurang-kurangnya <span class="min_member">.......</span> orang anggota.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung boleh membubarkan sesuatu cawangan :-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>apabila bilangan anggota cawangan itu kurang dari <span class="low_member">.......</span> orang selama enam bulan berturut-turut;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>kjika cawangan itu enggan atau gagal menurut peraturan-peraturan kesatuan ini atau keputusan Persidangan Perwakilan atau keputusan Majlis Jawatankuasa Agung, atau pada pendapat Majlis Jawatankuasa Agung, cawangan itu bersalah kerana melakukan sebarang perubahan yang merugikan kesatuan; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>apabila anggota-anggota melalui Mesyuarat Agung Cawangan/ Mesyuarat Agung Luarbiasa Cawangan bersetuju untuk membubarkan cawangan tersebut.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Jika sekiranya sesuatu cawangan itu dibubarkan dengan alasan yang tersebut diperenggan 2 (a) dan 2 (c) di atas maka Majlis Jawatankuasa Agung hendaklah memindahkan anggota-anggota yang tinggal itu ke cawangan yang berhampiran sekali.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Keputusan untuk membubarkan cawangan itu hendaklah dibuat dalam mesyuarat Majlis Jawatankuasa Agung dengan suara yang terbanyak. Akan tetapi jika sesuatu cawangan itu hendak dibubarkan menurut perenggan 2(b) maka jawatankuasa cawangan itu hendaklah diberi notis tiga puluh (30) hari dan diberi peluang untuk menjawab tuduhan-tuduhan ke atasnya. Sekiranya gagal, maka Majlis Jawatankuasa Agung boleh memecat semua jawatankuasa cawangan itu daripada menjadi anggota kesatuan dan anggota-anggota cawangannya akan dipindahkan ke cawangan yang berhampiran sekali.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Perintah membubarkan cawangan itu hendaklah ditandatangani oleh Setiausaha Agung. Apabila diterimanya perintah itu maka cawangan itu tidak lagi boleh menjalankan kerja kecuali kerja-kerja menutupnya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.&nbsp;&nbsp;&nbsp;</td>
			<td>Cawangan yang tidak berpuas hati dengan perintah pembubaran itu boleh mengemukakan surat kepada Setiausaha Agung bagi merayu kepada Persidangan Perwakilan dalam tempoh tiga puluh (30) hari dari tarikh penerimaan perintah itu. Meskipun rayuan itu dibuat, perintah pembubaran itu hendaklah juga dikuatkuasa sehingga ia ditutupkan. Dalam hal yang demikian, Majlis Jawatankuasa Agung boleh melantik di antara mereka itu sendiri suatu Jawatankuasa Pengelola untuk menguruskan hal ehwal cawangan itu sehingga rayuan itu mendapat keputusan. Cawangan tidak boleh diwakili peguam atau seseorang yang bukan anggota pada tarikh perintah pembubaran itu dikeluarkan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">7.&nbsp;&nbsp;&nbsp;</td>
			<td>Adalah menjadi kewajipan Pengerusi, Setiausaha dan Bendahari Cawangan yang dibubarkan itu menyerahkan kepada Setiausaha Agung segala buku-buku, surat-surat, wang dan harta kepunyaan cawangan, bersama-sama dengan suatu kenyataan kewangan dari tarikh kira-kira yang lalu dibentangkan sehingga tarikh perintah pembubaran itu dikeluarkan.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 30 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; JAWATANKUASA CAWANGAN</div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Jawatankuasa Cawangan hendaklah terdiri daripada seorang Pengerusi, seorang Naib Pengerusi, seorang Setiausaha, seorang Penolong Setiausaha, Bendahari, seorang Penolong Bendahari dan <span class="total_ajk">......... ( )</span> orang Ahli Jawatankuasa. Mereka dikenali sebagai Pegawai-Pegawai Cawangan dan dipilih setiap <span class="ajk_yearly">.......</span> tahun dengan undi rahsia oleh semua anggota berhak dalam cawangan masing-masing.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Wakil-wakil cawangan yang menghadiri Persidangan Perwakilan hendaklah dipilih setiap <span class="conference_yearly">.........</span> tahun dengan undi rahsia dan keputusan undi bagi Ahli Jawatankuasa dan wakil-wakil hendaklah di umumkan dalam Mesyuarat Agung <span class="meeting_yearly">.........</span> Tahunan Cawangan itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Sekiranya seseorang calon bagi sesuatu jawatan tidak ditandingi dan pencalonannya telah dilaksanakan menurut cara yang ditentukan di dalam Peraturan 32 (3), maka ia hendaklah dianggap telah dipilih dan namanya diasingkan dari kertas undi untuk pemilihan Ahli Jawatankuasa Cawangan dan wakil-wakil.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Jawatankuasa Cawangan dan wakil-wakil cawangan yang pertama hendaklah dipilih dengan undi rahsia dalam masa tiga bulan setelah cawangan itu ditubuhkan, dan sehingga pemilihan itu dijalankan Jawatankuasa Sementara Cawangan yang dilantik secara angkat tangan dalam Mesyuarat Penubuhan Cawangan itu hendaklah menguruskan hal ehwal cawangan. Ahli Jawatankuasa Cawangan hendaklah memegang jawatan dari satu Mesyuarat Agung <span class="meeting_yearly">.........</span> Tahunan Cawangan ke satu Mesyuarat Agung <span class="meeting_yearly">.........</span> Tahunan Cawangan akan datang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Sekiranya pada sesuatu Mesyuarat Agung atau Mesyuarat Agung Luarbiasa suatu usul tidak percaya terhadap Jawatankuasa Cawangan telah diluluskan oleh dua pertiga (2/3) suara teramai, maka Jawatankuasa Cawangan hendaklah dengan serta merta bertugas atas dasar pengurusan sementara. Jawatankuasa Cawangan hendaklah mengadakan pemilihan semula pegawai-pegawai melalui undi rahsia dalam tempoh sebulan setelah Mesyuarat Agung atau Mesyuarat Agung Luarbiasa itu. Ahli-ahli Jawatankuasa yang dipilih dengan cara ini hendaklah memegang jawatan sehingga Mesyuarat Agung <span class="meeting_yearly">.........</span> Tahunan Cawangan yang akan datang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila berlaku pertukaran pegawai-pegawai atau Jawatankuasa Cawangan, maka segala rekod dan dokumen yang berkaitan hendaklah diserahkan kepada pegawai-pegawai atau Jawatankuasa Cawangan yang baru dalam tempoh tujuh (7) hari .<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">7&nbsp;&nbsp;&nbsp;</td>
			<td>Keputusan pemilihan Pegawai-pegawai Cawangan hendaklah dikemukakan dalam borang yang ditetapkan kepada Setiausaha Agung dalam tempoh tujuh (7) hari selepas pemilihan. Pemberitahuan tentang pemilihan pegawai- pegawai tersebut hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja oleh Setiausaha Agung dalam tempoh empat belas (14) hari selepas pemilihan itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.&nbsp;&nbsp;&nbsp;</td>
			<td>Tanggungjawab Pegawai-pegawai Cawangan ialah menguruskan hal ehwal cawangan menurut peraturan-peraturan kesatuan dan arahan yang dikeluarkan oleh Majlis Jawatankuasa Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">9.&nbsp;&nbsp;&nbsp;</td>
			<td>Mesyuarat Jawatankuasa Cawangan hendaklah diuruskan oleh Setiausaha Cawangan dengan arahan atau persetujuan Pengerusi. Notis dan agenda mesyuarat hendaklah diberi kepada semua Ahli Jawatankuasa Cawangan sekurang-kurangnya lima (5) hari sebelum mesyuarat tersebut diadakan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">10.&nbsp;&nbsp;&nbsp;</td>
			<td>Jawatankuasa Cawangan hendaklah bermesyuarat sekurang-kurangnya tiga (3) bulan sekali dan cukup kuorum mesyuarat apabila setengah (Â½) daripada jumlah anggotanya hadir. Setiausaha Cawangan hendaklah menyampaikan kepada Setiausaha Agung minit mesyuarat dan laporan kewangan tidak lewat dari tujuh (7) hari selepas mesyuarat itu diadakan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.&nbsp;&nbsp;&nbsp;</td>
			<td>Ahli Jawatankuasa Cawangan yang tidak menghadiri mesyuarat tiga (3) kali berturut-turut tidak lagi berhak menyandang jawatannya kecuali dia dapat memberi alasan yang memuaskan kepada kepada Jawatankuasa Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">12.&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila seseorang pegawai Kesatuan dan wakil-wakil meninggal dunia, berhenti atau terlucut hak, maka calon yang mendapat undi terkebawah sedikit bagi jawatan berkenaan dalam masa undian yang lalu hendaklah dijemput untuk mengisi tempat yang kosong itu. Bagi jawatan Pengerusi, Naib Pengerusi, Setiausaha, Penolong Setiausaha, Bendahari dan Penolong Bendahari, calon tersebut hendaklah mendapat tidak kurang daripada satu perempat (1/4) jumlah undi yang telah dibuang bagi jawatan itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">13.&nbsp;&nbsp;&nbsp;</td>
			<td>Jika tiada calon yang layak atau calon yang layak enggan menerima jawatan tersebut maka Jawatankuasa Cawangan berkuasa melantik seorang anggota yang layak untuk mengisi kekosongan itu.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 31 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; TUGAS-TUGAS PEGAWAI-PEGAWAI CAWANGAN</div>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Pengerusi Cawangan</td>
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
			<td>menyelenggarakan urusan kewangan dan bank bersama-sama dengan Setiausaha dan Bendahari Cawangan menurut Peraturan 35;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>menandatangani semua cek kesatuan bersama dengan Setiausaha dan Bendahari Cawangan; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>mengawasi pentadbiran Cawangan.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Naib Pengerusi Cawangan</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Membantu Pengerusi dalam menjalankan tugas-tugasnya dan memangku jawatan Pengerusi pada masa ketiadaannya;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>menjalankan tugas-tugas sebagaimana diarahkan oleh Jawankuasa Cawangan.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Pengerusi Cawangan</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Menguruskan kerja-kerja cawangan mengikut peraturan ini dan hendaklah menjalankan perintah-perintah dan arahan-arahan Persidangan Perwakilan, Majlis Jawatankuasa Agung, Mesyuarat Agung Cawangan atau Jawatankuasa Cawangan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>bertanggungjawab menyimpan dan menyelenggara dokumen-dokumen kesatuan sebagaimana arahan Majlis Jawatankuasa Agung atau Jawatankuasa Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>menyimpan dan mengemaskini suatu Daftar Keanggotaan yang mengandungi Nama Anggota, Alamat Kediaman, Nombor Kad Pengenalan dan Tarikh Menjadi Anggota Kesatuan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>menetapkan serta menyediakan agenda Mesyuarat Agung dan Mesyuarat Jawatankuasa Cawangan dengan persetujuan Pengerusi Cawangan dan menyediakan minit-minit mesyuarat itu; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>menyelenggarakan urusan kewangan dan bank bersama-sama dengan Pengerusi dan Bendahari Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>menandatangani semua cek kesatuan bersama dengan Pengerusi dan Bendahari Cawangan.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Penolong Setiausaha Cawangan</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Membantu Setiausaha dalam urusan pentadbiran kesatuan dan memangku jawatan Setiausaha pada masa ketiadaannya; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>menjalankan tugas-tugas sebagaimana yang diarahkan oleh Jawatankuasa Cawangan.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari Cawangan</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Bertanggungjawab dalam urusan Penerimaan dan Pembayaran wang Kesatuan dan urusan penyimpanan dokumen kewangan sebagaimana yang dikehendaki oleh Peraturan-peraturan Kesatuan Sekerja 1959;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>mengeluarkan resit rasmi bagi segala wang yang diterima.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>bertanggungjawab tentang keselamatan simpanan dokumen kewangan dan surat-surat keterangan yang berkenaan di cawangan. Dokumen-dokumen dan surat-surat keterangan ini tidak boleh dikeluarkan dari tempat rasminya tanpa kebenaran yang bertulis daripada Pengerusi pada tiap-tiap kali ia hendak dikeluarkan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>bertanggungjawab ke atas wang-wang dan harta-harta kesatuan di dalam jagaannya;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>menyediakan penyata kewangan bagi tiap-tiap Mesyuarat Jawatankuasa Cawangan dan Mesyuarat Agung Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>menguruskan kira-kira bank cawangannya bersama-sama dengan Pengerusi dan Setiausaha Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(g)&nbsp;&nbsp;&nbsp;</td>
			<td>menandatangani semua cek kesatuan bersama dengan Pengerusi dan Setiausaha Cawangan.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">6.&nbsp;&nbsp;&nbsp;</td>
			<td>Penolong Bendahari Cawangan</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Membantu Bendahari dalam urusan kewangan Kesatuan dan memangku jawatan Bendahari pada masa ketiadaannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>Menjalankan tugas-tugas sebagaimana diarah oleh Jawatankuasa Cawangan.<br>&nbsp;</td>
		</tr>
	</table><br>

	<div class="break"> </div><br><br>

	<div class="bold uppercase left">PERATURAN 32 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; MESYUARAT AGUNG <span class="meeting_yearly">.........</span> CAWANGAN</div>

	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Mesyuarat Agung <span class="meeting_yearly">.........</span> Cawangan hendaklah diadakan dengan seberapa segera selepas 31hb Mac dan tidak lewat dari 30hb Jun tiap-tiap . tahun. Tarikh, masa dan tempat mesyuarat hendaklah ditetapkan oleh Jawatankuasa Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Cawangan hendaklah mengirim notis permulaan mengenai Mesyuarat Agung <span class="meeting_yearly">.........</span> Tahunan Cawangan kepada semua anggota- anggota berhak. Notis ini hendaklah dihantar sekurang-kurangnya tiga puluh (30) hari sebelum mesyuarat itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Notis permulaan tersebut hendaklah menyatakan tarikh, masa dan tempat Mesyuarat Agung akan diadakan. Notis tersebut juga hendaklah disertakan bersama dokumen-dokumen berikut :-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>Borang usul untuk perbincangan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>Borang pencalonan untuk pemilihan Ahli-ahli Jawatankuasa Cawangan serta wakil-wakil cawangan; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>Borang pencalonan untuk pemilihan Pegawai-pegawai Kanan seperti tersebut di dalam Peraturan 12(2),<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Nama-nama calon untuk pemilihan Pegawai-pegawai Kanan, Jawatankuasa Cawangan dan wakil-wakil cawangan serta usul-usul untuk dibincangkan di mesyuarat itu hendaklah dikemukakan oleh anggota-anggota kepada Setiausaha Cawangan sekurang-kurangnya dua puluh satu (21) hari sebelum Mesyuarat Agung...... Tahunan Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Semua pencalonan hendaklah dibuat dalam borang yang disediakan oleh kesatuan dan hendaklah mengandungi perkara-perkara yang berikut :-<br>Nama jawatan yang ditandingi, nama calon, nombor kad pengenalan, nombor keanggotaan, tarikh lahir, alamat kediaman, pekerjaan, nombor sijil kerakyataan/taraf kerakyatan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.&nbsp;&nbsp;&nbsp;</td>
			<td>Sesuatu pencalonan tidak sah jika:-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>ia tidak ditandatangani oleh seorang pencadang dan seorang penyokong yang merupakan anggota-anggota berhak;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>ia tidak mengandungi persetujuan bertulis calon yang hendak bertanding.<br>&nbsp;</td>
		</tr>
	</table>

	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">7.&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Cawangan hendaklah memaklumkan kepada Setiausaha Agung tarikh Mesyuarat Agung Cawangan hendak diadakan sekurang-kurangnya tiga puluh (30) hari sebelum mesyuarat itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Cawangan hendaklah menghantar kepada semua anggota cawangan sekurang-kurangnya empat belas (14) hari sebelum mesyuarat, suatu agenda, usul-usul (jika ada), Laporan Tahunan dan Penyata Kewangan, kertas undi serta sampul-sampul surat yang secukupnya bagi pemilihan wakil-wakil cawangan dan Jawatankuasa Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">9.&nbsp;&nbsp;&nbsp;</td>
			<td>Satu perempat (1/4) dari jumlah anggota-anggota yang berhak mengundi akan menjadi kuorum Mesyuarat Agung Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">10.&nbsp;&nbsp;&nbsp;</td>
			<td>Jika selepas satu (1) jam dari masa yang ditentukan bilangan anggota yang hadir tidak mencukupi maka mesyuarat itu hendaklah ditangguhkan kepada suatu tarikh (tidak lewat dari empat belas (14) hari kemudian) yang ditetapkan oleh Jawatankuasa Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.&nbsp;&nbsp;&nbsp;</td>
			<td>Sekiranya kuorum bagi Mesyuarat Agung <span class="meeting_yearly">.........</span> Tahunan Cawangan yang ditangguhkan itu masih belum mencukupi pada masa yang ditentukan maka anggota-anggota yang hadir berkuasa menguruskan mesyuarat itu, akan tetapi tidak berkuasa meminda peraturan-peraturan Kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">12.&nbsp;&nbsp;&nbsp;</td>
			<td>Urusan Mesyuarat Agung Cawangan antara lain ialah:-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>menerima dan meluluskan penyata-penyata dan laporan-laporan daripada Setiausaha dan Bendahari Cawangan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>imembincang dan memutuskan usul-usul untuk dibawa ke Persidangan Perwakilan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>imembincang dan memutuskan usul-usul untuk dibawa ke Persidangan Perwakilan;<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">(i)&nbsp;&nbsp;&nbsp;</td>
			<td>Juruaudit Dalam Cawangan; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">(ii)&nbsp;&nbsp;&nbsp;</td>
			<td>Jemaah Pemeriksa Undi Cawangan</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>menerima Penyata Pemeriksa Undi bagi pemilihan Ahli Jawatankuasa Cawangan, wakil-wakil dan perkara-perkara lain; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>membincang dan memutuskan lain-lain perkara yang terkandung di dalam agenda.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 33 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; MESYUARAT AGUNG LUARBIASA CAWANGAN</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Mesyuarat Agung Luarbiasa Cawangan hendaklah diadakan;-</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>apabila diarah oleh Majlis Jawatankuasa Agung;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>apabila sahaja difikirkan mustahak oleh Jawatankuasa Cawangan; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>apabila menerima permintaan bersama yang bertulis daripada sekurang-kurangnya satu perempat (1/4) daripada jumlah anggota yang berhak mengundi. Permintaan itu hendaklah menyatakan tujuan dan sebab anggota-anggota berkenaan mahu mesyuarat itu diadakan.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Mesyuarat Agung Luarbiasa Cawangan yang diminta oleh anggota-anggota hendaklah diadakan dalam tempoh empat belas (14) hari dari tarikh permintaan itu diterima.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Notis dan agenda bagi sesuatu Mesyuarat Agung Luarbiasa Cawangan hendaklah diedarkan oleh Setiausaha Cawangan kepada semua anggota berhak sekurang-kurangnya tujuh (7) hari sebelum mesyuarat itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Peruntukan-peruntukan Peraturan 32 tentang kuorum dan penangguhan Mesyuarat Agung Cawangan adalah terpakai kepada Mesyuarat Agung Luarbiasa Cawangan yang diadakan kerana difikirkan mustahak oleh Jawatankuasa Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Bagi Mesyuarat Agung Luarbiasa Cawangan yang diminta oleh anggota- anggota ditangguhkan kerana tidak cukup kuorum mengikut Peraturan 32(9) maka mesyuarat yang ditangguhkan itu hendaklah ditutupkan sekiranya kuorum masih tidak diperolehi selepas satu (1) jam dari masa yang dijadualkan. Mesyuarat Agung Luarbiasa Cawangan bagi perkara yang sama tidak boleh diminta lagi dalam tempoh enam (6) bulan dari tarikh mesyuarat itu ditutupkan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.&nbsp;&nbsp;&nbsp;</td>
			<td>Jika Mesyuarat Agung <span class="meeting_yearly">.........</span> Tahunan sesuatu cawangan tidak dapat diadakan dalam masa yang ditentukan di bawah Peraturan 32(1) maka suatu Mesyuarat Agung Luarbiasa Cawangan berkuasa menjalankan sebarang kerja yang lazimnya dijalankan oleh Mesyuarat Agung <span class="meeting_yearly">.........</span> Tahunan Cawangan itu dengan syarat Mesyuarat Agung Luarbiasa Cawangan berkenaan mestilah diadakan sebelum Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan dalam tahun yang sama.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 34 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; JEMAAH PEMERIKSA UNDI CAWANGAN</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Jemaah Pemeriksa Undi yang terdiri daripada lima (5) orang anggota hendaklah dipilih secara angkat tangan dalam Mesyuarat Agung <span class="meeting_yearly">.........</span> Tahunan Cawangan dan seorang daripadanya hendaklah dipilih sebagai Ketua Pemeriksa Undi. Mereka hendaklah bukan pegawai Kesatuan atau calon bagi pemilihan pegawai-pegawai kesatuan. Seboleh-bolehnya anggota-anggota yang dipilih ini hendaklah anggota-anggota yang tinggal di sekitar kawasan Pejabat Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Jemaah Pemeriksa Undi ini bertanggungjawab mengendalikan segala perjalanan undi rahsia yang dijalankan oleh kesatuan. Mereka akan berkhidmat dari suatu Mesyuarat Agung <span class="meeting_yearly">.........</span> Tahunan ke Mesyuarat Agung <span class="meeting_yearly">.........</span> Tahunan yang berikutnya. Apabila berlaku kekosongan, kekosongan ini hendaklah diisikan dengan cara lantikan oleh Jawatankuasa Cawangan sehingga Mesyuarat Agung yang akan datang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Sekurang-kurangnya tiga (3) orang pemeriksa undi hendaklah hadir apabila pembuangan dan pengiraan undi dijalankan. Mereka hendaklah memastikan bahawa aturcara yang tertera di dalam kembaran kepada peraturan-peraturan ini dipatuhi dengan sepenuhnya.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 35 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; KEWANGAN DAN AKAUN CAWANGAN</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Segala wang yang terkumpul di Ibu Pejabat Kesatuan dan di Cawangan-cawangan Kesatuan adalah menjadi kepunyaan kesatuan seluruhnya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung hendaklah menetapkan dari semasa ke semasa perbelanjaan yang akan dibuat oleh cawangan dan jumlah wang yang boleh disimpan di cawangan sebagai tabung cawangan itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari Cawangan hendaklah menyampaikan kepada Setiausaha Agung sebelum tiap-tiap empat belas (14) haribulan apa-apa yuran yang diterimanya sesudah ditolak perbelanjaan yang dibenarkan dan potongan yang telah diluluskan untuk tabung cawangan. Bendahari Cawangan hendaklah juga menyampaikan kepada Setiausaha Agung sebelum hari yang ke empat belas (14) pada tiap-tiap bulan suatu Penyata Pendapatan dan Perbelanjaan Cawangan bagi bulan yang lalu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Wang yang disimpan oleh Cawangan hendaklah dimasukkan ke dalam bank yang dipersetujui oleh Majlis Jawatankuasa Agung dengan nama Cawangan berkenaan dan akaun bank itu hendaklah diuruskan bersama-sama oleh Pengerusi, Setiausaha dan Bendahari Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari Cawangan dibenarkan menyimpan wang tunai tidak lebih dari RM<span class="branch_max_savings">.........</span> pada sesuatu masa. Ia tidak boleh membelanjakan lebih dari RM<span class="branch_max_expenses">.........</span> pada sesuatu masa tanpa kebenaran Jawatankuasa Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari Cawangan hendaklah memasukkan segala wang kesatuan yang diterima ke dalam bank yang dipersetujui oleh Majlis Jawatankuasa Agung dalam tempoh tujuh (7) hari kecuali had wang tunai yang dibenarkan.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 36 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; JURUAUDIT DALAM CAWANGAN</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Dua (2) orang Juruaudit Dalam yang bukan menjadi Ahli Jawatankuasa Cawangan, hendaklah dipilih secara angkat tangan oleh Mesyuarat Agung <span class="meeting_yearly">.........</span> Tahunan Cawangan. Mereka hendaklah memeriksa akaun kesatuan pada penghujung tiap-tiap tiga (3) bulan dan menyampaikan laporannya kepada Jawatankuasa Cawangan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Dokumen pentadbiran dan kewangan kesatuan hendaklah diaudit bersama-sama oleh kedua-dua Juruaudit Dalam dan mereka itu berhak melihat semua buku dan surat keterangan yang perlu untuk menyempurnakan tugas mereka.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang anggota kesatuan boleh mengadu dengan bersurat kepada Juruaudit Dalam mengenai sebarang hal kewangan yang tidak betul.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila berlaku kekosongan jawatan oleh sebarang sebab, kekosongan ini bolehlah diisi dengan cara lantikan oleh Jawantankuasa Cawangan sehingga Mesyuarat Agung yang akan datang.<br>&nbsp;</td>
		</tr>
	</table><br><br>
	<div class="bold uppercase center"><u>KEMBARAN</u></div><br>
	<div class="bold uppercase center">ATURCARA MENJALANKAN UNDI RAHSIA</div><br>
	<div class="bold center">(Ibu Pejabat)</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Agung hendaklah menetapkan tarikh, masa dan tempat mengundi kesatuan. Majlis Jawatankuasa Agung hendaklah memberi hak dan peluang yang sama kepada semua anggota yang berhak untuk membuang undi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Agung hendaklah memberitahu semua Setiausaha Cawangan perkara- perkara yang perlu dibuat dan menghantar kepada mereka bilangan kertas-kertas undi yang dikehendaki dalam tempoh yang mencukupi dan munasabah. Kertas-kertas undi ini hendaklah disediakan menurut contoh A atau contoh C yang mana berkenaan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Mengenai kertas undi di Contoh C, isu-isu yang berlainan tujuannya hendaklah ditentukan dengan tanda pangkah (X) secara berasingan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Jawatankuasa Cawangan pula hendaklah menetapkan tarikh, masa dan tempat mengundi dan hendaklah memastikan semua anggota berhak di cawangan masing-masing diberikan hak dan peluang yang sama supaya semua anggota yang berhak dapat membuang undi mereka dengan bebas.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Cawangan hendaklah mengeluarkan kepada tiap-tiap anggota yang berhak di cawangan masing-masing kertas undi yang dicap dengan nama kesatuan atau yang ditandatangani oleh Setiausaha Agung, bersama-sama dengan satu sampul surat yang dialamatkan kepada Ketua Pemeriksa Undi Cawangan (bagi contoh A) atau Setiausaha Cawangan (bagi contoh B).<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.&nbsp;&nbsp;&nbsp;</td>
			<td>Kertas-kertas undi itu hendaklah dikeluarkan kepada semua anggota berhak dengan pos atau dengan unjukan tangan oleh Setiausaha Cawangan atau mana-mana pegawai lain dengan kelulusan Jawatankuasa Cawangan. Sekiranya diberikan dengan unjukan tangan, tandatangan si penerima secara bersendirian hendaklah diperolehi sebagai bukti penerimaannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">7.&nbsp;&nbsp;&nbsp;</td>
			<td>Sampul surat itu hendaklah mengandungi perkataan Kertas Undi dan nombor anggota dicatatkan di atasnya. Kertas undi dan sampul surat itu, hendaklah disampaikan kepada semua anggota berhak dalam tempoh masa yang cukup supaya ia boleh memulangkannya kepada Ketua Pemeriksa Undi Cawangan (bagi contoh A) atau Setiausaha Cawangan (bagi contoh C) dalam tempoh yang ditetapkan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.&nbsp;&nbsp;&nbsp;</td>
			<td>Anggota-anggota bebas memilih sama ada hendak mengundi dengan pos atau secara peribadi. Sekiranya seorang anggota itu memilih hendak mengundi dengan pos dia hendaklah mengembalikan kertas undi yang telah ditandanya kepada Ketua Pemeriksa Undi Cawangan (bagi contoh A) atau Setiausaha Cawangan (bagi contoh C) atau menurut cara-cara yang ditentukan di dalam aturan ini tetapi sekiranya dia memilih untuk mengundi secara peribadi, dia hendaklah membuang undinya menurut cara-cara yang ditentukan di bawah ini.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">9.&nbsp;&nbsp;&nbsp;</td>
			<td>Jika seseorang yang berhak mengundi dan hadir di tempat mengundi menyatakan dengan bersurat bahawa ia belum lagi menerima kertas undi melalui pos dia hendaklah diberi oleh Setiausaha Cawangan satu kertas undi yang dimeterai dengan Mohor Kesatuan atau ditandatangani oleh Setiausaha Agung berserta dengan satu sampul surat yang mengandungi perkataan Kertas Undi dan nombor anggota tertulis di atasnya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">10.&nbsp;&nbsp;&nbsp;</td>
			<td>Mana-mana anggota yang tidak membuat aduan kerana tidak menerima kertas undi sebelum Mesyuarat Agung Cawangan tidak boleh membuat aduan tentang hal ini kemudian.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.&nbsp;&nbsp;&nbsp;</td>
			<td>Pembuangan undi hendaklah dilaksanakan di bawah pengawasan Pemeriksa-pemeriksa Undi Cawangan. Sekurang-kurangnya tiga (3) orang pemeriksa undi cawangan hendaklah hadir sepanjang masa urusan undi itu dijalankan. Sebelum urusan undi dijalankan Setiausaha Cawangan hendaklah meminta Pemeriksa-pemeriksa Undi Cawangan menentukan yang peti undi itu kosong dan setelah itu mereka hendaklah mengunci, memeteri dan kemudian menyimpan kunci-kunci itu dalam jagaan mereka. Pemeriksa- Pemeriksa Undi Cawangan hendaklah menandatangani surat perakuan mengesahkan peti undi adalah kosong dan berkunci.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">12.&nbsp;&nbsp;&nbsp;</td>
			<td>Sebelum pengiraan undi itu dijalankan, Setiausaha Cawangan hendaklah memberi kepada Pemeriksa-pemeriksa Undi Cawangan satu senarai anggota yang telah diberi kertas undi ( dengan tangan atau dengan pos ) dan mereka hendaklah menentukan dengan menyemak senarai itu dengan Buku Daftar Keanggotaan / Yuran, bahawa :-<br>&nbsp;</td>
		</tr>
	</table><br>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>anggota-anggota yang berhak sahaja diberi peluang mengundi;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>tiap-tiap anggota hanya mengundi sekali sahaja bagi sesuatu perkara;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>anggota-anggota yang telah mengundi dengan pos itu tidak diberi kertas undi menurut perenggan di atas; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>anggota-anggota boleh mengundi mengikut kehendak mereka dan undi mereka tidaklah diketahui oleh orang lain.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">13.&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila sampai di tempat mengundi pada masa mengundi, anggota yang memilih untuk mengundi secara peribadi hendaklah masuk seorang demi seorang ke dalam bilik mengundi atau di bahagian dewan yang ditempatkan peti undi itu dan menurunkan undinya dengan menandakan pangkah (X) atau yang mana berkenaan di atas kertas undi itu. Tanda-tanda yang lain tidak boleh ditulis. Selepas itu lipatkan kertas undi itu sekurang-kurangnya sekali dan masukkan semula ke dalam sampul suratnya, kemudian masukkan ke dalam peti undi yang telah disediakan. Setelah itu tinggalkan tempat mengundi itu dengan segera.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">14.&nbsp;&nbsp;&nbsp;</td>
			<td>Seorang anggota yang mengundi melalui pos hendaklah menandakan (X) pada kertas undinya dan setelah itu hendaklah melipatkan kertas undi itu sekurang-kurangnya sekali dan memasukkannya ke dalam sampul surat yang telah disediakan untuknya serta menghantarkannya kepada Ketua Pemeriksa Undi Cawangan bagi Contoh A manakala Contoh C kepada Setiausaha Cawangan supaya sampai kepada mereka sebelum hari yang ditetapkan untuk mengundi itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">15.&nbsp;&nbsp;&nbsp;</td>
			<td>Ketua Pemeriksa Undi Cawangan (bagi contoh A) atau Setiausaha Cawangan (bagi contoh C) hendaklah menyimpan segala kertas undi itu tanpa dibuka di suatu tempat yang selamat sehingga hari yang ditetapkan. Mereka hendaklah menyerahkannya kepada Pemeriksa-pemeriksa Undi Cawangan dan memasukkannya ke dalam peti undi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">16.&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah semua anggota yang berhak mengundi itu membuang undi masing- masing maka Ketua Pemeriksa Undi Cawangan, setelah mengisytiharkan pembuangan undi ditutup, hendaklah membuka peti undi dan mengira sampul surat yang mengandungi kertas-kertas undi itu di hadapan sekurang-kurang tiga (3) orang saksi yang merupakan anggota kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">17.&nbsp;&nbsp;&nbsp;</td>
			<td>Pada permulaannya mereka hendaklah menyemak Nombor anggota Kesatuan di atas sampul surat itu dengan senarai anggota yang diberi oleh Setiausaha Cawangan. Semasa sampul surat itu disemak, nombor anggota itu hendaklah dipotong hingga tidak dapat dibaca semula dan sampul-sampul surat itu dimasukkan dengan tidak dibuka ke dalam satu peti yang berkunci.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">18.&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah semua sampul surat itu disemak maka Pemeriksa-pemeriksa Undi Cawangan hendaklah mengeluarkan sampul-sampul surat itu semula daripada peti berkunci itu, membuka sampul-sampul surat itu dan memasukkan kertas undi yang masih terlipat itu ke dalam peti undi. Setelah itu mereka akan mula mengira undi. Jika pada pendapat seseorang Pemeriksa Undi Cawangan ada undi yang tidak sah maka undi berkenaan hendaklah dianggap rosak dan ditolak.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">19.&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah kesemua undi itu dikira maka Pemeriksa-pemeriksa Undi Cawangan yang hadir hendaklah menyediakan Laporan Keputusan Undi Rahsia dalam lima (5) salinan dan menyerahkan kesemua salinan Laporan Keputusan Undi Rahsia tersebut kepada Setiausaha Cawangan sesudah ditandatangani oleh mereka. Laporan itu hendaklah ditandatangani juga oleh Pengerusi dan Setiausaha Cawangan dan empat (4) salinan daripadanya hendaklah disampaikan kepada Setiausaha Agung. Satu (1) salinan lagi hendaklah disimpan oleh Setiausaha Cawangan.<br>&nbsp;<br></td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">20.&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila laporan keputusan undi rahsia telah diterima daripada semua cawangan oleh Setiausaha Agung maka Setiausaha Agung hendaklah meminta Pemeriksa-pemeriksa Undi yang dilantik oleh Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan untuk memeriksa laporan itu dan membuat penjumlahan undi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">21.&nbsp;&nbsp;&nbsp;</td>
			<td>Bagi pemilihan pegawai-pegawai kanan, setelah penjumlahan undi oleh Pemeriksa-pemeriksa Undi yang dipilih dalam Persidangan Perwakilan <span class="conference_yearly">.........</span> Tahunan, satu Laporan Keputusan Undi Rahsia hendaklah disediakan dalam lima (5) salinan dan setelah ditandatangani oleh mereka diserahkan kepada Presiden dan Setiausaha Agung untuk disahkan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">22.&nbsp;&nbsp;&nbsp;</td>
			<td>Laporan Keputusan Undi Rahsia hendaklah dilampirkan bersama dengan Penyata Keputusan Undi (Borang U) yang ditandatangani oleh Pemeriksa- pemeriksa Undi yang dilantik oleh Persidangan Perwakilan  Tahunan bersama-sama Presiden, Setiausaha Agung dan Bendahari Agung. Tiga (3) salinan penyata itu hendaklah disampaikan kepada Ketua Pengarah Kesatuan Sekerja dan dua (2) salinan disimpan oleh Setiausaha Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">23.&nbsp;&nbsp;&nbsp;</td>
			<td>Satu salinan penyata undi tersebut yang telah disahkan oleh Kesatuan hendaklah dihantar oleh Setiausaha Agung kepada semua Setiausaha Cawangan. Setiausaha Cawangan hendaklah memaklumkan kepada anggota-anggota cawangan akan keputusan undi itu dengan apa cara yang difikirkannya munasabah.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">24.&nbsp;&nbsp;&nbsp;</td>
			<td>Kertas-kertas undi yang telah dikira, termasuk juga kertas-kertas undi yang ditolak hendaklah disampaikan oleh Setiausaha Cawangan kepada Setiausaha Agung. Setiausaha Agung akan menyimpan kertas-kertas itu dengan selamat selama sekurang-kurangnya enam (6) bulan dari tarikh keputusan undi yang akhir disahkan supaya dapat diperiksa oleh pegawai- pegawai Jabatan Hal Ehwal Kesatuan Sekerja. Selepas enam (6) bulan, kertas-kertas undi itu bolehlah dimusnahkan oleh atau di bawah kelolaan Presiden dan Setiausaha Agung.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase center"><u>KEMBARAN</u></div><br>
	<div class="bold uppercase center">ATURCARA MENJALANKAN UNDI RAHSIA</div><br>
	<div class="bold center">(CAWANGAN KESATUAN)</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Cawangan hendaklah menetapkan tarikh, masa dan tempat mengundi. Majlis Jawatankuasa Cawangan juga hendaklah memastikan semua anggota berhak di cawangannya diberikan hak dan peluang yang sama supaya semua anggota yang berhak dapat membuang undi mereka dengan bebas.<br>&nbsp;</td>
		</tr>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Cawangan hendaklah menyediakan sejumlah kertas-kertas undi yang dikehendaki menurut Contoh B.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Cawangan hendaklah mengeluarkan kepada tiap-tiap anggota yang berhak di cawangannya kertas undi yang dicap dengan nama kesatuan atau yang ditandatangani oleh Setiausaha Cawangan, bersama-sama dengan satu sampul surat yang dialamatkan kepada Ketua Pemeriksa Undi Cawangan (bagi contoh B).<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.&nbsp;&nbsp;&nbsp;</td>
			<td>Kertas-kertas undi itu hendaklah dikeluarkan kepada semua anggota berhak dengan pos atau dengan unjukan tangan oleh Setiausaha Cawangan atau mana-mana pegawai lain dengan kelulusan Jawatankuasa Cawangan. Sekiranya diberikan dengan unjukan tangan, tandatangan si penerima secara bersendirian hendaklah diperolehi sebagai bukti penerimaannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.&nbsp;&nbsp;&nbsp;</td>
			<td>Sampul surat itu hendaklah mengandungi perkataan Kertas Undi dan nombor anggota dicatatkan di atasnya. Kertas undi dan sampul surat itu, hendaklah disampaikan kepada semua anggota berhak dalam tempoh masa yang cukup supaya ia boleh memulangkannya kepada Ketua Pemeriksa Undi Cawangan (bagi contoh B) dalam tempoh yang ditetapkan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.&nbsp;&nbsp;&nbsp;</td>
			<td>Anggota-anggota bebas memilih sama ada hendak mengundi dengan pos atau secara peribadi. Sekiranya seorang anggota itu memilih hendak mengundi dengan pos dia hendaklah mengembalikan kertas undi yang telah ditandanya kepada Ketua Pemeriksa Undi Cawangan (bagi contoh B) menurut cara-cara yang ditentukan di dalam aturan ini tetapi sekiranya dia memilih untuk mengundi secara peribadi, dia hendaklah membuang undinya menurut cara-cara yang ditentukan di bawah ini.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">7.&nbsp;&nbsp;&nbsp;</td>
			<td>Jika seseorang yang berhak mengundi dan hadir di tempat mengundi menyatakan dengan bersurat bahawa ia belum lagi menerima kertas undi melalui pos dia hendaklah diberi oleh Setiausaha Cawangan satu kertas undi yang dimeterai dengan Mohor Kesatuan atau ditandatangani oleh Setiausaha Cawangan berserta dengan satu sampul surat yang mengandungi perkataan Kertas Undi dan nombor anggota tertulis di atasnya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.&nbsp;&nbsp;&nbsp;</td>
			<td>Mana-mana anggota yang tidak membuat aduan kerana tidak menerima kertas undi sebelum Mesyuarat Agung Cawangan tidak boleh membuat aduan tentang hal ini kemudian.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">9.&nbsp;&nbsp;&nbsp;</td>
			<td>Pembuangan undi hendaklah dilaksanakan di bawah pengawasan Pemeriksa-pemeriksa Undi Cawangan. Sekurang-kurangnya tiga (3) orang pemeriksa undi cawangan hendaklah hadir sepanjang masa urusan undi itu dijalankan. Sebelum urusan undi dijalankan Setiausaha Cawangan hendaklah meminta Pemeriksa-pemeriksa Undi Cawangan menentukan yang peti undi itu kosong dan setelah itu mereka hendaklah mengunci, memeteri dan kemudian menyimpan kunci-kunci itu dalam jagaan mereka. Pemeriksa-Pemeriksa Undi Cawangan hendaklah menandatangani surat perakuan mengesahkan peti undi adalah kosong dan berkunci.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">10.&nbsp;&nbsp;&nbsp;</td>
			<td>Sebelum pengiraan undi itu dijalankan, Setiausaha Cawangan hendaklah memberi kepada Pemeriksa-pemeriksa Undi Cawangan satu senarai anggota yang telah diberi kertas undi ( dengan tangan atau dengan pos ) dan mereka hendaklah menentukan dengan menyemak senarai itu dengan Buku Daftar Keanggotaan / Yuran, bahawa :-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>anggota-anggota yang berhak sahaja diberi peluang mengundi;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>tiap-tiap anggota hanya mengundi sekali sahaja bagi sesuatu perkara;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>anggota-anggota yang telah mengundi dengan pos itu tidak diberi kertas undi menurut perenggan di atas; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>anggota-anggota boleh mengundi mengikut kehendak mereka dan undi mereka tidaklah diketahui oleh orang lain.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">11.&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila sampai di tempat mengundi pada masa mengundi, anggota yang memilih untuk mengundi secara peribadi hendaklah masuk seorang demi seorang ke dalam bilik mengundi atau di bahagian dewan yang ditempatkan peti undi itu dan menurunkan undinya dengan menandakan pangkah (X) atau yang mana berkenaan di atas kertas undi itu. Tanda-tanda yang lain tidak boleh ditulis. Selepas itu lipatkan kertas undi itu sekurang-kurangnya sekali dan masukkan semula ke dalam sampul suratnya, kemudian masukkan ke dalam peti undi yang telah disediakan. Setelah itu tinggalkan tempat mengundi itu dengan segera.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">12.&nbsp;&nbsp;&nbsp;</td>
			<td>Seorang anggota yang mengundi melalui pos hendaklah menandakan (X) pada kertas undinya dan setelah itu hendaklah melipatkan kertas undi itu sekurang-kurangnya sekali dan memasukkannya ke dalam sampul surat yang telah disediakan untuknya serta menghantarkannya kepada Ketua Pemeriksa Undi Cawangan bagi <b>Contoh B</b> supaya sampai kepada mereka sebelum hari yang ditetapkan untuk mengundi itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">13.&nbsp;&nbsp;&nbsp;</td>
			<td>Ketua Pemeriksa Undi Cawangan hendaklah menyimpan segala kertas undi itu tanpa dibuka di suatu tempat yang selamat sehingga hari yang ditetapkan. Mereka hendaklah menyerahkannya kepada Pemeriksa-pemeriksa Undi Cawangan dan memasukkannya ke dalam peti undi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">14.&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah semua anggota yang berhak mengundi itu membuang undi masing- masing maka Ketua Pemeriksa Undi Cawangan, setelah mengisytiharkan pembuangan undi ditutup, hendaklah membuka peti undi dan mengira sampul surat yang mengandungi kertas-kertas undi itu di hadapan sekurang-kurang tiga (3) orang saksi yang merupakan anggota kesatuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">15.&nbsp;&nbsp;&nbsp;</td>
			<td>Pada permulaannya mereka hendaklah menyemak Nombor anggota Kesatuan di atas sampul surat itu dengan senarai anggota yang diberi oleh Setiausaha Cawangan. Semasa sampul surat itu disemak, nombor anggota itu hendaklah dipotong hingga tidak dapat dibaca semula dan sampul-sampul surat itu dimasukkan dengan tidak dibuka ke dalam satu peti yang berkunci.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">16.&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah semua sampul surat itu disemak maka Pemeriksa-pemeriksa Undi Cawangan hendaklah mengeluarkan sampul-sampul surat itu semula daripada peti berkunci itu, membuka sampul-sampul surat itu dan memasukkan kertas undi yang masih terlipat itu ke dalam peti undi. Setelah itu mereka akan mula mengira undi. Jika pada pendapat seorang Pemeriksa Undi Cawangan ada undi yang tidak sah maka undi berkenaan hendaklah dianggap rosak dan ditolak.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">17.&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah kesemua undi itu dikira maka Pemeriksa-pemeriksa Undi Cawangan yang hadir hendaklah menyediakan Laporan Keputusan Undi Rahsia dalam lima (5) salinan dan menyerahkan kesemua salinan Laporan Keputusan Undi Rahsia tersebut kepada Setiausaha Cawangan sesudah ditandatangani oleh mereka. Laporan itu hendaklah ditandatangani juga oleh Pengerusi dan Setiausaha Cawangan dan empat (4) salinan daripadanya hendaklah disampaikan kepada Setiausaha Agung. Satu (1) salinan lagi hendaklah disimpan oleh Setiausaha Cawangan.<br>&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">18.&nbsp;&nbsp;&nbsp;</td>
			<td>Laporan Keputusan Undi Rahsia itu hendaklah dilampirkan bersama dengan Penyata Keputusan Undi (Borang U) yang ditandatangani oleh Pemeriksa- pemeriksa Undi yang dilantik oleh Persidangan Perwakilan.......................... Tahunan bersama-sama dengan tandatangan Presiden, Setiausaha Agung dan Bendahari Agung. Tiga (3) salinan penyata itu hendaklah disampaikan kepada Ketua Pengarah Kesatuan Sekerja dan dua (2) salinan disimpan oleh Setiausaha Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">19.&nbsp;&nbsp;&nbsp;</td>
			<td>Kertas-kertas undi yang telah dikira, termasuk juga kertas-kertas undi yang ditolak hendaklah disampaikan oleh Setiausaha Cawangan kepada Setiausaha Agung. Setiausaha Agung akan menyimpan kertas-kertas itu dengan selamat selama sekurang-kurangnya enam (6) bulan dari tarikh keputusan undi yang akhir disahkan supaya dapat diperiksa oleh pegawai-pegawai Jabatan Hal Ehwal Kesatuan Sekerja. Selepas enam (6) bulan, kertas-kertas undi itu bolehlah dimusnahkan oleh atau di bawah kelolaan Presiden dan Setiausaha Agung.<br>&nbsp;</td>
		</tr>
	</table><br>
	<hr>
	<div style="text-align: right;" class="bold uppercase">CONTOH "A"</div><br>

	<table>
		<tr class="left justify">
			<td style="vertical-align: top;" class="right">Nama Kesatuan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
			<td class="bold">Kesatuan Unijaya</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<tr class="left justify" >
			<td class="right">Nombor Pendaftaran&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
			<td>424234-H</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" class="right">Alamat Berdaftar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
			<td style="vertical-align: top;">
				D-9-5, Megan Avenue 1, 189, Jalan Tun Razak, <br>
				Hampshire Park, 50450 Kuala Lumpur, Selangor
			</td>
		</tr>
	</table><br><br>
	<span class="bold uppercase center">KERTAS UNDI BAGI PEMILIHAN PEGAWAI-PEGAWAI KANAN</span><br><br>
	<div class="left bold"><u>Cara Mengundi:</u></div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Tuan / Puan berhak menanda satu (1) undi bagi jawatan Presiden, Naib Presiden, Setiausaha Agung, Penolong Setiausaha Agung, Bendahari Agung dan Penolong Bendahari Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Undi tuan / puan adalah <b>RAHSIA</b> dan tuan / puan hendaklah mencatatkan tanda pangkah seperti ini <b>X</b> di dalam ruangan yang disediakan bertentangan dengan nama calon yang tuan / puan pilih. <b>JANGAN DITULIS LAIN DARI TANDA X</b> dalam kertas undi ini dan janganlah mengundi lebih dari angka yang telah ditetapkan dan jika dibuat demikian undi bagi jawatan itu akan ditolak sebagai rosak dan tidak akan dikira.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah tuan / puan menanda undi, lipatkan kertas undi ini sekurang- kurangnya sekali dan masukkan ke dalam sampul surat dan masukkan ke dalam peti undi yang telah disediakan di dalam bilik mengundi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Jika tuan / puan mengundi dengan pos, lipatkan kertas undi ini sekurang- kurangnya sekali, masukkan ke dalam sampul surat yang telah disediakan dan hantarkan kepada Ketua Pemeriksa Undi supaya sampai kepadanya tidak lewat dari tarikh ........ haribulan ....... 20......</td>
		</tr>
	</table><br>

	<div class="bold uppercase left">PENGERUSI CAWANGAN</div>

	<table class="border collapse">
		<tr class="border center">
			<th class="border" width="3%">No.</th>
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
	<div class="bold uppercase left">NAIB PENGERUSI CAWANGAN</div>

	<table class="border collapse">
		<tr class="border center">
			<th class="border" width="3%">No.</th>
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
	<div class="bold uppercase left">SETIAUSAHA CAWANGAN</div>

	<table class="border collapse">
		<tr class="border center">
			<th class="border" width="3%">No.</th>
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
	<div class="bold uppercase left">BENDAHARI CAWANGAN</div>

	<table class="border collapse">
		<tr class="border center">
			<th class="border" width="3%">No.</th>
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
	<div class="bold uppercase left">AHLI JAWATAN KUASA</div>

	<table class="border collapse">
		<tr class="border center">
			<th class="border" width="3%">No.</th>
			<th class="border left">&nbsp;&nbsp;Nama Calon</th>
			<th class="border" width="35%">Undi ...... (...) sahaja</th>
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
	</table><br>
	<div class="bold uppercase left">WAKIL-WAKIL KE PERSIDANGAN PERWAKILAN</div>

	<table class="border collapse">
		<tr class="border center">
			<th class="border" width="3%">No.</th>
			<th class="border left">&nbsp;&nbsp;Nama Calon</th>
			<th class="border" width="35%">Undi ...... (...) sahaja</th>
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
	</table><br>
	<div class="bold right">CAP Nama Kesatuan</div>
	<div class="bold right">Atau Tandatangan Setiausaha Agung</div><br>

	<div class="break"> </div><br><br>
	<hr>

	<div style="text-align: right;" class="bold uppercase">CONTOH "C"</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;" class="right">Nama Kesatuan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
			<td class="bold">Kesatuan Unijaya</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<tr class="left justify" >
			<td  class="right">No. Pendaftaran&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
			<td>424234-H</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" class="right">Alamat Berdaftar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
			<td>
				D-9-5, Megan Avenue 1, 189, Jalan Tun Razak, <br>
				Hampshire Park, 50450 Kuala Lumpur, Selangor
			</td>
		</tr>
	</table><br>
	<span class="bold uppercase center">KERTAS UNDI</span><br>
	<div class="bold left"><u>Cara Mengundi</u></div>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(1)&nbsp;&nbsp;&nbsp;</td>
			<td>Tuan / Puan berhak mengundi sama ada MENYOKONG atau MEMBANGKANG usul yang berikut:</td>
		</tr>
	</table><br>
	<span class="center">........................................................................</span><br>
	<span class="bold center">(tuliskan usul itu di sini)</span>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">(2)&nbsp;&nbsp;&nbsp;</td>
			<td>Undi tuan / puan adalah <b>RAHSIA</b> dan tuan / puan hendaklah mencatatkan tanda pangkah seperti ini <b>X</b> di dalam ruang yang disediakan di bawah ini bertentangan dengan perkataan <b>MENYOKONG</b> atau perkataan <b>MEMBANGKANG</b> mengikut keputusan sendiri. Janganlah dituliskan lain daripada tanda <b>X</b> dalam kertas ini dan jika dibuat demikian kertas undi ini akan ditolak sebagai rosak dan tidak dikira.<br>&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(3)&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah tuan / puan menanda undi, lipatkanlah kertas undi ini sekurang- kurangnya sekali, masukkan ke dalam sampul surat nya dan masukkan ke dalam peti undi yang telah disediakan di dalam bilik mengundi itu.<br><br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">(4)&nbsp;&nbsp;&nbsp;</td>
			<td>Jika tuan / puan mengundi dengan pos, lipatkan kertas undi ini sekurang- kurangnya sekali, masukkan ke dalam sampul surat yang telah disediakan dan hantarkan kepada Setiausaha Cawangan supaya sampai kepadanya tidak lewat dari tarikh ......... haribulan......... 20 ..........<br> </td>
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
	<div class="right bold">CAP Kesatuan</div>
	<div class="right bold">Atau</div>
	<div class="right bold">Tandatangan Setiausaha Agung</div>

</div>
