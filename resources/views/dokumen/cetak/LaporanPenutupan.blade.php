<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet">
    
  <title>Laporan Penutup</title>
</head>

<style>
  * {
    font-family: 'Roboto', sans-serif;
  }
    p,li{
    text-align: justify;
    }
</style>

<body>
    @if (!function_exists('tanggal_indo'))
        @php
        function tanggal_indo($tanggal){
            $bulan = array (
            1 =>'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
            );
            $pecahkan = explode('-', $tanggal);

            return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
        }

        function rentang_tgl($tgl_mulai, $tgl_selesai){
            $tgl_mulai = tanggal_indo($tgl_mulai);
            $tgl_selesai = tanggal_indo($tgl_selesai);
            $tgl_mulai_pecah = explode(' ', $tgl_mulai);
            $tgl_selesai_pecah = explode(' ', $tgl_selesai);
            if ($tgl_mulai_pecah[1] == $tgl_selesai_pecah[1]) {
                return $tgl_mulai_pecah[0] . ' s.d ' . $tgl_selesai_pecah[0] . ' ' . $tgl_mulai_pecah[1] . ' ' . $tgl_mulai_pecah[2];
            }
            return $tgl_mulai . ' s.d ' . $tgl_selesai;
        }

        function hari_indo($tanggal){
            if (date('l', strtotime($tanggal)) == 'Sunday') {
                return 'Minggu';
            } elseif (date('l', strtotime($tanggal)) == 'Monday') {
                return 'Senin';
            } elseif (date('l', strtotime($tanggal)) == 'Tuesday') {
                return 'Selasa';
            } elseif (date('l', strtotime($tanggal)) == 'Wednesday') {
                return 'Rabu';
            } elseif (date('l', strtotime($tanggal)) == 'Thursday') {
                return 'Kamis';
            } elseif (date('l', strtotime($tanggal)) == 'Friday') {
                return 'Jumat';
            } elseif (date('l', strtotime($tanggal)) == 'Saturday') {
                return 'Sabtu';
            }
            return date('l', strtotime($tanggal));
        }
        @endphp
@endif
  <div class="container">
    <div class="isi">
      <div class="judul">
        <h2 style="text-align: center">LAPORAN PENUTUPAN PELAKSANAAN</h2>
        <h3 style="text-align: center;margin-top:-25px;">PELATIHAN {{ strtoupper($pelatihan->nama) }}</h3>
        <h3 style="text-align: center;margin-top:-20px;">SECARA {{ strtoupper($pelatihan->model_pelatihan->nama) }}</h3>
      </div>
      <br>
      <div class="isi-surat">
        <p style="margin-bottom: 20px; margin-top: -5px; text-align:right;">Surabaya, {{ tanggal_indo(now()->toDateString()) }}
        </p>
        <p>
            <b>Kepada yang selalu kami banggakan Plt. Kepala Badan Pengembangan SDM:</b>
            <br>
            {{ $request->kepala_bpsdm }}
        </p>
        <p>
            <b>Kepada Yth :</b>
            <ul>
                @foreach($data["kepada_yth"] as $item)
                    <li>{{ $data['kepada_yth'][$loop->index] }} {{ $loop->last? '.' : ';' }} <b>{{ $data['nama_yth'][$loop->index] }}</b></li>
                @endforeach
            </ul>
        </p>
        <p>
            <b>Yang kami hormati: </b>
            <ul>
                @foreach($data["yg_dihormati"] as $item)
                    <li>{{ $item }}{{ $loop->last? '.' : ';' }}</li>
                @endforeach
            </ul>
        </p>
        <p>Bismillaahirrohmaanirrahim</p>
        <p>Assalamu’alaikum Wr. Wb.</p>
        <p>Selamat Sore, Salam sejahtera bagi kita semua,</p>
        <p>
            Pertama-tama marilah kita panjatkan puji syukur kehadirat Allah SWT karena atas perkenan-Nya, pada hari ini <b>{{ hari_indo($request->tanggal)}}, {{ tanggal_indo($request->tanggal) }} </b> kita dapat hadir di sini diberikan nikmat sehat dan kesempatan, sehingga masih dapat mengikuti acara <b>Penutupan</b> Pelatihan {{ ucwords($pelatihan->nama) }} yang dilaksanakan secara {{ ucwords($pelatihan->model_pelatihan->nama) }}. 
        </p>
        <p>
            Selanjutnya Perkenankanlah kami melaporkan penyelenggaraan sebagai berikut :
        </p>

        <ol type="A">
            <li style="font-weight: bold;page-break-before:always">DASAR HUKUM PENYELENGGARAAN PELATIHAN</li>
                <ol type="1"> 
                    @foreach($data["dasar_hukum_penyelenggaraan"] as $item)
                        <li>{{ $item }}{{ $loop->last? '.' : ';' }}</li>
                    @endforeach
                </ol>
            <li style="font-weight: bold">PESERTA PELATIHAN</li>
                <p>Peserta pelatihan berjumlah {{ $request->jumlah_peserta }} orang mengikuti pelatihan. Keseluruhan calon peserta tersebut berasal dari seluruh unit kerja Lingkungan Kementerian Pekerjaan Umum.</p>
            <li style="font-weight: bold">KEGIATAN PELATIHAN</li>
                <p>Pelatihan diselenggarakan tanggal <b>{{ rentang_tgl($pelatihan->tanggal_mulai,$pelatihan->tanggal_selesai) }}</b> dilaksanakan dengan model pembelajaran {{ $pelatihan->model_pelatihan->nama }}.</p>
            <li style="font-weight: bold">EVALUASI PELATIHAN</li>
                <p>Evaluasi dilakukan terhadap: kehadiran peserta, Evaluasi manajemen dan proses belajar. Adapun rekapitulasi hasil evaluasi dimaksud adalah sebagai berikut:</p>
                <ol type="a">
                    <li style="font-weight: bold">Kehadiran Peserta</li>
                        <p>Peserta yang hadir mengikuti pelatihan dari awal sampai akhir sebanyak {{ $request->jumlah_peserta_hadir }} orang yang terdiri dari {{ $request->peserta_male }} orang laki-laki dan {{ $request->peserta_female }} orang Perempuan. Keseluruhan peserta berasal dari Lingkungan Kementerian Pekerjaan Umum.</p>
                    @if ($pelatihan->model_pelatihan->id == 'MP001' || $pelatihan->model_pelatihan->id == 'MP002')
                        <li style="font-weight: bold">Evaluasi Pembelajaran Jarak Jauh (E-Learning): </li>
                        <p>Evaluasi terhadap e-learning dilakukan untuk mengetahui tingkat keberhasilan pembelajaran yang dilaksanakan oleh penyelenggara secara e-learning. Rekap hasil evaluasi e-learning sebagai berikut: </p>
                        <ol type="1">
                            @foreach($data["evaluasi_elearning"] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ol>
                    @endif
                    @if ($pelatihan->model_pelatihan->id == 'MP001' || $pelatihan->model_pelatihan->id == 'MP003')
                        <li style="font-weight: bold">Evaluasi Manajemen:</li>
                            <p>Evaluasi terhadap manajemen dilakukan untuk mengetahui tingkat keberhasilan pembelajaran yang dilaksanakan oleh penyelenggara secara langsung. Rekap hasil evaluasi manajemen sebagai berikut:</p>
                            <ol type="1">
                                @foreach($data["evaluasi_manajemen"] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ol>
                    @endif
                    <li style="font-weight: bold">Evaluasi Proses Belajar</li>
                        <p>Berdasarkan rekap hasil evaluasi terhadap peserta dari unsur-unsur yang dinilai baik akademik maupun non akademik peserta Pelatihan Manajemen Komunikasi Publik secara keseluruhan dinyatakan lulus.</p>
                        <p>Adapun 3 peserta terbaik pada Pelatihan Manajemen Komunikasi Publik adalah sebagai berikut:</p>
                        @foreach($data["best3_peringkat"] as $item)
                            <p>Peringkat {{ $data["best3_peringkat"][$loop->index] }} diraih oleh {{ $data["best3_nama"][$loop->index] }} dari {{ $data["best3_unit_kerja"][$loop->index] }} dengan nilai <b>{{ $data["best3_nilai"][$loop->index] }} ({{ $data["best3_predikat"][$loop->index] }})</b></p>
                        @endforeach
                </ol>
                
            <p>Sebelum saya akhiri, izinkan saya menyampaikan pantun terlebih dahulu:</p>
            <p><b>
                @foreach ($pantun as $item)
                    {{ $item }}<br>
                @endforeach
            </b></p>
            </li>
            <li style="font-weight: bold">PENUTUP</li>
                <p>
                    Demikian laporan yang dapat kami sampaikan pada hari ini, dan kepada 
                    <b>
                        {{ $data['kepada_yth'][0] }} : {{ $data['nama_yth'][0] }}
                    </b> dengan hormat kami mohon untuk memberikan sambutan sekaligus menutup pelatihan ini secara resmi. Terimakasih.
                </p>
            </li>
        </ol>
        <p>
            <i>Wabilahitaufiq walhidayah</i>
            <br>
            <i>Wassalamu’alaikum Wr. Wb.</i>
        </p>
      </div>
    </div>
  </div>
</body>
<script>
    // window.print();
</script>

</html>