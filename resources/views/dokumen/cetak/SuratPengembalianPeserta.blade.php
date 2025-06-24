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
    
  <title>Surat Pengembalian Peserta</title>
</head>

<style>
  * {
    font-family: 'Roboto', sans-serif;
  }
    .peserta{
        border-collapse: collapse;
        
    }
    .peserta th {
        border: 2px solid black;
        padding: 15px;
    }
    .peserta td {
        border: 2px solid black;
        padding: 15px;
    }
    p,li{
      text-align: justify
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
    <div class="kopsurat" style="border-bottom: 1px solid black;">
      <div class="wrapper">
        <img style="background-color: blue;" src="{{ $logo }}" alt="pupr" width="100" height="100">
        <div class="heading" style="text-align: center; width: 80%; float: right;">
          <h4 style="margin-top: 5px;margin-left: -80px;">KEMENTERIAN PEKERJAAN UMUM</h4>
          <h4 style="margin-top: -20px;margin-left: -80px;font-weight:normal">BADAN PENGEMBANGAN SUMBER DAYA MANUSIA</h4>
          <h4 style="margin-top: -20px;margin-left: -80px;">BALAI PENGEMBANGAN KOMPETENSI PEKERJAAN UMUM WILAYAH VI SURABAYA</h4>
          <h6 style="margin-top: -20px;margin-left: -80px;font-weight:normal">Jalan Gayung Kebonsari 48, Gayungan, Surabaya 60234, Telepon (031) 8291040, 8286501 Faksimili 8275847</h6>
        </div>
      </div>
    </div>
    <br>
    <div class="isi">
      <div class="judul">
        <p style="margin-bottom: 20px; margin-top: -5px; text-align:right;">Surabaya, {{ tanggal_indo(now()->toDateString()) }}
        </p>
        <table style="margin-top: -30px;">
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td>{{ $request->nomor_surat }}</td>
            </tr>
            <tr>
                <td>Sifat</td>
                <td>:</td>
                <td>Biasa</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>1 (satu) berkas</td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td style="word-wrap: break-word;vertical-align:top">Pengembalian Peserta Pelatihan {{ $pelatihan->nama }}</td>
            </tr>
        </table>
      </div>
      <div class="isi-surat">
        <p>
            Yth.<b>Bapak/Ibu </b>
            <br>
            <b>(Daftar Terlampir)</b> 
            <br>
            di Tempat
        </p>

        <p style="text-indent: 50px; line-height: 1.5;">Sehubungan dengan telah berakhirnya Pelatihan Manajemen Konstruksi yang diselenggarakan dari tanggal  {{ rentang_tgl($pelatihan->tanggal_mulai, $pelatihan->tanggal_selesai) }} secara {{ $pelatihan->model_pelatihan->nama }} di Balai Pengembangan Kompetensi Pekerjaan Umum Wilayah VI Surabaya, maka dengan hormat kami menyerahkan kembali peserta yang telah mengikuti pelatihan kepada Unit Organisasi Pengutus/Pemberi Tugas.</p>
        <p style="text-indent: 50px; line-height: 1.5;">Sebagai informasi, dari 28 orang peserta pelatihan ini, peserta dinyatakan lulus sebanyak 26 orang. Informasi kelulusan setiap peserta dapat diakses melalui sistem Sibangkoman.pu.go.id. Peserta yang telah mengikuti pelatihan diberikan Sertifikat dari Badan Pengembangan Sumber Daya Manusia, Kementerian Pekerjaan Umum.</p>
        <p style="text-indent: 50px;line-height: 1.5;">Demikian kami sampaikan, atas perhatian dan kerjasamanya, kami mengucapkan terima kasih.</p>
      </div>
    </div>
    <div class="ttd" style="position: relative; margin-bottom: 250px;">
      <div class="ttd-koprodi" style="position: absolute; width: 50%; right: 0; top: 20px;">
        <p style="margin-top: -20px; text-align:center;"><b>Kepala Balai Pengembangan Kompetensi Pekerjaan Umum
            <br>Wilayah VI Surabaya,</b>
        </p>
        <p style="margin-top: 100px;text-align:center;"><b>Diki Zulkarnaen, ST, M.Sc.</b></p>
        <p style="margin-top: -10px;text-align:center;">NIP. 197904182005021001</p>
        <p style="margin-top: -10px;text-align:center;"><i style="color:rgb(151, 149, 149)">Ditandatangani secara elektronik</i></p>
      </div>
    </div>
    <div style="page-break-inside: avoid">
      <p><b>Tembusan:</b></p>
      <ol>
        @foreach ($data as $item)
          @if (!$loop->first && $item['tembusan'] != null)
            <li>{{ $item['tembusan'] }}{{ $loop->last? '.' : ';' }}</li>
          @endif
        @endforeach
      </ol>
    </div>
  </div>

  {{-- Lampiran 1 --}}
  <div class="wrapper" style="width: 50%; float: right;">
    <p style="text-align: left; page-break-before: always;">
      Lampiran I Surat Kepala Balai Pengembangan
       Kompetensi Pekerjaan Umum Wilayah VI Surabaya</p>
    <div style="text-align: right;margin-bottom:30px;margin-top:-15px">
      <table style="">
        <tr>
            <td>Nomor</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td></td>
      </table>
    </div>
  </div>
  <h3 style="text-align:center;clear:right;">DAFTAR UNIT ORGANISASI PENGUTUS</h3>
  <p>Yth.</p>
  <ol>
      @foreach($data as $item)
        @if (!$loop->first && $item['unit_kerja_pengutus'] != null)
          <li>{{ $item['unit_kerja_pengutus'] }}{{ $loop->last? '.' : ';' }}</li>
        @endif
      @endforeach
    </ol>

    {{-- Lampiran 2 --}}
    <div class="wrapper" style="width: 50%; float: right;">
      <p style="text-align: left; page-break-before: always;">
        Lampiran II Surat Kepala Balai Pengembangan
         Kompetensi Pekerjaan Umum Wilayah VI Surabaya</p>
      <div style="text-align: right;margin-bottom:30px;margin-top:-15px">
        <table style="">
          <tr>
              <td>Nomor</td>
              <td>:</td>
              <td></td>
          </tr>
          <tr>
              <td>Tanggal</td>
              <td>:</td>
              <td></td>
        </table>
      </div>
    </div>
    <br>
    <h3 style="text-align:center;clear: both;">
        DAFTAR PESERTA
        <br>
        PESERTA PELATIHAN MANAJEMEN KONSTRUKSI 
        <br>
        Balai Pengembangan Kompetensi Pekerjaan Umum Wilayah VI Surabaya
        <br>
        {{ rentang_tgl($pelatihan->tanggal_mulai, $pelatihan->tanggal_selesai) }}
    </h3>
    <table class="table peserta">
        @php
        $temp = 0;
      @endphp
      @foreach($data as $item)
        @if ($loop->first)
        <thead>
          <tr style="page-break-inside: avoid;">
            <th style="background-color:#92aec9;text-align:center;padding:10px;">{{ $item['no'] }}</th>
            <th style="background-color:#92aec9;text-align:center;padding:10px;">{{ $item['nama'] }}</th>
            <th style="background-color:#92aec9;text-align:center;padding:10px;">{{ $item['nip/nrp'] }}</th>
            <th style="background-color:#92aec9;text-align:center;padding:10px;">{{ $item['unit_kerja'] }}</th>
            <th style="background-color:#92aec9;text-align:center;padding:10px;">{{ $item['peringkat'] }}</th>
          </tr>
        </thead>
        @elseif ($loop->iteration == 2)
        <tbody>
          <tr style="page-break-inside: avoid;">
            <td style="text-align:center;padding:10px;vertical-align:middle">{{ $item['no'] }}</td>
            <td style="text-align:center;padding:10px;vertical-align:middle">{{ $item['nama'] }}</td>
            <td style="text-align:center;padding:10px;vertical-align:middle">{{ $item['nip/nrp'] }}</td>
            <td style="text-align:center;padding:10px;vertical-align:middle">{{ $item['unit_kerja'] }}</td>
            <td style="text-align:center;padding:10px;vertical-align:middle">{{ $item['peringkat'] }}</td>
          </tr>
        @else
        <tr style="page-break-inside: avoid;">
          <td style="text-align:center;padding:10px;vertical-align:middle">{{ $item['no'] }}</td>
          <td style="text-align:center;padding:10px;vertical-align:middle">{{ $item['nama'] }}</td>
          <td style="text-align:center;padding:10px;vertical-align:middle">{{ $item['nip/nrp'] }}</td>
          <td style="text-align:center;padding:10px;vertical-align:middle">{{ $item['unit_kerja'] }}</td>
          <td style="text-align:center;padding:10px;vertical-align:middle">{{ $item['peringkat'] }}</td>
        </tr>
        @endif
      </tbody>
      @endforeach
    </table>
</body>
<script>
    // window.print();
</script>

</html>