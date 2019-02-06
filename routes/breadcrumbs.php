<?php

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Paparan Utama', route('home'));
});

//letter generator
Breadcrumbs::register('letter', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Pengurusan Surat', route('letter'));
});

//letter generator
Breadcrumbs::register('inbox', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Inbox', route('inbox'));
});

// Monitoring
Breadcrumbs::register('monitoring', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Pemantauan', route('monitoring'));
});

Breadcrumbs::register('announcement', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Pengurusan Pengumuman', route('announcement'));
});

// Profil
Breadcrumbs::register('profile', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Profil', route('profile'));
});

// Search
Breadcrumbs::register('search', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Carian', route('search'));
});

// Report
Breadcrumbs::register('report', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Laporan', route('report'));
});

// Appeal
Breadcrumbs::register('registration.appeal', function ($breadcrumbs) {
	$breadcrumbs->parent('home');
    $breadcrumbs->push('Rayuan', route('appeal.list'));
});

// Tenure
Breadcrumbs::register('registration.tenure', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Penggal', route('tenure'));
});

// Branch
Breadcrumbs::register('registration.branch', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cawangan', route('branch'));
});

// Form B
Breadcrumbs::register('registration.formb', function ($breadcrumbs) {
	$breadcrumbs->parent('home');
    $breadcrumbs->push('Borang B', route('formb'));
});

// Form BB
Breadcrumbs::register('registration.formbb', function ($breadcrumbs) {
	$breadcrumbs->parent('home');
    $breadcrumbs->push('Borang BB', route('formbb'));
});

// Form BB
Breadcrumbs::register('registration.formo', function ($breadcrumbs) {
	$breadcrumbs->parent('home');
    $breadcrumbs->push('Borang O', route('formo'));
});

// Incorporation
Breadcrumbs::register('incorporation', function ($breadcrumbs) {
	$breadcrumbs->parent('home');
    $breadcrumbs->push('Penggabungan');
});

Breadcrumbs::register('federation', function ($breadcrumbs) {
	$breadcrumbs->parent('incorporation');
    $breadcrumbs->push('Penggabungan Dengan Persekutuan', route('federation'));
});

Breadcrumbs::register('formp', function ($breadcrumbs) {
	$breadcrumbs->parent('federation');
    $breadcrumbs->push('Borang P');
});

Breadcrumbs::register('formq', function ($breadcrumbs) {
	$breadcrumbs->parent('federation');
    $breadcrumbs->push('Borang Q');
});

Breadcrumbs::register('consultation', function ($breadcrumbs) {
	$breadcrumbs->parent('incorporation');
    $breadcrumbs->push('Penggabungan Dengan Badan Perunding');
});

Breadcrumbs::register('formww', function ($breadcrumbs) {
	$breadcrumbs->parent('consultation');
    $breadcrumbs->push('Borang WW', route('formww.list'));
});

Breadcrumbs::register('formw', function ($breadcrumbs) {
	$breadcrumbs->parent('consultation');
    $breadcrumbs->push('Borang W', route('formw.list'));
});

// eCTR4U
Breadcrumbs::register('ectr4u', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('eCTR4U', route('ectr4u.list'));
});

// Affidavit
Breadcrumbs::register('affidavit', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Affidavit Jawapan', route('affidavit.list'));
});

// EligibilityIssue
Breadcrumbs::register('eligibility-issue', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Isu Kelayakan', route('eligibility-issue.list'));
});

// Exception
Breadcrumbs::register('exception', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Pengecualian', route('exception'));
});

Breadcrumbs::register('pp30', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Seksyen 30(b)', route('pp30.list'));
});

Breadcrumbs::register('pp68', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Peraturan 68', route('pp68.list'));
});

// ChangeOfficer
Breadcrumbs::register('change-officer', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Perubahan Pegawai / Pekerja');
});

Breadcrumbs::register('formlu', function ($breadcrumbs) {
    $breadcrumbs->parent('change-officer');
    $breadcrumbs->push('Pendaftaran Perubahan', route('formlu.list'));
});

Breadcrumbs::register('forml1', function ($breadcrumbs) {
    $breadcrumbs->parent('change-officer');
    $breadcrumbs->push('Perubahan Pekerja', route('forml1.list'));
});

Breadcrumbs::register('forml', function ($breadcrumbs) {
    $breadcrumbs->parent('change-officer');
    $breadcrumbs->push('Perubahan Pegawai', route('forml.list'));
});

// Dissoultion Cancellation
Breadcrumbs::register('dissolution-cancellation', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Pembubaran & Pembatalan');
});


Breadcrumbs::register('cancellation', function ($breadcrumbs) {
    $breadcrumbs->parent('dissolution-cancellation');
    $breadcrumbs->push('Pembatalan Kesatuan Sekerja', route('cancellation.list'));
});


Breadcrumbs::register('dissolution', function ($breadcrumbs) {
    $breadcrumbs->parent('dissolution-cancellation');
    $breadcrumbs->push('Pembubaran Kesatuan Sekerja', route('dissolution.list'));
});

// Finance
Breadcrumbs::register('finance', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Kewangan');
});

Breadcrumbs::register('levy', function ($breadcrumbs) {
    $breadcrumbs->parent('finance');
    $breadcrumbs->push('Pengenaan Levi', route('levy.list'));
});

Breadcrumbs::register('insurance', function ($breadcrumbs) {
    $breadcrumbs->parent('finance');
    $breadcrumbs->push('Pembayaran Insuran', route('insurance.list'));
});

Breadcrumbs::register('fund', function ($breadcrumbs) {
    $breadcrumbs->parent('finance');
    $breadcrumbs->push('Kutipan Dana', route('fund.list'));
});

Breadcrumbs::register('statement', function ($breadcrumbs) {
    $breadcrumbs->parent('finance');
    $breadcrumbs->push('Penyata Kewangan');
});

Breadcrumbs::register('statement.ks', function ($breadcrumbs) {
    $breadcrumbs->parent('statement');
    $breadcrumbs->push('Kesatuan Sekerja', route('statement.ks.list'));
});

Breadcrumbs::register('statement.audit', function ($breadcrumbs) {
    $breadcrumbs->parent('statement');
    $breadcrumbs->push('Juruaudit Luar', route('statement.audit.list'));
});

Breadcrumbs::register('formi', function ($breadcrumbs) {
    $breadcrumbs->parent('dissolution');
    $breadcrumbs->push('Borang I');
});

Breadcrumbs::register('forme', function ($breadcrumbs) {
    $breadcrumbs->parent('dissolution');
    $breadcrumbs->push('Borang E');
});

Breadcrumbs::register('formu', function ($breadcrumbs) {
    $breadcrumbs->parent('dissolution');
    $breadcrumbs->push('Borang U');
});

Breadcrumbs::register('enforcement', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Penguatkuasaan Berkanun', route('enforcement'));
});

Breadcrumbs::register('enforcement.pbp2', function ($breadcrumbs) {
    $breadcrumbs->parent('enforcement');
    $breadcrumbs->push('PBP2');
});

Breadcrumbs::register('investigation', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Siasatan');
});

Breadcrumbs::register('complaint', function ($breadcrumbs) {
    $breadcrumbs->parent('investigation');
    $breadcrumbs->push('Aduan', route('investigation.complaint.list'));
});

Breadcrumbs::register('strike', function ($breadcrumbs) {
    $breadcrumbs->parent('investigation');
    $breadcrumbs->push('Mogok', route('strike.list'));
});

Breadcrumbs::register('lockout', function ($breadcrumbs) {
    $breadcrumbs->parent('investigation');
    $breadcrumbs->push('Tutup Pintu', route('lockout.list'));
});

Breadcrumbs::register('prosecution', function ($breadcrumbs) {
    $breadcrumbs->parent('investigation');
    $breadcrumbs->push('Kertas Siasatan (Pendakwaan)', route('prosecution.list'));
});

Breadcrumbs::register('amendment', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Pindaan');
});

Breadcrumbs::register('formg', function ($breadcrumbs) {
    $breadcrumbs->parent('amendment');
    $breadcrumbs->push('Borang G', route('formg.list'));
});

Breadcrumbs::register('formg.g1', function ($breadcrumbs) {
    $breadcrumbs->parent('formg');
    $breadcrumbs->push('G1');
});

Breadcrumbs::register('formj', function ($breadcrumbs) {
    $breadcrumbs->parent('amendment');
    $breadcrumbs->push('Borang J', route('formj.list'));
});

Breadcrumbs::register('formj.j1', function ($breadcrumbs) {
    $breadcrumbs->parent('formj');
    $breadcrumbs->push('J1');
});

Breadcrumbs::register('formk', function ($breadcrumbs) {
    $breadcrumbs->parent('amendment');
    $breadcrumbs->push('Borang K', route('formk.list'));
});

Breadcrumbs::register('formk.k1', function ($breadcrumbs) {
    $breadcrumbs->parent('formk');
    $breadcrumbs->push('K1' );
});

Breadcrumbs::register('formk.k2', function ($breadcrumbs) {
    $breadcrumbs->parent('formk');
    $breadcrumbs->push('K2');
});

Breadcrumbs::register('formk.query', function ($breadcrumbs) {
    $breadcrumbs->parent('formk');
    $breadcrumbs->push('Kuiri', route('formk.query'));
});

Breadcrumbs::register('formk.result', function ($breadcrumbs) {
    $breadcrumbs->parent('formk');
    $breadcrumbs->push('Keputusan');
});

Breadcrumbs::register('formk.editor', function ($breadcrumbs) {
    $breadcrumbs->parent('formk');
});

Breadcrumbs::register('admin', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    // $breadcrumbs->push('Pentadbir');
});

Breadcrumbs::register('admin.settings', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Konfigurasi Sistem', route('admin.settings'));
});

Breadcrumbs::register('admin.holiday', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Pengurusan Cuti', route('admin.holiday'));
});

Breadcrumbs::register('staff.holiday_approved', function ($breadcrumbs) {
    $breadcrumbs->parent('staff');
    $breadcrumbs->push('Approved Cuti', route('staff.holiday_approved'));
});

Breadcrumbs::register('admin.user', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Pengurusan Pengguna');
});

Breadcrumbs::register('admin.user.internal', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.user');
    $breadcrumbs->push('Pengguna Dalaman', route('admin.user.internal'));
});

Breadcrumbs::register('admin.user.external', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.user');
    $breadcrumbs->push('Pengguna Luaran', route('admin.user.external'));
});

Breadcrumbs::register('admin.role', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Pengurusan Peranan', route('admin.role'));
});

Breadcrumbs::register('admin.permission', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Pengurusan Keizinan', route('admin.permission'));
});

Breadcrumbs::register('admin.backup', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Pengurusan Simpanan', route('admin.backup'));
});

Breadcrumbs::register('admin.notification', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Pengurusan Notifikasi', route('admin.notification'));
});

Breadcrumbs::register('admin.letter', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Pengurusan Paparan Surat', route('admin.letter'));
});

Breadcrumbs::register('admin.log', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Log Sistem', route('admin.log'));
});

Breadcrumbs::register('admin.master', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Data Induk');
});

Breadcrumbs::register('admin.master.announcement-type', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.master');
    $breadcrumbs->push('Jenis Pengumuman', route('admin.master.announcement-type'));
});

Breadcrumbs::register('admin.master.holiday-type', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.master');
    $breadcrumbs->push('Jenis Cuti', route('admin.master.holiday-type'));
});

Breadcrumbs::register('admin.master.attorney', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.master');
    $breadcrumbs->push('Pejabat Peguam', route('admin.master.attorney'));
});

Breadcrumbs::register('admin.master.province-office', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.master');
    $breadcrumbs->push('Pejabat Wilayah', route('admin.master.province-office'));
});

Breadcrumbs::register('admin.master.court', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.master');
    $breadcrumbs->push('Mahkamah', route('admin.master.court'));
});

Breadcrumbs::register('admin.master.programme-type', function($breadcrumbs) {
    $breadcrumbs->parent('admin.master');
    $breadcrumbs->push('Jenis Program', route('admin.master.programme-type'));
});

Breadcrumbs::register('admin.master.complaint-classification', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.master');
    $breadcrumbs->push('Klasifikasi Aduan', route('admin.master.complaint-classification'));
});

Breadcrumbs::register('admin.master.designation', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.master');
    $breadcrumbs->push('Jawatan', route('admin.master.designation'));
});

Breadcrumbs::register('admin.master.sector', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.master');
    $breadcrumbs->push('Sektor', route('admin.master.sector'));
});

Breadcrumbs::register('admin.master.meeting-type', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.master');
    $breadcrumbs->push('Jenis Mesyuarat', route('admin.master.meeting-type'));
});

Breadcrumbs::register('admin.master.organization-type', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.master');
    $breadcrumbs->push('Jenis Organisasi', route('admin.master.organization-type'));
});

Breadcrumbs::register('admin.master.union-type', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.master');
    $breadcrumbs->push('Jenis Kesatuan', route('admin.master.union-type'));
});

Breadcrumbs::register('admin.master.federation-type', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.master');
    $breadcrumbs->push('Jenis Persekutuan', route('admin.master.federation-type'));
});

Breadcrumbs::register('admin.master.region', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.master');
    $breadcrumbs->push('Kawasan', route('admin.master.region'));
});

Breadcrumbs::register('staff', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    // $breadcrumbs->push('Pentadbir');
});

Breadcrumbs::register('admin.master.sector-category', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.master');
    $breadcrumbs->push('Kategori Sektor', route('admin.master.sector-category'));
});

Breadcrumbs::register('distribution', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Agihan', route('distribution'));
});

Breadcrumbs::register('staff.holiday', function ($breadcrumbs) {
    $breadcrumbs->parent('staff');
    $breadcrumbs->push('Pengurusan Cuti', route('staff.holiday'));
});

Breadcrumbs::register('staff.settings', function ($breadcrumbs) {
    $breadcrumbs->parent('staff');
    $breadcrumbs->push('Konfigurasi Sistem', route('staff.settings'));
});
