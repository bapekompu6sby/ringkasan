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
    
  <title>Laporan Pembukaan</title>
</head>

<style>
  * {
    font-family: 'Roboto', sans-serif;
  }
    .tabel{
        border-collapse: collapse;
        
    }
    .tabel th {
        border: 1px solid black;
        padding: 15px;
    }
    .tabel td {
        border: 1px solid black;
        padding: 15px;
    }
    .tabel th{
        background-color: aqua;
    }
    ul{
        list-style-type: hyphen;
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
        <h2 style="text-align: center;">LAPORAN PERSIAPAN PELAKSANAAN</h2>
        <h3 style="text-align: center;margin-top:-25px;">PEMBUKAAN PELATIHAN{{ strtoupper($pelatihan->nama) }} SECARA {{ strtoupper($pelatihan->model_pelatihan->nama) }}</h3>
        
        <h4 style="text-align: center;">=============================================================================</h4>
      </div>
      <div class="isi-surat">

        <p style="margin-bottom: 20px; margin-top: -5px; text-align:right;">Surabaya, {{ tanggal_indo(now()->toDateString()) }}
        </p>
        <p>
            <b>Kepada yang selalu kami banggakan Plt. Kepala Badan Pengembangan SDM:</b>
            <br>
            {{ $pelatihan->kepala_bpsdm }}
        </p>
        <p>
            <b>Kepada Yth :</b>
            <ul>
                @foreach($data['kepada_yth'] as $item)
                    <li>{{ $data['kepada_yth'][$loop->index] }} {{ $loop->last? '.' : ';' }} <b>{{ $data['nama_yth'][$loop->index] }}</b></li>
                @endforeach
            </ul>
        </p>
        <p>
            <b>Yang kami hormati: </b>
            <ul>
                @foreach($data['yg_dihormati'] as $item)
                    <li>{{ $item }}{{ $loop->last? '.' : ';' }}</li>
                @endforeach
                <li>Para Widyaiswara, Pengajar, Panitia dan Peserta pelatihan yang berbahagia.</li>
            </ul>
        </p>
        <p>Bismillaahirrohmaanirrahim</p>
        <p>Assalamu’alaikum Wr. Wb.</p>
        <p>Selamat pagi, Salam sejahtera bagi kita semua,</p>
        <p>
            Pertama-tama marilah kita panjatkan puji syukur kehadirat Allah SWT karena atas perkenan-Nya, pada hari ini <b>{{ hari_indo($request->tanggal) }}, {{ tanggal_indo($request->tanggal) }}</b> kita dapat hadir di sini diberikan nikmat sehat dan kesempatan, sehingga masih dapat mengikuti acara <b>Pembukaan</b> Pelatihan {{ ucwords($pelatihan->nama) }} yang dilaksanakan secara {{ ucwords($pelatihan->model_pelatihan->nama) }}. 
        </p>
        <p>
            Perkenankanlah kami panitia melaporkan persiapan pelaksanaan penyelenggaraan pelatihan tersebut sebagai berikut :
        </p>

        <ol type="A">
            <li style="font-weight: bold">DASAR PELAKSANAAN</li>
                <ol type="1"> 
                    @foreach($data['dasar_pelaksanaan'] as $item)
                        <li>{{ $item }}{{ $loop->last? '.' : ';' }}</li>
                    @endforeach
                </ol>
                <br>
            <li style="font-weight: bold">TUJUAN</li>
                <p>Pelatihan {{ $pelatihan->nama }} ini dimaksudkan {{ $request->tujuan }}
                </p>
            <li style="font-weight: bold">WAKTU DAN TEMPAT</li>
                <p>Pelatihan diselenggarakan tanggal <b>{{ rentang_tgl($pelatihan->tanggal_mulai, $pelatihan->tanggal_selesai) }}</b> dilaksanakan dengan model pembelajaran {{ $pelatihan->model_pelatihan->nama }} dengan panitia di Balai Pengembangan Kompetensi Pekerjaan Umum Wilayah VI Surabaya.</p>
            </li>
            <li style="font-weight: bold">PESERTA</li>
                <p>Calon peserta pelatihan seluruhnya berjumlah {{ array_sum($data['jumlah_peserta']); }} orang yang dipanggil untuk mengikuti pelatihan. Keseluruhan calon peserta tersebut berasal dari seluruh unit kerja di Lingkungan Kementerian Pekerjaan Umum dengan rincian sebagai berikut :</p>
                <table class="tabel">
                    <thead>
                        <tr style="page-break-inside: avoid;">
                            <th style="background-color:#92aec9;text-align:center;">No</th>
                            <th style="background-color:#92aec9;padding:10px;">Unit Kerja</th>
                            <th style="background-color:#92aec9;text-align:center;padding:10px;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['no_peserta'] as $item){
                            <tr style="page-break-inside: avoid;">
                                <td style="text-align:center;vertical-align:middle">{{ $data['no_peserta'][$loop->index] }}</td>
                                <td style="padding:10px;vertical-align:middle">{{ $data['unit_kerja_peserta'][$loop->index] }}</td>
                                <td style="text-align:center;padding:10px;vertical-align:middle">{{ $data['jumlah_peserta'][$loop->index] }}</td>
                            </tr>
                        }
                        @endforeach
                    </tbody>
                </table>
            <br>
            <li style="font-weight: bold">KURIKULUM DAN MODEL PEMBELAJARAN</li>
                <ol type="1">
                    <li>KURIKULUM</li>
                        <p>Pelatihan Manajemen Komunikasi Publik diprogramkan {{ end($data['jp_kurikulum']) }} JP. Untuk 1 (satu) Jam Pelajaran setara dengan 45 menit yang meliputi :</p>
                        <table class="tabel">
                            <thead>
                                <tr style="page-break-inside: avoid;">
                                    <th style="background-color:#92aec9;text-align:center;">No.</th>
                                    <th style="background-color:#92aec9;padding:10px;">Mata Pelatihan</th>
                                    <th style="background-color:#92aec9;text-align:center;padding:10px;">Jumlah JP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['no_kurikulum'] as $item){
                                    @if (!$loop->last)
                                        <tr style="page-break-inside: avoid;">
                                            <td style="text-align:center;vertical-align:middle">{{ $data['no_kurikulum'][$loop->index] }}</td>
                                            <td style="padding:10px;vertical-align:middle">{{ $data['mapel_kurikulum'][$loop->index] }}</td>
                                            <td style="text-align:center;padding:10px;vertical-align:middle">{{ $data['jp_kurikulum'][$loop->index] }}</td>
                                        </tr>
                                    @else
                                        <tr style="page-break-inside: avoid;">
                                            <td colspan="2" style="text-align:center;vertical-align:middle">{{ $data['no_kurikulum'][$loop->index] }}</td>
                                            <td style="text-align:center;padding:10px;vertical-align:middle">{{ $data['jp_kurikulum'][$loop->index] }}</td>
                                        </tr>
                                    @endif
                                }
                                @endforeach
                            </tbody>
                        </table>
                    <li>MODEL PEMBELAJARAN</li>
                        <p>Pelatihan ini dilaksanakan dengan model {{ $pelatihan->model_pelatihan->nama }} dengan mengunakan pola pembelajaran di kelas bertatap muka secara langsung dengan peserta. Metode penyampaian pelatihan menggunakan sistem belajar orang dewasa (andragogy) dengan pembelajaran langsung. Metode ini diharapkan akan menimbulkan peran serta secara aktif bagi peserta pelatihan. Peserta diperlakukan sebagai orang dewasa melalui komunikasi dua arah sehingga memberikan kesempatan kepada peserta untuk menyumbangkan pikiran dan pengalamannya. Pola pembelajaran pada pelatihan ini dilaksanakan secara konvesional dengan metode ceramah serta praktik yang dipandu oleh pengampu/pengajar secara langsung yang berpusat pada aktivitas peserta. </p>
                </ol>
                
            <li style="font-weight: bold">PENGAJAR / WIDYAISWARA</li>
                <p>Tenaga Pengajar adalah Pejabat Struktural, fungsional dan Widyaiswara dari Kementerian Pekerjaan Umum.</p>
            <li style="font-weight: bold">EVALUASI TERHADAP PESERTA</li>
                <p>Evaluasi untuk pelatihan yang dilakukan terdiri dari :</p>
                <ol type="1">
                    @foreach($data['evaluasi'] as $item)
                        <li>{{ $item }}.</li>
                    @endforeach
                </ol>
                <br>
            <li style="font-weight: bold">SURAT TANDA TAMAT PELATIHAN</li>
                <p>Peserta pelatihan yang dapat mengikuti seluruh program pelatihan yang telah ditetapkan akan diberikan Sertifikat Pelatihan yang ditandatangani oleh Kepala BPSDM Kementerian Pekerjaan Umum.</p>
        </ol>
        <p>Sebelum saya akhiri izinkan saya menyampaikan pantun terlebih dahulu :</p>
        @foreach ($pantun as $item)
            {{ $item }}<br>
        @endforeach

        <p style="text-align: justify">
            Demikian Laporan Persiapan Penyelenggaraan Pelatihan {{ $pelatihan->nama }} selanjutnya mohon perkenan 
            <b>
                {{ $data['kepada_yth'][0] }} : {{ $data['nama_yth'][0] }}
            </b> berkenan untuk memberikan pengarahan dan sekaligus membuka pelatihan secara resmi.
        </p>

        <p>
            <b><i>Wabilahitaufiq walhidayah</i></b>
            <br>
            <b><i>Wassalamu’alaikum Wr. Wb.</i></b>
        </p>
      </div>
    </div>
  </div>
</body>
<script>
    // window.print();

</script>

</html>