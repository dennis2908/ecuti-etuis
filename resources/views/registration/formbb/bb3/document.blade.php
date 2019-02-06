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
		<span class="uppercase bold">PERATURAN- PERATURAN <br><span class="entity_name">{{ $formbb->federation->name }}</span></span><br><br>
		<div class="dotted"> </div><br>
		<div class="bold uppercase left">PERATURAN 1&nbsp; - &nbsp;NAMA DAN PEJABAT YANG BERDAFTAR</div>
	</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">1.1&nbsp;&nbsp;&nbsp;</td>
			<td>Nama Persekutuan ialah <span class="entity_name">{{ strtoupper($formbb->federation->name) }}</span> (Selepas ini dipanggil sebagai <b>Persekutuan</b>).</b><br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">1.2&nbsp;&nbsp;&nbsp;</td>
			<td>Pejabat yang berdaftar Persekutuan ialah di <span class="uppercase entity_address">{{ strtoupper($formbb->address->address1.
	    	($formbb->address->address2 ? ', '.$formbb->address->address2 : '').
	    	($formbb->address->address3 ? ', '.$formbb->address->address3 : '').', '.
	    	$formbb->address->postcode.' '.
	    	($formbb->address->district ? $formbb->address->district->name : '').', '.
	    	($formbb->address->state ? $formbb->address->state->name : '')) }}</span>, dan tempat
			mesyuaratnya ialah di pejabat berdaftar atau mana-mana tempat yang ditetapkan
			oleh Majlis Jawatankuasa Tertinggi.</td>
		</tr>
	</table>
	<br><br>
	<div class="bold uppercase left">PERATURAN 2 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; TUJUAN</div>
	<br>
	<div class="left">2.1&nbsp;&nbsp;&nbsp;Tujuan Persekutuan ialah :-</div>

	<table class="justify" width="50%">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">a)&nbsp;&nbsp;&nbsp;</td>
			<td>Membuat apa-apa yang perlu untuk menggalakkan kepentingan atau untuk
			kesempurnaan kerja-kerja semua atau mana-mana kesatuan sekerja
			gabungannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">b)&nbsp;&nbsp;&nbsp;</td>
			<td>Melindungi kepentingan kesatuan-kesatuan sekerja gabungan dan anggota-anggotanya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">c)&nbsp;&nbsp;&nbsp;</td>
			<td>Memberi nasihat dan bantuan dalam usaha memperbaiki keadaan-keadaan kerja misalnya pengambilan, masa kerja, kenaikan pangkat, tatatertib, keselamatan jawatan, gaji dan faedah-faedah persaraan kepada anggota-anggota kesatuan sekerja gabungannya apabila diperlukan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">d)&nbsp;&nbsp;&nbsp;</td>
			<td>Mengatur atau membantu perhubungan di antara pihak majikan-majikan dengan kesatuan-anggota gabungan, di antara anggota gabungan dengan anggota gabungan yang lainnya atau di antara anggota gabungan dengan anggotanya, dan menasihat untuk menyelesaikan sebarang perselisihan di antara mereka itu dengan cara damai dan muafakat.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">e)&nbsp;&nbsp;&nbsp;</td>
			<td>Mengadakan faedah-faedah bagi anggota-anggota kesatuan sekerja gabungan sebagaimana yang akan diputuskan oleh Konvensyen Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">f)&nbsp;&nbsp;&nbsp;</td>
			<td>Berusaha membantu untuk memajukan pergerakan dan pentadbiran semua atau	mana-mana kesatuan sekerja gabungan dan anggota-anggotanya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">g)&nbsp;&nbsp;&nbsp;</td>
			<td>Membantu mana-mana kesatuan sekerja gabungan atau mana-mana anggotanya
			sama ada secara kewangan atau lain-lain untuk memperolehi apa-apa nasihat
			undang-undang tertakluk kepada peruntukan dalam undang-undang kesatuan
			sekerja yang berkuatkuasa.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">h)&nbsp;&nbsp;&nbsp;</td>
			<td>Menggalakkan pembentukan undang-undang mengenai kepentingan kesatuan
			sekerja gabungan khasnya atau kesatuan-kesatuan sekerja lainnya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">i)&nbsp;&nbsp;&nbsp;</td>
			<td>Menjalankan, jika diputuskan oleh Majilis Jawatankuasa Tertinggi Persekutuan, kerja-kerja mengarang, mencetak, menerbit dan mengedarkan apa-apa akhbar, majalah, berita atau lain-lain persuratan bercetak untuk memajukan tujuan-tujuan Persekutuan atau menggalakkan kepentingan kesatuan-kesatuan sekerja gabungannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">j)&nbsp;&nbsp;&nbsp;</td>
			<td>Menggalakkan kebajikan, kebendaan, sosial dan pendidikan kesatuan sekerja gabungan dengan apa-apa cara yang sah yang dianggap patut oleh Konvensyen Persekutuan atau Majlis Jawatankuasa Tertinggi.</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">k)&nbsp;&nbsp;&nbsp;</td>
			<td>Amnya menjalankan segala tindakan dan usaha yang perlu untuk memajukan
			tujuan-tujuan tersebut di atas mengikut keputusan-keputusan yang dibuat oleh Konvensyen Persekutuan atau Majlis Jawatankuasa Tertinggi.</td>
		</tr>
	</table><br>

	<div class="bold uppercase left">PERATURAN 3 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; KEANGGOTAAN</div>

	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">3.1&nbsp;&nbsp;&nbsp;</td>
			<td>Keanggotaan Persekutuan terbuka kepada semua <b>kesatuan sekerja di dalam tred / pekerjaan / industri</b> yang serupa yang berdaftar di Malaysia.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">3.2&nbsp;&nbsp;&nbsp;</td>
			<td>Setiap kesatuan sekerja yang berdaftar yang ingin menjadi anggota gabungan hendaklah meluluskan satu ketetapan bersetuju menjadi anggota gabungan dalam mesyuarat agung atau persidangan perwakilan. Keputusan ketetapan ini hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja dalam masa satu bulan dari tarikh diluluskan berserta dengan satu pemberitahuan bertulis bahawa ketetapan tersebut telah diluluskan dalam mesyuarat agung atau persidangan perwakilan dan pemberitahuan seumpama itu hendaklah ditandatangani oleh Setiausaha dan tujuh orang anggota kesatuan sekerja tersebut.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.3&nbsp;&nbsp;&nbsp;</td>
			<td>Kesatuan sekerja yang berdaftar itu hendaklah menghantar kepada Setiausaha Agung Persekutuan di Ibu Pejabat berdaftar satu permohonan untuk menjadi anggota gabungan Persekutuan, berserta dengan satu salinan ketetapan anggota-anggota yang telah meluluskan permohonan itu dan satu salinan peraturan dan undang-undang kecilnya serta penyata anggota-anggota kesatuan sekerja yang membuat permohonan serta meluluskan ketetapan tersebut. Setiausaha Agung setelah menerima permohonan itu akan membawa semua permohonan menjadi anggota gabungan ke mesyuarat Majlis Jawatankuasa Tertinggi yang akan datang. Majlis Jawatankuasa Tertinggi adalah bebas menerima mana-mana permohonan menjadi anggota gabungan atau menolaknya dengan sebab-sebab yang pada pendapat Majlis Jawatankuasa Tertinggi adalah munasabah.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.4&nbsp;&nbsp;&nbsp;</td>
			<td>Setiap kesatuan sekerja yang berdaftar apabila diterima menjadi anggota gabungan Persekutuan akan diberi satu salinan Peraturan Persekutuan yang didaftarkan oleh Ketua Pengarah Kesatuan Sekerja dan satu Peraturan Tetap seperti yang dipersetujui oleh Konvensyen Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.5&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Agung akan memberitahu kesatuan sekerja yang berdaftar itu
			mengenai penerimaan permohonannya menjadi anggota gabungan dan meminta
			kesatuan sekerja yang berdaftar itu menghantar yuran masuk dan yuran tahunan pertama. Setelah menerima yuran-yuran tersebut daripada kesatuan sekerja yang berdaftar itu, Setiausaha Agung akan memberitahu Ketua Pengarah Kesatuan Sekerja bahawa permohonan menjadi anggota gabungan itu telah diluluskan. Setelah menerima pemberitahuan daripada Ketua Pengarah Kesatuan Sekerja bahawa catatan telah dibuat dalam daftar tentang gabungan tersebut, kesatuan sekerja yang berdaftar itu akan dianggap menjadi anggota gabungan Persekutuan.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 4 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; MENARIK DIRI DARI MENJADI ANGGOTA GABUNGAN</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">4.1&nbsp;&nbsp;&nbsp;</td>
			<td>Setiap kesatuan sekerja yang menjadi anggota Persekutuan yang ingin menarik diri daripada menjadi anggota Persekutuan hendaklah mendapatkan persetujuan anggota-anggotanya melalui undi majoriti yang dijalankan di Mesyuarat Agung atau Persidangan Perwakilan kesatuan sekerja yang berkenaan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">4.2&nbsp;&nbsp;&nbsp;</td>
			<td>Anggota gabungan yang ingin menarik diri daripada menjadi anggota Persekutuan itu apabila mendapat persetujuan anggota-anggotanya mengikut Peraturan 4.1 hendaklah mengemukakan notis bertulis dalam tempoh tiga (3) bulan yang dialamatkan kepada Setiausaha Agung Persekutuan. Satu salinan notis itu akan dihantar kepada Ketua Pengarah Kesatuan Sekerja. Selepas tamat tempoh tiga (3) bulan dari tarikh notis menarik diri daripada gabungan dengan Persekutuan, gabungan kesatuan sekerja tersebut akan terhenti, kecuali apa-apa wang yang terhutang yang patut diterima dari kesatuan sekerja yang berdaftar itu akan menjadi hutang dan perlu dibayar serta boleh diminta oleh Persekutuan.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 5 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; HAK DAN TANGGUNGJAWAB KESATUAN ANGGOTA GABUNGAN</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">5.1&nbsp;&nbsp;&nbsp;</td>
			<td>Mana-mana anggota gabungan yang bertukar alamat hendaklah memberitahu
			Setiausaha Agung dalam tempoh 14 hari mengenai pertukaran alamat itu. Jika
			tidak, Persekutuan tidak akan bertanggungjawab di atas surat-surat yang tidak diterima yang dialamatkan kepada alamat terakhir anggota gabungan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.2&nbsp;&nbsp;&nbsp;</td>
			<td>Adalah menjadi tanggungjawab tiap-tiap anggota gabungan untuk memastikan supaya yuran-yuran dan bayaran-bayaran khas dibayar pada masa yang ditetapkan dan resit-resitnya diperolehi. Tanggungjawab supaya pembayaran dibuat mengikut jadual masanya terletak kepada kesatuan sekerja yang bergabung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">5.3&nbsp;&nbsp;&nbsp;</td>
			<td>Anggota gabungan tidak boleh menerbitkan sebarang berita atau surat pekeliling mengenai Persekutuan melainkan dengan mendapat kebenaran dan kelulusan terlebih dahulu daripada Majlis Jawatankuasa Tertinggi. Anggota gabungan termasuk anggota-anggotanya tidak boleh mendedahkan sebarang kegiatan atau hal-hal Persekutuan kepada orang ramai yang bukan anggota-anggota gabungan atau kepada lain-lain pertubuhan atau pihak akhbar tanpa mendapat izin daripada Majlis Jawatankuasa Tertinggi.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 6 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; YURAN MASUK, YURAN TAHUNAN DAN YURAN KHAS</div>
	<table class="justify">
		<tr class="left justify">
			<td style="vertical-align: top;">6.1&nbsp;&nbsp;&nbsp;</td>
			<td>Tiap-tiap anggota gabungan hendaklah membayar yuran apabila diterima menjadi anggota gabungan Persekutuan seperti berikut:<br>&nbsp;</td>
		</tr>
		<tr class="left justify bold">
			<td style="vertical-align: top;"> &nbsp;&nbsp;&nbsp;</td>
			<td>Yuran Masuk &nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp; RM <span class="entrance_fee">.........</span></td>
		</tr>
		<tr class="left justify bold">
			<td style="vertical-align: top;"> &nbsp;&nbsp;&nbsp;</td>
			<td>Yuran Tahunan &nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;RM <span class="yearly_fee">.........</span><br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">&nbsp;&nbsp;&nbsp;</td>
			<td>
				Yuran tahunan hendaklah dibayar selewat-lewatnya sebelum 31hb Januari setiap tahun. Yuran tahunan untuk tahun pertama akan dikira secara <i>pro-rata</i> tahun kewangan mengikut tarikh permohonan untuk bergabung diterima.<br>&nbsp;
			</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.2&nbsp;&nbsp;&nbsp;</td>
			<td>Jika pada bila-bila masa jumlah pendapatan Persekutuan jatuh serendah-
			rendahnya atau jika apa-apa tanggungan kewangan akan menjadi sangat berat
			kepada sumber-sumber kewangan Persekutuan, maka Konvensyen Persekutuan
			boleh mengenakan satu bayaran khas. Bagaimanapun, bayaran khas hanya boleh
			dikenakan sekiranya lebih daripada separuh anggota-anggota kesatuan sekerja yang bergabung bersetuju dengan bayaran khas tersebut mengikut Peraturan 26.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.3&nbsp;&nbsp;&nbsp;</td>
			<td>Sekiranya mana-mana anggota gabungan gagal menjelaskan yuran atau jumlah apa-apa bayaran khas yang dikenakan itu dalam tempoh tiga (3) bulan dari tarikh sepatutnya dijelaskan, maka anggota gabungan itu akan digantung daripada mendapat segala faedah (kewangan dan lain-lain) selama tempoh anggota gabungan itu terhutang dan selama tempoh tiga (3) bulan lagi daripada masa ia menjelaskan yuran atau bayaran khas itu. Sekiranya anggota gabungan gagal membayar yurannya atau mana-mana bayaran khas yang dikenakan itu selepas tempoh enam (6) bulan daripada tarikh yang sepatutnya, perkara tersebut akan dibawa kepada Majlis Jawantankuasa Tertinggi yang akan berkuasa mengeluarkan atau memecat anggota gabungan itu daripada Persekutuan atau menyelesaikan perkara tersebut dengan cara yang dianggap baik. Anggota gabungan itu mempunyai hak merayu kepada Konvensyen Persekutuan yang mana keputusannya adalah muktamad.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.4&nbsp;&nbsp;&nbsp;</td>
			<td>Sekiranya mana-mana anggota gabungan tidak dapat menjelaskan jumlah apa-apa yuran atau jumlah apa-apa bayaran khas yang dikenakan itu, disebabkan kesulitan kewangannya, maka ia boleh membuat permohonan kepada Majlis Jawatankuasa Tertinggi secara bersurat yang dialamatkan kepada Setiausaha Agung bagi pengecualian sementara. Majlis Jawatankuasa Tertinggi mempunyai kuasa meluluskan permohonan itu dengan bersyarat dan bagi sesuatu tempoh atau tempoh-tempoh yang dianggap wajar. Dalam tempoh sesuatu pengecualian itu, anggota gabungan tersebut tidak mempunyai hak atas apa-apa faedah dan hanya akan mempunyai hak atas faedah-faedah yang sama apabila menjelaskan bayaran setelah tamat tempoh seperti yang ditetapkan oleh Majlis Jawatankuasa Tertinggi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">6.5&nbsp;&nbsp;&nbsp;</td>
			<td>Sebuah kesatuan sekerja yang telah diberi pengecualian sementara oleh Majlis Jawatankuasa Tertinggi boleh dibenarkan mengambil bahagian dalam
			Konvensyen Persekutuan atau apa-apa kegiatan lain yang diluluskan oleh Majlis Jawatankuasa Tertinggi tertakluk kepada ketetapan yang mungkin ditetapkan oleh Majlis Jawatankuasa Tertinggi dengan syarat kesatuan berkenaan membayar penuh yuran tahunan semasa dengan serta merta dan memberi akuan secara bertulis untuk menyelesaikan hutang-hutang yuran serta yuran tahunan akan datang secara ansuran seperti yang dipersetujui oleh Majlis Jawatankuasa Tertinggi.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 7 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PERLEMBAGAAN DAN PENTADBIRAN</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">7.1&nbsp;&nbsp;&nbsp;</td>
			<td>Kuasa yang tertinggi sekali di dalam Persekutuan ini terletak ke atas Konvensyen Persekutuan melainkan kuasa mengenai perkara-perkara yang keputusannya mesti diambil dengan undi rahsia menurut peraturan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">7.2&nbsp;&nbsp;&nbsp;</td>
			<td>Persekutuan ini hendaklah ditadbir oleh Majlis Jawatankuasa Tertinggi.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 8 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; KONVENSYEN <span class="convention_yearly">.........</span> TAHUNAN</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">8.1&nbsp;&nbsp;&nbsp;</td>
			<td>Konvensyen Persekutuan <span class="convention_yearly">.........</span> Tahunan hendaklah diadakan dengan seberapa segera selepas 1hb April dan tidak lewat dari 31hb Oktober pada
			setiap <span class="convention_yearly">.........</span> tahun. Tarikh, masa dan tempat Konvensyen itu hendaklah
			ditetapkan oleh Majlis Jawatankuasa Tertinggi Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.2&nbsp;&nbsp;&nbsp;</td>
			<td>Konvensyen itu hendaklah terdiri daripada wakil-wakil kesatuan sekerja yang
			menjadi anggota Persekutuan dan anggota-anggota Majlis Jawatankuasa
			Tertinggi Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.3&nbsp;&nbsp;&nbsp;</td>
			<td>Konvensyen akan mengandungi wakil-wakil yang layak dibawah peraturan-
			peraturan ini dan dilantik oleh kesatuan-kesatuan sekerja anggota secara undi
			rahsia mengikut bilangan keanggotaan masing-masing seperti yang didaftarkan
			di pejabat persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.4&nbsp;&nbsp;&nbsp;</td>
			<td>Tiap-tiap kesatuan anggota akan berhak mempunyai dua wakil bagi <span class="first_member">.......</span> ratus
			anggota yang pertama dan tambahan seorang lagi bagi tiap-tiap <span class="next_member">.......</span> ratus
			anggota lagi atau sebahagian daripadanya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.5&nbsp;&nbsp;&nbsp;</td>
			<td>Semua pemilihan tersebut di atas hendaklah diberitahu kepada Setiausaha
			Agung Persekutan tidak lewat dari 14 hari dari tarikh pemilihan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.6&nbsp;&nbsp;&nbsp;</td>
			<td>Hanya wakil-wakil dan anggota Majlis Jawatankuasa Tertinggi sahaja yang boleh
			mengundi di dalam Konvensyen Persekutuan. Pengerusi Konvensyen boleh
			memberi undi pemutus apabila undi yang diterima adalah sama banyak di atas
			semua perkara kecuali perkara-perkara di bawah Peraturan 26. Konvensyen
			akan dijalankan mengikut perbekalan-perbekalan yang dinyatakan dalam
			Peraturan-peraturan Tetap Konvensyen Persekutuan yang dibuat oleh
			Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.7&nbsp;&nbsp;&nbsp;</td>
			<td>Notis permulaan bagi Konvensyen <span class="convention_yearly">.........</span> Tahunan yang menyatakan tarikh, masa
			dan tempat konvensyen dan permintaan usul-usul (termasuk usul pindaan
			peraturan), penamaan calon-calon bagi menganggotai Majlis Jawatankuasa
			Tertinggi dan wakil-wakil, hendaklah dihantar oleh Setiausaha Agung kepada
			semua Setiausaha anggota gabungan sekurang-kurangnya 30 hari sebelum
			tarikh konvensyen. Penamaan calon bagi Majlis Jawatankuasa Tertinggi
			hendaklah atas nama jawatan dalam anggota gabungan masing-masing.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.8&nbsp;&nbsp;&nbsp;</td>
			<td>Tiap-tiap Setiausaha anggota gabungan hendaklah menghantar kepada
			Setiausaha Agung Persekutuan sekurang-kurangnya 14 hari sebelum
			Konvensyen, butir-butir mengenai wakil masing-masing, nama-nama calon bagi
			Pegawai-pegawai Utama dan anggota-anggota Majlis Jawatankuasa Tertinggi
			dan juga usul-usul (jika ada) untuk dibincangkan di dalam Konvensyen. Semua
			pencalonan hendaklah dibuat atas borang yang disediakan oleh Persekutuan
			yang mengandungi butir-butir yang berikut: nama jawatan yang ditandingi, nama
			calon, nombor anggota, nombor kad pengenalan, umur, alamat, pekerjaan dan
			nombor sijil kerakyatan atau taraf kerakyatan, seperti ditentukan di bawah
			Peraturan 12.2. Sesuatu pencalonan itu tidak sah kecuali:-<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">&nbsp;&nbsp;&nbsp;</td>
			<td>a)&nbsp;&nbsp;&nbsp;ia ditandatangani oleh seorang pencadang dan seorang penyokong
			yang merupakan anggota-anggota berhak; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">&nbsp;&nbsp;&nbsp;</td>
			<td>b)&nbsp;&nbsp;&nbsp;calon yang hendak bertanding itu memberi persetujuan secara bertulis.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.9&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Agung Persekutuan hendaklah menghantar kepada semua
			Setiausaha anggota gabungan sekurang-kurangnya 10 hari sebelum tarikh
			Konvensyen suatu agenda yang mengandungi usul-usul untuk perbincangan,
			penyata tahunan dan penyata kewangan dan kertas undi rahsia dengan
			secukupnya menurut kembaran kepada Peraturan-peraturan ini untuk pemilihan
			anggota Majlis Jawatankuasa Tertinggi dan untuk mengundi perkara-perkara
			yang akan diputuskan dengan undi sulit (jika ada).
			Setiausaha anggota gabungan hendaklah mengedarkan kertas-kertas undi itu
			dengan sampulnya kepada semua anggota yang berhak mengundi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.10&nbsp;&nbsp;&nbsp;</td>
			<td>Dua Pertiga (2/3) dari jumlah perwakilan yang berhak hendaklah menjadi kuorum Konvensyen <span class="convention_yearly">.........</span> Tahunan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.11&nbsp;&nbsp;&nbsp;</td>
			<td>Jika satu jam kemudian dari masa yang ditentukan itu, bilangan wakil yang hadir
			(atau kuorum) tidak mencukupi maka Konvensyen itu hendaklah ditangguhkan
			kepada suatu tarikh (tidak lewat dari 21 hari kemudian) yang akan ditetapkan
			oleh Majlis Jawatankuasa Tertinggi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.12&nbsp;&nbsp;&nbsp;</td>
			<td>Dalam Konvensyen yang ditangguhkan itu jika kuorumnya masih tidak mencukupi pada masa yang ditentukan maka wakil-wakil yang hadir berkuasa menjalankan Konvensyen itu akan tetapi tidak berkuasa meminda Peraturan-peraturan Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">8.13&nbsp;&nbsp;&nbsp;</td>
			<td>Urusan Konvensyen <span class="convention_yearly">.........</span> Tahunan antara lain-lain ialah:-<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify" width="50%">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(a)&nbsp;&nbsp;&nbsp;</td>
			<td>menerima dan meluluskan laporan-laporan daripada Setiausaha Agung,Bendahari Agung dan Majlis Jawatankuasa Tertinggi Persekutuan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(b)&nbsp;&nbsp;&nbsp;</td>
			<td>membincang dan memutuskan sebarang perkara atau usul mengenai kebajikan dan kemajuan anggota-anggota gabungan Persekutuan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>memilih/melantik: -<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">i.&nbsp;&nbsp;&nbsp;</td>
			<td>Pemegang Amanah; jika ada</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">ii.&nbsp;&nbsp;&nbsp;</td>
			<td>Ahli Jemaah Penimbangtara; jika perlu</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">iii.&nbsp;&nbsp;&nbsp;</td>
			<td>Juruaudit Dalam; dan</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">iv.&nbsp;&nbsp;&nbsp;</td>
			<td>Pemeriksa Undi</td>
		</tr>
	</table>
	<table class="justify" width="50%">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(d)&nbsp;&nbsp;&nbsp;</td>
			<td>meluluskan jawatan-jawatan sepenuh masa bagi pegawai-pegawai dan pekerja sekiranya perlu;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(e)&nbsp;&nbsp;&nbsp;</td>
			<td>menerima penyata Pemeriksa Undi berkenaan dengan undi rahsia bagi pemilihan anggota Majlis Jawatankuasa Tertinggi; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(f)&nbsp;&nbsp;&nbsp;</td>
			<td>membincang dan memutuskan perkara-perkara lain yang terkandung di dalam agenda.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">8.14&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Agung hendaklah menyampaikan kepada semua Setiausaha
			anggota gabungan satu salinan minit Konvensyen <span class="convention_yearly">.........</span> Tahunan dalam tempoh
			tidak melebihi 60 hari sesudah sahaja selesai Konvensyen itu.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 9 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; KONVENSYEN LUAR BIASA PERSEKUTUAN</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">9.1&nbsp;&nbsp;&nbsp;</td>
			<td>Konvensyen Luar Biasa Persekutuan hendaklah diadakan :-<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify" width="50%">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">a)&nbsp;&nbsp;&nbsp;</td>
			<td>apabila sahaja difikirkan mustahak oleh Majlis Jawatankuasa Tertinggi; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">b)&nbsp;&nbsp;&nbsp;</td>
			<td>atas permintaan bersama secara bertulis daripada tidak kurang satu pertiga
			(1/3) daripada kesatuan-kesatuan sekerja yang mempunyai hak
			keanggotaan dalam Persekutuan. Permintaan itu hendaklah menyatakan
			tujuan-tujuan dan sebab-sebab mereka ingin Konvensyen itu diadakan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">(c)&nbsp;&nbsp;&nbsp;</td>
			<td>memilih/melantik: -<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">9.2&nbsp;&nbsp;&nbsp;</td>
			<td>Konvensyen Luar Biasa Persekutuan yang diminta oleh kesatuan gabungan
			hendaklah dikendalikan oleh Setiausaha Agung dalam tempoh 21 hari dari tarikh
			permintaan itu diterima. Majlis Jawatankuasa Tertinggi hendaklah memastikan
			bahawa permintaan yang sah di bawah Peraturan 9.1 dilaksanakan dengan teratur tanpa gagal.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">9.3&nbsp;&nbsp;&nbsp;</td>
			<td>Notis dan agenda bagi Konvensyen Luar Biasa Persekutuan hendaklah
			disampaikan oleh Setiausaha Agung kepada kesatuan gabungan sekurang-
			kurangnya 7 hari sebelum tarikh Konvensyen.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">9.4&nbsp;&nbsp;&nbsp;</td>
			<td>Peruntukan-peruntukan Peraturan 8 berkenaan dengan kuorum dan
			penangguhan Konvensyen Persekutuan <span class="convention_yearly">.........</span> Tahunan adalah juga terpakai bagi
			Konvensyen Luar Biasa Persekutuan. Walau bagaimanapun dalam Konvensyen
			Luar Biasa yang diminta oleh kesatuan-kesatuan gabungan jika Konvensyen itu
			ditangguhkan kerana kuorum tidak cukup maka Konvensyen yang ditetapkan
			sesudah penangguhan itu hendaklah ditutupkan sekiranya kuorum masih tidak
			mencukupi selepas satu jam dari masa yang dijadualkan. Konvensyen
			berkenaan bagi perkara yang sama tidak boleh diadakan melainkan selepas
			enam (6) bulan dari tarikh konvensyen itu ditutupkan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">9.5&nbsp;&nbsp;&nbsp;</td>
			<td>Jika Konvensyen Persekutuan <span class="convention_yearly">.........</span> Tahunan tidak dapat diadakan dalam masa
			yang ditentukan dalam Peraturan 8, maka berkuasalah Konvensyen Luar Biasa
			Persekutuan menjalankan sebarang kerja yang lazimnya dijalankan oleh
			Konvensyen Persekutuan <span class="convention_yearly">.........</span> Tahunan dengan syarat Konvensyen Luar Biasa
			Persekutuan yang demikian mestilah diadakan sebelum 31hb Disember dalam
			tahun yang berkenaan.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 10 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; MAJLIS JAWATANKUASA TERTINGGI</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">10.1&nbsp;&nbsp;&nbsp;</td>
			<td>Pengurusan dan penyelenggaran Persekutuan termasuk pertikaian-pertikaian
			perusahaan, di antara tempoh Konvensyen Persekutuan <span class="convention_yearly">.........</span> Tahunan akan
			terletak kepada Majlis Jawatankuasa Tertinggi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">10.2&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Tertinggi akan mengandungi -<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr>
			<th width="70%"></th>
			<th width="1%"></th>
			<th width="29%"></th>
		</tr>
		<tr class="left" >
			<td>
				<ul>
					<li>seorang Presiden;</li>
					<li>seorang Naib Presiden;</li>
					<li>seorang Setiausaha Agung;</li>
					<li>seorang Penolong Setiausaha Agung;</li>
					<li>seorang Bendahari Agung;</li>
					<li>seorang Penolong Bendahari Agung; dan</li>
					<li>seorang Ahli Jawatankuasa dari Kesatuan masing-masing.</li>
				</ul>
			</td>
			<td class="right" style="font-size: 130px; font-family: arial !important;">}&nbsp;&nbsp;&nbsp;</td>
			<td class="left">Mereka dikenali sebagai Pegawai-Pegawai Utama <br>Persekutuan dan akan dipilih menurut Peraturan 8.7, <br>setiap <span class="convention_yearly">.........</span> tahun sekali undi rahsia oleh wakil-wakil.</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">&nbsp;&nbsp;&nbsp;</td>
			<td>Seorang Ahli Jawatankuasa akan dipilih oleh wakil-wakil di dalam Konvensyen menurut peraturan 8.3, daripada setiap kesatuan gabungan.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">10.3&nbsp;&nbsp;&nbsp;</td>
			<td>Semua pegawai Persekutuan hendaklah memegang jawatan sehingga pemilihan
			yang akan datang. Mereka layak untuk dicalonkan ataupun dipilih semula
			tertakluk kepada Peraturan 8.3.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">10.4&nbsp;&nbsp;&nbsp;</td>
			<td>Sekiranya seseorang Ahli Majlis Jawatankuasa Tertinggi meletakkan jawatan
			maka Majlis Jawatankuasa Tertinggi berkuasa melantik atau mengisi
			kekosongan tertakluk kepada Peraturan 8.3. Jika kekosongan jawatan dalam
			Majlis Jawatankuasa Tertinggi disebabkan pegawai itu meninggal dunia atau
			tidak lagi berkelayakkan maka kesatuan gabungan yang pegawainya memegang
			jawatan berhak untuk menentukan pengganti.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">10.5&nbsp;&nbsp;&nbsp;</td>
			<td>Ahli Majlis Jawatankuasa Tertinggi yang tidak menghadiri tiga (3) kali mesyuarat
			berturut-turut tidak lagi berhak menyandang jawatannya melainkan jika dapat ia
			memberi alasan yang memuaskan kepada Majlis Jawatankuasa Tertinggi.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 11 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; TUGAS DAN FUNGSI MAJLIS JAWATANKUASA TERTINGGI</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">11.1&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Tertinggi akan mengadakan mesyuaratnya sekurang-
			kurangnya tiga bulan sekali atau seberapa kerap yang perlu. Kuorum bagi
			mesyuarat Majlis Jawatankuasa Tertinggi ialah Â½ daripada jumlah anggotanya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.2&nbsp;&nbsp;&nbsp;</td>
			<td>Tugas-tugas Majlis Jawatankuasa Tertinggi ialah -<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify" width="50%">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">a)&nbsp;&nbsp;&nbsp;</td>
			<td>Menguruskan hal ehwal Persekutuan dan menggunakan semua atau
			mana-mana kuasa serta menjalankan semua tindakan, tugas dan
			kewajipan sebagaimana perlu untuk mencapai atau ada berkaitan atau
			untuk kebaikan bagi mencapai tujuan-tujuan dan kepentingan-
			kepentingan Persekutuan. Dalam menguruskan hal ehwal Persekutuan,
			Majlis Jawatankuasa Tertinggi itu akan patuh kepada semua arahan yang
			diberi oleh Konvensyen Persekutuan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">b)&nbsp;&nbsp;&nbsp;</td>
			<td>Membincang dan memberi nasihat atas semua soal yang dikemukakan oleh anggota dan wakil-wakil anggota gabungan; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">c)&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila perlu, melantik jawatankuasa kecil atau perwakilan untuk
			menemui pihak-pihak yang terlibat dalam apa-apa perselisihan atau
			membuat penyelesaiannya dengan tujuan untuk mengelakkan atau pun
			menyelesaikan sesuatu pertikaian.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">11.3&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Tertinggi hendaklah memberi perintah-perintah kepada
			Setiausaha Agung dan pegawai-pegawai lain bagi mengendalikan hal-ehwal
			Persekutuan. Tertakluk kepada perbekalan-perbekalan Peraturan 12.3, ia
			boleh mengambil kakitangan yang dianggap perlu, dan boleh menggantung
			atau memecat mana-mana pegawai atau pekerja kerana kecuaian menjalankan
			tugas, tidak jujur, tidak berkelayakan, enggan menjalankan keputusan-
			keputusan Majlis Jawatankuasa Tertinggi atau kerana apa-apa sebab yang lain
			yang dianggapnya berpatutan demi kepentingan Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.4&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Tertinggi hendaklah melindungi kewangan Persekutuan
			daripada pemborosan dan penipuan. Majlis Jawatankuasa Tertinggi hendaklah
			mengarahkan Setiausaha Agung atau mana-mana pegawai lain untuk mendakwa mana-mana pegawai atau anggota kerana menipu atau menahan mana-mana wang atau harta kepunyaan Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.5&nbsp;&nbsp;&nbsp;</td>
			<td>Di antara dua Konvensyen Persekutuan <span class="convention_yearly">.........</span> Tahunan, maka Majlis
			Jawatankuasa Tertinggi akan mentafsirkan Peraturan dan, apabila perlu,
			menentukan apa-apa perkara yang tidak diterangkan dalam Peraturan ini.<br>&nbsp;</td>
					</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.6&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Tertinggi mempunyai kuasa menggantungkan mana-mana
			anggota gabungan daripada mendapat faedah atau memecat daripada
			keanggotaan gabungan, atau melarang daripada memegang apa-apa jawatan,
			yang pada pendapatnya bersalah kerana cuba merosakkan Persekutuan atau
			kerana tindakan yang bercanggah dengan Peraturan Persekutuan atau
			membuat atau dengan apa-apa cara juga melibatkan diri dengan apa-apa
			serangan menfitnah, memburukkan atau mencerca Persekutuan, pegawai-
			pegawai atau dasar Persekutuan. Anggota gabungan yang digantung, dipecat
			atau dilarang mempunyai hak merayu kepada Konvensyen Persekutuan.
			Keputusan Konvensyen Persekutuan adalah muktamad.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.7&nbsp;&nbsp;&nbsp;</td>
			<td>Semua persoalan dalam Majlis Jawatankuasa Tertinggi (kecuali ada peruntukan
			yang lain dibekalkan) akan diputuskan dengan cara mengangkat tangan dan
			sekiranya undi sama banyak maka Presiden atau dalam ketiadaannya, Naib
			Presiden akan mempunyai undi pemutus.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.8&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Tertinggi jika perlu boleh memanggil anggota-anggota
			gabungan bermesyuarat untuk memutuskan secara bersama sesuatu dasar,
			upah atau gaji atau apa-apa perkara lain yang berkaitan dengan kepentingan
			Persekutuan. Apa-apa keputusan yang diambil akan tertakluk kepada kelulusan
			Konvensyen Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.9&nbsp;&nbsp;&nbsp;</td>
			<td>Sekiranya apa-apa persoalan atau perkara berbangkit yang pada pendapat
			Majlis Jawatankuasa Tertinggi tidak diliputi oleh peraturan ini atau yang
			mengenainya atau peraturan ini kelihatan samar-samar kepada Majlis
			Jawatankuasa Tertinggi, maka Majlis Jawatankuasa Tertinggi boleh memberi
			keputusan bagaimana soal atau perkara itu akan diselenggarakan, dan akan
			membawa keputusan mereka itu kepada Konvensyen Persekutuan yang akan
			datang, atau kepada Konvensyen Luar Biasa Persekutuan, jika Majlis
			Jawatankuasa Tertinggi menganggapnya perlu. Konvensyen Persekutuan boleh
			mempersetujui, mengubah atau membatalkan keputusan itu dan boleh
			mengekalkan keputusan itu dengan mengubah peraturan seperti yang
			dibekalkan dalam Peraturan 25. Keputusan itu berkuatkuasa sehingga
			keputusan Majlis Jawatankuasa Tertinggi diubah atau ditutupkan atau
			diketepikan oleh Mahkamah. Sekiranya, Konvensyen Persekutuan
			membatalkan atau mengubah keputusan itu maka Konvensyen Persekutuan
			boleh memberi arahan-arahan supaya Pembatalan atau pengubahan itu
			berkuatkuasa dari tarikh kebelakangan jika difikirkan perlu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.10&nbsp;&nbsp;&nbsp;</td>
			<td>Jika mana-mana anggota gabungan tidak berpuashati dengan mana-mana
			keputusan Majlis Jawatankuasa Tertinggi maka ia boleh merayu kepada
			Konvensyen Persekutuan, yang keputusannya di atas perkara tersebut adalah muktamad dan mengikat, kecuali diketepikan oleh sebuah Mahkamah. Mana-
			mana anggota gabungan yang ingin merayu hendaklah menghantar
			pemberitahuan mengenai keinginannya berserta butir-butir ringkas alasan-
			alasan rayuannya itu kepada Setiausaha Agung dalam masa 30 hari setelah
			keputusan itu diberi oleh Majlis Jawatankuasa Tertinggi dan rayuan tersebut
			akan dibawa kepada Konvensyen Persekutuan yang akan datang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.11&nbsp;&nbsp;&nbsp;</td>
			<td>Persekutuan dan Majlis Jawatankuasa Tertinggi hendaklah menghormati kedaulatan perlembagaan setiap anggota gabungannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.12&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila berlaku sesuatu perkara yang memerlukan keputusan dari Majlis
			Jawatankuasa Tertinggi dengan serta merta dan tidak dapat diadakan satu
			mesyuarat tergempar, maka Setiausaha Agung boleh, dengan persetujuan
			Presiden, mendapatkan satu keputusan melalui satu surat pekeliling. Syarat-
			syarat berikut mestilah dipenuhi sebelum satu-satu keputusan Majlis
			Jawatankuasa Tertinggi itu dianggap telah diperolehi:-<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify" width="50%">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">a)&nbsp;&nbsp;&nbsp;</td>
			<td>Perkara dan tindakan yang dicadangkan mestilah dinyatakan dengan
			jelas dalam surat pekeliling, dan salinan-salinan pekeliling tersebut
			mestilah dihantar kepada semua anggota Majlis Jawatankuasa Tertinggi;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">b)&nbsp;&nbsp;&nbsp;</td>
			<td>Sekurang-kurangnya Â½ daripada anggota-anggota Majlis Jawatankuasa
			Tertinggi mestilah menyatakan secara bertulis samada mereka bersetuju
			atau menentang cadangan itu; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">c)&nbsp;&nbsp;&nbsp;</td>
			<td>Suara yang terbanyak dari mereka yang menyatakan pendapatnya
			adalah menjadi keputusan.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">11.13&nbsp;&nbsp;&nbsp;</td>
			<td>Sesuatu keputusan yang diperolehi melalui surat pekeliling hendaklah
			dilaporkan oleh Setiausaha Agung kepada mesyuarat Majlis Jawatankuasa
			Tertinggi yang akan datang dan dicatatkan dalam minit.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">11.14&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Tertinggi hendaklah memberi arahan kepada pemegang-
			pemegang Amanah mengenai pelaburan wang Persekutuan.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 12 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PEGAWAI DAN KAKITANGAN</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">12.1&nbsp;&nbsp;&nbsp;</td>
			<td>Erti pegawai dalam Persekutuan ini adalah seseorang yang menjadi anggota
			Majlis Jawatankuasa Tertinggi tetapi tidak termasuk Juruaudit.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">12.2&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang itu tidak boleh dipilih atau bertugas sebagai Pegawai Persekutuan jika orang itu:-<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify" width="50%">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">a)&nbsp;&nbsp;&nbsp;</td>
			<td>bukan anggota kesatuan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">b)&nbsp;&nbsp;&nbsp;</td>
			<td>belum sampai 21 tahun umurnya;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">c)&nbsp;&nbsp;&nbsp;</td>
			<td>bukan warganegara Malaysia;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">d)&nbsp;&nbsp;&nbsp;</td>
			<td>pernah manjadi anggota eksekutif mana-mana kesatuan yang pendaftarannya telah ditutupkan di bawah seksyen 15 (1) (b) (iv), (v) atau (vi) Akta Kesatuan Sekerja 1959 atau enakmen yang telah dimansuhkan oleh Akta itu;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">e)&nbsp;&nbsp;&nbsp;</td>
			<td>pernah disabitkan salah oleh Mahkamah kerana pecah amanah,
			pemerasan atau mengugut, atau kerana melakukan sebarang
			kesalahan lain yang mengikut pendapat Ketua Pengarah Kesatuan
			Sekerja tidak melayakkannya menjadi pegawai sesebuah kesatuan
			sekerja;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">f)&nbsp;&nbsp;&nbsp;</td>
			<td>seorang pemegang jawatan atau pekerja sesebuah parti politik;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">g)&nbsp;&nbsp;&nbsp;</td>
			<td>seseorang yang masih bankrap; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">h)&nbsp;&nbsp;&nbsp;</td>
			<td>Memegang jawatan atau kakitangan lain-lain Persekutuan.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">12.3&nbsp;&nbsp;&nbsp;</td>
			<td>Tertakluk kepada kelulusan Konvensyen Persekutuan, Majlis Jawatankuasa
			Tertinggi berkuasa menggaji orang yang difikirkan perlu. Dengan syarat
			seseorang pegawai atau kakitangan sepenuh masa itu selain daripada orang-
			orang yang tersebut di dalam proviso kepada seksyen 29 (1) Akta Kesatuan
			Sekerja 1959, tidak boleh menjadi pegawai kesatuan (melainkan ianya
			dikecualikan di bawah seksyen 30 Akta Kesatuan Sekerja 1959) atau bertugas
			dengan sedemikian rupa hingga urusan hal ehwal Persekutuan itu nampak
			dalam kawalannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">12.4&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang itu tidak boleh digaji sedemikian jika:-<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify" width="50%">
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">a)&nbsp;&nbsp;&nbsp;</td>
			<td>ia bukan warganegara Malaysia, atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">b)&nbsp;&nbsp;&nbsp;</td>
			<td>ia telah disabitkan salah oleh sebuah Mahkamah melakukan sesuatu
			kesalahan jenayah dan belum lagi mendapat pengampunan bagi
			kesalahan tersebut dan kesalahan itu mengikut pendapat Ketua
			Pengarah Kesatuan Sekerja tidak melayakkannya digaji oleh sebuah
			Kesatuan sekerja; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">c)&nbsp;&nbsp;&nbsp;</td>
			<td>ia adalah seorang pegawai atau pekerja sesebuah kesatuan sekerja yang lain; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">d)&nbsp;&nbsp;&nbsp;</td>
			<td>ia adalah seorang pemegang jawatan atau pekerja sesebuah parti politik.<br>&nbsp;</td>
		</tr>
	</table>
	<div class="bold uppercase left">PERATURAN 13 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; KEWAJIPAN PEGAWAI-PEGAWAI UTAMA PERSEKUTUAN</div><br>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">1&nbsp;&nbsp;&nbsp;</td>
			<td>Presiden</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">a)&nbsp;&nbsp;&nbsp;</td>
			<td>Dalam masa menyandang jawatannya hendaklah menjadi Pengerusi
			semua mesyuarat Konvensyen dan semua mesyuarat Majlis
			Jawatankuasa Tertinggi, dan hendaklah bertanggungjawab tentang
			ketenteraman dan kesempurnaan mesyuarat-mesyuarat itu. Ia
			mempunyai undian pemutus dalam isu-isu pada masa mesyuarat.
			Kuasa pemutus ini tidak termasuk perkara-perkara yang melibatkan
			undi rahsia;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">b)&nbsp;&nbsp;&nbsp;</td>
			<td>Beliau hendaklah mengesahkan minit tiap-tiap mesyuarat dengan menandatanganinya;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">c)&nbsp;&nbsp;&nbsp;</td>
			<td>Ia hendaklah menandatangani segala cek bagi pihak Persekutuan
			bersama-sama dengan Setiausaha Agung dan Bendahari Agung
			Persekutuan; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">d)&nbsp;&nbsp;&nbsp;</td>
			<td>Ia hendaklah mengawasi semua pentadbiran dan perjalanan
			persekutuan dan juga hendaklah berikhtiar supaya peraturan-peraturan
			ini dipatuhi oleh sekalian yang berkenaan.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">2&nbsp;&nbsp;&nbsp;</td>
			<td>Naib Presiden</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">a)&nbsp;&nbsp;&nbsp;</td>
			<td>Naib Presiden hendaklah menggantikan Presiden dan memegang
			kuasanya dimasa ketiadaannya.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">3&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Agung</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">a)&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Agung hendaklah mengelolakan kerja-kerja Persekutuan
			mengikut peraturan-peraturan ini dan hendaklah menjalankan perintah-
			perintah dan arahan-arahan mesyuarat Konvensyen dan Majlis
			Jawatankuasa Tertinggi;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">b)&nbsp;&nbsp;&nbsp;</td>
			<td>Ia hendaklah mengawasi kerja-kerja kakitangan Persekutuan dan
			hendaklah bertanggungjawab tentang surat menyurat dan menyimpan
			buku-buku, surat-surat keterangan dan kertas-kertas Persekutuan
			dengan cara dan aturan yang diarahkan oleh Majlis Jawatankuasa
			Tertinggi;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">c)&nbsp;&nbsp;&nbsp;</td>
			<td>Ia hendaklah menyediakan agenda dan menetapkan mesyuarat Majlis
			Jawatankuasa Tertinggi dengan persetujuan terlebih dahalu dari
			Presiden. Ia hendaklah menghadiri semua mesyuarat dan mencatat
			minit-minit mesyuarat itu dan hendaklah menyediakan penyata tahunan
			kegiatan Persekutuan untuk mesyuarat Konvensyen Persekutuan <span class="convention_yearly">.........</span>
			Tahunan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">d)&nbsp;&nbsp;&nbsp;</td>
			<td>Ia hendaklah menyediakan atau berikhtiar supaya disediakan Penyata-
			penyata tahunan dan lain-lain surat keterangan yang dikehendaki oleh
			Ketua Pengarah Kesatuan Sekerja dan hendaklah menghantarkannya
			kepada Ketua Pengarah Kesatuan Sekerja dalam masa yang
			ditentukan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">e)&nbsp;&nbsp;&nbsp;</td>
			<td>Ia hendaklah menyimpan dan mengemaskinikan suatu Daftar
			Keanggotaan, nama alamat mereka, nombor anggota, dan tarikh
			mereka menjadi anggota Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">f)&nbsp;&nbsp;&nbsp;</td>
			<td>Setiausaha Agung hendaklah menandatangani segala cek bagi pihak
			Persekutuan bersama-sama dengan Presiden dan Bendahari Agung.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">4&nbsp;&nbsp;&nbsp;</td>
			<td>Penolong Setiausaha Agung</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">a)&nbsp;&nbsp;&nbsp;</td>
			<td>Penolong Setiausaha Agung hendaklah membantu Setiausaha Agung Persekutuan dalam urusan pentadbiran Persekutuan dan hendaklah
			menggantinya pada masa ketiadaannya; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">b)&nbsp;&nbsp;&nbsp;</td>
			<td>Penolong Setiausaha Agung hendaklah juga menjalankan tugas-tugas
			yang diarah oleh Majlis Jawatankuasa Tertinggi.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">5&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari Agung</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">a)&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari Agung hendaklah bertanggungjawab dalam urusan
			penerimaan dan pembayaran wang bagi pihak Persekutuan dan urusan
			penyimpanan dan catatan di buku-buku kewangan sebagaimana yang
			dikehendaki oleh Peraturan-peraturan Kesatuan Sekerja 1959;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">b)&nbsp;&nbsp;&nbsp;</td>
			<td>Ia hendaklah mengeluarkan resit-resit rasmi bagi tiap-tiap wang yang
			diterimanya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">c)&nbsp;&nbsp;&nbsp;</td>
			<td>Tidaklah boleh pegawai-pegawai lain atau kakitangan Persekutuan di
			Ibu Pejabat menerima wang atau mengeluarkan resit rasmi tanpa kuasa
			yang diberikan dengan bersurat oleh Presiden pada tiap-tiap kali
			dikehendaki mereka itu berbuat demikian.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">d)&nbsp;&nbsp;&nbsp;</td>
			<td>Ia hendaklah bertanggungjawab tentang keselamatan simpanan buku-
			buku kewangan dan surat-surat keterangan yang berkenaan di Ibu
			Pejabat. Buku-buku dan surat-surat keterangan ini tidak boleh
			dikeluarkan dari tempat rasminya tanpa kebenaran bertulis daripada
			Presiden pada setiap kali ia hendak dikeluarkan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">e)&nbsp;&nbsp;&nbsp;</td>
			<td>Ia hendaklah menyediakan penyata kewangan bagi setiap mesyuarat
			Majlis Jawatankuasa Tertinggi Konvensyen Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">f)&nbsp;&nbsp;&nbsp;</td>
			<td>Ia hendaklah menandatangani segala cek bagi pihak Persekutuan
			bersama-sama dengan Presiden dan Setiausaha Agung Persekutuan.<br>&nbsp;</td>
		</tr>
	</table>
	<table class="justify">
		<tr class="left justify bold">
			<td style="vertical-align: top;" width="5%">6&nbsp;&nbsp;&nbsp;</td>
			<td>Penolong Bendahari Agung</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">a)&nbsp;&nbsp;&nbsp;</td>
			<td>Penolong Bendahari Agung hendaklah membantu Bendahari
			Agung dalam urusan penyimpanan dan catatan di buku-buku
			kewangan dan hendaklah menggantikannya pada masa
			ketiadaannya.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 14 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; GAJI DAN BAYARAN-BAYARAN LAIN</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">14.1&nbsp;&nbsp;&nbsp;</td>
			<td>Gaji mana-mana pegawai dan kakitangan yang bekerja sepenuh masa dengan
			Persekutuan hendaklah ditetapkan oleh Konvensyen <span class="convention_yearly">.........</span> Tahunan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">14.2&nbsp;&nbsp;&nbsp;</td>
			<td>Pegawai-pegawai Persekutuan yang dikehendaki berkhidmat separuh masa
			bagi pihak Persekutuan bolehlah diberi bayaran saguhati. Jumlah wang yang
			akan dibayar hendaklah diputuskan oleh Majlis Jawatankuasa Tertinggi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">14.3&nbsp;&nbsp;&nbsp;</td>
			<td>Pegawai-pegawai dan wakil-wakil Persekutuan bolehlah diberi bayaran kerana
			hilang masa kerjanya dan kerana telah membuat perbelanjaan yang berpatutan
			bagi menjalankan kerja-kerja Persekutuan jika diluluskan oleh Majlis
			Jawatankuasa Tertinggi. Suatu keterangan perbelanjaan yang berserta resit
			atau lain-lain keterangan pembayaran hendaklah dihantar kepada Majlis
			Jawatankuasa Tertinggi. Had maksima yang boleh dibayar di bawah perenggan
			ini hendaklah ditentukan dari masa ke semasa oleh Majlis Jawatankuasa
			Tertinggi dan tidak boleh mengesahkan sebarang bayaran yang melebihi had
			yang telah ditentukan itu.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 15 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; KEWANGAN DAN KIRA-KIRA</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">15.1&nbsp;&nbsp;&nbsp;</td>
			<td>Wang Persekutuan bolehlah dibelanjakan bagi perkara-perkara yang tersebut di bawah :-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">a)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran gaji, bayaran elaun dan perbelanjaan kepada pegawai-pegawai dan pekerja-pekerja Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">b)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran dan perbelanjaan pentadbiran Persekutuan termasuk bayaran audit kira-kira Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">c)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran urusan pendakwaan atau pembelaan dalam perbicaraan
			perundangan mengenai sesuatu hal berhubung dengan Persekutuan atau
			anggota gabungan Persekutuan dengan tujuan hendak memperolehi atau
			mempertahankan hak Persekutuan atau sebarang hak yang terbit dari
			perhubungan di antara anggota gabungan Persekutuan dengan majikannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">d)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran urusan mengenai pertikaian kerja bagi pihak Persekutuan atau
			anggotanya dengan syarat bahawa pertikaian kerja itu tidak bertentangan
			dengan Akta Kesatuan Sekerja 1959 atau undang-undang bertulis yang lain.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">e)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran yuran gabungan mengenai pergabungan dengan atau
			keanggotaan pada mana-mana persekutuan kesatuan-kesatuan sekerja
			yang telah di daftarkan di bawah Bahagian XII Akta Kesatuan Sekerja 1959,
			atau mana-mana badan perunding atau badan yang serupa yang mana
			kelulusan telah diberi oleh Ketua Pengarah di bawah seksyen 76A (1) atau
			Ketua Pengarah Kesatuan Sekerja telah diberitahu di bawah seksyen 76A
			(2), Akta Kesatuan Sekerja 1959.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">f)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran-bayaran yang tersebut di bawah :-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">(i)&nbsp;&nbsp;&nbsp;</td>
			<td>Tambang-tambang keretapi, perbelanjaan pengangkutan lain yang
			perlu, perbelanjaan makan dan tempat tidur, yang disertakan resit atau
			sebanyak mana yang telah ditentukan oleh Persekutuan, mengikut had-
			had yang ditentukan di bawah Peraturan ini.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">(ii)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran jumlah kehilangan gaji yang sebenar oleh wakil Persekutuan
			kerana menghadiri mesyuarat-mesyuarat mengenai atau berhubung
			dengan hal perhubungan perusahaan atau menyempurnakan apa-apa
			perkara seperti diperlukan oleh Ketua Pengarah Kesatuan Sekerja
			berkaitan dengan Akta Kesatuan Sekerja 1959 atau Peraturan-
			peraturannya, mengikut had-had yang ditentukan di bawah Peraturan
			14.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">g)&nbsp;&nbsp;&nbsp;</td>
			<td>Perbelanjaan urusan mengarang, mencetak, menerbit dan mengedar
			sebarang surat khabar, majalah, surat berita atau lain-lain penerbitan yang
			dikeluarkan oleh Persekutuan untuk menjayakan tujuan-tujuannya atau
			untuk faedah anggota-anggota gabungan menurut peraturan yang telah
			didaftarkan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">h)&nbsp;&nbsp;&nbsp;</td>
			<td>Perbelanjaan yang dibuat untuk menyelesaikan pertikaian di bawah
			Bahagian VI Akta Kesatuan Sekerja 1959.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">i)&nbsp;&nbsp;&nbsp;</td>
			<td>Bayaran mengenai aktiviti-aktiviti sosial, sukan, pelajaran dan amal
			kebajikan bagi anggota gabungan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">j)&nbsp;&nbsp;&nbsp;</td>
			<td>Pembayaran premium kepada syarikat-syarikat insurans (berdaftar di
			Malaysia). Pembayaran premium ini hendaklah diluluskan oleh Ketua
			Pengarah Kesatuan Sekerja dari semasa ke semasa.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">15.2&nbsp;&nbsp;&nbsp;</td>
			<td>Wang Persekutuan tidak boleh digunakan secara langsung atau sebaliknya
			untuk membayar denda atau hukuman yang dikenakan oleh Mahkamah kepada
			sesiapa pun.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">15.3&nbsp;&nbsp;&nbsp;</td>
			<td>Wang Persekutuan yang tidak dikehendaki untuk perbelanjaan biasa yang telah
			diluluskan hendaklah dimasukkan kedalam Bank oleh Bendahari Agung dalam
			tempoh tujuh (7) hari dari tarikh penerimaannya. Kira-kira Bank itu hendaklah di
			atas nama Persekutuan dan Ketua Pengarah Kesatuan Sekerja hendaklah
			dibekalkan maklumat-maklumat mengenai nama-nama Bank, nombor akaun
			Bank dan butir-butir lain. Pelantikan sesuatu bank itu hendaklah diluluskan oleh
			Majlis Jawatankuasa Tertinggi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">15.4&nbsp;&nbsp;&nbsp;</td>
			<td>Semua cek atau notis pengeluaran wang atas nama Persekutuan hendaklah
			ditandatangani bersama-sama oleh Presiden (dimasa ketiadaannya oleh Naib
			Presiden), Setiausaha Agung (dimasa ketiadaannya oleh Penolong Setiausaha
			Agung), dan Bendahari Agung (dimasa ketiadaannya oleh Penolong Bendahari
			Agung).<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">15.5&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari Agung dibenarkan menyimpan wang tunai tidak lebih dari
			<span class="max_savings">......... ringgit (RM......)</span> pada satu masa dan
			tidak dibenarkan membelanjakan lebih daripada <span class="max_expenses">......... ringgit (RM......)</span> pada satu masa tanpa terlebih dahulu mendapat
			kebenaran Majlis Jawatankuasa Tertinggi. Bendahari Agung hendaklah
			menyediakan satu belanjawan tahunan untuk diluluskan dalam Konvensyen Persekutuan dan segala had yang dibenarkan oleh belanjawan itu. Belanjawan
			itu bolehlah dipinda dari semasa ke semasa dengan mendapat kelulusan
			terlebih dahulu di dalam Konvensyen Persekutuan atau dengan surat pekeliling.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">15.6&nbsp;&nbsp;&nbsp;</td>
			<td>Semua harta Persekutuan hendaklah dimiliki atas nama Pemegang-pemegang
			Amanah Persekutuan. Wang Persekutuan yang tidak dikehendaki untuk urusan
			pentadbiran Persekutuan sehari-hari bolehlah :-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">a)&nbsp;&nbsp;&nbsp;</td>
			<td>digunakan untuk membeli atau memajak sebarang tanah atau bangunan
			untuk kegunaan Persekutuan. Tanah atau bangunan ini tertakluk kepada
			sesuatu undang-undang bertulis atau undang-undang lain yang boleh
			dipakai, dipajak atau dengan persetujuan anggota-anggota gabungan
			persekutuan yang diperolehi melalui usul yang dibawa dalam Konvensyen
			Persekutuan boleh dijual, ditukar atau digadai;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">b)&nbsp;&nbsp;&nbsp;</td>
			<td>dilaburkan dalam amanah saham (securities) atau dalam mana-mana
			pinjaman kepada mana-mana Syarikat mengikut mana-mana Undang-
			undang yang berkaitan dengan pemegang amanah;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">c)&nbsp;&nbsp;&nbsp;</td>
			<td>disimpan di dalam Bank Simpanan Nasional atau dalam mana-mana Bank
			yang ditubuhkan atau didaftarkan di Malaysia atau dalam mana-mana
			Syarikat Kewangan yang merupakan anak syarikat bank tersebut; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">d)&nbsp;&nbsp;&nbsp;</td>
			<td>dengan mendapat kelulusan terlebih dahulu daripada Menteri Sumber
			Manusia dan tertakluk kepada syarat-syarat yang mungkin dikenakan oleh
			beliau, dilaburkan :-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">(i)&nbsp;&nbsp;&nbsp;</td>
			<td>dalam mana-mana Syarikat Kerjasama yang berdaftar; atau<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="14%" class="right">(ii)&nbsp;&nbsp;&nbsp;</td>
			<td>dalam mana-mana pengusahaan perdagangan, perindustrian atau
			pertanian atau bank yang ditubuhkan dan berjalan urusannya di
			Malaysia.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">15.7&nbsp;&nbsp;&nbsp;</td>
			<td>Semua belian dan pelaburan-pelaburan di bawah Peraturan ini hendaklah
			diluluskan terlebih dahulu oleh Majlis Jawatankuasa Tertinggi dan dibuat atas
			nama Pemegang-pemegang Amanah Persekutuan. Pemegang-pemegang
			Amanah hendaklah memegang saham-saham atau pelaburan-pelaburan bagi
			pihak anggota gabungan. Kelulusan ini hendaklah disahkan oleh Konvensyen
			Persekutuan yang akan datang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">15.8&nbsp;&nbsp;&nbsp;</td>
			<td>Bendahari Agung hendaklah menulis atau menguruskan supaya ditulis di dalam
			buku kira-kira Persekutuan sebarang keterangan penerimaan dan pembayaran
			wang Persekutuan dan sebarang hasil dari pelaburan. Apabila ia berhenti atau
			meletak jawatan atau pekerjaannya pada atau sebelum 1hb Oktober setiap
			tahun, dan pada bila-bila masa ia dikehendaki berbuat demikian oleh Majlis
			Jawatankuasa Tertinggi atau melalui suatu ketetapan yang dibuat oleh
			Konvensyen Persekutuan atau Konvensyen Khas Persekutuan atau apabila
			dikehendaki oleh Ketua Pengarah Kesatuan Sekerja maka hendaklah ia menyerahkan kepada Persekutuan dan anggota gabungan atau kepada Ketua
			Pengarah Kesatuan Sekerja, mana-mana kehendak yang berkaitan, suatu
			kenyataan yang sah lagi betul perihal sekalian wang yang diterima dan
			dibayarnya dari tempoh ia mula memegang jawatan itu, atau jika ia telah pernah
			membentangkan kira-kira terlebih dahulu, maka dari tarikh kira-kira dahulu itu
			dibentangkan. Beliau hendaklah juga menyatakan baki wang ditangannya pada
			masa ia menyerah kira-kira itu dan semua bon dan jaminan (securities) atau
			lain-lain Persekutuan di dalam simpanan atau jagaannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">15.9&nbsp;&nbsp;&nbsp;</td>
			<td>Borang yang akan digunakan untuk membentangkan kira-kira itu ialah
			sebagaimana yang ditentukan oleh Peraturan-peraturan Kesatuan Sekerja
			1959. Kira-kira itu hendaklah diaudit menurut Peraturan 16 dan 17. Sesudah
			sahaja kira-kira itu diaudit maka Bendahari Agung hendaklah menyerah kepada
			Pemegang-pemegang Amanah Persekutuan jika dikehendaki oleh mereka itu,
			semua bon dan jaminan, perkakasan, buku-buku, surat dan harta Persekutuan
			yang ada di dalam simpanan atau jagaannya.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 16 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; JURUAUDIT DALAM</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">16.1&nbsp;&nbsp;&nbsp;</td>
			<td>Dua orang juruaudit dalam yang bukan menjadi anggota Majlis Jawatankuasa
			Tertinggi hendaklah dilantik secara angkat tangan dalam Konvensyen
			Persekutuan <span class="convention_yearly">.........</span> Tahunan. Mereka itu hendaklah memeriksa kira-kira
			Persekutuan pada penghujung setiap tiga (3) bulan dan menyampaikan
			penyataannya kepada Setiausaha Agung yang akan menghantar satu salinan
			penyata itu kepada tiap-tiap anggota Majlis Jawatankuasa Tertinggi dalam
			masa empat belas (14) hari setelah diterimanya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">16.2&nbsp;&nbsp;&nbsp;</td>
			<td>Buku-buku dan kira-kira Persekutuan hendaklah diaudit bersama oleh kedua-
			dua juruaudit itu dan mereka itu berhak melihat semua buku-buku dan surat-
			surat keterangan yang perlu untuk menyempurnakan tugas mereka.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">16.3&nbsp;&nbsp;&nbsp;</td>
			<td>Anggota gabungan Persekutuan bolehlah mengadu secara bersurat kepada
			Juruaudit Dalam mengenai sebarang hal kewangan yang tidak betul, yang telah
			sampai kepada pengetahuan mereka.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">16.4&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila berlaku apa-apa kekosongan jawatan ini oleh sebarang sebab di antara
			dua Konvensyen Persekutuan ia bolehlah diisi dengan cara lantikan oleh Majlis
			Jawatankuasa Tertinggi.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 17 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PERLANTIKAN JURUAUDIT LUAR</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">17.1&nbsp;&nbsp;&nbsp;</td>
			<td>Persekutuan hendaklah melantik seorang Juruaudit Luar bertauliah dan
			seterusnya memperolehi kelulusan Ketua Pengarah Kesatuan Sekerja bagi
			pelantikan ini. Juruaudit ini hendaklah seorang Akauntan yang memperolehi
			kebenaran bertulis daripada Kementerian Kewangan untuk mengaudit kira-kira syarikat-syarikat di bawah Akta Syarikat. Juruaudit ini hendaklah mengaudit
			Dokumen-dokumen dan akaun ini.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">17.2&nbsp;&nbsp;&nbsp;</td>
			<td>Dokumen-dokumen dan akaun Persekutuan yang diaudit itu hendaklah diakui
			benar oleh Juruaudit Luar dengan Surat Sumpah <i>(Statutory Declaration)</i>.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">17.3&nbsp;&nbsp;&nbsp;</td>
			<td>Dokumen-dokumen dan akaun Persekutuan hendaklah diaudit dengan segera
			selepas sahaja ditutup tahun kewangan Persekutuan pada 31 Mac dan
			hendaklah selesai sebelum 31 Ogos tiap-tiap tahun.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">17.4&nbsp;&nbsp;&nbsp;</td>
			<td>Dokumen-dokumen dan akaun Persekutuan yang diaudit itu dan laporan
			Juruaudit Luar, hendaklah dibentangkan untuk kelulusan di dalam Konvensyen
			Persekutuan dan satu salinan penyata hendaklah di hantar kepada tiap-tiap
			anggota gabungan sebelum Konvensyen itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">17.5&nbsp;&nbsp;&nbsp;</td>
			<td>Dokumen-dokumen dan akaun Persekutuan yang diaudit hendaklah dihantar
			kepada Ketua Pengarah Kesatuan Sekerja berserta dengan Borang N
			sebelum 1 Oktober tiap-tiap tahun.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 18 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; JEMAAH PEMERIKSA UNDI</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">18.1&nbsp;&nbsp;&nbsp;</td>
			<td>Satu Jemaah Pemeriksa Undi yang terdiri daripada lima orang anggota
			hendaklah dipilih secara angkat tangan dalam Konvensyen Persekutuan untuk
			mengendalikan segala perjalanan undi rahsia. Mereka hendaklah bukan
			pegawai Persekutuan atau calon bagi pemilihan pegawai-pegawai Persekutuan.
			Seboleh-bolehnya anggota yang dipilih ini hendaklah anggota-anggota yang
			tinggal di sekitar kawasan Ibu Pejabat Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">18.2&nbsp;&nbsp;&nbsp;</td>
			<td>Jemaah Pemeriksa Undi ini akan berkhidmat dari satu Konvensyen
			Persekutuan <span class="convention_yearly">.........</span> Tahunan ke Konvensyen Persekutuan <span class="convention_yearly">.........</span> Tahunan yang
			berikutnya. Apabila berlaku kekosongan, kekosongan ini hendaklah diisi dengan
			cara lantikan oleh Majlis Jawatankuasa Tertinggi sehingga Konvensyen yang
			akan datang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">18.3&nbsp;&nbsp;&nbsp;</td>
			<td>Sekurang-kurangnya tiga orang Pemeriksa Undi hendaklah hadir apabila
			pembuangan undi dijalankan. Mereka hendaklah memastikan bahawa aturcara
			yang tertera di dalam Kembaran kepada Peraturan ini dipatuhi dengan
			sepenuhnya.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 19 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PEMERIKSAAN DOKUMEN DAN AKAUN</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">19.1&nbsp;&nbsp;&nbsp;</td>
			<td>Dokumen-dokumen dan akaun Persekutuan serta pendaftaran anggota
			gabungannya boleh dibuka untuk pemeriksaan oleh semua wakil yang
			berkelayakan daripada anggota-anggota gabungan atau orang-orang yang ada
			kepentingan dalam wang Persekutuan dengan menyampaikan notis sekurang-
			kurangnya 14 hari kepada Setiausaha Agung mengenai keinginan dan niatnya
			melakukan pemeriksaan itu.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 20 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PEMEGANG-PEMEGANG AMANAH</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">20.1&nbsp;&nbsp;&nbsp;</td>
			<td>Tiga orang Pemegang Amanah yang umurnya tidak kurang dari 21 tahun dan
			bukan seorang Setiausaha Agung atau Bendahari Agung Persekutuan
			hendaklah dilantik atau dipilih di dalam Konvensyen Persekutuan yang pertama.
			Mereka itu akan menyandang jawatan itu selama yang dikehendaki oleh
			Persekutuan. Sebarang harta (tanah, bangunan, pelaburan dan lain-lain) yang
			dimiliki oleh Persekutuan hendaklah diserahkan kepada mereka itu untuk
			diuruskan sebagaimana yang diarahkan oleh Majlis Jawatankuasa Tertinggi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">20.2&nbsp;&nbsp;&nbsp;</td>
			<td>Pemegang Amanah tidak boleh menjual, menarik balik atau memindahkan milik
			sebarang harta Persekutuan tanpa persetujuan dan kuasa daripada Majlis
			Jawatankuasa Tertinggi yang diberi dengan bertulis oleh Setiausaha Agung dan
			Bendahari Agung Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">20.3&nbsp;&nbsp;&nbsp;</td>
			<td>Seseorang Pemegang Amanah boleh dilucutkan jawatannya oleh Majlis
			Jawatankuasa Tertinggi kerana tidak sihat, tidak sempurna akal, tidak berada
			dalam negara atau kerana sebarang sebab lain yang menyebabkan ia tidak
			boleh menjalankan tugasnya atau tidak dapat menyempurnakan tugasnya
			dengan memuaskan hati. Jika seseorang Pemegang Amanah itu meninggal
			dunia, berhenti atau diberhentikan diantara dua Konvensyen Persekutuan,
			maka kekosongan itu hendaklah diisi oleh mana-mana anggota yang dilantik
			oleh Majlis Jawatankuasa Tertinggi sehingga disahkan dalam Konvensyen
			Persekutuan yang akan datang.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">20.4&nbsp;&nbsp;&nbsp;</td>
			<td>Konvensyen Persekutuan boleh melantik sebuah syarikat pemegang amanah
			seperti yang diterangkan di dalam Akta Syarikat Amanah 1949 (Trust
			Companies Act 1949) atau undang-undang lain yang bertulis yang mengawal
			syarikat-syarikat pemegang amanah di Malaysia, untuk menjadi pemegang
			amanah yang tunggal bagi Persekutuan ini. Jika syarikat pemegang amanah
			seperti yang tersebut itu dilantik maka rujukan pemegang amanah di dalam
			Peraturan ini hendaklah difahamkan sebagai syarikat pemegang amanah yang
			dilantik.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">20.5&nbsp;&nbsp;&nbsp;</td>
			<td>Butir-butir mengenai Pemegang Amanah atau apa-apa pertukaran
			mengenainya hendaklah dihantar kepada Ketua Pengarah Kesatuan Sekerja
			dalam tempoh 14 hari selepas pelantikan atau pemilihan itu atau pertukaran
			berkenaan untuk pendaftaran. Pelantikan atau pemilihan ini tidak boleh
			berkuatkuasa sehingga didaftarkan oleh Ketua Pengarah Kesatuan Sekerja.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 21 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; URUSAN DENGAN ANGGOTA-ANGGOTA KESATUAN GABUNGAN</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">21.1&nbsp;&nbsp;&nbsp;</td>
			<td>Semua urusan berkenaan dengan anggota gabungan akan dijalankan melalui Majlis Jawatankuasa Tertinggi atau badan lain yang menjaga hal ehwal setiap
			anggota gabungan. Semua surat menyurat akan di alamatkan kepada
			Setiausaha anggota gabungan dan sebaliknya dari Setiausaha anggota
			gabungan atau lain-lain pegawai yang sah anggota gabungan kepada
			Setiausaha Agung Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">21.2&nbsp;&nbsp;&nbsp;</td>
			<td>Anggota perseorangan dari mana-mana anggota gabungan tidak berhak
			membuat apa-apa permintaan terus atau mempunyai apa-apa hak sedemikian
			terhadap Persekutuan.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 22 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; ATURAN MENYELENGGARAKAN KESALAHAN-KESALAHAN ANGGOTA GABUNGAN</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">22.1&nbsp;&nbsp;&nbsp;</td>
			<td>Sekiranya mana-mana anggota gabungan gagal mematuhi mana-mana
			permintaan dari Majlis Jawatankuasa Tertinggi atau menjalankan apa-apa tugas
			yang patut dijalankan di bawah Peraturan-peraturan ini atau pada pendapat
			Majlis Jawatankuasa Tertinggi mana-mana anggota gabungan menjalankan
			tindakan yang bercanggah dengan Peraturan-peraturan ini atau dengan cara
			yang merugikan kepentingan kesatuan sekerja amnya, maka Majlis
			Jawatankuasa Tertinggi akan mengambil tindakan mengikut peraturan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">22.2&nbsp;&nbsp;&nbsp;</td>
			<td>Apa-apa keputusan Majlis Jawatankuasa Tertinggi di bawah Peraturan ini akan
			tertakluk kepada rayuan kepada Konvensyen Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">22.3&nbsp;&nbsp;&nbsp;</td>
			<td>Notis mengenai keinginan merayu itu hendaklah dikemukakan oleh anggota
			gabungan itu dalam masa 21 hari setelah keputusan itu dibuat dan rayuan itu
			akan dibawa ke Konvensyen Persekutuan yang akan datang selepas notis
			diterima.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">22.4&nbsp;&nbsp;&nbsp;</td>
			<td>Konvensyen Persekutuan mempunyai kuasa penuh untuk mendengar semua
			perkara, mengubah atau meminda keputusan Majlis Jawatankuasa Tertinggi
			mengenai kesalahan dan hukuman, seperti berikut:-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">a)&nbsp;&nbsp;&nbsp;</td>
			<td>Pemberitahuan atas kesalahan itu akan disampaikan kepada Setiausaha
			kesatuan gabungan yang berkenaan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">b)&nbsp;&nbsp;&nbsp;</td>
			<td>Ia akan juga mengarahkan kesatuan gabungan itu melantik wakil-wakil
			Majlis Jawatankuasa Kerjanya menghadiri mesyuarat Majlis Jawatankuasa
			Tertinggi yang akan datang; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">c)&nbsp;&nbsp;&nbsp;</td>
			<td>Keputusan Majlis Jawatankuasa Tertinggi yang telah
			mengendalikan kes kesalahan kesatuan gabungan dan seterusnya memecat
			keanggotaan daripada Persekutuan atau mengenakan apa-apa tindakan lain.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 23 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PERJANJIAN DAN PERTIKAIAN</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">23.1&nbsp;&nbsp;&nbsp;</td>
			<td>Kuasa eksekutif kesatuan terletak di tangan Majlis Jawatankuasa Kerja
			kesatuan anggota gabungan masing-masing. Persekutuan tidak ada kuasa
			untuk campur tangan bagi maksud atau tujuan sah Kesatuan sebagaimana
			yang dinyatakan dalam peraturan-peraturan kesatuan gabungan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">23.2&nbsp;&nbsp;&nbsp;</td>
			<td>Sebarang pertikaian di antara sebuah kesatuan gabungan dengan majikan
			akan diselenggarakan pada peringkat awalnya oleh kesatuan sekerja
			berkenaan mengikut peraturan dan arahan Majlis Jawatankuasa Kerja.
			Persekutuan bagaimanapun, atas permintaan kesatuan gabungan itu, boleh
			campurtangan dalam apa-apa pertikaian di antara anggota gabungan dengan
			majikan dan berunding bagi pihak anggota gabungan dan anggota-anggotanya
			dan apa-apa perjanjian yang dimeteraikan dengan persetujuan kesatuan
			berkenaan akan dipatuhi oleh anggota gabungan itu.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">23.3&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Tertinggi Persekutuan mempunyai kuasa ke atas
			sebarang pertikaian perusahaan untuk menyiasat perkara yang dipertikaikan
			bertujuan mencari satu penyelesaian. Jika tidak tercapai penyelesaian dan
			tindakan mogok dipersetujui, maka anggota gabungan hendaklah mengikut
			Peraturan - peraturan anggota gabungan itu dan atas perintah yang dinyatakan
			oleh Majlis Jawatankuasa Kerja anggota gabungan yang berkenaan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">23.4&nbsp;&nbsp;&nbsp;</td>
			<td>Sekiranya satu pertikaian berbangkit maka Persekutuan akan berusaha
			membantu anggota gabungan yang terlibat dari segi kewangan atau dengan
			apa-apa cara yang sah.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">23.5&nbsp;&nbsp;&nbsp;</td>
			<td>Persekutuan tidak akan mengambil apa-apa tindakan atau menyetujui apa-apa
			keputusan yang bercanggah dengan maksud-maksud dan tujuan-tujuan
			Persekutuan atau anggota gabungan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">23.6&nbsp;&nbsp;&nbsp;</td>
			<td>Semua perjanjian atau dokumen yang dimeteraikan oleh Persekutuan bagi
			pihak anggota gabungan akan ditandatangani oleh dua orang wakil yang dipersetujui oleh Majlis Jawatankuasa Tertinggi Persekutuan dan dua orang
			wakil anggota gabungan yang dipersetujui oleh Majlis Jawatankuasa Kerja
			kesatuan yang diwakili itu. Cap-cap Persekutuan dan anggota gabungan akan
			diperturunkan di atas perjanjian-perjanjian atau dokumen-dokumen itu.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 24 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PERTIKAIAN DI ANTARA ANGGOTA-ANGGOTA GABUNGAN</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">24.1&nbsp;&nbsp;&nbsp;</td>
			<td>Persekutuan atas permintaan sebuah atau lebih anggota gabungannya,
			mempunyai kuasa untuk campurtangan dalam mana-mana pertikaian dan cuba
			menyelesaikan pertikaian di antara sebuah anggota gabungan dengan anggota
			gabungan yang lain.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">24.2&nbsp;&nbsp;&nbsp;</td>
			<td>Dalam apa-apa pertikaian yang berbangkit di antara anggota gabungan,
			anggota gabungan berkenaan akan melaporkan kepada Majlis Jawatankuasa
			Tertinggi, yang mempunyai kuasa penuh untuk mengendalikan pertikaian
			tersebut dan cuba untuk menyelesaikannya.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">24.3&nbsp;&nbsp;&nbsp;</td>
			<td>Anggota gabungan berkenaan berhak merayu kepada Konvensyen
			Persekutuan di atas keputusan-keputusan yang dibuat oleh Majlis
			Jawatankuasa Tertinggi. Konvensyen Persekutuan mempunyai hak untuk
			menarik balik, mengubah atau meluluskan keputusan-keputusan Majlis
			Jawatankuasa Tertinggi itu dan keputusan Konvensyen Persekutuan adalah
			muktamad. Pada masa yang sama juga, anggota-anggota kepada anggota
			gabungan boleh meneruskan aktiviti seperti biasa dalam tempoh pertikaian
			tersebut.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 25 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PINDAAN PERATURAN</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">25.1&nbsp;&nbsp;&nbsp;</td>
			<td>Usul-usul untuk meminda Peraturan hendaklah dikemukakan kepada
			Setiausaha Agung. Semua usul untuk pindaan kepada Peraturan akan
			diselenggarakan oleh Majlis Jawatankuasa Tertinggi dan akan berkuatkuasa
			selepas didaftarkan oleh Ketua Pengarah Kesatuan Sekerja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">25.2&nbsp;&nbsp;&nbsp;</td>
			<td>Pindaan peraturan yang akan menyebabkan beratnya lagi tanggungan anggota
			gabungan untuk mencarum atau kurangnya faedah yang akan didapatinya
			hanya boleh dibuat jika diluluskan oleh anggota-anggota gabungan dengan undi
			rahsia. Peraturan-peraturan lain bolehlah dipinda dengan kelulusan
			Konvensyen Persekutuan atau dengan undi rahsia.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">25.3&nbsp;&nbsp;&nbsp;</td>
			<td>Tiap-tiap pindaan Peraturan hendaklah berkuatkuasa dari tarikh pindaan itu
			didaftarkan oleh Ketua Pengarah Kesatuan Sekerja kecuali jika suatu tarikh
			yang terkemudian dari itu ada ditentukan di dalam Peraturan-peraturan ini.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">25.4&nbsp;&nbsp;&nbsp;</td>
			<td>Satu naskah Peraturan Persekutuan yang dicetak dalam Bahasa Malaysia hendaklah dipamerkan di suatu tempat yang mudah dilihat di Pejabat Persekutuan yang didaftarkan. Setiausaha Agung Persekutuan hendaklah memberi senaskah peraturan Persekutuan kepada sesiapa juga yang memintanya dengan bayaran RM10.00.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 26 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PENGUNDIAN DALAM KONVENSYEN PERSEKUTUAN DAN PERATURAN MENGUNDI</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">26.1&nbsp;&nbsp;&nbsp;</td>
			<td>Keputusan-keputusan berkenaan dengan perkara-perkara yang tersebut di
			bawah ini hendaklah dibuat dengan undi rahsia oleh semua anggota berhak
			kepada anggota gabungan dengan syarat mereka di bawah umur 18 tahun,
			tidak boleh mengambil bahagian dalam pengundian atas perkara-perkara (a),
			(b), dan (c):-<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">a)&nbsp;&nbsp;&nbsp;</td>
			<td>mengenakan yuran khas;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">b)&nbsp;&nbsp;&nbsp;</td>
			<td>membubarkan Persekutuan;<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">c)&nbsp;&nbsp;&nbsp;</td>
			<td>pindaan kepada peraturan di mana pindaan itu menyebabkan bertambahnya tanggungan pembayaran anggota-anggota gabungan atau mengurangkan faedah-faedah yang didapati; dan<br>&nbsp;</td>
		</tr>
		<tr class="left justify" >
			<td style="vertical-align: top;" width="10%" class="right">d)&nbsp;&nbsp;&nbsp;</td>
			<td>apa-apa perkara lain jika diputuskan oleh Konvensyen Persekutuan.<br>&nbsp;</td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">26.2&nbsp;&nbsp;&nbsp;</td>
			<td>Undi rahsia hendaklah dijalankan sebagaimana yang dinyata di dalam Kembaran A.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="bold uppercase left">PERATURAN 27 &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; PEMBUBARAN</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">27.1&nbsp;&nbsp;&nbsp;</td>
			<td>Persekutuan ini tidak boleh dibubarkan dengan sendirinya melainkan dengan
			persetujuan melalui undi rahsia tidak kurang daripada 75 % daripada jumlah
			anggota anggota gabungan yang berhak mengundi.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">27.2&nbsp;&nbsp;&nbsp;</td>
			<td>Jika sekiranya Persekutuan ini dibubarkan seperti yang tersebut di atas maka
			semua hutang dan tanggungan yang dibuat dengan cara sah oleh Persekutuan
			hendaklah dijelaskan dengan sepenuhnya dan baki wang yang tinggal
			hendaklah dibahagikan di antara anggota gabungan atas dasar purata
			bergantung pada bilangan tahun menjadi anggota gabungan serta jumlah yuran
			yang telah dibayar.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">27.3&nbsp;&nbsp;&nbsp;</td>
			<td>Notis pembubaran dan dokumen-dokumen lain sebagaimana di kehendaki oleh
			Peraturan-peraturan Kesatuan Sekerja 1959 hendaklah dihantar kepada Ketua
			Pengarah Kesatuan Sekerja dalam tempoh 14 hari selepas pembubaran.
			Pembubaran itu hanya berkuatkuasa dari tarikh pendaftarannya oleh Ketua
			Pengarah Kesatuan Sekerja.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="break"> </div><br>

	<div class="bold uppercase center">KEMBARAN A</div><br><br>
	<div class="bold uppercase left">1.&nbsp;&nbsp;&nbsp;PENGUNDIAN OLEH ANGGOTA-ANGGOTA KESATUAN KEPADA ANGGOTA GABUNGAN.</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.1&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila sesuatu perkara yang memerlukan undian anggota-anggota Kesatuan
			kepada anggota gabungan Persekutuan, Majlis Jawatankuasa Tertinggi
			Persekutuan akan menyediakan resolusi yang hendak diundi itu dan
			memutuskan tarikh pengundian yang hendak dilaksanakan. Setiausaha Agung
			Persekutuan akan menghantar satu salinan resolusi itu kepada Setiausaha
			setiap anggota gabungan dan memberitahunya tarikh undian itu disempurnakan
			dan penyata keputusan undian itu dihantar kepada Ibu Pejabat Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">1.2&nbsp;&nbsp;&nbsp;</td>
			<td>Undian akan dijalankan oleh anggota-anggota Kesatuan kepada anggota
			gabungan mengikut peraturan-peraturan setiap kesatuan berkenaan.
			Jawatankuasa Kerja setiap anggota gabungan itu akan bertanggungjawab
			mengawal bahawa undian dijalankan dengan betul.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">1.3&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah selesai urusan pengiraan kertas undi, Pemeriksa-pemeriksa Undi bagi
			setiap anggota gabungan akan menyediakan sebanyak 2 salinan kenyataan
			mengenai keputusan muktamad undian dalam borang-borang yang ditentukan
			menurut Peraturan-peraturan Kesatuan Sekerja 1959. Setelah
			menandatanganinya, menghantar satu salinan kepada Majlis Jawatankuasa
			Tertinggi Persekutuan dan menyimpan satu salinan lagi itu di pejabat kesatuan
			berkenaan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">1.4&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila semua keputusan undi telah diterima maka dua salinan penyata
			mengenai semua keputusan undi yang dikumpulkan oleh Pemeriksa-pemeriksa
			Undi yang dilantik oleh Konvensyen Persekutuan akan ditandatangani pula oleh
			Presiden dan Setiausaha Agung Persekutuan. Satu salinan lagi disimpan oleh
			Setiausaha Agung Persekutuan sekurang-kurangnya selama tiga (3) bulan dan
			diberi kepada mana-mana wakil Persekutuan untuk diteliti atas permintaannya.
			Satu salinan, yang ditandatangani oleh Setiausaha tiap-tiap anggota gabungan
			akan disimpan oleh beliau sekurang-kurangnya selama enam (6) bulan dan
			diberi oleh beliau untuk penelitian kepada mana-mana anggota-anggota
			Kesatuan kepada anggota gabungan atas permintaan mereka.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">1.5&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Kerja setiap anggota gabungan akan mengambil langkah-
			langkah untuk memberitahu anggota-anggota kesatuan masing-masing
			mengenai keputusan undi itu dengan cara yang mereka fikirkan patut.<br>&nbsp;</td>
		</tr>
	</table><br>

	<div class="bold uppercase left">2.&nbsp;&nbsp;&nbsp;PENGUNDIAN OLEH WAKIL-WAKIL ANGGOTA GABUNGAN PERSEKUTUAN.</div><br>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">2.1&nbsp;&nbsp;&nbsp;</td>
			<td>Majlis Jawatankuasa Tertinggi Persekutuan hendaklah menyediakan kertas-kertas
			undi yang secukupnya menurut Contoh A  atau Contoh B .
			Majlis Jawatankuasa Tertinggi hendaklah menetapkan tarikh, masa dan tempat
			mengundi. Setiausaha Agung Persekutuan hendaklah memberitahu wakil anggota
			gabungan seberapa segera yang boleh mengenai perkara tersebut.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.2&nbsp;&nbsp;&nbsp;</td>
			<td>Setiap wakil anggota gabungan yang berhak mengundi dan yang hadir di tempat
			Konvensyen pada tarikh dan masa yang ditetapkan itu akan menerima daripada
			Setiausaha Agung Persekutuan satu kertas undi yang ditandakan Cap
			Persekutuan atau tandatangan Setiausaha Agung Persekutuan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.3&nbsp;&nbsp;&nbsp;</td>
			<td>Pembuangan undi akan dikelolakan oleh tiga Pemeriksa Undi yang dipilih oleh
			Konvensyen Persekutuan yang tidak menjadi anggota Majlis Jawatankuasa
			Tertinggi atau calon untuk jawatan pegawai Persekutuan. Sekurang-kurangnya
			dua (2) daripada mereka itu akan hadir sepanjang masa membuang undi di dalam
			sebuah bilik atau sebahagian bilik yang disediakan khas di mana sebuah peti undi
			yang ditutup akan diletakkan. Pemeriksa-pemeriksa Undi itu diberi oleh
			Setiausaha Agung Persekutuan sebelum undian dimulakan senarai wakil-wakil
			yang telah diberi kertas-kertas undi dan memastikan melalui pemeriksaan bahawa
			hanya wakil-wakil yang berhak sahaja yang boleh mengundi dan tiap-tiap wakil
			hanya boleh mengundi sekali sahaja.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.4&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila tiba masa mengundi, setiap wakil dan anggota Majlis Jawatankuasa
			Tertinggi yang telah diberi kertas undi hendaklah masuk seorang demi seorang ke
			dalam bilik atau sebahagian bilik dewan dimana peti undi itu ditempatkan. Mereka
			hendaklah mengundi dengan menulis tanda pangkah - satu atau beberapa yang
			dikehendaki di atas kertas undi. Tanda-tanda lain tidak boleh digunakan. Setelah
			melipatkan kertas undi itu sekurang-kurangnya sekali dan memasukkannya ke
			dalam sampul surat yang diberi oleh Setiausaha Agung Persekutuan dan
			hendaklah memasukkannya ke dalam peti undi itu, kemudian meninggalkan
			tempat itu dengan segera.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.5&nbsp;&nbsp;&nbsp;</td>
			<td>Apabila wakil yang terakhir sekali telah membuang undi maka Pemeriksa Undi
			hendaklah mengumumkan bahawa urusan undi telah ditutup lalu membuka peti
			undi itu dan mulai mengira undi, dihadiri oleh sekurang-kurangnya tiga orang Pegawai Majlis Jawatankuasa Tertinggi. Mereka mula menyemak nombor wakil di
			atas sampul surat dengan senarai yang telah didapatinya daripada Setiausaha
			Agung Persekutuan. Bagi tiap-tiap sampul surat yang sudah disemak nombor
			wakil yang bertulis di atasnya hendaklah dipotong supaya tiada dapat dibaca lagi
			dan sampul surat itu hendaklah dimasukkan dengan tidak berbuka ke dalam peti
			undi berkunci. Apabila semua sampul surat sudah disemak maka Pemeriksa-
			pemeriksa Undi hendaklah mengeluarkan sampul-sampul surat itu semula,
			membukanya dan memasukkan kertas undi yang masih dilipat itu ke dalam peti
			undi. Apabila ini telah disempurnakan Pemeriksa-pemeriksa Undi hendaklah
			membuka peti undi itu dan mengira undi. Sekiranya menurut pendapat seseorang
			Pemeriksa Undi sesuatu kertas undi itu tidak sah, kertas undi itu hendaklah
			ditandakan rosak dan ditolak.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.6&nbsp;&nbsp;&nbsp;</td>
			<td>Setelah selesai memeriksa dan mengira kertas-kertas undi maka Pemeriksa-
			pemeriksa Undi hendaklah menyediakan dua salinan penyata keputusan undi dan
			menyerahkan kedua-dua salinan itu kepada Setiausaha Agung Persekutuan
			sesudah ditandatanganinya. Penyata itu hendaklah ditandatanganinya juga oleh
			Presiden dan Setiausaha Agung Persekutuan dan satu salinan daripadanya
			hendaklah diserahkan kepada Setiausaha Agung Persekutuan. Setiausaha Agung
			Persekutuan hendaklah menyimpan salinan itu selama tiga (3) bulan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.7&nbsp;&nbsp;&nbsp;</td>
			<td>Presiden atau Setiausaha Agung Persekutuan kemudian akan mengumumkan
			keputusan undi itu kepada wakil-wakil yang hadir. Satu salinan yang disimpan oleh
			Setiausaha Agung boleh disemak oleh mana-mana wakil atas permintaan mereka
			dan satu lagi akan dihantar kepada Ketua Pengarah Kesatuan Sekerja. Satu
			salinan penyata itu yang ditandatangani oleh Setiausaha Agung Persekutuan
			sebagai salinan yang benar, akan dihantar kepada Setiausaha setiap anggota
			gabungan.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.8&nbsp;&nbsp;&nbsp;</td>
			<td>Kertas-kertas undi yang telah dikira dan yang ditolak, selepas keputusannya
			disahkan seperti tersebut di atas akan segera dibungkus serta dimeterai dan
			disimpan ditempat yang selamat selama enam (6) bulan. Dalam tempoh itu
			bungkusan kertas-kertas undi tersebut boleh dibuka untuk pemeriksaan oleh
			Pegawai-pegawai Jabatan Hal Ehwal Kesatuan Sekerja. Setelah tamat tempoh
			enam bulan, kertas-kertas undi itu boleh dimusnahkan oleh Presiden dan
			Setiausaha Agung Persekutuan atau dimusnahkan di bawah pengawasan mereka.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.2&nbsp;&nbsp;&nbsp;</td>
			<td>Setiap wakil anggota gabungan yang berhak mengundi dan yang hadir di tempat
			Konvensyen pada tarikh dan masa yang ditetapkan itu akan menerima daripada
			Setiausaha Agung Persekutuan satu kertas undi yang ditandakan Cap
			Persekutuan atau tandatangan Setiausaha Agung Persekutuan.<br>&nbsp;</td>
		</tr>
	</table><br>
	<div class="break"> </div><br>

	<hr>

	<div class="bold center">CONTOH "A"</div><br><br>

	<table>
		<tr>
			<td class="left top">Nama Persekutuan</td>
			<td>:</td>
			<td class="left">PERSEKUTUAN KESATUAN MULTIJAYA</td>
		</tr>
		<tr>
			<td class="left">No. Pendaftaran</td>
			<td>:</td>
			<td>2424D-5</td>
		</tr>
		<tr>
			<td style="vertical-align: top" class="left">Alamat</td>
			<td style="vertical-align: top">:</td>
			<td>
				D-9-5, Megan Avenue 1, 189, Jalan Tun Razak, Hampshire Park, <br>
				50450 Kuala Lumpur, Selangor
			</td>
		</tr>
	</table><br>

	<div class="bold center">KERTAS UNDI BAGI PEMILIHAN PEGAWAI-PEGAWAI UTAMA</div><br><br>

	Cara mengundi:<br>

	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Tuan/Puan berhak menandakan <b>enam (6) undi</b> iaitu <b>satu (1) undi</b> bagi tiap-tiap
			seorang Presiden, Naib Presiden, Setiausaha Agung, Penolong Setiausaha
			Agung, Bendahari Agung dan Penolong Bendahari Agung.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Undi tuan/puan adalah RAHSIA dan tuan/puan hendaklah mencatatkan tanda
			pangkah seperti ini X di dalam ruangan yang disediakan bertentangan dengan
			nama calon yang tuan/puan pilih. Jangan ditanda selain daripada tanda X
			dalam kertas ini dan janganlah mengundi lebih dari angka yang ditetapkan dan
			jika dibuat demikian, kertas undi ini akan ditolak sebagai rosak dan tidak akan
			dikira.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Sesudah menandakan kertas undi, lipatkan kertas ini sekurang-kurangnya
			sekali, masukkan ke dalam sampul surat yang disediakan oleh Persekutuan
			dan masukkan kedalam peti undi yang disediakan untuk keperluan itu di dalam
			bilik mengundi.<br>&nbsp;</td>
		</tr>
	</table><br>

	<div class="bold uppercase left">PRESIDEN</div>
	<table class="border collapse">
		<tr class="border center">
			<th class="border" width="3%">No.</th>
			<th class="border left">&nbsp;&nbsp;Nama Calon</th>
			<th class="border" width="35%">Undi satu sahaja</th>
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
	<table class="border collapse">
		<tr class="border center">
			<th class="border" width="3%">No.</th>
			<th class="border left">&nbsp;&nbsp;Nama Calon</th>
			<th class="border" width="35%">Undi satu sahaja</th>
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

	<div class="bold uppercase left">SETIAUSAHA AGUNG</div>
	<table class="border collapse">
		<tr class="border center">
			<th class="border" width="3%">No.</th>
			<th class="border left">&nbsp;&nbsp;Nama Calon</th>
			<th class="border" width="35%">Undi satu sahaja</th>
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

	<div class="bold uppercase left">PENOLONG SETIAUSAHA AGUNG</div>
	<table class="border collapse">
		<tr class="border center">
			<th class="border" width="3%">No.</th>
			<th class="border left">&nbsp;&nbsp;Nama Calon</th>
			<th class="border" width="35%">Undi satu sahaja</th>
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

	<div class="bold uppercase left">BENDAHARI AGUNG</div>
	<table class="border collapse">
		<tr class="border center">
			<th class="border" width="3%">No.</th>
			<th class="border left">&nbsp;&nbsp;Nama Calon</th>
			<th class="border" width="35%">Undi satu sahaja</th>
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

	<div class="bold uppercase left">PENOLONG BENDAHARI AGUNG</div>
	<table class="border collapse">
		<tr class="border center">
			<th class="border" width="3%">No.</th>
			<th class="border left">&nbsp;&nbsp;Nama Calon</th>
			<th class="border" width="35%">Undi satu sahaja</th>
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
	<table>
		<tr>
			<td width="60%"></td>
			<td width="40%" class="center bold">Cap Nama Persekutuan<br>Atau<br>Tandatangan Setiausaha Agung</td>
		</tr>
	</table>

	<div class="break"> </div><br><br>

	<hr>

	<div class="bold center">CONTOH "B"</div><br><br>

	<table>
		<tr>
			<td class="left">Nama Persekutuan</td>
			<td>:</td>
			<td class="left">PERSEKUTUAN MUTIJAYA</td>
		</tr>
		<tr>
			<td class="left">No. Pendaftaran</td>
			<td>:</td>
			<td>4242-H</td>
		</tr>
		<tr>
			<td style="vertical-align: top" class="left">Alamat berdaftar</td>
			<td style="vertical-align: top">:</td>
			<td>D-9-5, Megan Avenue 1, 189, Jalan Tun Razak, Hampshire Park, <br>
				50450 Kuala Lumpur, Selangor
			</td>
		</tr>
		<tr>
			<td class="left bold">KERTAS UNDI</td>
			<td>&nbsp;<br>&nbsp;</td>
		</tr>
		<tr>
			<td class="left">Cara mengundi :</td>
			<td></td>
		</tr>
	</table>
	<table>
		<tr class="left justify">
			<td style="vertical-align: top;">1.&nbsp;&nbsp;&nbsp;</td>
			<td>Tuan berhak mengundi sama ada MENYOKONG atau MEMBANGKANG usul berikut :-<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">&nbsp;&nbsp;&nbsp;</td>
			<td class="center">(tuliskan usul di sini )<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">2.&nbsp;&nbsp;&nbsp;</td>
			<td>Undi tuan/puan adalah RAHSIA dan tuan/puan hendaklah mencatatkan
			tanda pangkah seperti ini X di dalam ruangan yang disediakan
			bertentangan dengan perkataan MENYOKONG atau MEMBANGKANG
			mengikut pilihan sendiri. Jangan menanda selain daripada tanda X dalam
			kertas ini dan jika berbuat demikian, kertas undi ini akan ditolak sebagai
			rosak dan tidak akan dikira.<br>&nbsp;</td>
		</tr>
		<tr class="left justify">
			<td style="vertical-align: top;">3.&nbsp;&nbsp;&nbsp;</td>
			<td>Sesudah menandakan kertas undi, lipatkan kertas ini sekurang-kurangnya
			sekali, masukkan ke dalam sampul surat yang disediakan dan masukkan ke
			dalam peti undi yang disediakan untuk keperluan itu di dalam bilik mengundi.
			Jika tuan/puan mengundi dengan pos, lipatkan kertas ini sekurang-kurang
			sekali, masukkan ke dalam sampul surat yang telah disediakan dan
			hantarkan kepada Setiausaha Agung supaya sampai kepadanya tidak lewat
			daripada........<br>&nbsp;</td>
		</tr>
	</table>
	<div class="right bold" style="margin:-20px;">Undi di sini&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
	<table class="border collapse">
		<tr class="">
			<td rowspan="2" class="top bold" width="55%" height="100">&nbsp;<br>&nbsp;&nbsp;&nbsp;Usul 1</td>
			<td class="border center" width="30%">MENYOKONG</td>
			<td class="border" width="15%"></td>
		</tr>
		<tr class="border">
			<td class="border center">MEMBANGKANG</td>
			<td class="border left"></td>
		</tr>
	</table><br><br>

	<div class="right bold" style="margin:-20px;">Undi di sini&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
	<table class="border collapse">
		<tr class="">
			<td rowspan="2" class="top bold" width="55%" height="100">&nbsp;<br>&nbsp;&nbsp;&nbsp;Usul 1</td>
			<td class="border center" width="30%">MENYOKONG</td>
			<td class="border" width="15%"></td>
		</tr>
		<tr class="border">
			<td class="border center">MEMBANGKANG</td>
			<td class="border left"></td>
		</tr>
	</table>
	<table>
		<tr>
			<td width="60%"></td>
			<td width="40%" class="center bold">Cap Nama Persekutuan<br>Atau<br>Tandatangan Setiausaha Agung</td>
		</tr>
	</table><br>
	<hr>
	<div class="center bold">JAWATANKUASA PENAJA</div>
	<span class="left">PERSEKUTUAN</span><br>
	<span class="left">Persekutuan Multijaya</span><br>

	<table class="border collapse">
		<tr class="border">
			<th class="border" width="3%">Bil.</th>
			<th class="border left">&nbsp;&nbsp;Nama</th>
			<th class="border" width="35%">No. Kad <br>Pengenalan</th>
			<th class="border left" width="15%">&nbsp;&nbsp;Tandatangan</th>
		<tr class="border">
			<td class="border center">1</td>
			<td class="border left"></td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">2</td>
			<td class="border left"></td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">3</td>
			<td class="border left"></td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">4</td>
			<td class="border left"></td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">5</td>
			<td class="border left"></td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">6</td>
			<td class="border left"></td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
		<tr class="border">
			<td class="border center">7</td>
			<td class="border left"></td>
			<td class="border left"></td>
			<td class="border left"></td>
		</tr>
	</table><br>
</div>
