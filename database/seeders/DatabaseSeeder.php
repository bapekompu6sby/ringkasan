<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // DB::table('role')->insert([
        //     'id'=> 'RO01',
        //     'nama' => 'Admin',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        // DB::table('role')->insert([
        //     'id'=> 'RO02',
        //     'nama' => 'Supervisi',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        // DB::table('role')->insert([
        //     'id'=> 'RO03',
        //     'nama' => 'Petugas',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        /////////////////////////////////////////////////
        DB::table('user')->insert([
            'id'=> 'US001',
            'role'=> 'admin',
            'nip'=> '1998',
            'nama_lengkap' => 'bapekom6surabaya',
            'username' => 'bapekom6surabaya',
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('user')->insert([
            'id'=> 'US002',
            'role'=> 'supervisi',
            'nip'=> '1999',
            'nama_lengkap' => 'Supervisi 1',
            'username' => 'supervisi1',
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('user')->insert([
            'id'=> 'US003',
            'role'=> 'petugas',
            'nip'=> '2000',
            'nama_lengkap' => 'Petugas 1',
            'username' => 'petugas1',
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        /////////////////////////////////////////////////
        DB::table('sop')->insert([
            'id'=> 'SOP01',
            'nomor'=> 'BPSDM-5.2.5_CFM.01.SOP.IK.SM01',
            'icon' => 'schedule', 
            'judul' => 'Pelaksanaan Rapat Persiapan Pelatihan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('sop')->insert([
            'id'=> 'SOP02',
            'nomor'=> 'BPSDM-5.2.5_CFM.01.SOP.IK.SM02',
            'icon' => 'contact_mail',
            'judul' => 'Konfirmasi Pengajar Pengembangan Kompetensi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('sop')->insert([
            'id'=> 'SOP03',
            'nomor'=> 'BPSDM-5.2.5_CFM.01.SOP.IK.SM03',
            'icon' => 'people_outline',
            'judul' => 'Konfirmasi Peserta Pengembangan Kompetensi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('sop')->insert([
            'id'=> 'SOP04',
            'nomor'=> 'BPSDM-5.2.5_CFM.02.SOP.IK.SM01',
            'icon' => 'event',
            'judul' => 'Pelaksanaan Pembukaan/Penutupan Pelatihan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('sop')->insert([
            'id'=> 'SOP05',
            'nomor'=> 'BPSDM-5.2.5_CFM.02.SOP.IK.SM02',
            'icon' => 'class',
            'judul' => 'Pengelolaan Piket (Pemantauan Kegiatan Belajar Mengajar)',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('sop')->insert([
            'id'=> 'SOP06',
            'nomor'=> 'BPSDM-5.2.5_CFM.03.SOP.IK.SM01',
            'icon' => 'web',
            'judul' => 'Pelaksanaan Monitoring dan Evaluasi Pelatihan (e-Pelatihan)',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('sop')->insert([
            'id'=> 'SOP07',
            'nomor'=> 'BPSDM-5.2.5_CFM.03.SOP.IK.SM02',
            'icon' => 'question_answer',
            'judul' => 'Rapat Evaluasi Kelulusan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('sop')->insert([
            'id'=> 'SOP08',
            'nomor'=> 'BPSDM-5.2.5_CFM.09.SOP.IK.03',
            'icon' => 'folder',           
            'judul' => 'Penyusunan Laporan Pelatihan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('sop')->insert([
            'id'=> 'SOP09',
            'nomor'=> 'BPSDM-5.2.5_CFM.03.SOP.IK.SM04',
            'icon' => 'description',
            'judul' => 'Penerbitan Sertifikat Pelatihan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('sop')->insert([
            'id'=> 'SOP10',
            'nomor'=> 'BPSDM-5.2.5_CFM.03.SOP.IK.SM05',
            'icon' => 'assignment_ind',
            'judul' => 'Penyusunan Surat Pengembalian Peserta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        /////////////////////////////////////////////////
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP001',
            'nama' => 'Penetapan peserta, pengajar, dan jadwal pelatihan',
            'deskripsi' => 'Surat penetapan peserta, pengajar, dan jadwal pelatihan ditetapkan oleh PUSBANGKOM.',
            'id_sop' => 'SOP01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP002',
            'nama' => 'Penetapan jadwal rapat persiapan pelatihan',
            'deskripsi' => 'Kepala Seksi Penyelenggaraan membuat draft jadwal rapat persiapan pelatihan.',
            'id_sop' => 'SOP01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP003',
            'nama' => 'Penyusunan undangan rapat persiapan pelatihan',
            'deskripsi' => 'Pranata Diklat menyusun draft undangan rapat persiapan pelatihan.',
            'id_sop' => 'SOP01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP004',
            'nama' => 'Persetujuan draft undangan rapat persiapan pelatihan',
            'deskripsi' => 'Kepala Balai dan Kepala Seksi Penyelenggaraan menyetujui draft undangan rapat persiapan pelatihan yang telah disusun oleh Pranata Diklat.',
            'id_sop' => 'SOP01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP005',
            'nama' => 'Pendistribusian undangan rapat persiapan pelatihan',
            'deskripsi' => 'Undangan rapat persiapan pelatihan didistribusikan kepada tim dari sie penyelenggara, tim dari sub bagian Tata Usaha dan tim dari bagian keuangan oleh Pranata Diklat.',
            'id_sop' => 'SOP01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP006',
            'nama' => 'Pelaksanaan rapat persiapan pelatihan',
            'deskripsi' => 'Rapat persiapan pelatihan yang dipimpin oleh kepala seksi penyelenggaraan dihadiri oleh tim dari sie penyelenggara, tim dari sub bagian Tata Usaha dan tim dari bagian keuangan dengan menghasilkan Draft Notulen Rapat.',
            'id_sop' => 'SOP01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP007',
            'nama' => 'Persetujuan notulen rapat persiapan pelatihan dan daftar ceklis pelaksanaan pelatihan',
            'deskripsi' => 'Draft notulen rapat dan daftar ceklis pelaksanaan pelatihan yang berisi sarana dan prasarana, pembagian tugas panitia, SK Penetapan dan penunjukan tim pelaksana, peserta, dan pengajar, materi/modul, lokasi PKL, surat undangan pejabat pembuka/ penutup, jadwal piket, KAK, buku pedoman, biodata peserta, bahan serahan, name tag peserta, nama table, daftar ceklis penyelenggaraan pelatihan, laporan panitia penyelenggaraan dan sambutan pejabat pembukaan/penutup oleh Pranata Diklat ditandatangani Kepala Balai dan/ atau Kepala Seksi Penyelenggaraan.',
            'id_sop' => 'SOP01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP008',
            'nama' => 'Koordinasi dan penyiapan sarana prasarana pelatihan yang dibutuhkan',
            'deskripsi' => 'Koordinasi dan penyiapan sarana prasarana pelatihan sesuai dengan metode yang ditetapkan (e-learning/ distance learning, blended learning / klasikal) dilakukan antara Kepala Seksi Penyelenggaraan dan Kepala Subbagian Umum dan Tata Usaha.',
            'id_sop' => 'SOP01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP009',
            'nama' => 'Pengarsipan notulen rapat persiapan',
            'deskripsi' => 'Notulen rapat, daftar ceklis pelaksanaan pelatihan diarsipkan oleh Pranata Diklat.',
            'id_sop' => 'SOP01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP010',
            'nama' => 'Pengkonsepan surat pemanggilan calon pengajar',
            'deskripsi' => 'Kepala Seksi Penyelenggaraan mengkonsep surat pemanggilan calon pengajar berdasarkan disposisi dari Kepala Balai terkait surat perintah (SPRINT) dari PUSBANGKOM terkait atau jadwal pelaksanaan pelatihan.',
            'id_sop' => 'SOP02',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP011',
            'nama' => 'Pengkonfirmasian kehadiran calon pengajar',
            'deskripsi' => 'Pranata Diklat mengkonfirmasi kehadiran Pengajar/Narasumber/Widyaiswara berdasarkan disposisi dari Kepala Seksi Penyelenggaraan.',
            'id_sop' => 'SOP02',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP012',
            'nama' => 'Pemeriksaan hasil laporan progress konfirmasi',
            'deskripsi' => 'Kepala Seksi Penyelenggaraan memeriksa laporan progress konfirmasi kehadiran yang dilakukan Pranata Diklat berdasarkan tanda terima/bukti distribusi surat pemanggilan calon pengajar dan laporan progres pemanggilan pengajar.',
            'id_sop' => 'SOP02',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP013',
            'nama' => 'Pengajuan usulan pengajar pengganti',
            'deskripsi' => 'Kepala Seksi Penyelenggaraan mengusulkan pengajar pengganti kepada Kepala Balai karena hasil laporan progres konfirmasi tidak sesuai SPRINT.',
            'id_sop' => 'SOP02',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP014',
            'nama' => 'Pemeriksaan usulan pengajar pengganti',
            'deskripsi' => 'Kepala Balai memeriksa usulan pengajar pengganti yang diajukan oleh Kepala Seksi Penyelenggaraan kemudian disetujui Kepala Balai.',
            'id_sop' => 'SOP02',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP015',
            'nama' => 'Koordinasi ke Pusbangkom untuk penerbitan SPRINT Pengajar/Narasumber/Widyaiswara pengganti',
            'deskripsi' => 'Kepala Balai berkoordinasi ke Pusbangkom untuk penerbitan SPRINT Pengajar/Narasumber/Widyaiswara pengganti jika usulan pengajar pengganti telah sesuai.',
            'id_sop' => 'SOP02',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP016',
            'nama' => 'Pengusulan penundaan/pembatalan jadwal pelaksaan pelatihan',
            'deskripsi' => 'Kepala Balai mengusulkan untuk menunda atau membatalkan jadwal pelaksanaan pelatihan jika usulan pengajar pengganti tidak sesuai.',
            'id_sop' => 'SOP02',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP017',
            'nama' => 'Pengkonfirmasian kepada Pengajar pengganti',
            'deskripsi' => 'Pranata Diklat melakukan konfirmasi kepada Pengajar pengganti sesuai SPRINT Pengajar/Narasumber/Widyaiswara pengganti berdasarkan disposisi Kepala Seksi Penyelenggaraan.',
            'id_sop' => 'SOP02',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP018',
            'nama' => 'Pengarsipan berkas pemanggilan pengajar',
            'deskripsi' => 'Pranata diklat mengarsipkan berkas pemanggilan pengajar.',
            'id_sop' => 'SOP02',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP019',
            'nama' => 'Pengkonsepan surat pemanggilan calon peserta',
            'deskripsi' => 'Pranata Diklat mengkonsep surat pemanggilan calon peserta sesuai berdasarkan surat perintah (SPRINT) dari PUSBANGKOM terkait atau jadwal pelaksanaan berdasarkan disposisi dari Kepala Seksi Penyelenggaraan.',
            'id_sop' => 'SOP03',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP020',
            'nama' => 'Pengkoreksian konsep surat pemanggilan peserta',
            'deskripsi' => 'Kepala Seksi Penyelenggaraan melakukan koreksi terhadap konsep surat pemanggilan peserta yang dibuat oleh Pranata Diklat.',
            'id_sop' => 'SOP03',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP021',
            'nama' => 'Penyetujuan konsep surat pemanggilan calon peserta',
            'deskripsi' => 'Kepala Balai mengkoreksi dan menyetujui dengan menandatangani konsep surat pemanggilan calon peserta.',
            'id_sop' => 'SOP03',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP022',
            'nama' => 'Pemanggilan Peserta',
            'deskripsi' => 'Pranata Diklat melakukan pemanggilan peserta dan mendistribusikan kepada unit kerja pengusul/calon peserta sesuai penugasan dari Kepala Seksi Penyelenggaraan.',
            'id_sop' => 'SOP03',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP023',
            'nama' => 'Pemeriksaan hasil laporan progres pemanggilan peserta',
            'deskripsi' => 'Kepala Seksi Penyelenggaraan memeriksa tanda terima/bukti distribusi surat pemanggilan calon peserta dan laporan progres pemanggilan peserta yang dilakukan Pranata Diklat.',
            'id_sop' => 'SOP03',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP024',
            'nama' => 'Persiapan surat usulan peserta cadangan',
            'deskripsi' => 'Kepala Seksi Penyelenggaraan menyiapkan surat usulan peserta cadangan jika laporan progres pemanggilan peserta tidak sesuai.',
            'id_sop' => 'SOP03',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP025',
            'nama' => 'Pemeriksaan surat usulan peserta cadangan',
            'deskripsi' => 'Kepala Balai memeriksa surat usulan peserta cadangan dan menyetujui usulan calon peserta cadangan.',
            'id_sop' => 'SOP03',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP026',
            'nama' => 'Penerbitan SPRINT calon peserta tambahan',
            'deskripsi' => 'Kepala Balai melakukan koordinasi ke PUSBANGKOM untuk penerbitan SPRINT calon peserta tambahan.',
            'id_sop' => 'SOP03',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP027',
            'nama' => 'Pemanggilan calon peserta tambahan',
            'deskripsi' => 'Pranata Diklat melakukan pemanggilan peserta tambahan dan melaporkannya sesuai penugasan dari Kepala Seksi Penyelenggaraan.',
            'id_sop' => 'SOP03',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP028',
            'nama' => 'Pemeriksaan dan pemutusan laporan progres pemanggilan peserta tambahan',
            'deskripsi' => 'Kepala Balai memeriksa tanda terima/bukti distribusi surat pemanggilan calon peserta tambahan dan laporan progres pemanggilan peserta tambahan yang dilakukan Pranata Diklat dan memutuskan "lanjut atau tidak" kegiatan.',
            'id_sop' => 'SOP03',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP029',
            'nama' => 'Penundaan/Pembatalan Pengembangan Kompetensi',
            'deskripsi' => 'Kepala Balai melakukan penundaan atau pembatalan kegiatan pengembangan kompetensi jika memutuskan tidak lanjutnya kegiatan berdasarkan pemeriksaan laporan progres pemanggilan peserta tambahan.',
            'id_sop' => 'SOP03',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP030',
            'nama' => 'Pengarsipan berkas pemanggilan peserta',
            'deskripsi' => 'Pranata Diklat mengarsipkan berkas pemanggilan calon peserta.',
            'id_sop' => 'SOP03',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP031',
            'nama' => 'Persiapan sarana dan prasarana kegiatan pembukaan/penutupan pelatihan',
            'deskripsi' => 'Berkas pembukaan/penutupan (tanda terima surat pengembalian peserta, ceklis sarana prasarana, laporan pembukaan/penutupan, daftar undangan) disiapkan oleh Pranata Diklat berdasarkan disposisi dari Kepala Seksi penyelenggaraan.',
            'id_sop' => 'SOP04',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP032',
            'nama' => 'Pemeriksaan kesesuaian kesiapan pelaksanaan pembukaan/penutupan',
            'deskripsi' => 'Pemeriksaan kesesuaian kesiapan pelaksanaan pembukaan/penutupan dilakukan oleh Kepala Seksi Penyelenggaraan.',
            'id_sop' => 'SOP04',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP033',
            'nama' => 'Pelaksanaan upacara pembukaan/penutupan',
            'deskripsi' => 'Upacara pembukaan/penutupan yang dipimpin Kepala Balai terlaksana sesuai susunan acara.',
            'id_sop' => 'SOP04',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP034',
            'nama' => 'Dokumentasi dan publikasi',
            'deskripsi' => 'Pranata Diklat mendokumentasi dan mempublikasi kegiatan pembukaan/penutupan pelatihan.',
            'id_sop' => 'SOP04',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP035',
            'nama' => 'Penyusunan jadwal pelaksanaan piket setiap pelatihan',
            'deskripsi' => 'Jadwal piket dibentuk oleh Kepala Seksi Penyelenggaraan.',
            'id_sop' => 'SOP05',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP036',
            'nama' => 'Penyusunan jadwal piket',
            'deskripsi' => 'Pranata Diklat menyusun jadwal piket berdasarkan jadwal piket yang dibentuk oleh Kepala Seksi Penyelenggaraan.',
            'id_sop' => 'SOP05',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP037',
            'nama' => 'Persiapan formulir pemantauan piket dan pelaksanaaan pemantauan piket',
            'deskripsi' => 'Pranata Diklat menyiapkan formulir pemantauan piket untuk pelaksanaan pemantauan piket, serta melaporkan hasil pemantauan piket kepada Kepala Seksi Penyelenggaraan.',
            'id_sop' => 'SOP05',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP038',
            'nama' => 'Penyusunan laporan hasil pemantauan piket',
            'deskripsi' => 'Kepala Seksi Penyelenggaraan menyusun laporan hasil pemantauan piket dan melaporkan kepada Kepala Balai (Laporan ketidaksesuaian).',
            'id_sop' => 'SOP05',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP039',
            'nama' => 'Pemeriksaan laporan hasil pemantauan piket',
            'deskripsi' => 'Kepala Balai memeriksa dan mengevaluasi laporan hasil pemantauan piket.',
            'id_sop' => 'SOP05',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP040',
            'nama' => 'Penyimpanan hasil laporan pemantauan piket',
            'deskripsi' => 'Laporan hasil pemantauan piket disimpan oleh Pranata Diklat.',
            'id_sop' => 'SOP05',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP041',
            'nama' => 'Penetapan SK Pembentukan Tim Monitoring dan Evaluasi Pelatihan',
            'deskripsi' => 'SK Pembentukan Tim Monitoring dan Evaluasi Pelatihan ditetapkan oleh Kepala Balai.',
            'id_sop' => 'SOP06',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP042',
            'nama' => 'Pengaksesan aplikasi E-Pelatihan oleh Tim Monitoring dan Evaluasi',
            'deskripsi' => 'Tim Monitoring dan Evaluasi menerima password dan dapat mengakses aplikasi E-Pelatihan. ',
            'id_sop' => 'SOP06',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP043',
            'nama' => 'Pembuatan Jadwal Pelaksanaan monitoring dan evaluasi serta form-form evaluasi',
            'deskripsi' => 'Jadwal Pelaksanaan monitoring dan evaluasi serta form-form evaluasi terkait materi pelatihan, pengajar, manajemen penyelenggaraan pelatihan, dan peserta pelatihan disiapkan oleh Tim Monitoring dan Evaluasi.',
            'id_sop' => 'SOP06',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP044',
            'nama' => 'Penginputan formulir E-Pelatihan oleh peserta',
            'deskripsi' => 'Peserta mengisi formulir E-Pelatihan yang digunakan dalam monitoring dan evaluasi.',
            'id_sop' => 'SOP06',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP045',
            'nama' => 'Penyusunan laporan hasil monitoring dan evaluasi',
            'deskripsi' => 'Draft laporan penyelenggaraan monitoring dan evaluasi dan rekomendasi tindakan perbaikan yang diperlukan untuk pelatihan mendatang  disusun oleh Tim Monitoring dan Evaluasi.',
            'id_sop' => 'SOP06',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP046',
            'nama' => 'Penyampaian laporan hasil monitoring dan evaluasi masing-masing pelatihan',
            'deskripsi' => 'Draft laporan penyelenggaraan monitoring dan evaluasi dan rekomendasi tindakan perbaikan oleh Tim Monitoring dan Evaluasi disampaikan ke Kepala Balai dengan persetujuan Kepala Seksi Penyelenggaraan.',
            'id_sop' => 'SOP06',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP047',
            'nama' => 'Verifikasi hasil monitoring dan evaluasi serta pemberian saran dan masukan terkait monitoring evaluasi (bila ada)',
            'deskripsi' => 'Laporan penyelenggaraan monitoring dan evaluasi dan rekomendasi tindakan perbaikan ditandatangani oleh Kepala Balai.',
            'id_sop' => 'SOP06',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP048',
            'nama' => 'Pengarsipan laporan monitoring dan evaluasi',
            'deskripsi' => 'Laporan penyelenggaraan monitoring dan evaluasi dengan tandatangan Kepala Balai diarsip.',
            'id_sop' => 'SOP06',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP049',
            'nama' => 'Penyusunan konsep kegiatan rapat evaluasi kelulusan',
            'deskripsi' => 'Kepala Seksi Penyelenggaraan menyusun konsep kegiatan rapat evaluasi kelulusan berdasarkan disposisi dari Kepala Balai untuk mempersiapkan rapat evaluasi kelulusan peserta pengembangan kompetensi dan menugaskan Pelaksana terkait untuk mengumpulkan bahan rapat evaluasi kelulusan.',
            'id_sop' => 'SOP07',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP050',
            'nama' => 'Pengumpulan bahan rapat evaluasi kelulusan',
            'deskripsi' => 'Pranata Diklat mempelajari peraturan terkait kegiatan rapat evaluasi kelulusan dan mengumpulkan bahan rapat evaluasi kelulusan antara lain, hasil rekap nilai seluruh pengajar, rekap absensi peserta, hasil pemantauan piket kelas berdasarkan disposisi dari Kepala Seksi Penyelenggaraan.',
            'id_sop' => 'SOP07',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP051',
            'nama' => 'Pelaksanaan rapat evaluasi kelulusan',
            'deskripsi' => 'Terlaksananya rapat evaluasi kelulusan, yaitu penyampaian materi rapat evaluasi kelulusan oleh Kepala Seksi Penyelenggaraan dan pemberian masukan dan penilaian serta keputusan terhadap hasil rapat evaluasi kelulusan oleh Kepala Balai.',
            'id_sop' => 'SOP07',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP052',
            'nama' => 'Penyusunan konsep notulen rapat evaluasi kelulusan',
            'deskripsi' => 'Konsep notulen rapat evaluasi kelulusan disusun oleh Pranata Diklat.',
            'id_sop' => 'SOP07',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP053',
            'nama' => 'Pemeriksaan dan pengesahan konsep notulen rapat evaluasi kelulusan',
            'deskripsi' => 'Konsep notulen rapat diperiksa dan disetujui oleh Kepala Seksi Penyelenggaraan dan Kepala Balai.
            ',
            'id_sop' => 'SOP07',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP054',
            'nama' => 'Pengarsipan notulen rapat',
            'deskripsi' => 'Notulen rapat digandakan, didistribusikan dan diarsipkan oleh Pranata Diklat.',
            'id_sop' => 'SOP07',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP055',
            'nama' => 'Pengumpulan kebutuhan data',
            'deskripsi' => 'Pranata Diklat mengumpulkan kebutuhan data sebagai lampiran laporan pelatihan, antara lain SK penyelenggaraan, buku panduan, biodata peserta, biodata pengajar, hasil evaluasi dari e-pelatihan/Sibangkoman, salinan STTP dan/atau sertifikat (bila ada), dan dokumentasi pelatihan.',
            'id_sop' => 'SOP08',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP056',
            'nama' => 'Penyusunan laporan penyelenggaraan pelatihan',
            'deskripsi' => 'Pranata Diklat menyusun laporan penyelenggaraan dan dikoreksi disertai paraf Kepala Seksi Penyelenggaraan.',
            'id_sop' => 'SOP08',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP057',
            'nama' => 'Perbaikan dan finalisasi laporan penyelenggaraan pelatihan',
            'deskripsi' => 'Pranata Diklat memperbaiki dan menyelesaikan laporan penyelenggaraan serta ditandatangani oleh Kepala Balai.',
            'id_sop' => 'SOP08',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP058',
            'nama' => 'Pengarsipan laporan penyelenggaraan',
            'deskripsi' => 'Pranata Diklat menggandakan laporan untuk arsip balai dan yang lain untuk dikirim ke Pusbangkom.',
            'id_sop' => 'SOP08',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP059',
            'nama' => 'Pemindaian dan pengunggahan laporan penyelenggaraan pelatihan',
            'deskripsi' => 'Pranata Diklat memindai dan mengunggah laporan penyelenggaraan pelatihan di e-pelatihan/Sibangkoman.',
            'id_sop' => 'SOP08',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP060',
            'nama' => 'Pendistribusian salinan laporan penyelenggaraan pelatihan',
            'deskripsi' => 'Pusbangkom mendistribusikan salinan laporan penyelenggaraan pelatihan yang telah diupload di e-pelatihan/Sibangkoman.',
            'id_sop' => 'SOP08',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP061',
            'nama' => 'Pelaksanaan rapat evaluasi kelulusan peserta',
            'deskripsi' => 'Kepala Pusbangkom mengadakan rapat evaluasi kelulusan peserta dan menetapkan surat penetapan peserta pelatihan, jadwal pembelajaran, dan penugasan pengajar.',
            'id_sop' => 'SOP09',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP062',
            'nama' => 'Penginputan data nilai peserta pelatihan',
            'deskripsi' => 'Kepala Balai menginputkan nilai peserta pelatihan secara online.',
            'id_sop' => 'SOP09',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP063',
            'nama' => 'Pengajuan nomor sertifikat',
            'deskripsi' => 'Pranata Diklat mengajukan nomor sertifikat secara online dengan  persetujuan dari Kepala Seksi Penyelenggaraan.',
            'id_sop' => 'SOP09',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP064',
            'nama' => 'Penerbitan nomor pelatihan sertifikat',
            'deskripsi' => 'Kepala Pusbangkom menerbitkan nomor pelatihan sertifikat berdasarkan undangan dari Kepala Pusbangkom/surat dari Kepala Balai.',
            'id_sop' => 'SOP09',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP065',
            'nama' => 'Pengunggahan berita acara kelulusan peserta evaluasi pelatihan',
            'deskripsi' => 'Pranata Diklat mengunggah berita acara kelulusan peserta evaluasi pelatihan ke website e-pelatihan.',
            'id_sop' => 'SOP09',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP066',
            'nama' => 'Pengajuan TTE sertifikat',
            'deskripsi' => 'Pranata Diklat mengajukan TTE sertifikat kepada Pusbangkom terkait pada website e-pelatihan/Sibangkoman.',
            'id_sop' => 'SOP09',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP067',
            'nama' => 'Pengoreksian dan persetujuan proses TTE sertifikat',
            'deskripsi' => 'Pranata Diklat mengoreksi dan menyetujui proses TTE sertifikat kepada Pusbangkom untuk diteruskan kepada Kepala BPSDM.',
            'id_sop' => 'SOP09',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP068',
            'nama' => 'Penandatanganan sertifikat pelatihan elektronik',
            'deskripsi' => 'Pranata Diklat menandatangani sertifikat pelatihan elektronik.',
            'id_sop' => 'SOP09',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP069',
            'nama' => 'Pemeriksaan kebutuhan koordinasi dengan pihak lain diluar BPSDM',
            'deskripsi' => 'Kepala Seksi Penyelenggaraan melakukan pemeriksaan kebutuhan koordinasi dengan pihak lain diluar BPSDM.',
            'id_sop' => 'SOP09',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP070',
            'nama' => 'Koordinasi Pelaksanaan Kunjungan Lapangan dan/atau Koordinasi dengan Asosiasi pemberi sertifikasi',
            'deskripsi' => 'Pranata diklat melakukan Koordinasi Pelaksanaan Kunjungan Lapangan dan/atau Koordinasi dengan Asosiasi pemberi sertifikasi untuk tata cara dan persyaratan sertifikasi keahlian (bila ada).',
            'id_sop' => 'SOP09',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP071',
            'nama' => 'Persiapan sarana dan prasarana pelatihan',
            'deskripsi' => 'Kepala Subbagian Umum dan Tata Usaha menyiapkan sarana dan prasarana pelatihan dengan metode virtual maupun klasikal, menyiapkan akomodasi dan transportasi pengajar, training kit peserta, dan rencana konsumsi.',
            'id_sop' => 'SOP09',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP072',
            'nama' => 'Pembuatan Konsep Surat Pemulangan peserta pelatihan',
            'deskripsi' => 'Pranata Diklat membuat konsep surat pemulangan peserta pelatihan berdasarkan arahan dari kepala seksi penyelenggaraan.',
            'id_sop' => 'SOP10',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP073',
            'nama' => 'Pemeriksaan konsep surat pemulangan peserta',
            'deskripsi' => 'Kepala Seksi Penyelenggaraan memeriksa konsep surat pemulangan peserta pelatihan yang telah dikonsep oleh Pranata Diklat kemudian melaporkan ke Kepala Balai.',
            'id_sop' => 'SOP10',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP074',
            'nama' => 'Pemeriksaan dan pemvalidasian surat pemulangan peserta pelatihan',
            'deskripsi' => 'Surat pemulangan peserta pelatihan divalidasi oleh Kepala Balai.',
            'id_sop' => 'SOP10',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP075',
            'nama' => 'Penyerahan surat pemulangan peserta',
            'deskripsi' => 'Pranata Diklat menyerahkan surat pemulangan yang telah divalidasi ke peserta pelatihan.',
            'id_sop' => 'SOP10',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_sop')->insert([
            'id'=> 'KSOP076',
            'nama' => 'Pengarsipan surat pemulangan peserta pelatihan',
            'deskripsi' => 'Surat pemulangan peserta pelatihan yang telah divalidasi diarsipkan oleh Pranata Diklat.',
            'id_sop' => 'SOP10',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        /////////////////////////////////////////////
        DB::table('tahapan')->insert([
            'id'=> 'TP001',
            'judul' => 'Pelaksanaan Rapat Persiapan Pelatihan',
            'icon' => 'schedule',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tahapan')->insert([
            'id'=> 'TP002',
            'judul' => 'Konfirmasi Pengajar Pengembangan Kompetensi',
            'icon' => 'contact_mail',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tahapan')->insert([
            'id'=> 'TP003',
            'judul' => 'Konfirmasi Peserta Pengembangan Kompetensi',
            'icon' => 'people_outline',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tahapan')->insert([
            'id'=> 'TP004',
            'judul' => 'Pelaksanaan Pembukaan Pelatihan',
            'icon' => 'event_available',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tahapan')->insert([
            'id'=> 'TP005',
            'judul' => 'Pelaksanaan Pembelajaran',
            'icon' => 'class',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tahapan')->insert([
            'id'=> 'TP006',
            'judul' => 'Pengelolaan Piket (Pemantauan Kegiatan Belajar Mengajar)',
            'icon' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tahapan')->insert([
            'id'=> 'TP007',
            'judul' => 'Rapat Evaluasi Kelulusan',
            'icon' => 'question_answer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tahapan')->insert([
            'id'=> 'TP008',
            'judul' => 'Pelaksanaan Penutupan Pelatihan',
            'icon' => 'event_busy',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tahapan')->insert([
            'id'=> 'TP009',
            'judul' => 'Pengembalian Peserta',
            'icon' => 'event_note',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        /////////////////////////////////////////////
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP001',
            'aksi' => 'Membuat',
            'dokumen' => 'Surat Undangan Rapat Persiapan',
            'id_tahapan' => 'TP001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP002',
            'aksi' => 'Membuat',
            'dokumen' => 'Notulen Rapat Persiapan',
            'id_tahapan' => 'TP001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP003',
            'aksi' => 'Membuat',
            'dokumen' => 'Pedoman Pelatihan',
            'id_tahapan' => 'TP001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP004',
            'aksi' => 'Upload',
            'dokumen' => 'Surat Penetapan Pengajar',
            'id_tahapan' => 'TP002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP005',
            'aksi' => 'Upload',
            'dokumen' => 'Surat Penetapan Peserta',
            'id_tahapan' => 'TP003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP006',
            'aksi' => 'Membuat',
            'dokumen' => 'Surat Pemanggilan Peserta',
            'id_tahapan' => 'TP003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP007',
            'aksi' => 'Upload',
            'dokumen' => 'Form Biodata TF-4',
            'id_tahapan' => 'TP003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP008',
            'aksi' => 'Membuat',
            'dokumen' => 'SK Pelatihan',
            'id_tahapan' => 'TP003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP009',
            'aksi' => 'Membuat',
            'dokumen' => 'Surat Permohonan Membuka dan Menghadiri',
            'id_tahapan' => 'TP004',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP010',
            'aksi' => 'Membuat',
            'dokumen' => 'Surat Undangan Menghadiri Pembukaan',
            'id_tahapan' => 'TP004',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP011',
            'aksi' => 'Upload',
            'dokumen' => 'Sambutan Pembukaan Kepala Pusat',
            'id_tahapan' => 'TP004',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP012',
            'aksi' => 'Membuat',
            'dokumen' => 'Laporan Pembukaan',
            'id_tahapan' => 'TP004',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP013',
            'aksi' => 'Upload',
            'dokumen' => 'Virtual Background, Spanduk, Backdrop',
            'id_tahapan' => 'TP004',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP014',
            'aksi' => 'Upload',
            'dokumen' => 'Dokumentasi Ceremony Pembukaan',
            'id_tahapan' => 'TP004',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP015',
            'aksi' => 'Upload',
            'dokumen' => 'Bahan Tayang Pengajar',
            'id_tahapan' => 'TP005',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP016',
            'aksi' => 'Upload',
            'dokumen' => 'Laporan dan Bahan Tayang Seminar Peserta',
            'id_tahapan' => 'TP005',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP017',
            'aksi' => 'Upload',
            'dokumen' => 'Biodata Pengajar',
            'id_tahapan' => 'TP005',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP018',
            'aksi' => 'Upload',
            'dokumen' => 'Absensi Peserta',
            'id_tahapan' => 'TP005',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP019',
            'aksi' => 'Upload',
            'dokumen' => 'Absensi Pengajar',
            'id_tahapan' => 'TP005',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP020',
            'aksi' => 'Upload',
            'dokumen' => 'Form Penilaian Sikap Perilaku',
            'id_tahapan' => 'TP006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP021',
            'aksi' => 'Membuat',
            'dokumen' => 'Surat Undangan Rapat Evaluasi',
            'id_tahapan' => 'TP007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP022',
            'aksi' => 'Membuat',
            'dokumen' => 'Berita Acara Kelulusan',
            'id_tahapan' => 'TP007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP023',
            'aksi' => 'Membuat',
            'dokumen' => 'Surat Permohonan Menutup dan Menghadiri',
            'id_tahapan' => 'TP008',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP024',
            'aksi' => 'Membuat',
            'dokumen' => 'Surat Undangan Menghadiri Penutupan',
            'id_tahapan' => 'TP008',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP025',
            'aksi' => 'Upload',
            'dokumen' => 'Sambutan Penutupan Kepala Pusat',
            'id_tahapan' => 'TP008',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP026',
            'aksi' => 'Membuat',
            'dokumen' => 'Laporan Penutupan',
            'id_tahapan' => 'TP008',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP027',
            'aksi' => 'Upload',
            'dokumen' => 'Dokumentasi Ceremony Penutupan',
            'id_tahapan' => 'TP008',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP028',
            'aksi' => 'Membuat',
            'dokumen' => 'Surat Pengembalian Peserta',
            'id_tahapan' => 'TP009',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP029',
            'aksi' => 'Upload',
            'dokumen' => 'SPMK',
            'id_tahapan' => 'TP009',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('kegiatan_tahapan')->insert([
            'id'=> 'KGTP030',
            'aksi' => 'Upload',
            'dokumen' => 'Laporan Akhir Pelatihan',
            'id_tahapan' => 'TP009',
            'created_at' => now(),
            'updated_at' => now(),
        ]);-	
        
        /////////////////////////////////////////////
        DB::table('jenis_pelatihan')->insert([
            'id'=> 'JP001',
            'nama' => 'Fungsional',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('jenis_pelatihan')->insert([
            'id'=> 'JP002',
            'nama' => 'Kepemimpinan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('jenis_pelatihan')->insert([
            'id'=> 'JP003',
            'nama' => 'Teknis',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('jenis_pelatihan')->insert([
            'id'=> 'JP004',
            'nama' => 'Umum',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        /////////////////////////////////////////////
        DB::table('bidang_pelatihan')->insert([
            'id'=> 'BP001',
            'nama' => 'Sumber Daya Air',
            'gambar' => 'sda.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('bidang_pelatihan')->insert([
            'id'=> 'BP002',
            'nama' => 'Bina Marga',
            'gambar' => 'bina_marga.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('bidang_pelatihan')->insert([
            'id'=> 'BP003',
            'nama' => 'Cipta Karya',
            'gambar' => 'cipta_karya.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('bidang_pelatihan')->insert([
            'id'=> 'BP004',
            'nama' => 'Kepemimpinan',
            'gambar' => 'kepemimpinan.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('bidang_pelatihan')->insert([
            'id'=> 'BP005',
            'nama' => 'Pelatihan Dasar II',
            'gambar' => 'pelatihan_dasar.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('bidang_pelatihan')->insert([
            'id'=> 'BP006',
            'nama' => 'Konstruksi',
            'gambar' => 'konstruksi.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('bidang_pelatihan')->insert([
            'id'=> 'BP007',
            'nama' => 'Pembiayaan Infrastruktur',
            'gambar' => 'pembiayaan_infrastruktur.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('bidang_pelatihan')->insert([
            'id'=> 'BP008',
            'nama' => 'Perumahan',
            'gambar' => 'perumahan.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('bidang_pelatihan')->insert([
            'id'=> 'BP009',
            'nama' => 'Selain Bidang PUPR',
            'gambar' => 'bidang_lainnya.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('bidang_pelatihan')->insert([
            'id'=> 'BP010',
            'nama' => 'Bidang Umum dan Manajemen',
            'gambar' => 'manajemen.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        /////////////////////////////////////////////
        DB::table('model_pelatihan')->insert([
            'id'=> 'MP001',
            'nama' => 'Blended Learning',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('model_pelatihan')->insert([
            'id'=> 'MP002',
            'nama' => 'Pelatihan Jarak Jauh (Distance Learning)',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('model_pelatihan')->insert([
            'id'=> 'MP003',
            'nama' => 'Pelatihan di Kelas (Klasikal)',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        /////////////////////////////////////////////
        // DB::table('struktur_pupr')->insert([
        //     'id'=> 'pupr001',
        //     'nama' => 'Diki Zulkarnaen, ST, M.Sc.',
        //     'nip' => '197904182005021001',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // DB::table('pelatihan')->insert([
        //     'id'=> 'P001',
        //     'pelatihan' => 'Pengembangan Kompetensi Pengelolaan Keuangan Daerah',
        //     'bidang_pelatihan' => 'JP001',
        //     'tanggal_mulai' => '2021-01-01',
        //     'tanggal_selesai' => '2021-01-01',
        // ]);

        // DB::table('status')->insert([
        //     'id'=> 'S001',
        //     'status' => 'Sedang berlangsung',
        //     'pelatihan' => 'P001',
    }
}
